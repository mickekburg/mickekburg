<?php

namespace Module\Login\Factory;

use Core\Widget\Form\DTO\FormFieldDTO;

final class FormLoginFieldsFactory
{
    const FORM_LOGIN = 'form_login';
    const FIELD_LOGIN = 'login';
    const FIELD_LOGIN_URL = 'login_url';
    const FIELD_IS_REMEMBER = 'is_remember';
    const FIELD_PASSWORD = 'password';
    const FORM_FORGOT_PASSWORD = 'form_forgot_password';

    /**
     * @return FormFieldDTO[]
     */
    public static function getLoginFields(bool $is_login_url): array
    {
        $form_login_fieldset = [
            (new FormFieldDTO())
                ->setType(FormFieldDTO::TYPE_TEXT)
                ->setName(self::FIELD_LOGIN)
                ->setIsRequired(true)
                ->setPlaceholder(\Application::i()->getTranslator()->trans("admin.login.form.your_login"))
                ->setAttrs([
                    'class' => 'form-control',
                ]),
            (new FormFieldDTO())
                ->setType(FormFieldDTO::TYPE_PASSWORD)
                ->setName(self::FIELD_PASSWORD)
                ->setIsRequired(true)
                ->setPlaceholder(\Application::i()->getTranslator()->trans("admin.login.form.your_password"))
                ->setAttrs([
                    'class' => 'form-control',
                ]),
            (new FormFieldDTO())
                ->setType(FormFieldDTO::TYPE_CHECKBOX)
                ->setName(self::FIELD_IS_REMEMBER)
                ->setAttrs([
                    'id' => 'field_remember',
                ]),
        ];
        if ($is_login_url) {
            $form_login_fieldset[] = (new FormFieldDTO())
                ->setType(FormFieldDTO::TYPE_HIDDEN)
                ->setName(self::FIELD_LOGIN_URL)
                ->setValue(\Application::i()->getRequest()->get(self::FIELD_LOGIN_URL));
        }
        return $form_login_fieldset;
    }

    /**
     * @return FormFieldDTO[]
     */
    public static function getForgotPasswordFields(): array
    {
        return [
            (new FormFieldDTO())
                ->setType(FormFieldDTO::TYPE_TEXT)
                ->setName(self::FIELD_LOGIN)
                ->setIsRequired(true)
                ->setPlaceholder(\Application::i()->getTranslator()->trans("admin.login.form.your_login"))
                ->setAttrs([
                    'class' => 'form-control',
                ]),
        ];
    }
}