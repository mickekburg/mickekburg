<?php

namespace Core\Common\Command;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;

class InstallCommand implements ICommand
{
    private array $fill_values = [];
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function execute(): void
    {
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

    public function getResult(): void
    {

    }

    /**
     * @param array $fill_values
     * @return $this
     */
    public function setFillValues(array $fill_values): self
    {
        $this->fill_values = $fill_values;
        return $this;
    }
}