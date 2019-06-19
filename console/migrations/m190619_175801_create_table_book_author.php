<?php

use yii\db\Migration;

/**
 * Class m190619_175801_create_table_book_author
 */
class m190619_175801_create_table_book_author extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('{{%book_author}}', [
            'book_id' => $this->integer()->notNull(),
            'author_id' => $this->integer()->notNull()
        ]);

        $this->createIndex('unic_book_author', '{{%book_author}}', ['book_id', 'author_id'], true);

        $this->addForeignKey('fk_book_author_book', '{{%book_author}}', 'book_id', '{{%book}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_book_author_author', '{{%book_author}}', 'author_id', '{{%author}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%book_author}}');
    }
}
