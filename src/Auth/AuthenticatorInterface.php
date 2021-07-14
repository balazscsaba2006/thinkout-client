<?php

declare(strict_types = 1);

namespace ThinkOut\Auth;

use ThinkOut\Response\SignInData;

interface AuthenticatorInterface
{
    public function authenticate(bool $forced = false): SignInData;
}
