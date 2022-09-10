<?php

namespace Core\Common\Command;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;

class InstallCommand extends AbstractInstallCommand
{
    public function execute(): void
    {
        if (!empty($this->entityManager)) {
            foreach ($this->fill_values as $new_object) {
                try {
                    $this->entityManager->persist($new_object);
                } catch (ORMException $e) {
                    exit("Wrong initial object - persist");
                }
            }
            try {
                $this->entityManager->flush();
            } catch (OptimisticLockException $e) {

            } catch (ORMException $e) {
                exit("Wrong initial object - flash");
            }
        }
    }
}