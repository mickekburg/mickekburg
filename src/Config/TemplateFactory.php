<?php

namespace Config;

use Core\Framework\Template\Dictionary\TemplateRegionDictionary;
use Core\Framework\Template\Template;

final class TemplateFactory
{
    public const ADMIN_LOGIN = 'admin_login';
    public const ADMIN = 'admin';
    public const FRONTEND = 'frontend';

    /**
     * @throws \Exception
     */
    public static function getTemplate(string $type): Template
    {
        //TODO:: докинуть нормальные регионы
        switch ($type) {
            case self::ADMIN_LOGIN:
                $template = new Template('admin/login/login.html.twig', [
                    TemplateRegionDictionary::META_TITLE,
                    TemplateRegionDictionary::TOP1,
                    TemplateRegionDictionary::TOP2,
                ]);
                $template
                    ->addCSS("/css/bootstrap.css")
                    ->addCSS("https://use.fontawesome.com/releases/v5.7.1/css/all.css", [
                        "integrity" => "sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr",
                        "crossorigin" => "anonymous",
                    ])
                    ->addCSS("/css/jquery-ui.theme.css")
                    ->addCSS("/css/bootstrap4-toggle.css")
                    ->addCSS("/css/tempusdominus-bootstrap-4.min.css")
                    ->addCSS("/css/select2.min.css")
                    ->addCSS("/css/select2-bootstrap4.css")
                    ->addCSS("/css/dropzone.css")
                    ->addCSS("/css/jquery.fancybox.css")
                    ->addCSS("/css/cropper.css")
                    ->addCSS("/css/init.css")
                    ->addCSS("/css/admin.style.css");

                $template
                    ->addJS("https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js")
                    ->addJS("/js/bootstrap.min.js")
                    ->addJS("/js/bootbox.min.js")
                    ->addJS("/js/jquery-ui.min.js")
                    ->addJS("/js/jquery.mjs.nestedSortable.js")
                    ->addJS("/js/bootstrap4-toggle.min.js")
                    ->addJS("/js/jquery.tree.controller.js")
                    ->addJS("https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.26.0/moment-with-locales.min.js")
                    ->addJS("https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js")
                    ->addJS("/js/select2.full.js")
                    ->addJS("/js/select2.ru.js")
                    ->addJS("/js/dropzone.js")
                    ->addJS("/js/jquery.fancybox.min.js")
                    ->addJS("/js/cropper.min.js")
                    ->addJS("/js/jquery-cropper.js")
                    ->addJS("/js/ckeditor/ckeditor.js")
                    ->addJS("/js/ckfinder/ckfinder.js")
                    ->addJS("/js/admin.scripts.js");

                return $template;
            case self::ADMIN:
                $template = new Template('admin/template.html.twig', [
                    TemplateRegionDictionary::META_TITLE,
                    TemplateRegionDictionary::CONTENT,
                    TemplateRegionDictionary::MODAL,
                    TemplateRegionDictionary::LEFT_MENU,
                ]);
                return $template;
            case self::FRONTEND:
                $template = new Template('front', []);
                return $template;
            default:
                throw new \Exception('Unknown TemplateFactory format given');
        }
    }
}