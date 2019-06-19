<?php


namespace api\controllers;


use api\models\search\BookSearch;
use common\models\Book;
use yii\rest\ActiveController;
use yii\rest\CreateAction;
use yii\rest\UpdateAction;
use yii\rest\ViewAction;

class BookController extends ActiveController
{
    public $modelClass = Book::class;

    public function actions()
    {
        return [
            'index' => [
                'class' => 'yii\rest\IndexAction',
                'modelClass' => $this->modelClass,
                'prepareDataProvider' => static function ($action) {
                    $searchModel = new BookSearch();
                    return $searchModel->search(\Yii::$app->request->queryParams);
                }
            ],

            'create' => [
                'class' => CreateAction::class,
                'scenario' => Book::SCENARIO_API,
                'modelClass' => $this->modelClass
            ],

            'update' => [
                'class' => UpdateAction::class,
                'scenario' => Book::SCENARIO_API,
                'modelClass' => $this->modelClass
            ],

            'view' => [
                'class' => ViewAction::class,
                'modelClass' => $this->modelClass
            ]

        ];
    }
}
