<?php

namespace App\Http\Controllers\Services\Game;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\View;
use App\Models\PterodactylServices;
use Illuminate\Support\Facades\Auth;

class ListController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function render()
    {
        return view('services.game.list', [
            'services' => PterodactylServices::where('userid', Auth::user()->id)->get(),
        ]);
    }
}
