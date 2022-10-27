<?php

namespace AhmetShen\StarterKits\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'starterKits:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the starterKits Components and Resources';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $kit = $this->components->choice(
            'Which Laravel starter kit you want to use?',
            ['Laravel UI (Bootstrap)'],
            0
        );

        if ($kit === "Laravel UI (Bootstrap)") {
            // Config File...
            (new Filesystem)->copy(__DIR__.'/../../config/'.packageName().'.php', config_path(packageName().'.php'));
        }

        $this->info('starterKits scaffolding installed successfully.');

        $this->comment('The installation process was carried out successfully. Please visit your web page.');
    }
}
