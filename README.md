# GitHub

```bash
composer require wilford-woodruff-papers/laravel-socialite-familysearch
```

## Installation & Basic Usage

Please see the [Base Installation Guide](https://socialiteproviders.com/usage/), then follow the provider specific instructions below.

### Add configuration to `config/services.php`

```php
'familysearch' => [    
    'base_uri' => env('FAMILYSEARCH_BASE_URI'),
    'base_auth_uri' => env('FAMILYSEARCH_AUTH_BASE_URI'),
    'client_id' => env('FAMILYSEARCH_CLIENT_ID'),
    'client_secret' => env('FAMILYSEARCH_CLIENT_SECRET'),
    'redirect' => env('FAMILYSEARCH_REDIRECT_URI'), 
],
```

### Add provider event listener

Configure the package's listener to listen for `SocialiteWasCalled` events.

Add the event to your `listen[]` array in `app/Providers/EventServiceProvider`. See the [Base Installation Guide](https://socialiteproviders.com/usage/) for detailed instructions.

```php
protected $listen = [
    \SocialiteProviders\Manager\SocialiteWasCalled::class => [
        // ... other providers
        \SocialiteProviders\FamilySearch\FamilySearchExtendSocialite::class.'@handle',
    ],
];
```

### Usage

You should now be able to use the provider like you would regularly use Socialite (assuming you have the facade installed):

```php
return Socialite::driver('familysearch')->redirect();
```
