<?php

namespace Core\Framework;

abstract class TwigRenderer
{
    protected string $template;

    protected function renderTwig(array $data): string
    {
        try {
            $twig_template = \Application::i()->getTwig()->load($this->template);
            return $twig_template->render($data);
        } catch (\Exception) {
            return "";
        }
    }

}