<?php

namespace App\Console\Commands\Environment;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class SetupApplicationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        Artisan::call('down');
        Artisan::call('evolving:environment:database');
        Artisan::call('php artisan migrate');
        Artisan::call('evolving:environment:app');
        Artisan::call('evolving:environment:mail');
        Artisan::call('up');
        $this->info('Done !');
    }
}