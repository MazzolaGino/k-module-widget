<?php

namespace KModuleWidget\Processor;

use KModuleWidget\Lib\Release;
use KModuleWidget\Lib\ReleaseWidget;

class WidgetProcessor extends Processor
{
    /**
     * 
     * @hook widgets_init
     * @return void
     */
    public function release_processor(): void
    {
        $this->register('Prochaines sorties', 'list_date');
    }

    /**
     * 
     * @hook widgets_init
     * @return void
     */
    public function nonrelease_processor(): void
    {
        $this->register('Date à venir', 'list_no_date');

    }

    private function register(string $title, string $type)
    {
        $app = $this->getApp();
        
        $rm = new Release(
            $app->getCnf(),
            $app->getPa()
        );

        $widget = new ReleaseWidget($app->twig(), $app->getPa(), $rm, $title, $type);

        \register_widget($widget);
    }

}
