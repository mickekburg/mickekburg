<?php

namespace Core\Common\Command;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Module\User\Entity\UserGroup;

class InstallCommand extends AbstractInstallCommand
{
    public function execute(): void
    {
        if (!empty($this->entityManager)) {
            foreach ($this->fill_values as $new_object) {
                $this->entityManager->persist($new_object);
            }
            $this->entityManager->flush();
        }
    }
}