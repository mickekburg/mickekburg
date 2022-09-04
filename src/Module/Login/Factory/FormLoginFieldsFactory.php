<?php

namespace Module\Login\Factory;

use Core\Widget\Form\DTO\FormFieldDTO;

final class FormLoginFieldsFactory
{
    const FORM_LOGIN = 'form_login';
    const FORM_FORGOT_PASSWORD = 'form_forgot_password';

    /**
     * @return FormFieldDTO[]
     */
    public static function getLoginFields(bool $is_login_url): array
    {
        $form_login_fieldset = [
            (new FormFieldDTO())
                ->setType(FormFieldDTO::TYPE_TEXT)
                ->setName('login')
                ->setIsRequired(true)
                ->setPlaceholder(\Application::i()->getTranslator()->trans("admin.login.form.your_login"))
                ->setAttrs([
                    'class' => 'form-control',
                ]),
            (new FormFieldDTO())
                ->setType(FormFieldDTO::TYPE_PASSWORD)
                ->setName('password')
                ->setIsRequired(true)
                ->setPlaceholder(\Application::i()->getTranslator()->trans("admin.login.form.your_password"))
                ->setAttrs([
                    'class' => 'form-control',
                ]),
            (new FormFieldDTO())
                ->setType(FormFieldDTO::TYPE_CHECKBOX)
                ->setName('is_remember')
                ->setAttrs([
                    'id' => 'field_remember',
                ]),
        ];
        if ($is_login_url) {
            $form_login_fieldset[] = (new FormFieldDTO())
                ->setType(FormFieldDTO::TYPE_HIDDEN)
                ->setName('login_url')
                ->setValue(\Application::i()->getRequest()->get('login_url'));
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
                ->setName('login')
                ->setIsRequired(true)
                ->setPlaceholder(\Application::i()->getTranslator()->trans("admin.login.form.your_login"))
                ->setAttrs([
                    'class' => 'form-control',
                ]),
            (new FormFieldDTO())
                ->setType(FormFieldDTO::TYPE_HIDDEN)
                ->setName('is_remind')
                ->setValue(1),
        ];
    }
}