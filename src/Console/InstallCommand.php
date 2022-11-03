<?php

namespace AhmetShen\StarterKits\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
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

            // Config File...
            (new Filesystem)->copy(__DIR__.'/../../config/'.packageName().'.php', config_path(packageName().'.php'));
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
        $routeFiles = [
            'auth',
            'breadcrumbs',
            'dashboard',
        ];

        foreach ($routeFiles as $routeFile) {
            (new Filesystem)->copy(__DIR__.'/../../resources/stubs/routes/'.$routeFile.'.stub', base_path('routes/'.$routeFile.'.php'));

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

    protected function migrationFiles()
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

            (new Filesystem)->copy(__DIR__.'/../../resources/stubs/database/migrations/'.$fileName.'.stub', database_path('migrations/'.date('Y_m_d_His').'_'.$fileName.'.php'));

            unset($migrationFile);
        }
    }

    protected function seederFiles()
    {
        //
    }
}
