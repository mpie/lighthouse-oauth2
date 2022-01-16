# lighthouse-oauth2
An OAuth2 implementation for Laravel Lighthouse through Passport

## Installation
To install run

```
composer require mpie/lighthouse-oauth2
```

ServiceProvider will be attached automatically.

Add the following env vars to your .env from the oauth_clients and the password grant client.

```
LIGHTHOUSE_OAUTH2_CLIENT_ID=
LIGHTHOUSE_OAUTH2_CLIENT_SECRET=
```

You are done with the installation!

## Tweaking configurations
In case you need to point to a different url such as a subdomain that is running in the same app add (without the last slash):

```
LIGHTHOUSE_OAUTH2_DOMAIN="https://sub.domain.com"
```

Changing the grant type to 'password' instead of the default 'authorization_code':

```
LIGHTHOUSE_OAUTH2_GRANT_TYPE="password"
```

Changing the default scope of '*':

```
LIGHTHOUSE_OAUTH2_SCOPE="email,something,another"
```

Unique feature. You can change the default guard 'api' for the user lookup instead of being vendor locked:

```
LIGHTHOUSE_OAUTH2_GUARD="super-private-guard"
```

The user model is returned when login mutation is called. This can be disabled with:

```
LIGHTHOUSE_OAUTH2_FETCH_USER=false # Make sure you uncomment 'user: User' model in the graphql file
```

User column matching (will be applied when 'fetch_user' is true). Defaults to 'email':

```
LIGHTHOUSE_OAUTH2_USER_COLUMN=id
```

## Customizing the schema

```
php artisan vendor:publish --provider="Mpie\LighthouseOAuth\LighthouseOAuthServiceProvider"
```

This will publish the schema. There are no migration files.

Then update the `lighthouse-oauth2.php` configuration file to point the schema file to load the exported file instead of the one provided by the package.

```php
/*
|--------------------------------------------------------------------------
| GraphQL schema
|--------------------------------------------------------------------------
|
| File path of the GraphQL schema to be used, defaults to null so it uses
| the default location
|
*/
'schema' => base_path('graphql/oauth2.graphql'),
```

From there you can customize the schema to fit your needs.
