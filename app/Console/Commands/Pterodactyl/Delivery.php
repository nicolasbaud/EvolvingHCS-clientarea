<?php

namespace App\Console\Commands\Pterodactyl;

use Timdesm\PterodactylPhpApi\PterodactylApi;
use App\Models\PterodactylServices;
use App\Models\PterodactylNodes;
use App\Models\PterodactylProducts;
use App\Models\PterodactylLogs;
use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Invoices;
use App\Models\InvoiceItems;
use Illuminate\Support\Str;

class Delivery extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pterodactyl {action}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pterodactyl Action';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if ($this->argument('action') == 'delivery') {
            $this->delivery();
        } elseif ($this->argument('action') == 'deadline') {
            $this->deadline();
        }
    }

    public function delivery()
    {
        // Model Pterodactyl Services
        $PterodactylCount = PterodactylServices::where('status', 'pending');
        // Get Service pending
        if ($PterodactylCount->count() >= '1') {
            $PterodactylServices = PterodactylServices::where('id', $PterodactylCount->first()->id)->first();
            // Get Pterodactyl Products
            $PterodactylProducts = PterodactylProducts::where('id', $PterodactylServices->offer_id)->first();
            // Set Expiration
            $date = new \DateTime(now());
            $expiration = $date->modify('+1 month');
            // Get Node
            $node = PterodactylNodes::find($PterodactylServices->location);
            // Connect to Pterodactyl API
            $pterodactyl = new PterodactylApi($node->fqdn, $node->pass, 'application');
            // Get User
            try {
                $getAccount = $pterodactyl->users->all(['filter[email]' => User::find($PterodactylServices->userid)->email]);
                if (!isset($getAccount[0]->id)) {
                    $user = User::find($PterodactylServices->userid);
                    $logAccount = $pterodactyl->users->create([
                        'email' => $user->email,
                        'username' => 'customer'.$user->id,
                        'first_name' => $user->firstname,
                        'last_name' => $user->lastname,
                    ]);
                    $userId = $logAccount->id;
                } else {
                    $userId = $getAccount[0]->id;
                }
            } catch (\Exception $e) {
                PterodactylLogs::create([
                    'serviceid' => $PterodactylServices->serviceid,
                    'name' => 'Delivery',
                    'type' => 'error',
                    'result' => json_encode($e),
                ]);
            }
            try {
                // Create Server
                $eggConfig = $pterodactyl->nest_eggs->get($PterodactylProducts->nest, $PterodactylProducts->egg, ['include' =>'variables']);
                $environment = [];
                foreach(json_decode(json_encode($eggConfig), true)['relationships']['variables'] as $key => $val) {
                    $attr = $val;
                    $var = $attr['env_variable'];
                    $default = $attr['default_value'];
                    if(isset($friendlyName)) $environment[$var] = $friendlyName;
                    elseif(isset($envName)) $environment[$var] = $envName;
                    else $environment[$var] = $default;
                }
                $logCreate = $pterodactyl->servers->create([
                    'name' => Str::random(10),
                    'external_id' => $PterodactylServices->serviceid,
                    'user' => $userId,
                    'egg' => $eggConfig->id,
                    'docker_image' => $eggConfig->docker_image,
                    'startup' => $eggConfig->startup,
                    'environment' => $environment,
                    'limits' => [
                        'memory' => $PterodactylProducts->memory,
                        'swap' => $PterodactylProducts->swap,
                        'disk' => $PterodactylProducts->disk,
                        'io' => '500',
                        'cpu' => $PterodactylProducts->cpu,
                    ],
                    'feature_limits' => [
                        'databases' => $PterodactylProducts->databases,
                        'backups' => $PterodactylProducts->backups,
                        'allocations' => $PterodactylProducts->allocations,
                    ],
                    'deploy' => [
                        'locations'    => [$node->location_id],
                        'dedicated_ip' => false,
                        'port_range'   => [],
                    ],
                ]);
                // Update Pterodactyl Services Status
                PterodactylServices::where('id', $PterodactylServices->id)->update([
                    'status' => 'active',
                    'expired_at' => $expiration,
                ]);
                PterodactylLogs::insert([
                    'serviceid' => $PterodactylServices->serviceid,
                    'name' => 'Delivery',
                    'type' => 'high',
                    'result' => json_encode($logCreate),
                    'created_at' => now(),
                ]);
                $this->info('Pterodactyl Delivery Service: ✅');
            } catch (\Exception $e) {
                PterodactylLogs::insert([
                    'serviceid' => $PterodactylServices->serviceid,
                    'name' => 'Delivery',
                    'type' => 'error',
                    'result' => json_encode($e),
                    'created_at' => now(),
                ]);
                $this->error('Pterodactyl Delivery Service Failed');
            }
        } else {
            $this->info('Nothing');
        }
    }

    public function deadline()
    {
        $count = PterodactylServices::where('status', 'active')->where('expired_at', '<=', now())->count();
        if ($count >= '1') {
            $service = PterodactylServices::where('status', 'active')->where('expired_at', '<=', now())->first();

            $node = PterodactylNodes::find($service->location);
            $pterodactyl = new PterodactylApi($node->fqdn, $node->pass, 'application');
            $suspend = $pterodactyl->http->post('servers/'.$pterodactyl->http->get('servers/external/'.$service->serviceid)->id.'/suspend');
            $date = new \DateTime(now());
            $due_at = $date->modify('+7 days');
            $invoiceid = rand(0000000, 10000000);
            Invoices::insert([
                'userid' => $service->userid,
                'invoiceid' => $invoiceid,
                'credit' => '0',
                'status' => 'unpaid',
                'due_at' => $due_at,
            ]);
            InvoiceItems::insert([
                'userid' => $service->userid,
                'invoiceid' => $invoiceid,
                'productid' => $service->serviceid,
                'type' => 'renew.game',
                'description' => 'Renouvellement du service #'.$service->serviceid,
                'amount' => $service->recurrent_price,
                'status' => 'unpaid',
            ]);
            PterodactylServices::where('id', $service->id)->update(['status' => 'suspend']);
            PterodactylLogs::insert([
                'serviceid' => $service->serviceid,
                'name' => 'Suspend',
                'type' => 'high',
                'result' => json_encode($suspend),
                'created_at' => now(),
            ]);
            $this->info('Pterodactyl Suspend Service: ✅');
        } else {
            $this->info('Nothing');
        }
    }

    public function unsuspend($serviceid, $invoiceid)
    {
        $PterodactylCount = PterodactylServices::where('serviceid', $serviceid)->count();
        if ($PterodactylCount >= '1') {
            $service = PterodactylServices::where('serviceid', $serviceid)->first();

            $date = new \DateTime($service->expired_at);
            $newExpirationDate = $date->modify('+1 month');

            $node = PterodactylNodes::find($service->location);
            $pterodactyl = new PterodactylApi($node->fqdn, $node->pass, 'application');
            $unsuspend = $pterodactyl->http->post('servers/'.$pterodactyl->http->get('servers/external/'.$service->serviceid)->id.'/unsuspend');
            InvoiceItems::where('invoiceid', $invoiceid)->update([
                'status' => 'paid',
            ]);
            PterodactylServices::where('serviceid', $service->serviceid)->update([
                'status' => 'active',
                'expired_at' => $newExpirationDate
            ]);
            PterodactylLogs::insert([
                'serviceid' => $service->serviceid,
                'name' => 'UnSuspend',
                'type' => 'high',
                'result' => json_encode($unsuspend),
                'created_at' => now(),
            ]);
        }
    }
}
