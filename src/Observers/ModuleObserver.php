<?php

namespace AhmetShen\StarterKits\Observers;

use AhmetShen\StarterKits\Models\Module;

class ModuleObserver
{
    /**
     * Handle the Module "creating" event.
     *
     * @param Module $module
     * @return void
     */
    public function creating(Module $module): void
    {
        if (is_null($module->order)) {
            $module->order = Module::where('position', '=', $module->position)->max('order') + 1;

            return;
        }

        $lowerPriorityModules = Module::where('position', '=', $module->position)
                                        ->where('order', '>=', $module->order)
                                        ->get();

        foreach ($lowerPriorityModules as $lowerPriorityModule) {
            $lowerPriorityModule->order++;

            $lowerPriorityModule->saveQuietly();

            unset($lowerPriorityModule);
        }
    }

    /**
     * Handle the Module "created" event.
     *
     * @param Module $module
     * @return void
     */
    public function created(Module $module): void
    {
        //
    }

    /**
     * Handle the Module "updating" event.
     *
     * @param Module $module
     * @return void
     */
    public function updating(Module $module): void
    {
        if ($module->isClean('order')) {
            return;
        }

        if (is_null($module->order)) {
            $module->order = Module::where('position', '=', $module->position)->max('order');
        }

        if ($module->getOriginal('order') > $module->order) {
            $orderRange = [
                $module->order, $module->getOriginal('order')
            ];
        } else {
            $orderRange = [
                $module->getOriginal('order'), $module->order
            ];
        }

        $lowerPriorityModules = Module::where('position', '=', $module->position)
                                        ->where('id', '!=', $module->id)
                                        ->whereBetween('order', $orderRange)
                                        ->get();

        foreach ($lowerPriorityModules as $lowerPriorityModule) {
            if ($module->getOriginal('order') < $module->order) {
                $lowerPriorityModule->order--;
            } else {
                $lowerPriorityModule->order++;
            }

            $lowerPriorityModule->saveQuietly();

            unset($lowerPriorityModule);
        }
    }

    /**
     * Handle the Module "updated" event.
     *
     * @param Module $module
     * @return void
     */
    public function updated(Module $module): void
    {
        //
    }

    /**
     * Handle the Module "deleted" event.
     *
     * @param Module $module
     * @return void
     */
    public function deleted(Module $module): void
    {
        $lowerPriorityModules = Module::where('position', '=', $module->position)
                                        ->where('order', '>', $module->order)
                                        ->get();

        foreach ($lowerPriorityModules as $lowerPriorityModule) {
            $lowerPriorityModule->order--;

            $lowerPriorityModule->saveQuietly();

            unset($lowerPriorityModule);
        }
    }

    /**
     * Handle the Module "restored" event.
     *
     * @param Module $module
     * @return void
     */
    public function restored(Module $module): void
    {
        //
    }

    /**
     * Handle the Module "force deleted" event.
     *
     * @param Module $module
     * @return void
     */
    public function forceDeleted(Module $module): void
    {
        //
    }
}
