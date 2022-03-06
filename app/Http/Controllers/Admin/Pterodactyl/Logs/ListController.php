<?php

namespace App\Http\Controllers\Admin\Pterodactyl\Logs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PterodactylLogs;

class ListController extends Controller
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
        $logs = PterodactylLogs::all();

        return view('admin.pterodactyl.logs.list', [
            'logs' => $logs,
        ]);
    }

    public function delete($id)
    {

        PterodactylLogs::where('id', $id)->delete();

        return redirect(route('admin.pterodactyl.logs'))->with('success', 'Log supprimé');
    }
}
