<?php

namespace Module\User\Factory;

use Module\User\Entity\User;
use Module\User\Entity\UserGroup;

class ModuleSettingsFactory extends \Core\Common\Factory\AbstractModuleSettingsFactory
{

    public function getEntityClass(): string
    {
        return User::class;
    }

    public function getEntityGroupClass(): string
    {
        return UserGroup::class;
    }
}