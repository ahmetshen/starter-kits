<?php

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Filesystem\Filesystem;
use Jenssegers\Agent\Agent;
use Yazan\Setting\Setting;

if (! function_exists('packageName')) {
    /**
     * Package name.
     *
     * @param string $packageName
     * @return mixed
     */
    function packageName(string $packageName = 'starter-kits'): mixed
    {
        return match($packageName) {
            'starter-kits' => StarterKits::packageName(),
        };
    }
}

if (! function_exists('packageVersion')) {
    /**
     * Package version.
     *
     * @param string $packageName
     * @return mixed
     */
    function packageVersion(string $packageName = 'starter-kits'): mixed
    {
        return match($packageName) {
            'starter-kits' => StarterKits::packageVersion(),
        };
    }
}

if (! function_exists('configValue')) {
    /**
     * Config value.
     *
     * @param string $configKeyName
     * @param string $packageName
     * @return mixed
     */
    function configValue(string $configKeyName, string $packageName = 'starter-kits'): mixed
    {
        $configKeyName = str($configKeyName)->lower()->snake();

        return match($packageName) {
            'starter-kits' => StarterKits::configValue($configKeyName),
        };
    }
}

if (! function_exists('formProperties')) {
    /**
     * Form properties.
     *
     * @return mixed
     */
    function formProperties(): mixed
    {
        return StarterKits::formProperties();
    }
}

if (! function_exists('formInputProperties')) {
    /**
     * Form input properties.
     *
     * @param string $inputName
     * @param bool $autoFocus
     * @return mixed
     */
    function formInputProperties(string $inputName = 'status', bool $autoFocus = false): mixed
    {
        $inputName = str($inputName)->lower()->snake();

        return StarterKits::formInputProperties($inputName, $autoFocus);
    }
}

if (! function_exists('viewPath')) {
    /**
     * View path.
     *
     * @param string $componentName
     * @param string $viewName
     * @param string $separator
     * @return mixed
     */
    function viewPath(string $componentName, string $viewName, string $separator = '.'): mixed
    {
        $componentName = str($componentName)->lower();

        $viewName = str($viewName)->lower()->kebab();

        return StarterKits::viewPath($componentName, $viewName, $separator);
    }
}

if (! function_exists('assetPath')) {
    /**
     * Asset path.
     *
     * @param string $componentName
     * @param string $assetName
     * @param string $separator
     * @return mixed
     */
    function assetPath(string $componentName, string $assetName, string $separator = '/'): mixed
    {
        $componentName = str($componentName)->lower();

        return StarterKits::assetPath($componentName, $assetName, $separator);
    }
}

if (! function_exists('anonymousComponentNamespace')) {
    /**
     * Anonymous component namespace.
     *
     * @param string $componentName
     * @return mixed
     */
    function anonymousComponentNamespace(string $componentName): mixed
    {
        $componentName = str($componentName)->lower();

        return StarterKits::anonymousComponentNamespace($componentName);
    }
}

if (! function_exists('componentProperty')) {
    /**
     * Component property.
     *
     * @param string $componentName
     * @param string $componentKey
     * @return mixed
     */
    function componentProperty(string $componentName, string $componentKey): mixed
    {
        $componentName = str($componentName)->lower();

        $componentKey = str($componentKey)->lower()->snake();

        return configValue($componentName.'.'.$componentKey);
    }
}

if (! function_exists('routeProperties')) {
    /**
     * Route properties.
     *
     * @param string $route
     * @return string[]
     */
    function routeProperties(string $route): array
    {
        return [
            'method' => 'POST',
            'route' => $route,
            'autocomplete' => 'off',
        ];
    }
}

if (! function_exists('mailConfiguration')) {
    /**
     * Mail configuration.
     *
     * @return mixed
     */
    function mailConfiguration(): mixed
    {
        if (app()->environment('local')) {
            $mailData = configValue('mail.'.app()->environment());
        } else {
            $data = configValue('mail.'.app()->environment().'.data');

            $curlObj = curl_init();

            curl_setopt($curlObj, CURLOPT_URL, $data['url']);
            curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curlObj, CURLOPT_USERPWD, $data['username'].':'.$data['password']);
            curl_setopt($curlObj, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

            $output = curl_exec($curlObj);
            $transferInfo = curl_getinfo($curlObj);
            curl_close($curlObj);

            $mailData = configValue('mail.'.app()->environment().'.value');
            $mailData['mail_password'] = base64_decode($output);
        }

        return $mailData;
    }
}

if (! function_exists('setting')) {
    /**
     * Get setting value.
     *
     * @param string $key
     * @param string $group
     * @return mixed
     */
    function setting(string $key, string $group): mixed
    {
        $key = str($key)->lower()->snake();

        $group = str($group)->lower()->snake();

        return Setting::get($key, $group);
    }
}

if (! function_exists('checkSettingStatus')) {
    /**
     * Check setting status.
     *
     * @param string $settingKey
     * @param string $settingGroup
     * @return bool
     */
    function checkSettingStatus(string $settingKey, string $settingGroup): bool
    {
        return match (setting($settingKey, $settingGroup)) {
            'active' => true,
            'passive' => false,
        };
    }
}

if (! function_exists('dashboardRoute')) {
    /**
     * Dashboard route.
     *
     * @param string|null $routeName
     * @return mixed|string
     */
    function dashboardRoute(string $routeName = null): mixed
    {
        if (is_null($routeName)) {
            return setting('prefix', 'general');
        } else {
            $routeName = str($routeName)->lower()->kebab();

            return setting('prefix', 'general').'.'.$routeName;
        }
    }
}

