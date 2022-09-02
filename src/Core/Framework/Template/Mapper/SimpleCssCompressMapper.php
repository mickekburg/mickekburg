<?php

namespace Core\Framework\Template\Mapper;

class SimpleCssCompressMapper extends CssCompressMapper
{
    public function mapArrayToString(): string
    {
        usort($this->files, fn($a, $b) => $a->getOrder() <=> $b->getOrder());
        //TODO: нормальную компрессию
        return implode('', array_map(function ($a) {
            return $this->cssFileLink($a->getName(), $a->getAttrs());
        }, $this->files));
    }

    private function cssFileLink(string $filename, array $attrs): string
    {
        $link = '<link rel="stylesheet" href="' . $filename . '"';
        foreach ($attrs as $attr_name => $attr_value) {
            $link .= ' ' . $attr_name . '="' . $attr_value . '" ';
        }
        $link .= ">";
        return $link;
    }


}