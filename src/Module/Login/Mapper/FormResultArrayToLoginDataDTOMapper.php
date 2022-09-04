<?php

namespace Module\Login\Mapper;

use Core\Widget\Form\DTO\FormResultDTO;
use Module\Login\DTO\LoginDataDto;

final class FormResultArrayToLoginDataDTOMapper
{
    /**
     * @param FormResultDTO[] $dto_array
     * @return LoginDataDto
     * @throws \Exception
     */
    public static function map(array $dto_array): LoginDataDto
    {
        $login = $password = "";
        $is_remind = false;
        foreach ($dto_array as $dto) {
            if ($dto->getName() == 'login') {
                $login = $dto->getValue();
            } else if ($dto->getName() == 'password') {
                $password = $dto->getValue();
            } else if ($dto->getName() == 'is_remind') {
                $is_remind = (bool)$dto->getValue();
            }
        }
        if (!empty($login) && !empty($password)) {
            return new LoginDataDto($login, $password, false, $is_remind);
        }
        throw new \Exception();
    }
}