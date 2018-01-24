<?php

use yii\db\Migration;

/**
 * Handles the creation of table `plan`.
 * Has foreign keys to the tables:
 *
 * - `department`
 */
class m171007_092554_create_plan_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('plan', [
            'id' => $this->primaryKey(),
	    'code' => $this->string(),
            'title' => $this->string(),
	    'profile' => $this->string(),
	    'type' => $this->string(),
            'link' => $this->string(),
            'department_id' => $this->integer(),
	    'year' => $this->integer(),
        ]);

        // creates index for column `department_id`
        $this->createIndex(
            'idx-plan-department_id',
            'plan',
            'department_id'
        );

        // add foreign key for table `department`
        $this->addForeignKey(
            'fk-plan-department_id',
            'plan',
            'department_id',
            'department',
            'id',
            'SET NULL'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `department`
        $this->dropForeignKey(
            'fk-plan-department_id',
            'plan'
        );

        // drops index for column `department_id`
        $this->dropIndex(
            'idx-plan-department_id',
            'plan'
        );

        $this->dropTable('plan');
    }
}
