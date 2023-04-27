<?php
/**
 * Plugin Name: k-module-widget
 * Description: k-module-widget
 * Version: 0.0.1
 * Author: 
 * Author URI: 
 */

$autoloaderFile = __DIR__ . '/../k-module/vendor/autoload.php';

define('KModuleWidget_WP_PLUGIN_DIR', WP_PLUGIN_DIR.'/k-module-widget/src/');
define('KModuleWidget_WP_PLUGIN_URL', WP_PLUGIN_URL.'/k-module-widget/src/');


if (file_exists($autoloaderFile)) {
    require_once ($autoloaderFile);
}

(new \KLib\AppBuilder(KModuleWidget_WP_PLUGIN_DIR, KModuleWidget_WP_PLUGIN_URL))->getApp()->on();


