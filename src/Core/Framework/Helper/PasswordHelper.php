<?php

namespace Core\Framework\Helper;

final class PasswordHelper
{

    public static function generateSaltedPassword(string $password, string $salt): string
    {
        return sha1($password . $salt);
    }

    public static function checkPassword(string $checked_password, string $real_password, string $salt, bool $is_hashed): bool
    {
        if ($is_hashed) {
            return $checked_password === $real_password;
        }
        return sha1($checked_password . $salt) === $real_password;
    }

}