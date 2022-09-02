<?php

namespace Core\Framework\Template\Mapper;


use Core\Framework\Template\DTO\templateIncludeDTO;

abstract class CssCompressMapper
{
    /**
     * @var templateIncludeDTO[]
     */
    protected array $files = [];

    public abstract function mapArrayToString(): string;

    /**
     * @param templateIncludeDTO[] $files
     * @return $this
     */
    public function setFiles(array $files): self
    {
        $this->files = $files;
        return $this;
    }


}