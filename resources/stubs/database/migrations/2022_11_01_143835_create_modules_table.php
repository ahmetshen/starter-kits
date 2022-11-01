<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Module name. (Log Viewer, Nice Artisan, Settings, Activity Log vb.)
            $table->string('slug_case'); // Module name slug(snake_case). (log_viewer, nice_artisan, setting, activity_log vb.)
            $table->string('permission')->default('empty'); // Module permission name. (log_viewer, view_nice_artisan, block_user, empty vb.)
            $table->string('route')->default('index'); // Module route name. (logs, nice_artisan.index, setting.index, activity.index, index vb.)
            $table->enum('target', ['blank', 'self'])->default('self'); // Module route name target. (_blank, _self vb.)
            $table->string('active_class')->nullable(); // Module route active class name. (navResources(<route_active_class_name>) vb.)
            $table->string('color')->nullable(); // Module color. (info, dark, danger, null vb.)
            $table->string('icon')->default('fas fa-home'); // Module icon. (fas fa-file-code, fas fa-cogs, fas fa-binoculars vb.)
            $table->string('text')->nullable(); // Module text. (trans(<activity.menu_name>, <setting.menu_name>) vb.)
            $table->tinyInteger('order')->default(1); // Module order (1, 2, 3 vb.)
            $table->enum('position', ['navbar', 'sidebar'])->default('sidebar'); // Module position. (navbar, sidebar vb.)
            $table->boolean('status')->default(true); // Module status. (true -> active, false -> passive vb.)
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('modules');
    }
};
