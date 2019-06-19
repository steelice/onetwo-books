<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "author".
 *
 * @property int $id
 * @property string $name Имя
 * @property string $surname Фамилия
 * @property string $patronymic Отчество
 *
 * @property BookAuthor[] $bookAuthors
 * @property Book[] $books
 */
class Author extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'author';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'surname'], 'required'],
            [['name', 'surname', 'patronymic'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Имя'),
            'surname' => Yii::t('app', 'Фамилия'),
            'patronymic' => Yii::t('app', 'Отчество'),
        ];
    }

    public function beforeDelete()
    {
        $parentResult = parent::beforeDelete();
        if ($parentResult) {
            // помечаем все книги удаленным автором как не опубликованные
            Book::updateAll(['is_published' => 0],
                ['id' => BookAuthor::find()->select('book_id')->where(['author_id' => $this->id])]);
        }
        return $parentResult;
    }

    /**
     * Возвращает полное имя автора
     *
     * @return string
     */
    public function getFullName(): string
    {
        return implode(' ', [$this->name, $this->surname, $this->patronymic]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBookAuthors()
    {
        return $this->hasMany(BookAuthor::className(), ['author_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBooks()
    {
        return $this->hasMany(Book::className(), ['id' => 'book_id'])->viaTable('book_author', ['author_id' => 'id']);
    }
}
