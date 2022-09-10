<?php

namespace Module\User\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping as ORM;
use Module\User\Repository\UserGroupRepository;

#[ORM\Table(name: "user_group")]
#[ORM\Entity(repositoryClass: UserGroupRepository::class)]
class UserGroup
{
    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\Id, ORM\GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[OneToOne(targetEntity: "UserGroup")]
    private ?UserGroup $parent = null;

    #[ORM\Column(type: 'boolean', options: ["default" => 1])]
    private bool $can_delete = true;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return UserGroup|null
     */
    public function getParent(): ?UserGroup
    {
        return $this->parent;
    }

    /**
     * @param UserGroup|null $parent
     */
    public function setParent(?UserGroup $parent): void
    {
        $this->parent = $parent;
    }

    /**
     * @return bool
     */
    public function getCanDelete(): bool
    {
        return $this->can_delete;
    }

    /**
     * @param bool $can_delete
     */
    public function setCanDelete(bool $can_delete): void
    {
        $this->can_delete = $can_delete;
    }
}