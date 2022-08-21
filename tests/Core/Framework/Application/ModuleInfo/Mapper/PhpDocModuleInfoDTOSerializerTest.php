<?php

namespace Core\Framework\Application\ModuleInfo\Mapper;

use Core\Framework\Application\ModuleInfo\DTO\ModuleFieldDTO;
use Core\Framework\Application\ModuleInfo\DTO\ModuleInfoDTO;
use Core\Framework\Application\ModuleInfo\DTO\ModuleInfoTabDTO;
use PHPUnit\Framework\TestCase;

class PhpDocModuleInfoDTOSerializerTest extends TestCase
{
    /**
     * Тест проверяет правильности сериализации конфигураций
     * @return void
     */
    public function testSerailizeAndDeserialize()
    {
        $field1 = (new ModuleFieldDTO())->setName("1");
        $field2 = (new ModuleFieldDTO())->setName("2");
        $tab = (new ModuleInfoTabDTO())->setName("123")->setFields([$field1, $field2]);

        $example = (new ModuleInfoDTO())->setModuleName("1111")->setTabs([$tab]);
        $serializer = new PhpDocModuleInfoDTOSerializer();

        $xml = $serializer->getSerializer()->serialize($example, 'xml', ['xml_format_output' => true,]);
        /**
         * @var ModuleInfoDTO
         */
        $result = $serializer->getSerializer()->deserialize($xml, ModuleInfoDTO::class, 'xml');

        $this->assertInstanceOf(ModuleInfoTabDTO::class, $result->getTabs()[0]);
        $this->assertInstanceOf(ModuleFieldDTO::class, $result->getTabs()[0]->getFields()[0]);
    }
}
