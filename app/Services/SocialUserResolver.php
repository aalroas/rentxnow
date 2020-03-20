<?php

namespace App\Services;

use Exception;
// use App\Services\SocialAccountsService;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Contracts\Auth\Authenticatable;
use Coderello\SocialGrant\Resolvers\SocialUserResolverInterface;

class SocialUserResolver implements SocialUserResolverInterface
{
    /**
     * Resolve user by provider credentials.
     *
     * @param string $provider
     * @param string $accessToken
     *
     * @return Authenticatable|null
     */
    public function resolveUserByProviderCredentials(string $provider, string $accessToken): ?Authenticatable
    {
        $providerUser = null;

        try {
            $providerUser = Socialite::driver($provider)->userFromToken($accessToken);
        } catch (Exception $exception) {
        }

        if ($providerUser) {
            return (new SocialAccountsService())->findOrCreate($providerUser, $provider);
        }
        return null;
    }
}
