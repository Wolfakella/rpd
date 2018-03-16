<?php

use yii\db\Migration;

/**
 * Handles adding secretary_id to table `department`.
 * Has foreign keys to the tables:
 *
 * - `teacher`
 */
class m180316_171753_add_secretary_id_column_to_department_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('department', 'secretary_id', $this->integer());

        // creates index for column `secretary_id`
        $this->createIndex(
            'idx-department-secretary_id',
            'department',
            'secretary_id'
        );

        // add foreign key for table `teacher`
        $this->addForeignKey(
            'fk-department-secretary_id',
            'department',
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
            'fk-department-secretary_id',
            'department'
        );

        // drops index for column `secretary_id`
        $this->dropIndex(
            'idx-department-secretary_id',
            'department'
        );

        $this->dropColumn('department', 'secretary_id');
    }
}
