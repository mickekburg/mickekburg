<?php

namespace Core\Widget;

abstract class TwigRenderer
{
    protected string $template;

    //TODO: вынести twig
    public function renderTwig(array $data): string
    {
        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/templates');
        $twig = new \Twig\Environment($loader, [
            'cache' => __DIR__ . '/templates/compilation_cache',
            'auto_reload' => true,
        ]);
        try{
            $twig_template = $twig->load($this->template);
            return $twig_template->render($data);
        }
        catch(\Exception){
            return "";
        }


    }
}