<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

class PluginController extends Controller
{
    public function actionIndex()
    {
        $pluginManager = Yii::$app->pluginManager;
        $plugins = $pluginManager->getAvailablePlugins();

        return $this->render('index', ['plugins' => $plugins]);
    }

    public function actionInstall($id)
    {
        $pluginManager = Yii::$app->pluginManager;
        $plugin = $pluginManager->getPluginById($id);

        if ($plugin) {
            $plugin::install();
            Yii::$app->session->setFlash('success', 'Plugin installed successfully.');
        } else {
            Yii::$app->session->setFlash('error', 'Plugin not found.');
        }

        return $this->redirect(['index']);
    }

    public function actionActivate($id)
    {
        $pluginManager = Yii::$app->pluginManager;
        $plugin = $pluginManager->getPluginById($id);

        if ($plugin) {
            $plugin::activate();
            Yii::$app->session->setFlash('success', 'Plugin activated successfully.');
        } else {
            Yii::$app->session->setFlash('error', 'Plugin not found.');
        }

        return $this->redirect(['index']);
    }

    public function actionDeactivate($id)
    {
        $pluginManager = Yii::$app->pluginManager;
        $plugin = $pluginManager->getPluginById($id);

        if ($plugin) {
            $plugin::deactivate();
            Yii::$app->session->setFlash('success', 'Plugin deactivated successfully.');
        } else {
            Yii::$app->session->setFlash('error', 'Plugin not found.');
        }

        return $this->redirect(['index']);
    }

    public function actionUninstall($id)
    {
        $pluginManager = Yii::$app->pluginManager;
        $plugin = $pluginManager->getPluginById($id);

        if ($plugin) {
            $plugin::uninstall();
            Yii::$app->session->setFlash('success', 'Plugin uninstalled successfully.');
        } else {
            Yii::$app->session->setFlash('error', 'Plugin not found.');
        }

        return $this->redirect(['index']);
    }

    public function actionShow($id)
    {
        $pluginManager = Yii::$app->pluginManager;
        $plugin = $pluginManager->getPluginById($id);

        if ($plugin) {
            return $plugin::show();
        } else {
            Yii::$app->session->setFlash('error', 'Plugin not found.');
            return $this->redirect(['index']);
        }
    }
}
