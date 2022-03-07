<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\InvoiceItems as Items;
use App\Models\User;
use App\Models\Transactions;
use App\Models\Invoices;

class InvoiceItems extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoice:items {action}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delivery All Pending Product';

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
            if (Items::where('status', 'pending')->count() >= '1') {
                $item = Items::where('status', 'pending')->first();
                if ($item->type == 'add.funds') {
                    $customer = User::find($item->userid);
                    $customer->update(['balance' => $customer->balance + $item->amount]);
                    $this->info('Add funds successful!');
                } elseif ($item->type == 'hosting.game') {
                    \App\Models\PterodactylServices::insert([
                        'userid' => $item->userid,
                        'serviceid' => rand(0000000, 10000000),
                        'offer_id' => $item->productid,
                        'first_price' => $item->amount,
                        'recurrent_price' => $item->amount,
                        'location' => \App\Models\PterodactylNodes::where('id', \App\Models\PterodactylProducts::find($item->productid)->first()->node)->first()->id,
                        'status' => 'pending',
                        'created_at' => now(),
                    ]);
                } elseif ($item->type == 'renew.game') {
                    $PterodactylUnsuspend = new \App\Console\Commands\Pterodactyl\Delivery();
                    $PterodactylUnsuspend->unsuspend($item->productid, $item->invoiceid);
                }
                Items::where('id', $item->id)->update(['status' => 'paid']);
            } else {
                $this->info('Nothing');
            }
        }
    }
}
