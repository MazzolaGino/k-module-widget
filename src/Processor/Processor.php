<?php

namespace KModuleWidget\Processor;

use KLib\App;
use KLib\AppBuilder;
use KLib\Base\BaseProcessor;

class Processor extends BaseProcessor
{
    /**
     *
     * @return App
     */
    public function getApp(): App
    {
      
        if(!($this->app)) {

            $dir = WP_PLUGIN_DIR . '/k-module-widget/src/';
            $url = WP_PLUGIN_URL . '/k-module-widget/src/';
    
            $this->app = (new AppBuilder($dir, $url))->getApp();

        }

        return $this->app;
    }

    /**
     *
     * @return string
     */

    public function getProcessorName(): string
    {
        $class = get_class($this);
        $namespace = $this->getApp()->getCnf()->get('processor_namespace');
        $name = str_replace($namespace, '', $class);
        $name = str_replace('Processor', '', $name);

        return strtolower($name);
    }
}