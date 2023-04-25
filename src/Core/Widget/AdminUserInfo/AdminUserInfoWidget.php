<?php

namespace Core\Widget\AdminUserInfo;

use Core\Widget\AdminUserInfo\DTO\UserInfoDTO;

class AdminUserInfoWidget extends \Core\Framework\TwigRenderer implements \Core\Framework\Renderable
{
    protected string $template = "core/widget/admin_user_info/admin_user_info.html.twig";

    private UserInfoDTO $user_info;

    public function __construct(UserInfoDTO $user_info)
    {
        $this->user_info = $user_info;
    }

    public function render(): string
    {
        return $this->renderTwig([
            'user_info' => $this->user_info,
        ]);
    }
}