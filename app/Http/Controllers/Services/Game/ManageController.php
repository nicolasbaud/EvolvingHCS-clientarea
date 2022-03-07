<?php

namespace App\Http\Controllers\Services\Game;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\View;
use App\Models\PterodactylServices;
use App\Models\PterodactylNodes;
use Illuminate\Support\Facades\Auth;
use Timdesm\PterodactylPhpApi\PterodactylApi;
use App\Models\Invoices;
use App\Models\InvoiceItems;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ManageController extends Controller
{

    private $id;

    public function __construct(Request $request)
    {
        $this->middleware('auth');
    }

    public function render($id)
    {
        $this->service = PterodactylServices::where('serviceid', $id)->where('userid', Auth::user()->id);

        if ($this->service->count() != '1') {
            throw new NotFoundHttpException();
        }

        $this->node = PterodactylNodes::find($this->service->first()->location);
        $this->panel = new PterodactylApi($this->node->fqdn, $this->node->key, 'client');
        $this->panelapp = new PterodactylApi($this->node->fqdn, $this->node->pass, 'application');

        return view('services.game.manage', [
            'application' => $this->panelapp->http,
            'client' => $this->panel->http,
            'baseUri' => $this->panel->baseUri,
            'service' => $this->service,
        ]);
    }

    public function renew($id)
    {
        $service = PterodactylServices::where('serviceid', $id)->where('userid', Auth::user()->id);
        if ($service->count() == '1') {
            $date = new \DateTime(now());
            $due_at = $date->modify('+7 days');
            $invoiceid = rand(00000000, 100000000);
            Invoices::insert([
                'userid' => Auth::user()->id,
                'invoiceid' => $invoiceid,
                'credit' => '0',
                'status' => 'unpaid',
                'due_at' => $due_at,
            ]);
            InvoiceItems::insert([
                'userid' => Auth::user()->id,
                'invoiceid' => $invoiceid,
                'productid' => $service->first()->serviceid,
                'type' => 'renew.game',
                'description' => 'Renouvellement du service #'.$service->first()->serviceid,
                'amount' => $service->first()->recurrent_price,
                'status' => 'unpaid',
            ]);
            return redirect(route('invoice.view', ['id' => $invoiceid]))->with('info', 'Facturé généré avec succès');
        } else {
            throw new NotFoundHttpException();
        }
    }

    public function base_uri()
    {
        return $this->panel->baseUri;
    }
}
