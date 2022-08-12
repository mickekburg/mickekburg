<?php

namespace Core;

abstract class TwigRenderer
{
    protected string $template;

    //TODO: вынести twig
    public function renderTwig(array $data): string
    {
        $loader = new \Twig\Loader\FilesystemLoader(APP_PATH . '/templates');
        $twig = new \Twig\Environment($loader, [
            'cache' => APP_PATH . '/templates/compilation_cache',
            'auto_reload' => true,
            'debug' => true,
        ]);
        try {
            $twig_template = $twig->load($this->template);
            return $twig_template->render($data);
        } catch (\Exception) {
            return "";
        }
    }


}