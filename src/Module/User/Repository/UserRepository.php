<?php

namespace Module\User\Repository;

use Doctrine\ORM\EntityRepository;
use Module\User\Entity\User;

class UserRepository extends EntityRepository
{
    public function findByLoginPassword(string $login, string $password)
    {
        /**
         * @var User
         */
        $user = $this->findOneBy(['login' => $login]);
        if (!empty($user) && $user->checkPassword($password)) {
            return $user;
        }
        return null;
    }
}