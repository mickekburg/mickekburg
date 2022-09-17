<?php

namespace Core\Framework\Template;

use Core\Framework\Renderable;
use Core\Framework\Template\Action\ITemplateAction;
use Core\Framework\Template\Dictionary\TemplateRegionDictionary;
use Core\Framework\Template\DTO\templateIncludeDTO;
use Core\Framework\Template\Mapper\cssCompressMapper;
use Core\Framework\Template\Mapper\JsCompressMapper;

class Template implements Renderable
{
    private array $regions = [];
    private array $init_regions = [];
    private string $template;
    private array $js = [];
    private array $css = [];
    /**
     * @var ITemplateAction[]
     */
    private array $afterActions = [];

    public function addJS(string $filename, array $attrs = [], int $order = null): self
    {
        if (is_null($order)) {
            $order = count($this->css);
        }
        $this->js[] = new templateIncludeDTO($filename, $attrs, $order);
        return $this;
    }

    public function addCSS(string $filename, array $attrs = [], int $order = null): self
    {
        if (is_null($order)) {
            $order = count($this->css);
        }
        $this->css[] = new templateIncludeDTO($filename, $attrs, $order);
        return $this;
    }

    public function addAfterAction(ITemplateAction $action)
    {
        $this->afterActions[] = $action;
    }

    public function writeRegion(string $region, string $data, $is_overwrite = false): self
    {
        if (in_array($region, $this->regions)) {
            if (!isset($this->init_regions[$region]) || $is_overwrite) {
                $this->init_regions[$region] = [];
            }
            $this->init_regions[$region][] = $data;
        }
        return $this;
    }

    public function __construct(string $template, array $regions)
    {
        $this->template = $template;
        $this->regions = $regions;
    }

    public function render(): string
    {
        $template = \Application::i()->getTwig()->load($this->template);
        /**
         * @var JsCompressMapper
         */
        $js_mapper = \Application::i()->getFromDIContainer('js_mapper');
        $this->init_regions[TemplateRegionDictionary::JS] = $js_mapper->setFiles($this->js)->mapArrayToString();
        /**
         * @var CssCompressMapper
         */
        $css_mapper = \Application::i()->getFromDIContainer('css_mapper');
        $this->init_regions[TemplateRegionDictionary::CSS] = $css_mapper->setFiles($this->css)->mapArrayToString();

        foreach ($this->init_regions as $region_name => $region_data) {
            if (is_array($region_data)) {
                $this->init_regions[$region_name] = implode($region_data);
            }
        }
        return $this->afterRender($template->render($this->init_regions));
    }

    private function afterRender(string $template): string
    {
        foreach ($this->afterActions as $action) {
            $template = $action->execute($template);
        }
        return $template;
    }
}