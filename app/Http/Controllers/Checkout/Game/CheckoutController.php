<?php

namespace App\Http\Controllers\Checkout\Game;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\View;
use App\Models\PterodactylProducts;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Models\Invoices;
use App\Models\InvoiceItems;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function render($id)
    {
        $getProduct = PterodactylProducts::where('id', $id);
        if ($getProduct->count() == '1') {
            $product = $getProduct->first();
        } else {
            throw new NotFoundHttpException();
        }

        return view('checkout.game.checkout', [
            'product' => $product,
        ]);
    }

    public function store($id)
    {
        $getProduct = PterodactylProducts::where('id', $id);
        if ($getProduct->count() == '1') {
            $date = new \DateTime(now());
            $due_at = $date->modify('+7 days');
            $invoiceid = rand(00000000, 100000000);
            Invoices::insert([
                'userid' => Auth::user()->id,
                'invoiceid' => $invoiceid,
                'credit' => '0',
                'status' => 'unpaid',
                'due_at' => $due_at,
            ]);
            InvoiceItems::insert([
                'userid' => Auth::user()->id,
                'invoiceid' => $invoiceid,
                'productid' => $getProduct->first()->id,
                'type' => 'hosting.game',
                'description' => $getProduct->first()->name,
                'amount' => $getProduct->first()->price,
                'status' => 'unpaid',
            ]);
            return redirect(route('invoice.view', ['id' => $invoiceid]))->with('info', 'Facturé généré avec succès');
        } else {
            throw new NotFoundHttpException();
        }
    }
}
