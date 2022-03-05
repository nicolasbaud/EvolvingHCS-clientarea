<?php

namespace App\Http\Controllers\Admin\Pterodactyl\Services;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PterodactylNodes;
use App\Models\PterodactylServices;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Timdesm\PterodactylPhpApi\PterodactylApi;

class EditController extends Controller
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
        $service = PterodactylServices::find($id);

        if (!$service) {
            throw new NotFoundHttpException();
        }

        $node = PterodactylNodes::find($service->location);
        $panel = new PterodactylApi($node->fqdn, $node->key, 'client');
        $panelapp = new PterodactylApi($node->fqdn, $node->pass, 'application');

        return view('admin.pterodactyl.services.edit', [
            'service' => $service,
            'client' => $panel->http,
            'application' => $panelapp->http,
        ]);
    }

    public function power($id, $signal)
    {
        $service = PterodactylServices::find($id);

        if (!$service) {
            throw new NotFoundHttpException();
        }

        $node = PterodactylNodes::find($service->location);
        $panel = new PterodactylApi($node->fqdn, $node->key, 'client');
        $panelapp = new PterodactylApi($node->fqdn, $node->pass, 'application');

        if ($signal == 'suspend' || $signal == 'unsuspend') {
            $panelapp->http->post('servers/'.$panelapp->http->get('servers/external/'.$service->serviceid)->id.'/'.$signal);
        }

        if ($signal == 'delete') {
            $panelapp->http->delete('servers/'.$panelapp->http->get('servers/external/'.$service->serviceid)->id);
        }

        return redirect(route('admin.pterodactyl.services.edit', ['id' => $id]))->with('success', 'Action effectuée');
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
}
