<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Components
    |--------------------------------------------------------------------------
    |
    | starterKits components.
    |
    */

    'components' => [
        'auth',
        'dashboard',
        'ui',
        'maintenance',
        'error',
    ],

    /*
    |--------------------------------------------------------------------------
    | Auth Component Properties
    |--------------------------------------------------------------------------
    |
    | Properties of the auth component.
    |
    */

    'auth' => [
        'folder_name' => 'auth',
        'theme_name' => 'adminlte',
    ],

    /*
    |--------------------------------------------------------------------------
    | Dashboard Component Properties
    |--------------------------------------------------------------------------
    |
    | Properties of the dashboard component.
    |
    */

    'dashboard' => [
        'folder_name' => 'dashboard',
        'theme_name' => 'adminlte',
    ],

    /*
    |--------------------------------------------------------------------------
    | Ui Component Properties
    |--------------------------------------------------------------------------
    |
    | Properties of the ui component.
    |
    */

    'ui' => [
        'folder_name' => 'ui-element',
        'theme_name' => 'adminlte',
    ],

    /*
    |--------------------------------------------------------------------------
    | Maintenance Component Properties
    |--------------------------------------------------------------------------
    |
    | Properties of the maintenance component.
    |
    */

    'maintenance' => [
        'folder_name' => 'maintenance',
        'theme_name' => 'drixo',
    ],

    /*
    |--------------------------------------------------------------------------
    | Error Component Properties
    |--------------------------------------------------------------------------
    |
    | Properties of the error component.
    |
    */

    'error' => [
        'folder_name' => 'errors',
        'theme_name' => 'drixo',
    ],

    /*
    |--------------------------------------------------------------------------
    | Role
    |--------------------------------------------------------------------------
    |
    | Default administrator role.
    |
    */

    'role' => 'Super Admin',

    /*
    |--------------------------------------------------------------------------
    | Flash Levels
    |--------------------------------------------------------------------------
    |
    | Flash message method names.
    |
    */

    'levels' => [
        'success' => 'success',
        'danger' => 'danger',
        'error' => 'danger',
        'warning' => 'warning',
        'info' => 'info',
    ],

    /*
    |--------------------------------------------------------------------------
    | Colors
    |--------------------------------------------------------------------------
    |
    | Here are the dashboard colors.
    |
    */

    'colors' => [
        'adminlte' => [
            'primary',
            'secondary',
            'info',
            'success',
            'warning',
            'danger',
            'black',
            'gray-dark',
            'gray',
            'light',
            'indigo',
            'lightblue',
            'navy',
            'purple',
            'fuchsia',
            'pink',
            'maroon',
            'orange',
            'lime',
            'teal',
            'olive',
            'dark',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Permissions
    |--------------------------------------------------------------------------
    |
    | Default permissions.
    |
    */

    'permissions' => [
        'view',
        'create',
        'store',
        'show',
        'edit',
        'update',
        'delete',
        'destroy',
        'restore',
        'order',
    ],

    /*
    |--------------------------------------------------------------------------
    | Mail
    |--------------------------------------------------------------------------
    |
    | Mail configuration properties.
    |
    */

    'mail' => [
        'local' => [
            'mail_host' => 'smtp.mailtrap.io',
            'mail_port' => 2525,
            'mail_encryption' => 'tls',
            'mail_address' => '',
            'mail_password' => '',
            'mail_from_address' => 'noreply@starter-kits.test',
        ],
        'production' => [
            'data' => [
                'url' => '',
                'username' => '',
                'password' => '',
            ],
            'value' => [
                'mail_host' => '',
                'mail_port' => 587,
                'mail_encryption' => 'tls',
                'mail_address' => '',
                'mail_from_address' => '',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Folder
    |--------------------------------------------------------------------------
    |
    | starterKits folder properties.
    |
    */

    'folder' => [
        'status' => true,
        'name' => 'starter-kits',
    ],

    /*
    |--------------------------------------------------------------------------
    | Input Length
    |--------------------------------------------------------------------------
    |
    | Form input length properties.
    |
    */

    'length' => [
        'password' => [
            'min' => 8,
            'max' => 20,
        ],
    ],

];
