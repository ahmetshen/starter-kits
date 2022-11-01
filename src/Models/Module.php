<?php

namespace AhmetShen\StarterKits\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Module extends Model
{
    use LogsActivity, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug_case',
        'permission',
        'route',
        'target',
        'active_class',
        'color',
        'icon',
        'text',
        'order',
        'position',
        'status',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted(): void
    {
        parent::boot();

        static::creating(function ($module) {
            $module->slug_case = str($module->name)->lower()->snake();
        });
    }

    /**
     * Activity log options.
     *
     * @return LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
                    ->logAll()
                    ->logFillable()
                    ->setDescriptionForEvent(fn(string $eventName) => 'This model has been '.$eventName)
                    ->useLogName('Modules');
    }

    /**
     * Interact with the module's name.
     *
     * @return Attribute
     */
    protected function name(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => str($value)->lower()->title(),
        );
    }

    /**
     * Interact with the module's permission.
     *
     * @return Attribute
     */
    protected function permission(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => str($value)->lower()->snake(),
        );
    }

    /**
     * Interact with the module's route.
     *
     * @return Attribute
     */
    protected function route(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => str($value)->lower(),
        );
    }

    /**
     * Interact with the module's target.
     *
     * @return Attribute
     */
    protected function target(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => '_'.$value,
            set: fn ($value) => str($value)->lower(),
        );
    }

    /**
     * Interact with the module's active_class.
     *
     * @return Attribute
     */
    protected function activeClass(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => str($value)->lower()->snake(),
        );
    }

    /**
     * Interact with the module's color.
     *
     * @return Attribute
     */
    protected function color(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => empty($value) ? '-' : str($value)->lower()->kebab(),
            set: fn ($value) => str($value)->lower()->kebab(),
        );
    }

    /**
     * Interact with the module's icon.
     *
     * @return Attribute
     */
    protected function icon(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => str($value)->lower(),
        );
    }

    /**
     * Interact with the module's text.
     *
     * @return Attribute
     */
    protected function text(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => str($value)->lower(),
        );
    }

    /**
     * Interact with the module's order.
     *
     * @return Attribute
     */
    protected function order(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => (int) $value,
        );
    }

    /**
     * Interact with the module's position.
     *
     * @return Attribute
     */
    protected function position(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => str($value)->lower(),
        );
    }

    /**
     * Interact with the module's status.
     *
     * @return Attribute
     */
    protected function status(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value === true) ? trans('status.active') : trans('status.passive'),
        );
    }

    /**
     * Interact with the module's created_at.
     *
     * @return Attribute
     */
    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => fullDateFormat($value),
        );
    }

    /**
     * Interact with the module's updated_at.
     *
     * @return Attribute
     */
    protected function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => fullDateFormat($value),
        );
    }

    /**
     * Interact with the module's deleted_at.
     *
     * @return Attribute
     */
    protected function deletedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => empty($value) ? '-' : fullDateFormat($value),
        );
    }
}
