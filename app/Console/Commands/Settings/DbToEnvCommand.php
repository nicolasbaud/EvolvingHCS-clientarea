<?php
namespace App\Console\Commands\Settings;

use DateTimeZone;
use Illuminate\Console\Command;
use App\Traits\Commands\EnvironmentWriterTrait;
use App\Models\Setting;
use Illuminate\Support\Facades\Artisan;

class DbToEnvCommand extends Command
{
    use EnvironmentWriterTrait;

    /**
     * @var \Illuminate\Contracts\Console\Kernel
     */
    protected $command;

    /**
     * @var \Illuminate\Contracts\Config\Repository
     */
    protected $config;

    /**
     * @var string
     */
    protected $description = 'Mets à jour les paramètres de l\'application.';

    /**
     * @var string
     */
    protected $signature = 'evolving:setup:dbtoenv';

    /**
     * @var array
     */
    protected $variables = [];

    /**
     * AppSettingsCommand constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Handle command execution.
     *
     * @throws \Exception
     */
    public function handle()
    {
        if (Setting::count() != '0') {

            $settings = Setting::all();

            foreach ($settings as $setting) {
                $this->variables[$setting->key] = $setting->value;
            }
            
            $this->writeToEnvironment($this->variables);

            Setting::orderBy('id', 'DESC')->delete();

            $this->info('Ok !');
            Artisan::call('config:clear');
        } else {
            $this->info('Nothing');
        }
    }
}