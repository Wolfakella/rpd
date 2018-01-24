<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "program".
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property int $plan_id
 * @property int $index
 * @property int $department_id
 * @property int $teacher_id
 *
 * @property Department $department
 * @property Plan $plan
 * @property Teacher $teacher
 */
class Program extends \yii\db\ActiveRecord
{

	function __construct($filePath = NULL, $index = NULL)
	{
		parent::__construct();		
		if(isset($filePath))
		{
			$data = simplexml_load_file($filePath)->План->СтрокиПлана->Строка[intval($index)];
			$this->code = (string)$data['ИдетификаторДисциплины'];
			$this->name = (string)$data['Дис'];
			if(isset($index)) $this->index = $index;
			$this->department_id = intval((string)$data['Кафедра']);
		}
	}

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'program';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['plan_id', 'index', 'department_id', 'teacher_id'], 'integer'],
            [['index'], 'required'],
            [['code', 'name'], 'string', 'max' => 255],
	    [['link'], 'string', 'max' => 1000],
	    [['link'], 'url'],
            [['department_id'], 'exist', 'skipOnError' => true, 'targetClass' => Department::className(), 'targetAttribute' => ['department_id' => 'id']],
            [['plan_id'], 'exist', 'skipOnError' => true, 'targetClass' => Plan::className(), 'targetAttribute' => ['plan_id' => 'id']],
            [['teacher_id'], 'exist', 'skipOnError' => true, 'targetClass' => Teacher::className(), 'targetAttribute' => ['teacher_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'code' => Yii::t('app', 'Code'),
            'name' => Yii::t('app', 'Name'),
	    'link' => Yii::t('app', 'Link'), 
            'plan_id' => Yii::t('app', 'Plan ID'),
            'index' => Yii::t('app', 'Index'),
            'department_id' => Yii::t('app', 'Department ID'),
            'teacher_id' => Yii::t('app', 'Teacher ID'),
        ];
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
    public function getPlan()
    {
        return $this->hasOne(Plan::className(), ['id' => 'plan_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeacher()
    {
        return $this->hasOne(Teacher::className(), ['id' => 'teacher_id']);
    }
}
