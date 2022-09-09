<?php

namespace Core\Framework\ModuleInfo;

use Core\Framework\Controller\BaseAdminController;
use Core\Framework\ModuleInfo\DTO\ModuleInfoDTO;

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

    public function getEntityFolder(): ?string
    {
        if (file_exists(APP_PATH . "src/" . $this->dto->getModuleName() . "/Entity")) {
            return APP_PATH . "src/" . $this->dto->getModuleName() . "/Entity";
        }

        return null;
    }

}