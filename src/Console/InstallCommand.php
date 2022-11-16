<?php

namespace AhmetShen\StarterKits\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

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
            $theme = $this->components->choice(
                'Which design theme you want to use?',
                ['adminlte'],
                0
            );

            // Route Files...
            $this->routeFiles();

            // Database Files...
            $this->databaseFiles();

            // Config File(s)...
            $this->configFiles();

            // App Files...
            $this->appFiles();

            // Table Migrations...
            $this->tableMigrations();

            // Provider Files...
            $this->providerFiles();
        }

        $this->info('starterKits scaffolding installed successfully.');

        $this->comment('The installation process was carried out successfully. Please visit your web page.');
    }

    /**
     * Route Files.
     *
     * @return void
     */
    protected function routeFiles(): void
    {
        $routeFiles = (new Filesystem)->allFiles(__DIR__.'/../../resources/stubs/routes');

        foreach ($routeFiles as $routeFile) {
            $fileName = Str::beforeLast($routeFile->getFilename(), '.stub');

            if ((new Filesystem)->exists(base_path('routes/'.$fileName.'.php'))) {
                (new Filesystem)->delete(base_path('routes/'.$fileName.'.php'));
            }

            (new Filesystem)->copy(__DIR__.'/../../resources/stubs/routes/'.$fileName.'.stub', base_path('routes/'.$fileName.'.php'));

            unset($routeFile);
        }
    }

    /**
     * Database Files.
     *
     * @return void
     */
    protected function databaseFiles(): void
    {
        $this->migrationFiles();

        $this->seederFiles();
    }

    /**
     * Migration Files.
     *
     * @return void
     */
    protected function migrationFiles(): void
    {
        $allMigrationFiles = (new Filesystem)->allFiles(database_path('migrations'));

        foreach ($allMigrationFiles as $allMigrationFile) {
            if ((new Filesystem)->exists(database_path('migrations/'.$allMigrationFile->getFilename()))) {
                (new Filesystem)->delete(database_path('migrations/'.$allMigrationFile->getFilename()));
            }

            unset($allMigrationFile);
        }

        $migrationFiles = (new Filesystem)->allFiles(__DIR__.'/../../resources/stubs/database/migrations');

        foreach ($migrationFiles as $migrationFile) {
            $fileName = Str::beforeLast($migrationFile->getFilename(), '.stub');

            (new Filesystem)->copy(__DIR__.'/../../resources/stubs/database/migrations/'.$fileName.'.stub', database_path('migrations/'.$fileName.'.php'));

            unset($migrationFile);
        }
    }

    /**
     * Seeder Files.
     *
     * @return void
     */
    protected function seederFiles(): void
    {
        $allSeederFiles = (new Filesystem)->allFiles(database_path('seeders'));

        foreach ($allSeederFiles as $allSeederFile) {
            if ((new Filesystem)->exists(database_path('seeders/'.$allSeederFile->getFilename()))) {
                (new Filesystem)->delete(database_path('seeders/'.$allSeederFile->getFilename()));
            }

            unset($allSeederFile);
        }

        $seederFiles = (new Filesystem)->allFiles(__DIR__.'/../../resources/stubs/database/seeders');

        foreach ($seederFiles as $seederFile) {
            $fileName = Str::beforeLast($seederFile->getFilename(), '.stub');

            (new Filesystem)->copy(__DIR__.'/../../resources/stubs/database/seeders/'.$fileName.'.stub', database_path('seeders/'.$fileName.'.php'));

            unset($seederFile);
        }
    }

    /**
     * Config Files.
     *
     * @return void
     */
    protected function configFiles(): void
    {
        (new Filesystem)->copy(__DIR__.'/../../config/starter-kits.php', config_path('starter-kits.php'));
    }

    /**
     * App Files.
     *
     * @return void
     */
    protected function appFiles(): void
    {
        $this->modelFiles();
    }

    /**
     * Model Files.
     *
     * @return void
     */
    protected function modelFiles(): void
    {
        $allModelFiles = (new Filesystem)->allFiles(__DIR__.'/../../resources/stubs/app/Models');

        $changeModels = [
            'Setting' => base_path('vendor/yazan/laravel-settings/src/Models/Setting.php'),
        ];

        foreach ($allModelFiles as $allModelFile) {
            $fileName = Str::beforeLast($allModelFile->getFilename(), '.stub');

            if (Arr::exists($changeModels, $fileName)) {
                if ((new Filesystem)->exists($changeModels[$fileName])) {
                    (new Filesystem)->delete($changeModels[$fileName]);
                }

                (new Filesystem)->copy(__DIR__.'/../../resources/stubs/app/Models/'.$fileName.'.stub', $changeModels[$fileName]);
            } else {
                if ((new Filesystem)->exists(app_path('Models/'.$fileName.'.php'))) {
                    (new Filesystem)->delete(app_path('Models/'.$fileName.'.php'));
                }

                (new Filesystem)->copy(__DIR__.'/../../resources/stubs/app/Models/'.$fileName.'.stub', app_path('Models/'.$fileName.'.php'));
            }

            unset($allModelFile);
        }
    }

    /**
     * Table Migrations.
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
     * Provider Files.
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
