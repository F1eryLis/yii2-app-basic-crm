<?php

namespace app\components\plugins;

use Yii;
use yii\base\BootstrapInterface;

abstract class PluginBase implements PluginInterface, BootstrapInterface
{
    public static function install()
    {
        // Логика установки
    }

    public static function uninstall()
    {
        // Логика удаления
    }

    public static function activate()
    {
        Yii::$app->db->createCommand()->insert('plugin', [
            'id' => static::getId(),
            'name'=> static::getName(),
            'status' => 'active',
        ])->execute();
    }

    public static function deactivate()
    {
        Yii::$app->db->createCommand()->update('plugin', [
            'status' => 'inactive',
        ], ['id' => static::getId()])->execute();
    }

    public function bootstrap($app)
    {
        // Логика инициализации плагина
    }

    public function registerComponents()
    {
        $this->registerRoutes();
    }

    protected function registerRoutes()
    {
        Yii::$app->urlManager->addRules([
            'plugin/<plugin:\w+>/<controller:\w+>/<action:\w+>' => '<plugin>/<controller>/<action>',
        ], false);

        Yii::$app->controllerMap[static::getId()] = [
            'class' => 'yii\web\Controller',
            'module' => static::getId(),
        ];
    }

    public static function show()
    {
        return Yii::$app->runAction(str_replace(' ', '', static::getName()) . '/default/index');
    }

    public static function getId()
    {
        return 'example-plugin';
    }

    public static function getName()
    {
        return 'Example Plugin';
    }

    public static function getStatus()
    {
        $status = Yii::$app->db->createCommand('SELECT status FROM plugin WHERE id=:id')
            ->bindValue(':id', static::getId())
            ->queryScalar();

        return $status ? $status : 'not installed';
    }
}