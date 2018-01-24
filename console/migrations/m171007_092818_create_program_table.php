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
            'code' => $this->string(),
	    'name' => $this->string(),
	    'link' => $this->string(1000),
            'plan_id' => $this->integer(),
	    'index' => $this->integer()->notNull(),
	    'department_id' => $this->integer(),
	    'teacher_id' => $this->integer(),
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
            'CASCADE'
        );

        // creates index for column `department_id`
        $this->createIndex(
            'idx-program-department_id',
            'program',
            'department_id'
        );

        // add foreign key for table `department`
        $this->addForeignKey(
            'fk-program-department_id',
            'program',
            'department_id',
            'department',
            'id',
            'SET NULL'
        );

        // creates index for column `teacher_id`
        $this->createIndex(
            'idx-program-teacher_id',
            'program',
            'teacher_id'
        );

        // add foreign key for table `teacher`
        $this->addForeignKey(
            'fk-program-teacher_id',
            'program',
            'teacher_id',
            'teacher',
            'id',
            'SET NULL'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `teacher`
        $this->dropForeignKey(
            'fk-program-teacher_id',
            'program'
        );

        // drops index for column `teacher_id`
        $this->dropIndex(
            'idx-program-teacher_id',
            'program'
        );

        // drops foreign key for table `department`
        $this->dropForeignKey(
            'fk-program-department_id',
            'program'
        );

        // drops index for column `department_id`
        $this->dropIndex(
            'idx-program-department_id',
            'program'
        );

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
