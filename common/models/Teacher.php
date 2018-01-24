<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "teacher".
 *
 * @property int $id
 * @property string $lastname
 * @property string $middlename
 * @property string $firstname
 * @property int $department_id
 * @property int $user_id
 *
 * @property Department $department
 * @property User $user
 */
class Teacher extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'teacher';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['department_id', 'user_id'], 'integer'],
            [['user_id'], 'required'],
            [['lastname', 'middlename', 'firstname'], 'string', 'max' => 255],
            [['user_id'], 'unique'],
            [['department_id'], 'exist', 'skipOnError' => true, 'targetClass' => Department::className(), 'targetAttribute' => ['department_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'lastname' => Yii::t('app', 'Lastname'),
            'middlename' => Yii::t('app', 'Middlename'),
            'firstname' => Yii::t('app', 'Firstname'),
            'department_id' => Yii::t('app', 'Department ID'),
            'user_id' => Yii::t('app', 'User ID'),
        ];
    }

    public function getCredentials()
    {
	return $this->lastname .' ' . $this->firstname . ' ' . $this->middlename;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartment()
    {
        return $this->hasOne(Department::className(), ['id' => 'department_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrograms()
    {
        return $this->hasMany(Program::className(), ['teacher_id' => 'id']);
    }

	public function getCompleted()
	{
		return $this->getPrograms()->where(['not', ['link' => null]])->count();
	}

	public function getCount()
	{
		return $this->getPrograms()->count();
	}

	public function getPercent()
	{
		if(!$this->count) return 0;
		else return $this->completed / $this->count;
	}
}
