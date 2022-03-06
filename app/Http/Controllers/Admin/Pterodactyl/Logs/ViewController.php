<?php

namespace App\Http\Controllers\Admin\Pterodactyl\Logs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PterodactylLogs;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ViewController extends Controller
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
        $log = PterodactylLogs::find($id);

        if (!$log) {
            throw new NotFoundHttpException;
            
        }

        return view('admin.pterodactyl.logs.view', [
            'log' => $log,
        ]);
    }
}
