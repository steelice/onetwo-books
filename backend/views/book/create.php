<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Book */

$this->title = Yii::t('app', 'Добавление книги');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Книги'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
