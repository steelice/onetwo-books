<?php

namespace api\models\search;

use common\models\Author;
use common\models\Book;
use common\models\BookAuthor;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * BookSearch represents the model behind the search form of `common\models\Book`.
 */
class BookSearch extends Model
{
    public $author;
    public $title;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'author'], 'safe'],
        ];
    }


    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Book::find()->where(['is_published' => 1]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
        ]);

        $this->load($params, '');

        if (!$this->validate()) {
            return $dataProvider;
        }


        $query->andFilterWhere(['like', 'title', $this->title]);

        if ($this->author) {
            $query->andFilterWhere([
                'id' => BookAuthor::find()->select('book_id')->where([
                    'author_id' => Author::find()->select('id')
                        ->where(['like', 'name', $this->author])
                        ->orWhere(['like', 'surname', $this->author])
                        ->orWhere(['like', 'patronymic', $this->author])
                ])
            ]);
        }

        return $dataProvider;
    }
}
