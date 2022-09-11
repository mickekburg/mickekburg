<?php

namespace Module\Login\Sevice;

use Core\Framework\Helper\UrlHelper;
use Module\Login\DTO\LoginDataDto;
use Module\Login\Exception\WrongPasswordException;
use Module\User\Entity\User;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\RedirectResponse;

class UserLoginService
{
    private LoginDataDto $dto;
    public const ADMIN_REDIRECT_DEFAULT_URL = ADMIN_PATH . "/" . DEFAULT_ADMIN_CONTROLLER;
    public const REMEMBER_LOGIN_COOKIE = 'remember_login';
    public const REMEMBER_PASSWORD_COOKIE = 'remember_password';
    public const ADMIN_AUTH_USER_ID = 'admin_auth_user_id';
    private User $user;

    public function __construct(LoginDataDto $dto)
    {
        $this->dto = $dto;
    }

    public static function logout(): RedirectResponse
    {
        \Application::i()->getSession()->remove(self::ADMIN_AUTH_USER_ID);
        $response = new RedirectResponse(UrlHelper::siteUrl(ADMIN_PATH . '/' . LOGIN_PATH));
        $response->headers->clearCookie(self::REMEMBER_LOGIN_COOKIE);
        $response->headers->clearCookie(self::REMEMBER_PASSWORD_COOKIE);
        return $response;
    }

    /**
     * @throws WrongPasswordException
     */
    public function login(): string
    {
        $user = \Application::i()->getDbManager()->getRepository(User::class)->findByLoginPassword(
            $this->dto->getLogin(),
            $this->dto->getPassword(),
            $this->dto->getIsPasswordHashed()
        );
        if (empty($user)) {
            throw new WrongPasswordException();
        }
        $redirect_url = !empty($this->dto->getLoginUrl()) ? $this->dto->getLoginUrl() : self::ADMIN_REDIRECT_DEFAULT_URL;
        $this->saveSession($user);
        $this->user = $user;

        return UrlHelper::siteUrl($redirect_url);
    }


    private function saveSession(User $user): void
    {
        \Application::i()->getSession()->set(self::ADMIN_AUTH_USER_ID, $user->getId());
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }


}