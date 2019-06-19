<?php

use yii\db\Migration;

/**
 * Class m190619_174750_create_table_author
 */
class m190619_174750_create_table_author extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('{{%author}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->comment('Имя'),
            'surname' => $this->string()->notNull()->comment('Фамилия'),
            'patronymic' => $this->string()->null()->comment('Отчество')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%author}}');
    }
}
