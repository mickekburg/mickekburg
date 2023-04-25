<?php

namespace Core\Widget\AdminUserInfo\Mapper;

use Core\Widget\AdminUserInfo\DTO\UserInfoDTO;
use Module\User\Entity\User;

final class AdminUserInfoWidgetMapper
{
    /**
     * @param User $user
     * @return UserInfoDTO
     */
    public static function mapUser(User $user): UserInfoDTO
    {
        return new UserInfoDTO($user->getName(), $user->getThirdName());
    }
}