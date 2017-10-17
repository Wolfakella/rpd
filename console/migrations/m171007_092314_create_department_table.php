<?php

use yii\db\Migration;

/**
 * Handles the creation of table `department`.
 * Has foreign keys to the tables:
 *
 * - `faculty`
 */
class m171007_092314_create_department_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('department', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),
            'short_name' => $this->string(),
            'faculty_id' => $this->integer(),
        ]);

        // creates index for column `faculty_id`
        $this->createIndex(
            'idx-department-faculty_id',
            'department',
            'faculty_id'
        );

        // add foreign key for table `faculty`
        $this->addForeignKey(
            'fk-department-faculty_id',
            'department',
            'faculty_id',
            'faculty',
            'id',
            'SET NULL'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `faculty`
        $this->dropForeignKey(
            'fk-department-faculty_id',
            'department'
        );

        // drops index for column `faculty_id`
        $this->dropIndex(
            'idx-department-faculty_id',
            'department'
        );

        $this->dropTable('department');
    }
}
