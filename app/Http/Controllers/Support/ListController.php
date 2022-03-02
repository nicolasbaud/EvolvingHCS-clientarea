<?php

namespace App\Http\Controllers\Support;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\View;
use App\Models\Tickets;
use Illuminate\Support\Facades\Auth;

class ListController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function render()
    {
        return view('support.tickets', [
            'tickets' => Tickets::where('userid', Auth::user()->id)->get(),
        ]);
    }
}
