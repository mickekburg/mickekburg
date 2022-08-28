<?php

namespace Core\Framework\Application\ModuleInfo\DTO;

class ModuleTableActionDTO
{
    protected string $title = "";
    protected string $function = "";

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getFunction(): string
    {
        return $this->function;
    }

    /**
     * @param string $function
     * @return $this
     */
    public function setFunction(string $function): self
    {
        $this->function = $function;
        return $this;
    }


}