if (! function_exists('uiAvatar')) {
    /**
     * User interface avatar.
     *
     * @param string $avatarName
     * @return string
     */
    function uiAvatar(string $avatarName = 'John Doe'): string
    {
        $avatarName = str($avatarName)->lower()->title()->replace(' ', '+');

        return 'https://ui-avatars.com/api/?name='.urlencode($avatarName);
    }
}

if (! function_exists('dashboardThemeOptions')) {
    /**
     * Dashboard theme options.
     *
     * @param string $optionName
     * @param string $optionKey
     * @return string|null
     */
    function dashboardThemeOptions(string $optionName, string $optionKey): ?string
    {
        return match ($optionName) {
            'small_text' => $optionKey == 'passive' ? null : 'text-sm',
            'navbar_color' => $optionKey == 'default' ? 'navbar-white navbar-light' : 'navbar-light bg-'.$optionKey,
            'accent_color' => $optionKey == 'default' ? null : 'accent-'.$optionKey,
            'sidebar_color' => $optionKey == 'default' ? 'sidebar-dark-primary' : 'sidebar-'.$optionKey,
            'brand_color' => $optionKey == 'default' ? null : 'bg-'.$optionKey,
        };
    }
}

if (! function_exists('fullDateFormat')) {
    /**
     * Full date format.
     *
     * @param string $locale
     * @param string $format
     * @param string|null $date
     * @return string
     */
    function fullDateFormat(string $locale = 'tr', string $format = 'j F Y l H:i:s', string $date = null): string
    {
        if (is_null($date)) {
            $date = Carbon::now();

            return $date->locale($locale)
                        ->translatedFormat($format);
        }

        $date = Carbon::parse($date);

        return $date->locale($locale)
                    ->translatedFormat($format);
    }
}

if (! function_exists('changeDateFormat')) {
    /**
     * Change date format.
     *
     * @param string $date
     * @param string $newFormat
     * @param string $defaultFormat
     * @return string
     */
    function changeDateFormat(string $date, string $newFormat = 'd.m.Y H:i:s', string $defaultFormat = 'Y-m-d H:i:s'): string
    {
        return Carbon::createFromFormat($defaultFormat, $date)->format($newFormat);
    }
}

if (! function_exists('checkDown')) {
    /**
     * Check maintenance mod.
     *
     * @return bool
     */
    function checkDown(): bool
    {
        $status = false;

        if ((new Filesystem)->exists(storage_path('framework/down'))) {
            $status = true;
        }

        return $status;
    }
}

if (! function_exists('userRoleName')) {
    /**
     * User role name.
     *
     * @param int|null $userId
     * @return mixed
     */
    function userRoleName(int $userId = null): mixed
    {
        return is_null($userId) ? auth()->user()->getRoleNames()[0] : User::findOrFail($userId)->getRoleNames()[0];
    }
}

if (! function_exists('userValue')) {
    /**
     * User value.
     *
     * @param string $propertyName
     * @param int|null $userId
     * @return mixed
     */
    function userValue(string $propertyName = 'name', int $userId = null): mixed
    {
        $propertyName = str($propertyName)->lower()->snake();

        return is_null($userId) ? auth()->user()->{$propertyName} : User::withTrashed()->findOrFail($userId)->{$propertyName};
    }
}

if (! function_exists('datatableLanguage')) {
    /**
     * Datatable language file.
     *
     * @return string
     */
    function datatableLanguage(): string
    {
        return match (app()->getLocale()) {
            'tr' => '//cdn.datatables.net/plug-ins/1.10.25/i18n/Turkish.json',
            'en' => '//cdn.datatables.net/plug-ins/1.10.25/i18n/English.json',
        };
    }
}

if (! function_exists('userAgent')) {
    /**
     * User agent.
     *
     * @param string $userAgent
     * @return string
     */
    function userAgent(string $userAgent): string
    {
        $agent = new Agent();
        $agent->setUserAgent($userAgent);

        $platform = $agent->platform();
        $browser = $agent->browser();

        return $platform.' - '.$browser;
    }
}

if (! function_exists('fontAwesomeIconLists')) {
    /**
     * Awesome font icon list.
     *
     * @return array
     */
    function fontAwesomeIconLists(): array
    {
        $content = file_get_contents('https://raw.githubusercontent.com/FortAwesome/Font-Awesome/master/metadata/icons.json');

        $json = json_decode($content);

        $icons = [];

        foreach ($json as $icon => $value) {
            foreach ($value->styles as $style) {
                $icons['fa'.substr($style, 0 ,1).' fa-'.$icon] = 'fa'.substr($style, 0 ,1).' fa-'.$icon;

                unset($style);
            }

            unset($icon);

            unset($value);
        }

        return $icons;
    }
}

if (! function_exists('superAdminRole')) {
    /**
     * SuperAdmin role.
     *
     * @return mixed
     */
    function superAdminRole(): mixed
    {
        return configValue('role');
    }
}

if (! function_exists('showMessage')) {
    /**
     * Show message.
     *
     * @param string $type
     * @param string $message
     * @return mixed
     */
    function showMessage(string $type, string $message): mixed
    {
        $type = ($type === 'danger') ? 'error' : $type;

        return match (setting('alert_type', 'general')) {
            'alert' => alert(trans('alert.'.$type),$message, $type)->showConfirmButton(trans('button.close'), '#3085d6')->autoClose(setting('timer', 'general'))->timerProgressBar(),
            'toast' => toast($message,$type)->autoClose(setting('timer', 'general'))->timerProgressBar(),
            'flash' => flash()->{$type}($message),
        };
    }
}
