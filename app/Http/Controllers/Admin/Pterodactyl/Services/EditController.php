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
        
        $list = json_decode(json_encode($panelapp->http->get('servers')), true);

        $i = 0;
        foreach ($list as $v) {
            if ($v['external_id'] == $service->serviceid) {
                $pterodactyl = 1;
            } else {
                $pterodactyl = 0;
            }
            $i++;
        }
        
        return view('admin.pterodactyl.services.edit', [
            'service' => $service,
            'client' => $panel->http,
            'application' => $panelapp->http,
            'pterodactyl' => $pterodactyl,
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
            'userid' => 'required|integer|exists:users,id',
            'offer_id' => 'required|integer|exists:pterodactyl_products,id',
            'recurrent_price' => 'required|numeric',
            'location' => 'required|integer|exists:pterodactyl_nodes,id',
            'expired_at' => 'required|date|after:tomorrow',
            'status' => 'required|string|in:active,pending,suspend,expired',
        ]);

        $service = PterodactylServices::find($id);
        $service->update($request->all());

        return redirect(route('admin.pterodactyl.services.edit', ['id' => $id]))->with('success', 'Service édité');
    }
}
