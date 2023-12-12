<?php

namespace SocialiteProviders\FamilySearch;

use SocialiteProviders\Manager\SocialiteWasCalled;

class FamilySearchExtendSocialite
{
    public function handle(SocialiteWasCalled $socialiteWasCalled): void
    {
        $socialiteWasCalled->extendSocialite('familysearch', Provider::class);
    }
}
