<?php

use yii\db\Migration;

/**
 * Handles the creation of table `program`.
 * Has foreign keys to the tables:
 *
 * - `plan`
 */
class m171007_092818_create_program_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('program', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull()->unique(),
            'index' => $this->integer()->notNull(),
            'plan_id' => $this->integer(),
        ]);

        // creates index for column `plan_id`
        $this->createIndex(
            'idx-program-plan_id',
            'program',
            'plan_id'
        );

        // add foreign key for table `plan`
        $this->addForeignKey(
            'fk-program-plan_id',
            'program',
            'plan_id',
            'plan',
            'id',
            'SET NULL'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `plan`
        $this->dropForeignKey(
            'fk-program-plan_id',
            'program'
        );

        // drops index for column `plan_id`
        $this->dropIndex(
            'idx-program-plan_id',
            'program'
        );

        $this->dropTable('program');
    }
}
