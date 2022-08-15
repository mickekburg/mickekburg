<?php

namespace Core\Framework\Application\ModuleInfo\Mapper;

use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @see  https://stackoverflow.com/questions/70467989/how-to-deserialize-a-nested-array-of-objects-declared-on-the-constructor-via-pro
 */
class ManualModuleInfoDTOSerializer implements iModuleInfoDTOSerializer
{
    private Serializer $serializer;

    public function __construct()
    {
        $extractor = new PropertyInfoExtractor([], [
            new PhpDocExtractor(),
            new ReflectionExtractor(),
        ]);

        $custom_denormalizer = new ModuleInfoDTODenormilizer();
        $normalizers = [
            $custom_denormalizer,
            new ObjectNormalizer(propertyTypeExtractor: $extractor),
            new ArrayDenormalizer(),
        ];
        $this->serializer = new Serializer($normalizers, [new XmlEncoder()]);
        $custom_denormalizer->setDenormalizer($this->serializer);
    }

    /**
     * @return Serializer
     */
    public function getSerializer(): Serializer
    {
        return $this->serializer;
    }


}