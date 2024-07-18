<?php

use yii\helpers\Html;

/**  @var yii\web\View $this */
/**  @var array $plugins */

$this->title = 'Manage Plugins';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plugin-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($plugins as $plugin): ?>
            <tr>
                <td><?= Html::encode($plugin->getId()) ?></td>
                <td><?= Html::encode($plugin->getName()) ?></td>
                <td><?= Html::encode($plugin->getStatus()) ?></td>
                <td>
                    <?= Html::a('Show', ['show', 'id' => $plugin->getId()], ['class' => 'btn btn-info']) ?>
                    <?= Html::a('Install', ['install', 'id' => $plugin->getId()], ['class' => 'btn btn-success']) ?>
                    <?= Html::a('Activate', ['activate', 'id' => $plugin->getId()], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('Deactivate', ['deactivate', 'id' => $plugin->getId()], ['class' => 'btn btn-warning']) ?>
                    <?= Html::a('Uninstall', ['uninstall', 'id' => $plugin->getId()], ['class' => 'btn btn-danger']) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>
