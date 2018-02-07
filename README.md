# Avaza Provider for OAuth 2.0 Client

This package provides Avaza OAuth 2.0 support for the PHP League's [OAuth 2.0 Client](https://github.com/thephpleague/oauth2-client).

## Installation

To install, use composer:

```
composer require league/oauth2-avaza
```

## Usage

Usage is the same as The League's OAuth client, using `\League\OAuth2\Client\Provider\Avaza` as the provider.

### Authorization Code Flow

```php
$provider = new League\OAuth2\Client\Provider\Avaza([
    'clientId'          => '{avaza-client-id}',
    'clientSecret'      => '{avaza-client-secret}',
    'redirectUri'       => 'https://example.com/callback-url',
]);

// If we don't have an authorization code then get one
if (!isset($_GET['code'])) {

    // Fetch the authorization URL from the provider; this returns the
    // urlAuthorize option and generates and applies any necessary parameters
    // (e.g. state).
    $authorizationUrl = $provider->getAuthorizationUrl();

    // Get the state generated for you and store it to the session.
    $_SESSION['oauth2state'] = $provider->getState();

    // Redirect the user to the authorization URL.
    header('Location: ' . $authorizationUrl);
    exit;

// Check given state against previously stored one to mitigate CSRF attack
} elseif (empty($_GET['state']) || (isset($_SESSION['oauth2state']) && $_GET['state'] !== $_SESSION['oauth2state'])) {

    if (isset($_SESSION['oauth2state'])) {
        unset($_SESSION['oauth2state']);
    }
    
    exit('Invalid state');

} else {

    try {

        // Try to get an access token using the authorization code grant.
        $token = $provider->getAccessToken('authorization_code', [
            'code' => $_GET['code']
        ]);

        // We have an access token, which we may use in authenticated
        // requests against the service provider's API.
        echo 'Access Token: ' . $token->getToken() . "<br>";
        echo 'Refresh Token: ' . $token->getRefreshToken() . "<br>";
        echo 'Expired in: ' . $token->getExpires() . "<br>";
        echo 'Already expired? ' . ($token->hasExpired() ? 'expired' : 'not expired') . "<br>";

        // Using the access token, we may look up details about the
        // resource owner.
        $user = $provider->getResourceOwner($token);

        // Use these details to create a new profile
        printf('Hello %s!', $user->getEmail());

        // The provider provides a way to get an authenticated API request for
        // the service, using the access token; it returns an object conforming
        // to Psr\Http\Message\RequestInterface.
        $request = $provider->getAuthenticatedRequest(
            'GET',
            'https://api.avaza.com/api/Contact',
            $token
        );

        // Use this to interact with an API on the users behalf
        echo $token->getToken();

    } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {

        // Failed to get the access token or user details.
        exit($e->getMessage());

    }        
}
```

### Managing Scopes

When creating your Avaza authorization URL, you can specify the state and scopes your application may authorize.

```php
$options = [
    'state' => 'OPTIONAL_CUSTOM_CONFIGURED_STATE',
    'scope' => ['read','write'] // array or string
];

$authorizationUrl = $provider->getAuthorizationUrl($options);
```
If neither are defined, the provider will utilize internal defaults.

## License

The MIT License (MIT). Please see [License File](https://github.com/thephpleague/oauth2-github/blob/master/LICENSE) for more information.