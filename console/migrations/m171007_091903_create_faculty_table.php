<?php

use yii\db\Migration;

/**
 * Handles the creation of table `faculty`.
 */
class m171007_091903_create_faculty_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('faculty', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),
            'short_name' => $this->string(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('faculty');
    }
}
