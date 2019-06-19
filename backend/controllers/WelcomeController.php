<?php


namespace backend\controllers;


use yii\web\Controller;

class WelcomeController extends Controller
{
    public function actionIndex(): string
    {
        return $this->render('index');
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
}