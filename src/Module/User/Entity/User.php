<?php

namespace Module\User\Entity;

use Core\Framework\Helper\StringHelper;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToOne;
use Module\User\Repository\UserRepository;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: "user")]
class User
{
    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\Id, ORM\GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $login;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: 'string', length: 255)]
    private string $second_name = "";

    #[ORM\Column(type: 'string', length: 255)]
    private string $third_name = "";

    #[ORM\Column(type: 'string', length: 255)]
    private string $password;

    #[ORM\Column(type: 'string', length: 255)]
    private string $password_salt;

    #[OneToOne(targetEntity: "UserGroup")]
    private UserGroup $parent;

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
     * @return string
     */
    public function getSecondName(): string
    {
        return $this->second_name;
    }

    /**
     * @param string $second_name
     */
    public function setSecondName(string $second_name): void
    {
        $this->second_name = $second_name;
    }

    /**
     * @return string
     */
    public function getThirdName(): string
    {
        return $this->third_name;
    }

    /**
     * @param string $third_name
     */
    public function setThirdName(string $third_name): void
    {
        $this->third_name = $third_name;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password_salt = StringHelper::randomString();
        $this->password = sha1($password . $this->password_salt);
    }

    /**
     * @return UserGroup
     */
    public function getParent(): UserGroup
    {
        return $this->parent;
    }

    /**
     * @param UserGroup $parent
     */
    public function setParent(UserGroup $parent): void
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
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @param string $login
     */
    public function setLogin(string $login): void
    {
        $this->login = $login;
    }

    public function checkPassword(string $password): bool
    {
        return sha1($password . $this->password_salt) === $this->password;
    }

}