<?php

namespace Core\Framework\Application\ModuleInfo\Mapper;

use Core\Framework\Application\ModuleInfo\DTO\ModuleFieldDTO;
use Core\Framework\Application\ModuleInfo\DTO\ModuleInfoDTO;
use Core\Framework\Application\ModuleInfo\DTO\ModuleInfoTabDTO;
use Core\Framework\Application\ModuleInfo\Factory\TestModuleInfoFactory;
use PHPUnit\Framework\TestCase;

class PhpDocModuleInfoDTOSerializerTest extends TestCase
{
    /**
     * Тест проверяет правильности сериализации конфигураций
     * @return void
     */
    public function testSerailizeAndDeserialize()
    {
        $module = TestModuleInfoFactory::getObject();
        $serializer = new PhpDocModuleInfoDTOSerializer();

        $xml = $serializer->getSerializer()->serialize($module, 'xml', ['xml_format_output' => true,]);
        /**
         * @var ModuleInfoDTO
         */
        $result = $serializer->getSerializer()->deserialize($xml, ModuleInfoDTO::class, 'xml');

        $this->assertInstanceOf(ModuleInfoTabDTO::class, $result->getTabs()[0]);
        $this->assertInstanceOf(ModuleFieldDTO::class, $result->getTabs()[0]->getFields()[0]);
    }
}
