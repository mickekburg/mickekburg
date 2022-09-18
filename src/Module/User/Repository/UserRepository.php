<?php

namespace Module\User\Repository;

use Core\Common\Repository\CommonRepository;
use Module\User\Entity\User;

class UserRepository extends CommonRepository
{
    public function findByLoginPassword(string $login, string $password, bool $is_hashed = false)
    {
        /**
         * @var User
         */
        $user = $this->findOneBy(['login' => $login]);
        if (!empty($user) && $user->checkPassword($password, $is_hashed)) {
            return $user;
        }
        return null;
    }
}