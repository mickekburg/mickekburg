<?php

namespace Core\Common\Command;

use Doctrine\ORM\EntityManager;

abstract class AbstractInstallCommand implements ICommand
{
    protected array $fill_values = [];
    protected EntityManager $entityManager;

    public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
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

    public function getResult(): void
    {

    }

    abstract public function execute(): void;
}