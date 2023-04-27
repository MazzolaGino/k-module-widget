<?php

namespace KModuleWidget\Processor;

use KLib\App;
use KLib\AppBuilder;
use KLib\Base\BaseProcessor;

/**
 * Summary of Controller
 */
class Processor extends BaseProcessor
{
    /**
     * Summary of getApp
     * @return App
     */
    public function getApp(): App {
        $dir = WP_PLUGIN_DIR . '/k-module-widget/src/';
        $url = WP_PLUGIN_URL . '/k-module-widget/src/';

        return (new AppBuilder($dir, $url))->getApp();
    }

    public function getProcessorName(): string
    {
        $class = get_class($this);
        $namespace = $this->getApp()->getCnf()->get('processor_namespace');
        $name = str_replace($namespace, '', $class);
        $name = str_replace('Processor', '', $name);

        return strtolower($name);
    }
}