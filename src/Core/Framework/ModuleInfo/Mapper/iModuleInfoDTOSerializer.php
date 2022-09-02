<?php

namespace Core\Framework\ModuleInfo\Mapper;

use Symfony\Component\Serializer\Serializer;

interface iModuleInfoDTOSerializer
{
    /**
     * @return Serializer
     */
    public function getSerializer(): Serializer;
}