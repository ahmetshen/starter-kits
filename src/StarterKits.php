<?php

namespace AhmetShen\StarterKits;

use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;

class StarterKits
{
    /**
     * The package name.
     *
     * @var string
     */
    const NAME = 'starter-kits';

    /**
     * The package version.
     *
     * @var string
     */
    const VERSION = '0.0.0';

    /**
     * Get the name of the package.
     *
     * @return string
     */
    public function packageName(): string
    {
        return static::NAME;
    }

    /**
     * Get the version number of the package.
     *
     * @return string
     */
    public function packageVersion(): string
    {
        return static::VERSION;
    }

    /**
     * The config value.
     *
     * @param string $configKeyName
     * @return mixed
     */
    public function configValue(string $configKeyName): mixed
    {
        return config($this->packageName().'.'.$configKeyName);
    }

    /**
     * Form properties.
     *
     * @return string[]
     */
    public function formProperties(): array
    {
        return [
            'method' => 'POST',
            'class' => 'form-horizontal',
            'autocomplete' => 'off',
            'novalidate',
        ];
    }

    /**
     * Form input properties.
     *
     * @param string $inputName
     * @param bool $autoFocus
     * @param string $settingGroupName
     * @return array
     */
    public function formInputProperties(string $inputName = 'status', bool $autoFocus = false, string $settingGroupName = 'length'): array
    {
        return match ($inputName) {
            'current_password', 'new_password', 'new_password_confirmation', 'password', 'password_confirmation' => [
                'id' => $inputName,
                'class' => 'form-control',
                'placeholder' => trans('placeholder.'.$inputName),
                $autoFocus ? 'autofocus' : null,
                'required',
                'data-validation-required-message' => trans('form_validation.required'),
                'minlength' => setting('password_min', 'length'),
                'maxlength' => setting('password_max', 'length'),
                'data-validation-minlength-message' => trans('form_validation.minlength', ['attribute' => setting('password_min', 'length')]),
                'data-validation-maxlength-message' => trans('form_validation.maxlength', ['attribute' => setting('password_max', 'length')]),
            ],
            'status' => [
                'id' => 'status',
                'class' => 'form-control',
                'placeholder' => trans('placeholder.status'),
                $autoFocus ? 'autofocus' : null,
                'required',
                'data-validation-required-message' => trans('form_validation.required'),
                'minlength' => 6,
                'maxlength' => 7,
                'data-validation-minlength-message' => trans('form_validation.minlength', ['attribute' => 6]),
                'data-validation-maxlength-message' => trans('form_validation.maxlength', ['attribute' => 7]),
            ],
            default => [
                'id' => $inputName,
                'class' => 'form-control',
                'placeholder' => trans('placeholder.'.$inputName),
                $autoFocus ? 'autofocus' : null,
                'required',
                'data-validation-required-message' => trans('form_validation.required'),
                'minlength' => setting($inputName.'_min', $settingGroupName),
                'maxlength' => setting($inputName.'_max', $settingGroupName),
                'data-validation-minlength-message' => trans('form_validation.minlength', ['attribute' => setting($inputName.'_min', $settingGroupName)]),
                'data-validation-maxlength-message' => trans('form_validation.maxlength', ['attribute' => setting($inputName.'_max', $settingGroupName)]),
            ],
        };
    }

    /**
     * View path.
     *
     * @param string $componentName
     * @param string $viewName
     * @param string $separator
     * @return string|void
     */
    public function viewPath(string $componentName, string $viewName, string $separator = '.')
    {
        if (in_array($componentName, $this->configValue('components'))) {
            if (configValue('folder.status') === true) {
                return configValue('folder.name').$separator.componentProperty($componentName).$separator.componentProperty($componentName, 'theme_name').$separator.$viewName;
            }

            return componentProperty($componentName).$separator.componentProperty($componentName, 'theme_name').$separator.$viewName;
        } else {
            Log::error('ErrorMessage => '.$componentName.' component not found.');

            abort(403, $componentName.' component not found.');
        }
    }

    /**
     * Asset path.
     *
     * @param string $componentName
     * @param string $assetName
     * @param string $separator
     * @return string|void
     */
    public function assetPath(string $componentName, string $assetName, string $separator = '/')
    {
        if (in_array($componentName, $this->configValue('components'))) {
            if (configValue('folder.status') === true) {
                return asset(configValue('folder.name').$separator.componentProperty($componentName).$separator.componentProperty($componentName, 'theme_name').$separator.$assetName);
            }

            return asset(componentProperty($componentName).$separator.componentProperty($componentName, 'theme_name').$separator.$assetName);
        } else {
            Log::error('ErrorMessage => '.$componentName.' component not found.');

            abort(403, $componentName.' component not found.');
        }
    }

    /**
     * Anonymous component namespace.
     *
     * @param string $componentName
     * @param string $separator
     * @return string|void
     */
    public function anonymousComponentNamespace(string $componentName, string $separator = '.')
    {
        if (in_array($componentName, $this->configValue('components'))) {
            if (configValue('folder.status') === true) {
                return configValue('folder.name').$separator.componentProperty($componentName).$separator.componentProperty($componentName, 'theme_name').$separator.'components';
            }

            return componentProperty($componentName).$separator.componentProperty($componentName, 'theme_name').$separator.'components';
        } else {
            Log::error('ErrorMessage => '.$componentName.' component not found.');

            abort(403, $componentName.' component not found.');
        }
    }

    /**
     * Default validation rules.
     *
     * @param string $validationName
     * @return array|string[]
     */
    public function defaultValidationRules(string $validationName): array
    {
        return match ($validationName) {
            'name' => [
                'required',
                'string',
                'min:'.setting('name_min', 'length'),
                'max:'.setting('name_max', 'length'),
                'between:'.setting('name_min', 'length').','.setting('name_max', 'length'),
            ],
            'email' => [
                'required',
                'string',
                'email',
                'min:'.setting('email_min', 'length'),
                'max:'.setting('email_max', 'length'),
                'between:'.setting('email_min', 'length').','.setting('email_max', 'length'),
            ],
            'password' => [
                'required',
                'string',
                'max:'.setting('password_max', 'length'),
                Rules\Password::defaults(),
                'between:'.setting('password_min', 'length').','.setting('password_max', 'length'),
            ],
            default => [
                'required',
                'string',
            ],
        };
    }
}
