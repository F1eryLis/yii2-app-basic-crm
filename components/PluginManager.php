<?php

namespace app\components;

use Yii;
use app\components\plugins\PluginInterface;
use yii\base\Application;
use yii\base\BootstrapInterface;

class PluginManager implements BootstrapInterface
{
    protected $plugins = [];

    public function loadPlugins()
    {
        $pluginPaths = glob(Yii::getAlias('@app/plugins/*'), GLOB_ONLYDIR);

        foreach ($pluginPaths as $pluginPath) {
            $pluginClass = 'app\\plugins\\' . basename($pluginPath) . '\\Plugin';
            if (class_exists($pluginClass) && in_array(PluginInterface::class, class_implements($pluginClass))) {
                $this->plugins[] = new $pluginClass();
            }
        }
    }

    public function registerPlugins()
    {
        foreach ($this->getActivePlugins() as $plugin) {
            $pluginInstance = new $plugin;
            $pluginInstance->registerComponents();
            Yii::$app->on(Application::EVENT_BEFORE_REQUEST, [$pluginInstance, 'bootstrap']);
        }
    }

    public function getAvailablePlugins()
    {
        $availablePlugins = [];
        foreach ($this->plugins as $pluginClass) {
            $availablePlugins[] = new $pluginClass;
        }
        return $availablePlugins;
    }

    public function getActivePlugins()
    {
        $activePlugins = [];
        $activePluginRecords = Yii::$app->db->createCommand('SELECT id FROM plugin WHERE status = :status')
            ->bindValue(':status', 'active')
            ->queryAll();

        foreach ($activePluginRecords as $record) {
            foreach ($this->plugins as $pluginClass) {
                if ($pluginClass::getId() === $record['id']) {
                    $activePlugins[] = new $pluginClass;
                }
            }
        }
        return $activePlugins;
    }

    public function getPluginById($id)
    {
        foreach ($this->plugins as $pluginClass) {
            if ($pluginClass::getId() === $id) {
                return new $pluginClass;
            }
        }
        return null;
    }

    public function bootstrap($app)
    {
        $this->loadPlugins();
        $this->registerPlugins();
    }
}