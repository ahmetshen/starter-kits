<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use AhmetShen\StarterKits\Models\Module;
use Illuminate\Database\Seeder;

class ModulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        //$this->navbarModules();

        $this->sidebarModules();
    }

    /**
     * Create navbar modules.
     *
     * @return void
     */
    protected function navbarModules(): void
    {
        $modules = [
            [
                'name' => '',
                'permission' => '',
                'route' => '',
                'target' => '',
                'active_class' => '',
                'color' => null,
                'icon' => '',
                'text' => '',
                'order' => 1,
                'position' => 'navbar',
                'status' => true,
            ],
        ];

        $this->createModules($modules);
    }

    /**
     * Create sidebar modules.
     *
     * @return void
     */
    protected function sidebarModules(): void
    {
        $modules = [
            [
                'name' => 'Modules',
                'permission' => 'view_modules',
                'route' => 'modules.index',
                'target' => 'self',
                'active_class' => 'modules',
                'color' => null,
                'icon' => 'fas fa-boxes',
                'text' => 'menu.modules_name',
                'order' => 1,
                'position' => 'sidebar',
                'status' => true,
            ],
            [
                'name' => 'Settings',
                'permission' => 'view_settings',
                'route' => 'settings.index',
                'target' => 'self',
                'active_class' => 'settings',
                'color' => null,
                'icon' => 'fas fa-cogs',
                'text' => 'menu.settings_name',
                'order' => 2,
                'position' => 'sidebar',
                'status' => true,
            ],
        ];

        $this->createModules($modules);
    }

    /**
     * Create modules.
     *
     * @param array $modules
     * @return void
     */
    protected function createModules(array $modules = []): void
    {
        foreach ($modules as $module) {
            Module::create($module);

            unset($module);
        }
    }
}
