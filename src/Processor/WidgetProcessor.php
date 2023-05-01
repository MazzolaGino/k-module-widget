<?php

namespace KModuleWidget\Processor;

use KModuleWidget\Lib\HlWidget;
use KModuleWidget\Lib\Release;
use KModuleWidget\Lib\ReleaseWidget;

class WidgetProcessor extends Processor
{

    /**
     * 
     * @hook widgets_init
     * @return void
     */
    public function hl_processor(): void
    {
        $this->init();
        $this->styles->enqueue('hl-css');

        $hlWidget = new HlWidget($this->getApp()->twig());

        \register_widget($hlWidget);
        
    }

    /**
     * 
     * @hook widgets_init
     * @return void
     */
    public function release_processor(): void
    {
        $this->init();
        $this->register('Prochaines sorties', 'list_date');
    }

    /**
     * 
     * @hook widgets_init
     * @return void
     */
    public function nonrelease_processor(): void
    {
        $this->init();
        $this->register('Date à venir', 'list_no_date');

    }

    private function register(string $title, string $type)
    {
        $rm = new Release(
            $this->getApp()->getCnf(),
            $this->getApp()->getPa()
        );

        $widget = new ReleaseWidget($this->getApp()->twig(), $this->getApp()->getPa(), $rm, $title, $type);

        \register_widget($widget);
    }

}
