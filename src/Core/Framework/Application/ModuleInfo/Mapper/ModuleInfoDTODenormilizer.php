<?php

namespace Core\Framework\Application\ModuleInfo\Mapper;

use Core\Framework\Application\ModuleInfo\DTO\ModuleInfoDTO;
use Core\Framework\Application\ModuleInfo\DTO\ModuleInfoTabDTO;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;

class ModuleInfoDTODenormilizer implements DenormalizerInterface, DenormalizerAwareInterface
{
    use DenormalizerAwareTrait;

    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        $tabs = array_map(
            fn($tab) => $this->denormalizer->denormalize($tab, ModuleInfoTabDTO::class), $data['tabs']
        );

        $fieldsTds = [];
        if (!is_array($data['fieldsTds']) && !empty($data['fieldsTds'])) {
            $fieldsTds = [$data['fieldsTds']];
        }

        return new ModuleInfoDTO(
            $data['moduleName'],
            $data['literalName'],
            $data['defaultOrder'],
            $tabs,
            $fieldsTds,
            is_array($data['settings']) ? $data['settings'] : [],
            $data['actions'],
            is_array($data['fieldsGroup']) ? $data['fieldsGroup'] : [],
        );
    }

    public function supportsDenormalization($data, string $type, string $format = null)
    {
        return $type === ModuleInfoDTO::class;
    }
}