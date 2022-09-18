<?php

namespace Module\User\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping as ORM;
use Module\User\Repository\UserGroupRepository;

#[ORM\Table(name: "user_group")]
#[ORM\Entity(repositoryClass: UserGroupRepository::class)]
class UserGroup
{
    public const ADMIN_GROUP = 2;

    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\Id, ORM\GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private string $name;

    #[ManyToOne(targetEntity: "UserGroup")]
    private ?UserGroup $parent = null;

    #[ORM\Column(type: Types::BOOLEAN, options: ["default" => 1])]
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

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

}