<?php

namespace AhmetShen\StarterKits;

use Illuminate\Support\Facades\Log;

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
     * @return array
     */
    public function formInputProperties(string $inputName = 'status', bool $autoFocus = false): array
    {
        return match ($inputName) {
            'current_password', 'new_password', 'new_password_confirmation' => [
                'id' => $inputName,
                'class' => 'form-control',
                'placeholder' => trans('placeholder.'.$inputName),
                $autoFocus ? 'autofocus' : null,
                'required',
                'data-validation-required-message' => trans('form_validation.required'),
                'minlength' => configValue('length.password.min'),
                'maxlength' => configValue('length.password.max'),
                'data-validation-minlength-message' => trans('form_validation.minlength', ['attribute' => configValue('length.password.min')]),
                'data-validation-maxlength-message' => trans('form_validation.maxlength', ['attribute' => configValue('length.password.max')]),
            ],
            'status' => [
                'id' => $inputName,
                'class' => 'form-control',
                'placeholder' => trans('placeholder.'.$inputName),
                $autoFocus ? 'autofocus' : null,
                'required',
                'data-validation-required-message' => trans('form_validation.required'),
                'minlength' => configValue('length.status.min'),
                'maxlength' => configValue('length.status.max'),
                'data-validation-minlength-message' => trans('form_validation.minlength', ['attribute' => configValue('length.status.min')]),
                'data-validation-maxlength-message' => trans('form_validation.maxlength', ['attribute' => configValue('length.status.max')]),
            ],
            default => [
                'id' => $inputName,
                'class' => 'form-control',
                'placeholder' => trans('placeholder.'.$inputName),
                $autoFocus ? 'autofocus' : null,
                'required',
                'data-validation-required-message' => trans('form_validation.required'),
                'minlength' => setting($inputName.'_min', 'length'),
                'maxlength' => setting($inputName.'_max', 'length'),
                'data-validation-minlength-message' => trans('form_validation.minlength', ['attribute' => setting($inputName.'_min', 'length')]),
                'data-validation-maxlength-message' => trans('form_validation.maxlength', ['attribute' => setting($inputName.'_max', 'length')]),
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
                return configValue('folder.name').$separator.componentProperty($componentName, 'folder_name').$separator.componentProperty($componentName, 'theme_name').$separator.'pages'.$separator.$viewName;
            }

            return componentProperty($componentName, 'folder_name').$separator.componentProperty($componentName, 'theme_name').$separator.'pages'.$separator.$viewName;
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
                return asset(configValue('folder.name').$separator.componentProperty($componentName, 'folder_name').$separator.componentProperty($componentName, 'theme_name').$separator.$assetName);
            }

            return asset(componentProperty($componentName, 'folder_name').$separator.componentProperty($componentName, 'theme_name').$separator.$assetName);
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
                return configValue('folder.name').$separator.componentProperty($componentName, 'folder_name').$separator.componentProperty($componentName, 'theme_name').$separator.'components';
            }

            return componentProperty($componentName, 'folder_name').$separator.componentProperty($componentName, 'theme_name').$separator.'components';
        } else {
            Log::error('ErrorMessage => '.$componentName.' component not found.');

            abort(403, $componentName.' component not found.');
        }
    }
}
