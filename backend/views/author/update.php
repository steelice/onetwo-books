<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Author */

$this->title = Yii::t('app', 'Редактирование автора: ') . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Авторы'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Редактирование');
?>
<div class="author-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
