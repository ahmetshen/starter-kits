<?php

namespace AhmetShen\StarterKits\Observers;

use AhmetShen\StarterKits\Models\Module;

class ModuleObserver
{
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
        //
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
