<?php

namespace App\Console\Commands\Environment;

use Illuminate\Console\Command;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class SetupApplicationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'evolving:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup Application';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->info('Commande indisponible !');
        $this->info('Veuillez utiliser la commande :');
        $this->info('bash <(curl https://api.evolving-hcs.com/install/setup.sh)');
    }
}