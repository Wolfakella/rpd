<?php

use yii\db\Migration;

/**
 * Handles adding secretary_id to table `faculty`.
 * Has foreign keys to the tables:
 *
 * - `teacher`
 */
class m180316_171458_add_secretary_id_column_to_faculty_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('faculty', 'secretary_id', $this->integer());

        // creates index for column `secretary_id`
        $this->createIndex(
            'idx-faculty-secretary_id',
            'faculty',
            'secretary_id'
        );

        // add foreign key for table `teacher`
        $this->addForeignKey(
            'fk-faculty-secretary_id',
            'faculty',
            'secretary_id',
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
            'fk-faculty-secretary_id',
            'faculty'
        );

        // drops index for column `secretary_id`
        $this->dropIndex(
            'idx-faculty-secretary_id',
            'faculty'
        );

        $this->dropColumn('faculty', 'secretary_id');
    }
}
