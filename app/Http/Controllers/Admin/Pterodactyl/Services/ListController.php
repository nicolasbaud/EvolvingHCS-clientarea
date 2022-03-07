<?php

namespace App\Http\Controllers\Admin\Pterodactyl\Services;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PterodactylServices;

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
        $services = PterodactylServices::all();

        return view('admin.pterodactyl.services.list', [
            'services' => $services,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'location_id' => 'required|numeric',
            'fqdn' => 'required|url',
            'key' => 'required',
            'pass' => 'required',
        ]);

        PterodactylNodes::create($request->all());

        return redirect(route('admin.pterodactyl.nodes'))->with('success', 'Node créé');
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'name' => 'required',
            'location_id' => 'required|numeric',
            'fqdn' => 'required|url',
            'key' => 'required',
            'pass' => 'required',
        ]);

        $node = PterodactylNodes::find($id);
        
        $node->fill(['status' => 'public']);
        $node->update($request->all());

        return redirect(route('admin.pterodactyl.nodes'))->with('success', 'Node édité');
    }

    public function delete($id)
    {

        PterodactylServices::where('id', $id)->delete();

        return redirect(route('admin.pterodactyl.services'))->with('success', 'Service supprimé');
    }
}
