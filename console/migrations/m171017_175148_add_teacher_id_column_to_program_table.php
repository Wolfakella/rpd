<?php

use yii\db\Migration;

/**
 * Handles adding teacher_id to table `program`.
 * Has foreign keys to the tables:
 *
 * - `teacher`
 */
class m171017_175148_add_teacher_id_column_to_program_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('program', 'teacher_id', $this->integer());

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

        $this->dropColumn('program', 'teacher_id');
    }
}
