<?php

namespace App\Http\Controllers\Invoices;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\View;
use App\Models\Invoices;
use App\Models\InvoiceItems;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ViewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function render($id)
    {   
        if(Invoices::where('invoiceid', $id)->where('userid', Auth::user()->id)->count() != '1') {
            throw new NotFoundHttpException();
        }
        return view('invoices.view', [
            'invoice' => Invoices::where('invoiceid', $id)->where('userid', Auth::user()->id)->first(),
        ]);
    }
}
