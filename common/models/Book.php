<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "book".
 *
 * @property int $id
 * @property string $title Название
 * @property string $keywords Ключевые слова
 * @property string $picture URL картинки
 * @property string $description Описание
 * @property int $is_published Статус: 0 не опубликовано, 1 опубликовано
 *
 * @property BookAuthor[] $bookAuthors
 * @property Author[] $authors
 */
class Book extends \yii\db\ActiveRecord
{
    public const SCENARIO_API = 'api';
    public $authors_list;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['description'], 'string'],
            [['authors_list'], 'validateAuthorsList'],
            [['is_published'], 'boolean', 'trueValue' => 1, 'falseValue' => 0],
            [['title', 'keywords'], 'string', 'max' => 255],
            [['picture'], 'url'],
        ];
    }

    public function validateAuthorsList($attribute, $params, $validator)
    {
        if ($this->authors_list && !is_array($this->authors_list)) {
            $this->addError($attribute, Yii::t('app', 'Параметр должен быть массивом или отсутстовать'));
        }
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_API] = ['title', 'description', 'picture', 'authors_list'];
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Название'),
            'keywords' => Yii::t('app', 'Ключевые слова'),
            'picture' => Yii::t('app', 'URL картинки'),
            'description' => Yii::t('app', 'Описание'),
            'is_published' => Yii::t('app', 'Опубликовано'),
            'authors_list' => Yii::t('app', 'Авторы'),
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        $this->setAuthors($this->authors_list);
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->authors_list = ArrayHelper::getColumn($this->authors, 'id');
    }

    public function fields()
    {
        return [
            'id', 'title', 'picture', 'description', 'keywords', 'authors_list' => 'authors'
        ];
    }

    /**
     * Устанавливает список авторов по их ID
     *
     * @param array $authors
     */
    public function setAuthors(?array $authors): void
    {
        if (!$authors) {
            $authors = [];
        }
        $currentAuthorsIds = ArrayHelper::map($this->authors, 'id', 'id');
        foreach ($authors as $authorId) {
            // уже существующие связи не трогаем
            if (!empty($currentAuthorsIds[$authorId])) {
                unset($currentAuthorsIds[$authorId]);
                continue;
            }

            // новых авторов у книги - добавляем в связь
            if ($author = Author::findOne($authorId)) {
                $this->link('authors', $author);
            }
        }
        // для уменьшения кол-ва запросов удаляем всё скопом прямо из таблицы связей
        BookAuthor::deleteAll(['book_id' => $this->id, 'author_id' => $currentAuthorsIds]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBookAuthors()
    {
        return $this->hasMany(BookAuthor::className(), ['book_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthors()
    {
        return $this->hasMany(Author::className(), ['id' => 'author_id'])->viaTable('book_author', ['book_id' => 'id']);
    }
}
