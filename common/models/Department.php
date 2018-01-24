<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "department".
 *
 * @property int $id
 * @property string $name
 * @property string $short_name
 * @property int $faculty_id
 *
 * @property Faculty $faculty
 * @property Plan[] $plans
 * @property User[] $users
 */
class Department extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'department';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['id', 'faculty_id'], 'integer'],
            [['name', 'short_name'], 'string', 'max' => 255],
            [['id', 'name'], 'unique'],
            [['faculty_id'], 'exist', 'skipOnError' => true, 'targetClass' => Faculty::className(), 'targetAttribute' => ['faculty_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'short_name' => Yii::t('app', 'Short Name'),
            'faculty_id' => Yii::t('app', 'Faculty ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFaculty()
    {
        return $this->hasOne(Faculty::className(), ['id' => 'faculty_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlans()
    {
        return $this->hasMany(Plan::className(), ['department_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrograms()
    {
        return $this->hasMany(Program::className(), ['department_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeachers()
    {
        return $this->hasMany(Teacher::className(), ['department_id' => 'id']);
    }

	public function getPlansSuccess()
	{
		$countCompleted = 0;
		$countTotal = 0;
		foreach($this->plans as $plan)
		{
			$countCompleted += $plan->completed;		
			$countTotal += $plan->count;
		}
		if($countTotal == 0) return 1;
		else return $countCompleted / $countTotal;
	}

	public function getProgramsSuccess()
	{
		$countCompleted = $this->getPrograms()->where(['not', ['link' => null]])->count();
		$countTotal = $this->getPrograms()->count();

		if($countTotal == 0) return 1;
		else return $countCompleted / $countTotal;
	}
}
