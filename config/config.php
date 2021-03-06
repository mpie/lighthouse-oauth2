<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Domain (usually a subdomain when working in a monolith)
    |--------------------------------------------------------------------------
    |
    | The domain.
    |
    */
    'domain' => env('LIGHTHOUSE_OAUTH2_DOMAIN', null),

    /*
    |--------------------------------------------------------------------------
    | Client ID
    |--------------------------------------------------------------------------
    |
    | The passport client id.
    |
    */
    'client_id' => env('LIGHTHOUSE_OAUTH2_CLIENT_ID', 1),

    /*
    |--------------------------------------------------------------------------
    | Client secret
    |--------------------------------------------------------------------------
    |
    | The passport client secret.
    |
    */
    'client_secret' => env('LIGHTHOUSE_OAUTH2_CLIENT_SECRET', null),

    /*
    |--------------------------------------------------------------------------
    | GraphQL schema
    |--------------------------------------------------------------------------
    |
    | File path of the GraphQL schema to be used, defaults to null so it uses
    | the default location
    |
    */
    'schema' => null,

    /*
    |--------------------------------------------------------------------------
    | Passport grant type
    |--------------------------------------------------------------------------
    |
    | The passport grant type.
    | Change this to 'password' if you are using first-party clients
    | as suggested: https://laravel.com/docs/8.x/passport#password-grant-tokens
    |
    */
    'grant_type' => env('LIGHTHOUSE_OAUTH2_GRANT_TYPE', 'authorization_code'),

    /*
    |--------------------------------------------------------------------------
    | Scope
    |--------------------------------------------------------------------------
    |
    | See: https://laravel.com/docs/8.x/passport#requesting-all-scopes
    |
    */
    'scope' => env('LIGHTHOUSE_OAUTH2_SCOPE', '*'),

    /*
    |--------------------------------------------------------------------------
    | Guard
    |--------------------------------------------------------------------------
    |
    | What column should be used to find the user in the table.
    | You can also make use of 'findForPassport' on the model.
    | See: https://laravel.com/docs/8.x/passport#customizing-the-username-field
    |
    */
    'guard' => env('LIGHTHOUSE_OAUTH2_GUARD', 'api'),

    /*
    |--------------------------------------------------------------------------
    | Fetch user
    |--------------------------------------------------------------------------
    |
    | Wether a user should be retrieved during login mutation.
    |
    */
    'fetch_user' => env('LIGHTHOUSE_OAUTH2_FETCH_USER', true),

    /*
    |--------------------------------------------------------------------------
    | User column matching (will be applied when 'fetch_user' is true)
    |--------------------------------------------------------------------------
    |
    | Which column should be used to find the user.
    | You can also make use of 'findForPassport' as stated in
    | https://laravel.com/docs/8.x/passport#customizing-the-username-field
    |
    */
    'match_user_by' => env('LIGHTHOUSE_OAUTH2_USER_COLUMN', 'email'),
];
