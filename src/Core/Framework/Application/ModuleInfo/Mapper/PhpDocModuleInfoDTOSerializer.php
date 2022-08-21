<?php

namespace Core\Framework\Application\ModuleInfo\Mapper;

use Symfony\Component\PropertyInfo\Extractor\ConstructorExtractor;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class PhpDocModuleInfoDTOSerializer implements iModuleInfoDTOSerializer
{

    private Serializer $serializer;

    public function __construct()
    {
        $phpDocExtractor = new PhpDocExtractor();
        $typeExtractor = new PropertyInfoExtractor(
            typeExtractors: [new ConstructorExtractor([$phpDocExtractor]), $phpDocExtractor,]
        );

        $this->serializer = new Serializer(
            normalizers: [
                new ObjectNormalizer(
                    nameConverter: new CamelCaseToSnakeCaseNameConverter(),
                    propertyTypeExtractor: $typeExtractor,
                ),
                new ArrayDenormalizer(),
            ],
            encoders: ['xml' => new XmlEncoder()]
        );
    }

    public function getSerializer(): Serializer
    {
        return $this->serializer;
    }
}