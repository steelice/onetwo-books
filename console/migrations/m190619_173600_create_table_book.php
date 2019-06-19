<?php

use yii\db\Migration;

/**
 * Class m190619_173600_create_table_book
 */
class m190619_173600_create_table_book extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('{{%book}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull()->comment('Название'),
            'keywords' => $this->string()->null()->comment('Ключевые слова'),
            'picture' => $this->string()->null()->comment('URL картинки'),
            'description' => $this->text()->null()->comment('Описание'),
            'is_published' => $this->tinyInteger()->defaultValue(1)->comment('Статус: 0 не опубликовано, 1 опубликовано')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%book}}');
    }
}
