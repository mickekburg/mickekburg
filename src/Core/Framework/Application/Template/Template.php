<?php

namespace Core\Framework\Application\Template;

use Core\Framework\Application\Template\DTO\templateIncludeDTO;
use Core\Framework\Application\Template\Mapper\jsCompressMapper;
use Core\Framework\Renderable;

class Template implements Renderable
{
    private const REGIONS = [
        'meta_title', 'meta_description', 'meta_keywords',
        'top1', 'top2', 'top3', 'top4', 'top5', 'top6', 'top7', 'top8', 'top9', 'top10',
        'left1', 'left2', 'left3', 'left4', 'left5',
        'content1', 'content2', 'content3', 'content4', 'content5',
        'right1', 'right2', 'right3', 'right4', 'right5',
        'bottom1', 'bottom2', 'bottom3', 'bottom4', 'bottom5', 'bottom6', 'bottom7', 'bottom8', 'bottom9', 'bottom10',
        'menu1', 'menu2', 'menu3', 'menu4', 'menu5',
        'content_main', 'breads',
        'counters', 'regions', 'verification', 'canonical', 'class_page',
    ];

    private array $init_regions = [];
    private string $template;
    private array $js = [];
    private array $css = [];

    public function addJS(string $filename, int $order = templateIncludeDTO::LAST_ORDER): void
    {
        $this->js[] = new templateIncludeDTO($filename, $order);
    }

    public function addCSS(string $filename, int $order = templateIncludeDTO::LAST_ORDER): void
    {
        $this->css[] = new templateIncludeDTO($filename, $order);
    }

    public function writeRegion(string $region, string $data): void
    {
        if (in_array($region, self::REGIONS)) {
            if (!isset($this->init_regions[$region])) {
                $this->init_regions[$region] = [];
            }
            $this->init_regions[$region][] = $data;
        }
    }

    public function __construct(string $template)
    {
        $this->template = $template;
        $this->beforeInit();
    }

    public function render(): string
    {
        $this->beforeRender();
        $template = \Application::i()->getTwig()->load($this->template);
        $this->init_regions['js'] = (new jsCompressMapper($this->js))->mapArrayToString();
        $this->init_regions['css'] = (new jsCompressMapper($this->js))->mapArrayToString();
        return $this->afterRender($template->render($this->init_regions));
    }

    private function beforeInit(): void
    {

    }

    private function beforeRender(): void
    {

    }

    private function afterRender(string $template): string
    {
        return $template;
    }
}