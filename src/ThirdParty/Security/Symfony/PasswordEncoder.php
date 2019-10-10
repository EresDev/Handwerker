<?php

namespace App\ThirdParty\Security\Symfony;

use Symfony\Component\Security\Core\Encoder\BasePasswordEncoder;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

class PasswordEncoder extends BasePasswordEncoder
{
    private $ignorePasswordCase;

    public function __construct()
    {
        $this->ignorePasswordCase = false;
    }

    public function encodePassword($raw, $salt)
    {
        // TODO: Implement encodePassword() method.
        return password_hash($raw,PASSWORD_BCRYPT );
    }

    public function isPasswordValid($encoded, $raw, $salt)
    {
        // TODO: Implement isPasswordValid() method.
        if ($this->isPasswordTooLong($raw)) {
            return false;
        }

        try {
            $pass2 = $this->encodePassword($raw, $salt);
        } catch (BadCredentialsException $e) {
            return false;
        }

        if (!$this->ignorePasswordCase) {
            return $this->comparePasswords($encoded, $pass2);
        }

        return $this->comparePasswords(strtolower($encoded), strtolower($pass2));
    }
}
