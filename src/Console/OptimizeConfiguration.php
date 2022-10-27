<?php

namespace AhmetShen\StarterKits\Console;

use Illuminate\Console\Command;

class OptimizeConfiguration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'starterKits:optimizeConfiguration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Laravel Deployment Optimizing Configuration';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $configurationCommands = [
            'optimize:clear',
            'key:generate',
            'config:cache',
            'route:cache',
            'view:cache',
        ];

        foreach ($configurationCommands as $configurationCommand) {
            $this->call($configurationCommand);

            unset($configurationCommand);
        }
    }
}
