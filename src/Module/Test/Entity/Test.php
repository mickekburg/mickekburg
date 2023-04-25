<?php

namespace Module\Test\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Module\Access\Repository\AccessModuleRepository;
use Module\Test\Repository\TestRepository;

#[ORM\Entity(repositoryClass: TestRepository::class)]
#[ORM\Table(name: "access_module")]
class Test
{

    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\Id, ORM\GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private string $name;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private string $module_name;

    #[ManyToOne(targetEntity: "AccessModule")]
    private ?AccessModule $parent = null;

    #[ORM\Column(type: Types::INTEGER, length: 255)]
    private int $sort;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private string $module_icon;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return AccessModule|null
     */
    public function getParent(): ?AccessModule
    {
        return $this->parent;
    }

    /**
     * @param AccessModule|null $parent
     * @return $this
     */
    public function setParent(?AccessModule $parent): self
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * @return string
     */
    public function getModuleName(): string
    {
        return $this->module_name;
    }

    /**
     * @param string $module_name
     * @return $this
     */
    public function setModuleName(string $module_name): self
    {
        $this->module_name = $module_name;
        return $this;
    }

    /**
     * @return int
     */
    public function getSort(): int
    {
        return $this->sort;
    }

    /**
     * @param int $sort
     */
    public function setSort(int $sort): void
    {
        $this->sort = $sort;
    }

    /**
     * @return string
     */
    public function getModuleIcon(): string
    {
        return $this->module_icon;
    }

    /**
     * @param string $module_icon
     */
    public function setModuleIcon(string $module_icon): void
    {
        $this->module_icon = $module_icon;
    }

}