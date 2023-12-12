<?php

namespace SocialiteProviders\FamilySearch;

use GuzzleHttp\RequestOptions;
use SocialiteProviders\Manager\OAuth2\AbstractProvider;
use SocialiteProviders\Manager\OAuth2\User;

class Provider extends AbstractProvider
{
    public const IDENTIFIER = 'FAMILYSEARCH';

    /**
     * {@inheritdoc}
     */
    protected $scopeSeparator = ' ';

    protected $usesPKCE = true;

    /**
     * {@inheritdoc}
     */
    protected $scopes = ['openid', 'profile', 'offline_access'];

    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase(config('services.familysearch.base_auth_uri', 'https://identbeta.familysearch.org').'/cis-web/oauth2/v3/authorization', $state);
    }

    protected function getTokenUrl()
    {
        return config('services.familysearch.base_auth_uri', 'https://identbeta.familysearch.org').'/cis-web/oauth2/v3/token';
    }

    protected function getUserByToken($token)
    {
        info(config('services.familysearch.base_uri', 'https://apibeta.familysearch.org').'/platform/users/current');
        info($token);
        $response = $this->getHttpClient()->get(config('services.familysearch.base_uri', 'https://apibeta.familysearch.org').'/platform/users/current', [
            RequestOptions::HEADERS => [
                'Authorization' => 'Bearer '.$token,
                'Accept' => 'application/json',
            ],
        ]);

        return json_decode((string) $response->getBody(), true);
    }

    protected function mapUserToObject(array $user)
    {
        ray($user);

        return (new User())->setRaw($user['users'][0])->map([
            'id' => $user['users'][0]['personId'],
            'nickname' => $user['users'][0]['displayName'] ?? '',
            'name' => $user['users'][0]['contactName'],
            'email' => $user['users'][0]['email'],
            'avatar' => null,
        ]);
    }
}
