<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoices;
use App\Models\InvoiceItems;

class HomeController extends Controller
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
    public function index()
    {
        $turnover = [
            'today' => InvoiceItems::where('created_at', '>', date('Y-m-d 00:00:00'))->where('status', 'paid')->sum('amount'),
            'yesterday' => InvoiceItems::where('created_at', '>', date('Y-m-d 00:00:00', strtotime("-1 day")))->where('created_at', '<', date('Y-m-d 00:00:01'))->where('status', 'paid')->sum('amount'),
            'month' => InvoiceItems::where('created_at', '>', date('Y-m-01'))->where('status', 'paid')->sum('amount'),
            'year' => InvoiceItems::where('created_at', '>', date('Y-01-01'))->where('status', 'paid')->sum('amount'),
            'all' => InvoiceItems::where('created_at', '>', date('20-01-01'))->where('status', 'paid')->sum('amount'),
        ];

        return view('admin.home', [
            'turnover' => $turnover,
        ]);
    }
}
