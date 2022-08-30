<?php

namespace Core\Framework\Application\Template\Mapper;


use Core\Framework\Application\Template\DTO\templateIncludeDTO;

class cssCompressMapper
{
    /**
     * @var templateIncludeDTO[]
     */
    protected array $files = [];

    /**
     * @param templateIncludeDTO[] $files
     */
    public function __construct($files)
    {
        $this->files = $files;
    }

    public function mapArrayToString(): string
    {
        usort($this->files, fn($a, $b) => $a->getOrder() < $b->getOrder());
        //TODO: нормальную компрессию
        return implode("", $this->files);
    }


}