<?php

namespace Module\Login\DTO;

class LoginDataDto
{
    private string $login;
    private string $password;
    private bool $is_password_hashed;
    private bool $is_remember;
    private string $login_url;

    public function __construct(string $login, string $password, bool $is_password_hashed = false, bool $is_remember = true, string $login_url = "")
    {
        $this->login = $login;
        $this->password = $password;
        $this->is_password_hashed = $is_password_hashed;
        $this->is_remember = $is_remember;
        $this->login_url = $login_url;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return bool
     */
    public function getIsPasswordHashed(): bool
    {
        return $this->is_password_hashed;
    }

    /**
     * @return bool
     */
    public function getIsRemember(): bool
    {
        return $this->is_remember;
    }

    /**
     * @return string
     */
    public function getLoginUrl(): string
    {
        return $this->login_url;
    }

}