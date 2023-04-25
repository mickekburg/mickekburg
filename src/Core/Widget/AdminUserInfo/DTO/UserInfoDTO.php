<?php

namespace Core\Widget\AdminUserInfo\DTO;

class UserInfoDTO
{
    private string $name;
    private string $third_name;

    public function __construct(string $name, string $third_name)
    {
        $this->name = $name;
        $this->third_name = $third_name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getThirdName(): string
    {
        return $this->third_name;
    }


}