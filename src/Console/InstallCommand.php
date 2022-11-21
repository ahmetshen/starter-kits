<?php

namespace AhmetShen\StarterKits\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class InstallCommand extends Command
{
    use DeleteFiles;

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

    public array $changeModels = [];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->changeModels = [
            'Setting' => base_path('vendor/yazan/laravel-settings/src/Models/Setting.php'),
        ];
    }

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
            $theme = $this->components->choice(
                'Which design theme you want to use?',
                ['adminlte'],
                0
            );

            // Delete Files...
            $this->deleteFiles();

            // extension-activity-logs Files...
            $this->extensionActivityLogs();

            // App Files...
            $this->appFiles();

            // Config File(s)...
            $this->configFiles();

            // Database Files...
            $this->databaseFiles();

            // Route Files...
            $this->routeFiles();

            // Table Migrations...
            $this->tableMigrations();

            // Provider Files...
            $this->providerFiles();
        }

        $this->info('starterKits scaffolding installed successfully.');

        $this->comment('The installation process was carried out successfully. Please visit your web page.');
    }

    /**
     * Log activity inside your laravel application.
     *
     * @return void
     */
    protected function extensionActivityLogs(): void
    {
        $this->call('extensionActivityLogs:install');
    }

    /**
     * App files.
     *
     * @return void
     */
    protected function appFiles(): void
    {
        $this->modelFiles();
    }

    /**
     * Model files.
     *
     * @return void
     */
    protected function modelFiles(): void
    {
        $allModelFiles = (new Filesystem)->allFiles(__DIR__.'/../../resources/stubs/app/Models');

        foreach ($allModelFiles as $allModelFile) {
            $fileName = Str::beforeLast($allModelFile->getFilename(), '.stub');

            if (Arr::exists($this->changeModels, $fileName)) {
                (new Filesystem)->copy(__DIR__.'/../../resources/stubs/app/Models/'.$fileName.'.stub', $this->changeModels[$fileName]);
            } else {
                (new Filesystem)->copy(__DIR__.'/../../resources/stubs/app/Models/'.$fileName.'.stub', app_path('Models/'.$fileName.'.php'));
            }

            unset($allModelFile);
        }
    }

    /**
     * Config files.
     *
     * @return void
     */
    protected function configFiles(): void
    {
        (new Filesystem)->copy(__DIR__.'/../../config/starter-kits.php', config_path('starter-kits.php'));
    }

    /**
     * Database files.
     *
     * @return void
     */
    protected function databaseFiles(): void
    {
        $this->migrationFiles();

        $this->seederFiles();
    }

    /**
     * Migration files.
     *
     * @return void
     */
    protected function migrationFiles(): void
    {
        $migrationFiles = (new Filesystem)->allFiles(__DIR__.'/../../resources/stubs/database/migrations');

        foreach ($migrationFiles as $migrationFile) {
            $fileName = Str::beforeLast($migrationFile->getFilename(), '.stub');

            (new Filesystem)->copy(__DIR__.'/../../resources/stubs/database/migrations/'.$fileName.'.stub', database_path('migrations/'.$fileName.'.php'));

            unset($migrationFile);
        }
    }

    /**
     * Seeder files.
     *
     * @return void
     */
    protected function seederFiles(): void
    {
        $seederFiles = (new Filesystem)->allFiles(__DIR__.'/../../resources/stubs/database/seeders');

        foreach ($seederFiles as $seederFile) {
            $fileName = Str::beforeLast($seederFile->getFilename(), '.stub');

            (new Filesystem)->copy(__DIR__.'/../../resources/stubs/database/seeders/'.$fileName.'.stub', database_path('seeders/'.$fileName.'.php'));

            unset($seederFile);
        }
    }

    /**
     * Route files.
     *
     * @return void
     */
    protected function routeFiles(): void
    {
        $routeFiles = (new Filesystem)->allFiles(__DIR__.'/../../resources/stubs/routes');

        foreach ($routeFiles as $routeFile) {
            $fileName = Str::beforeLast($routeFile->getFilename(), '.stub');

            (new Filesystem)->copy(__DIR__.'/../../resources/stubs/routes/'.$fileName.'.stub', base_path('routes/'.$fileName.'.php'));

            unset($routeFile);
        }
    }

    /**
     * Table migrations.
     *
     * @return void
     */
    protected function tableMigrations(): void
    {
        if (Schema::hasTable('migrations')) {
            $this->call('migrate:refresh');
        } else {
            $this->call('migrate');
        }

        $this->call('db:seed');
    }

    /**
     * Provider files.
     *
     * @return void
     */
    protected function providerFiles(): void
    {
        $allProviderFiles = (new Filesystem)->allFiles(__DIR__.'/../../resources/stubs/app/Providers');

        foreach ($allProviderFiles as $allProviderFile) {
            $fileName = Str::beforeLast($allProviderFile->getFilename(), '.stub');

            (new Filesystem)->copy(__DIR__.'/../../resources/stubs/app/Providers/'.$fileName.'.stub', app_path('Providers/'.$fileName.'.php'));

            unset($allProviderFile);
        }
    }
}
