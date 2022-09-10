<?php

namespace Core\Framework\Application\ModuleInfo\Mapper;

use Core\Framework\ModuleInfo\DTO\ModuleFieldDTO;
use Core\Framework\ModuleInfo\DTO\ModuleInfoDTO;
use Core\Framework\ModuleInfo\DTO\ModuleInfoTabDTO;
use Core\Framework\ModuleInfo\Mapper\PhpDocModuleInfoDTOSerializer;
use Module\Test\Factory\TestModuleInfoFactory;
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
