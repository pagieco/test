<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | This option controls the default authentication "guard" and password
    | reset options for your application. You may change these defaults
    | as required, but they're a perfect start for most applications.
    |
    */

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Next, you may define every authentication guard for your application.
    | Of course, a great default configuration has been defined for you
    | here which uses session storage and the Eloquent user provider.
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your user's data.
    |
    | Supported: "session", "token"
    |
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'api' => [
            'driver' => 'token',
            'provider' => 'users',
            'hash' => false,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your user's data.
    |
    | If you have multiple user tables or models you may configure multiple
    | sources which represent each model / table. These sources may then
    | be assigned to any extra authentication guards you have defined.
    |
    | Supported: "database", "eloquent"
    |
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | You may specify multiple password reset configurations if you have more
    | than one user table or model in the application and you want to have
    | separate password reset settings based on the specific user types.
    |
    | The expire time is the number of minutes that the reset token should be
    | considered valid. This security feature keeps tokens short-lived so
    | they have less time to be guessed. You may change this as needed.
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
        ],
    ],

    /*
   |--------------------------------------------------------------------------
   | Permissions
   |--------------------------------------------------------------------------
   |
   | The list of available authorization permissions. These will only be used
   | when seeding the database and should never directly be referred to.
   |
   */

    'permissions' => [
        'asset:list' => ['List assets', 'List the assets.'],
        'asset:view' => ['View asset', 'View an asset.'],
        'asset:upload' => ['Upload asset', 'Upload an asset.'],
        'asset:move' => ['Move asset', 'Move an asset.'],
        'asset:update' => ['Update asset', 'Update an asset.'],
        'asset:delete' => ['Delete asset', 'Delete an asset.'],
        'asset-folder:list' => ['List asset folders', 'List the asset folders.'],
        'asset-folder:view' => ['View asset folder', 'View an asset folder.'],
        'asset-folder:create' => ['Create asset folder', 'Create an asset folder.'],
        'asset-folder:update' => ['Update asset folder', 'Update an asset folder.'],
        'asset-folder:delete' => ['Delete asset folder', 'Delete an asset folder.'],

        'automation:list' => ['List automations', 'List the automations.'],
        'automation:view' => ['View automation', 'View an automation.'],

        'collection:list' => ['List collections', 'List the collections.'],
        'collection:view' => ['View collection', 'View a collection.'],

        'domain:list' => ['List domains', 'List the domains.'],
        'domain:view' => ['View domain', 'View a domain.'],

        'email:list' => ['List emails', 'List the emails.'],
        'email:view' => ['View email', 'View an email.'],

        'form:list' => ['List forms', 'List the forms.'],
        'form:view' => ['View form', 'View a form.'],
        'form:list-submissions' => ['List form submissions', 'List the form submissions.'],
        'form:view-submission' => ['View form submission', 'View a form submission.'],

        'page:list' => ['List pages', 'List the pages.'],
        'page:view' => ['View page', 'View a page.'],

        'profile:list' => ['List profiles', 'List the profiles.'],
        'profile:view' => ['View profile', 'View a profile.'],
        'profile:delete' => ['Delete profile', 'Delete a profile.'],
        'profile:list-events' => ['List profile events', 'List the profile events.'],
        'profile:view-event' => ['View profile event', 'View the profile event.'],

        'workflow:list' => ['List workflows', 'List the workflows.'],
        'workflow:view' => ['View workflow', 'View a workflow.'],
    ],

];
