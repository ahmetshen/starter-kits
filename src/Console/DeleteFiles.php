<?php

namespace AhmetShen\StarterKits\Console;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

trait DeleteFiles
{
    /**
     * Delete files.
     *
     * @return void
     */
    protected function deleteFiles(): void
    {
        $this->deleteAppFiles();

        $this->deleteDatabaseFiles();

        $this->deleteRouteFiles();
    }

    /**
     * Delete app files.
     *
     * @return void
     */
    protected function deleteAppFiles(): void
    {
        $this->deleteModelFiles();
    }

    /**
     * Delete model files.
     *
     * @return void
     */
    protected function deleteModelFiles(): void
    {
        $allModelFiles = (new Filesystem)->allFiles(__DIR__.'/../../resources/stubs/app/Models');

        foreach ($allModelFiles as $allModelFile) {
            $fileName = Str::beforeLast($allModelFile->getFilename(), '.stub');

            if (Arr::exists($this->changeModels, $fileName)) {
                if ((new Filesystem)->exists($this->changeModels[$fileName])) {
                    (new Filesystem)->delete($this->changeModels[$fileName]);
                }
            } else {
                if ((new Filesystem)->exists(app_path('Models/'.$fileName.'.php'))) {
                    (new Filesystem)->delete(app_path('Models/'.$fileName.'.php'));
                }
            }

            unset($allModelFile);
        }
    }

    /**
     * Delete database files.
     *
     * @return void
     */
    protected function deleteDatabaseFiles(): void
    {
        $this->deleteMigrationFiles();

        $this->deleteSeederFiles();
    }

    /**
     * Delete migration files.
     *
     * @return void
     */
    protected function deleteMigrationFiles(): void
    {
        $allMigrationFiles = (new Filesystem)->allFiles(database_path('migrations'));

        foreach ($allMigrationFiles as $allMigrationFile) {
            if ((new Filesystem)->exists(database_path('migrations/'.$allMigrationFile->getFilename()))) {
                (new Filesystem)->delete(database_path('migrations/'.$allMigrationFile->getFilename()));
            }

            unset($allMigrationFile);
        }
    }

    /**
     * Delete seeder files.
     *
     * @return void
     */
    protected function deleteSeederFiles(): void
    {
        $allSeederFiles = (new Filesystem)->allFiles(database_path('seeders'));

        foreach ($allSeederFiles as $allSeederFile) {
            if ((new Filesystem)->exists(database_path('seeders/'.$allSeederFile->getFilename()))) {
                (new Filesystem)->delete(database_path('seeders/'.$allSeederFile->getFilename()));
            }

            unset($allSeederFile);
        }
    }

    /**
     * Delete route files.
     *
     * @return void
     */
    protected function deleteRouteFiles(): void
    {
        $routeFiles = (new Filesystem)->allFiles(__DIR__.'/../../resources/stubs/routes');

        foreach ($routeFiles as $routeFile) {
            $fileName = Str::beforeLast($routeFile->getFilename(), '.stub');

            if ((new Filesystem)->exists(base_path('routes/'.$fileName.'.php'))) {
                (new Filesystem)->delete(base_path('routes/'.$fileName.'.php'));
            }

            unset($routeFile);
        }
    }
}
