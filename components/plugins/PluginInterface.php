<?php

namespace app\components\plugins;

interface PluginInterface
{
    public static function install();
    public static function uninstall();
    public static function activate();
    public static function deactivate();
    public function bootstrap($app);
    public static function getId();
    public static function getName();
    public static function getStatus();
}