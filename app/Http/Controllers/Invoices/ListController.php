<?php

namespace App\Http\Controllers\Invoices;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\View;
use App\Models\Invoices;
use App\Models\InvoiceItems;
use Illuminate\Support\Facades\Auth;

class ListController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function render()
    {
        return view('invoices.list', [
            'invoices' => Invoices::where('userid', Auth::user()->id)->get(),
        ]);
    }
}
