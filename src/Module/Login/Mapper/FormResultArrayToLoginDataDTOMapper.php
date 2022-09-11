<?php

namespace Module\Login\Mapper;

use Core\Widget\Form\DTO\FormResultDTO;
use Module\Login\DTO\LoginDataDto;
use Module\Login\Factory\FormLoginFieldsFactory;

final class FormResultArrayToLoginDataDTOMapper
{
    /**
     * @param FormResultDTO[] $dto_array
     * @return LoginDataDto
     */
    public static function map(array $dto_array): ?LoginDataDto
    {
        $login = $password = $login_url = "";
        $is_remind = false;
        foreach ($dto_array as $dto) {
            if ($dto->getName() == FormLoginFieldsFactory::FIELD_LOGIN) {
                $login = $dto->getValue();
            } else if ($dto->getName() == FormLoginFieldsFactory::FIELD_PASSWORD) {
                $password = $dto->getValue();
            } else if ($dto->getName() == FormLoginFieldsFactory::FIELD_IS_REMEMBER) {
                $is_remind = (bool)$dto->getValue();
            } else if ($dto->getName() == FormLoginFieldsFactory::FIELD_LOGIN_URL) {
                $login_url = (string)$dto->getValue();
            }
        }
        if (!empty($login) && !empty($password)) {
            return new LoginDataDto($login, $password, false, $is_remind, $login_url);
        }
        return null;
    }
}