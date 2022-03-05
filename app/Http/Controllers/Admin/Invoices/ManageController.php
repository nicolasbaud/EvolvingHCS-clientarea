<?php

namespace App\Http\Controllers\Admin\Invoices;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoices;
use App\Models\InvoiceItems;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ManageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($id)
    {
        $invoice = Invoices::where('invoiceid', $id)->first();

        if (Invoices::where('invoiceid', $id)->count() != '1') {
            throw new NotFoundHttpException();
        }

        $items = InvoiceItems::where('invoiceid', $id)->get();

        return view('admin.invoices.edit', [
            'invoice' => $invoice,
            'items' => $items,
        ]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'userid' => 'required|numeric',
        ]);

        $invoiceid = rand(0000000, 10000000);

        Invoices::create([
            'userid' => $request->userid,
            'invoiceid' => $invoiceid,
            'credit' => 0,
            'status' => 'unpaid',
        ]);

        return redirect(route('admin.invoice.edit', ['id' => $invoiceid]))->with('success', 'Facture créé');
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'status' => ['required', Rule::in(['paid', 'pending', 'unpaid'])],
        ]);

        Invoices::where('invoiceid', $id)->update([
            'status' => $request->status,
        ]);

        return redirect(route('admin.invoice.edit', ['id' => $id]))->with('success', 'Facture mise à jour');
    }

    public function createItems($id, Request $request)
    {
        $invoice = Invoices::where('invoiceid', $id)->first();
        $request->validate([
            'description' => 'required|max:255',
            'productid' => 'required|numeric',
            'type' => ['required', Rule::in(['hosting.game', 'renew.game'])],
            'amount' => 'required|numeric',
            'status' => ['required', Rule::in(['paid', 'pending', 'unpaid'])],
        ]);
        InvoiceItems::create([
            'userid' => $invoice->userid,
            'invoiceid' => $invoice->invoiceid,
            'description' => $request->description,
            'productid' => $request->productid,
            'type' => $request->type,
            'amount' => $request->amount,
            'status' => $request->status,
        ]);

        return redirect(route('admin.invoice.edit', ['id' => $id]))->with('success', 'Item ajouté');
    }

    public function deleteItems($id, $itemid)
    {
        InvoiceItems::where('invoiceid', $id)->where('id', $itemid)->delete();
        return redirect(route('admin.invoice.edit', ['id' => $id]))->with('success', 'Item supprimé');
    }
}
