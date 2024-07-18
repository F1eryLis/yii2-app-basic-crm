<?php

namespace app\plugins\ExamplePlugin;

use Yii;
use app\components\plugins\PluginBase;
use yii\base\Application;

class Plugin extends PluginBase
{
    public static function install()
    {
        // Логика установки плагина
        // Например, миграции базы данных
    }

    public static function uninstall()
    {
        // Логика удаления плагина
        // Например, откат миграций базы данных
    }

    public static function activate()
    {
        // Логика активации
        Yii::$app->db->createCommand()->update('plugin', [
            'id' => static::getId(),
            'name' => static::getName(),
            'status' => 'active',
        ])->execute();
    }

    public static function deactivate()
    {
        // Логика деактивации
        Yii::$app->db->createCommand()->update('plugin', [
            'status' => 'inactive',
        ], ['name' => static::getName()])->execute();
    }

    public function bootstrap($app)
    {
        // Логика инициализации плагина
        // Например, регистрация событий или добавление маршрутов
        $app->on(Application::class, Application::EVENT_BEFORE_REQUEST, function () {
            Yii::info('ExamplePlugin is initialized!');
        });
    }

    public function registerComponent()
    {
        parent::registerComponents();

        Yii::$app->controllerMap[static::getId()] = [
            'class' => 'yii\web\controller',
            'module' => static::getId(),
            'controllerNamespace' => 'app\plugins\ExamplePlugin\controllers',
        ];
    }

    public static function show()
    {
        return Yii::$app->view->render('@app/plugins/' . str_replace(' ', '', static::getName()) . '/views/default/index');
    }

    public static function getId()
    {
        return 'example-plugin';
    }

    public static function getName()
    {
        return 'Example Plugin';
    }
}

