<?php
namespace App\Console\Commands\Environment;

use DateTimeZone;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Validation\Factory as ValidatorFactory;
use App\Traits\Commands\EnvironmentWriterTrait;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Support\Str;

class AppSettingsCommand extends Command
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
    protected $description = 'Édite le nom de l\'application.';

    /**
     * @var string
     */
    protected $signature = 'evolving:setup:name
                            {--name= : The Name that this Panel is running on.}';

    /**
     * @var array
     */
    protected $variables = [];

    /**
     * AppSettingsCommand constructor.
     */
    public function __construct(ConfigRepository $config, Kernel $command, ValidatorFactory $validator)
    {
        parent::__construct();

        $this->config = $config;
        $this->command = $command;
        $this->validator = $validator;
    }

    /**
     * Handle command execution.
     *
     * @throws \Exception
     */
    public function handle()
    {
        $this->output->note('Nom de l\'application');
        $this->variables['APP_NAME'] = $this->option('name') ?? $this->ask(
            'Nom de l\'application',
            $this->config->get('app.name')
        );

        $this->writeToEnvironment($this->variables);

        $this->info($this->command->output());
    }
}