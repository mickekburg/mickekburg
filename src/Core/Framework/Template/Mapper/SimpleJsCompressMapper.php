<?php

namespace Core\Framework\Template\Mapper;

class SimpleJsCompressMapper extends JsCompressMapper
{

    public function mapArrayToString(): string
    {
        usort($this->files, fn($a, $b) => $a->getOrder() <=> $b->getOrder());
        //TODO: нормальную компрессию
        return implode('', array_map(function ($a) {
            return $this->jsFileLink($a->getName(), $a->getAttrs());
        }, $this->files));
    }

    private function jsFileLink(string $filename, array $attrs): string
    {
        $link = '<script type="text/javascript" src="' . $filename . '"';
        foreach ($attrs as $attr_name => $attr_value) {
            $link .= ' ' . $attr_name . '="' . $attr_value . '" ';
        }
        $link .= "></script>";
        return $link;
    }
}