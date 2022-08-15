<?php

namespace Core\Framework\Application\ModuleInfo;

use Core\Framework\Application\Controller\BaseAdminController;
use Core\Framework\Application\ModuleInfo\DTO\ModuleInfoDTO;

class ModuleInfo
{
    protected ModuleInfoDTO $dto;

    public function __construct(ModuleInfoDTO $dto)
    {
        $this->dto = $dto;
    }

    public function getAdminController(): BaseAdminController
    {
        $controller_name = "\Module\\" . $this->dto->getModuleName() . "\\AdminController";
        return new $controller_name();
    }

}