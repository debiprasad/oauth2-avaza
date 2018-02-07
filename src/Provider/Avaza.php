<?php 

namespace League\OAuth2\Client\Provider;

use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;
use Psr\Http\Message\ResponseInterface;

class Avaza extends AbstractProvider
{
    use BearerAuthorizationTrait;

    /**
     * Domain
     *
     * @var string
     */
    public $domain = 'https://any.avaza.com/';
    /**
     * Api domain
     *
     * @var string
     */
    public $apiDomain = 'https://api.avaza.com/';

    /**
     * Returns the base URL for authorizing a client.
     *
     * @return string
     */
    public function getBaseAuthorizationUrl()
    {
        return $this->domain.'oauth2/authorize/?response_type=code';
    }

    /**
     Returns the base URL for requesting an access token.
     *
     * @param array $params
     * @return string
     */
    public function getBaseAccessTokenUrl(array $params)
    {
        return $this->domain.'oauth2/token';
    }

    /**
     * Returns the URL for requesting the resource owner's details.
     *
     * @param AccessToken $token
     * @return string
     */
    public function getResourceOwnerDetailsUrl(AccessToken $token)
    {
        return $this->apiDomain.'api/UserProfile';
    }

    /**
     * Get the default scopes used by this provider.
     *
     * This should not be a complete list of all scopes, but the minimum
     * required for the provider user interface!
     *
     * @return array
     */
    protected function getDefaultScopes()
    {
        return ['read'];
    }

    /**
     * Check a provider response for errors.
     *
     * @link   https://www.avaza.com/avaza-api-oauth2-authentication/
     * @throws IdentityProviderException
     * @param  ResponseInterface $response
     * @param  array $data Parsed response data
     * @return void
     */
    protected function checkResponse(ResponseInterface $response, $data)
    {
        if (!empty($data['error'])) {
            $message = $data['error'].': '.$data['error_description'];
            throw new IdentityProviderException($message, '400', $data);
        }
    }

    /**
     * Generate a user object from a successful user details request.
     *
     * @param array $response
     * @param AccessToken $token
     * @return \League\OAuth2\Client\Provider\ResourceOwnerInterface
     */
    protected function createResourceOwner(array $response, AccessToken $token)
    {
        return new AvazaUser($response);
    }
}