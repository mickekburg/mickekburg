<?php

namespace Module\Login\Sevice;

use Module\Login\DTO\LoginDataDto;

class UserLoginService
{
    private LoginDataDto $dto;

    public function __construct(LoginDataDto $dto)
    {
        $this->dto = $dto;
    }

    public function login()
    {

    }
}