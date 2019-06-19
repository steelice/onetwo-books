<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\BookSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Книги');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-index box box-primary">
    <?php Pjax::begin(); ?>
    <div class="box-header with-border">
        <?= Html::a(Yii::t('app', 'Добавить книгу'), ['create'], ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <div class="box-body table-responsive no-padding">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'layout' => "{items}\n{summary}\n{pager}",
            'columns' => [
                'title',
                'keywords',
                'picture',
                'description:ntext',
                [
                    'attribute' => 'is_published',
                    'filter' => [0 => Yii::t('app', 'Нет'), 1 => Yii::t('app', 'Да')],
                    'content' => static function (\common\models\Book $book) {
                        return $book->is_published ?
                            Html::tag('i', '', ['class' => 'fa fa-check-square text-success']) :
                            Html::tag('i', '', ['class' => 'fa fa-times text-danger']);

                    },
                    'contentOptions' => ['class' => 'text-center']
                ],
                [
                    'header' => Yii::t('app', 'Авторы'),
                    'value' => static function (\common\models\Book $book) {
                        return implode(', ', \yii\helpers\ArrayHelper::getColumn($book->authors, 'fullName'));
                    }
                ],

                ['class' => 'yii\grid\ActionColumn', 'template' => '{update} {delete}'],
            ],
        ]); ?>
    </div>
    <?php Pjax::end(); ?>
</div>
