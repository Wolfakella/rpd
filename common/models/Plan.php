<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "plan".
 *
 * @property int $id
 * @property string $code
 * @property string $title
 * @property string $profile
 * @property string $type
 * @property string $link
 * @property int $department_id
 * @property int $year
 *
 * @property Department $department
 * @property Program[] $programs
 */
class Plan extends \yii\db\ActiveRecord
{
    public $programCount = 0;

    function __construct($departmentId = NULL, $filePath = NULL)
    {
	parent::__construct();
	if(isset($filePath))
	{
	    $titlePattern = '/"?(([^\s\d\.]+\s+)?[^\s"]+)"?$/s';
	    $profilePattern = '/"(.*)"/';	    
	    $planData = simplexml_load_file($filePath);
	    
		$this->code = (string)$planData->План->Титул['ПоследнийШифр'];
		
		$this->type = mb_strtoupper((string)$planData->План['ФормаОбучения']);
		
		$this->year = $planData->План->Титул['ГодНачалаПодготовки'];
		
		$test = $planData->План->Титул->Специальности->Специальность[0];
		$matches = array();
		preg_match($titlePattern, $test['Название'], $matches);
		$this->title = $matches[0];
		
		$test = $planData->План->Титул->Специальности->Специальность[1];
		$matches = array();
		preg_match($profilePattern, $test['Название'], $matches);
		$this->profile = $matches[1];

		$this->link = $filePath;

		$this->department_id = $departmentId;
		foreach($planData->План->СтрокиПлана->Строка as $value) $this->programCount++;
	}
    } 
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'plan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['department_id', 'year'], 'integer'],
            [['code', 'title', 'profile', 'type', 'link'], 'string', 'max' => 255],
            [['department_id'], 'exist', 'skipOnError' => true, 'targetClass' => Department::className(), 'targetAttribute' => ['department_id' => 'id']],
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
            'title' => Yii::t('app', 'Title'),
            'profile' => Yii::t('app', 'Profile'),
            'type' => Yii::t('app', 'Type'),
            'link' => Yii::t('app', 'Link'),
            'department_id' => Yii::t('app', 'Department ID'),
            'year' => Yii::t('app', 'Year'),
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
    public function getPrograms()
    {
        return $this->hasMany(Program::className(), ['plan_id' => 'id']);
    }

    public function getHeader()
    {
        return $this->code . ' ' . $this->title . '. Профиль "' . $this->profile . '"';
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
