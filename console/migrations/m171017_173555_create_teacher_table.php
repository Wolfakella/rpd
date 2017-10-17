<?php

use yii\db\Migration;

/**
 * Handles the creation of table `teacher`.
 * Has foreign keys to the tables:
 *
 * - `department`
 * - `user`
 */
class m171017_173555_create_teacher_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('teacher', [
            'id' => $this->primaryKey(),
            'lastname' => $this->string(),
            'middlename' => $this->string(),
            'firstname' => $this->string(),
            'department_id' => $this->integer(),
            'user_id' => $this->integer()->notNull()->unique(),
        ]);

        // creates index for column `department_id`
        $this->createIndex(
            'idx-teacher-department_id',
            'teacher',
            'department_id'
        );

        // add foreign key for table `department`
        $this->addForeignKey(
            'fk-teacher-department_id',
            'teacher',
            'department_id',
            'department',
            'id',
            'SET NULL'
        );

        // creates index for column `user_id`
        $this->createIndex(
            'idx-teacher-user_id',
            'teacher',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-teacher-user_id',
            'teacher',
            'user_id',
            'user',
            'id',
            'RESTRICT'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `department`
        $this->dropForeignKey(
            'fk-teacher-department_id',
            'teacher'
        );

        // drops index for column `department_id`
        $this->dropIndex(
            'idx-teacher-department_id',
            'teacher'
        );

        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-teacher-user_id',
            'teacher'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-teacher-user_id',
            'teacher'
        );

        $this->dropTable('teacher');
    }
}
