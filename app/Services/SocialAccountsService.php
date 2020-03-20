<?php

namespace App\Services;

use App\Models\Auth\User;
use App\Models\Auth\SocialAccount;
use Laravel\Socialite\Two\User as ProviderUser;

class SocialAccountsService
{
    /**
     * Find or create user instance by provider user instance and provider name.
     *
     * @param ProviderUser $providerUser
     * @param string $provider
     *
     * @return User
     */
    public function findOrCreate(ProviderUser $providerUser, string $provider): User
    {
        $SocialAccount = SocialAccount::where('provider', $provider)
            ->where('provider_id', $providerUser->getId())
            ->first();
        if ($SocialAccount) {
            return $SocialAccount->user;
        } else {
            $user = null;
            if ($email = $providerUser->getEmail()) {
                $user = User::where('email', $email)->first();
            }
            if (!$user) {
                $user = User::create([
                    'first_name' => $providerUser->getName(),
                    'last_name' => $providerUser->getName(),
                    'email' => $providerUser->getEmail(),
                ]);
            }
            $user->providers()->create([
                'provider_id' => $providerUser->getId(),
                'provider' => $provider,
            ]);
            return $user;
        }
    }
}
