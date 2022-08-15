<?php

namespace Core\Framework\Application\ModuleInfo\Mapper;

use Symfony\Component\Serializer\Serializer;

interface iModuleInfoDTOSerializer
{
    /**
     * @return Serializer
     */
    public function getSerializer(): Serializer;
}