<?php

namespace Module\Access\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Module\Access\Repository\AccessModuleRoleRepository;
use Module\User\Entity\User;
use Module\User\Entity\UserGroup;

#[ORM\Entity(repositoryClass: AccessModuleRoleRepository::class)]
#[ORM\Table(name: "access_module_role")]
class AccessModuleRole
{
    public const DENY = 0;
    public const ALLOW = 1;
    public const INHERIT = 2;

    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\Id, ORM\GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[ManyToOne(targetEntity: "Module\User\Entity\User", cascade: ["all"])]
    private ?User $user;

    #[ManyToOne(targetEntity: "Module\User\Entity\UserGroup", cascade: ["all"])]
    private ?UserGroup $user_group;

    #[ManyToOne(targetEntity: "AccessModule")]
    private AccessModule $module;

    #[ORM\Column(type: Types::INTEGER, options: ["default" => AccessModuleRole::INHERIT])]
    private int $can_view;

    #[ORM\Column(type: Types::INTEGER, options: ["default" => AccessModuleRole::INHERIT])]
    private int $can_edit;

    #[ORM\Column(type: Types::INTEGER, options: ["default" => AccessModuleRole::INHERIT])]
    private int $can_add;

    #[ORM\Column(type: Types::INTEGER, options: ["default" => AccessModuleRole::INHERIT])]
    private int $can_delete;

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User|null $user
     */
    public function setUser(?User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return UserGroup|null
     */
    public function getUserGroup(): ?UserGroup
    {
        return $this->user_group;
    }

    /**
     * @param UserGroup|null $user_group
     */
    public function setUserGroup(?UserGroup $user_group): void
    {
        $this->user_group = $user_group;
    }

    /**
     * @return AccessModule
     */
    public function getModule(): AccessModule
    {
        return $this->module;
    }

    /**
     * @param AccessModule $module
     */
    public function setModule(AccessModule $module): void
    {
        $this->module = $module;
    }

    /**
     * @return int
     */
    public function getCanView(): int
    {
        return $this->can_view;
    }

    /**
     * @param int $can_view
     */
    public function setCanView(int $can_view): void
    {
        $this->can_view = $can_view;
    }

    /**
     * @return int
     */
    public function getCanEdit(): int
    {
        return $this->can_edit;
    }

    /**
     * @param int $can_edit
     */
    public function setCanEdit(int $can_edit): void
    {
        $this->can_edit = $can_edit;
    }

    /**
     * @return int
     */
    public function getCanAdd(): int
    {
        return $this->can_add;
    }

    /**
     * @param int $can_add
     */
    public function setCanAdd(int $can_add): void
    {
        $this->can_add = $can_add;
    }

    /**
     * @return int
     */
    public function getCanDelete(): int
    {
        return $this->can_delete;
    }

    /**
     * @param int $can_delete
     */
    public function setCanDelete(int $can_delete): void
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