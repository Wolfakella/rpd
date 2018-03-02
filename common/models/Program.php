<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

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
	private $_temp;
	private $_list;
	
	public $competencies;
	public $semesters = array();
	public $zaoch = false;

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
			
			$this->_temp = simplexml_load_file($filePath)->План->СтрокиПлана->Строка[intval($index)];
			$this->_list = simplexml_load_file($filePath)->План->Компетенции;
		
			$this->competencies = $this->getCompetencies();
			VarDumper::dump($index);
			if(preg_match('/.plm.xml$/', $filePath))
			      foreach($this->_temp->Сем as $item) $this->semesters[intval($item['Ном'])] = new Semester($item);
			if(preg_match('/.plz.xml$/', $filePath))
			{
			      foreach($this->_temp->Курс as $item) $this->semesters[intval($item['Ном'])] = new Semester($item, true);
			      $this->zaoch = true;
			}
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

	public function getTotalHours()
	{
	    return ArrayHelper::getValue($this->_temp->attributes(), 'ГОС');
	}
	
	public function getSrs()
	{
	    return ArrayHelper::getValue($this->_temp->attributes(), 'СР');
	}
	
	public function getCode()
	{
	    return ArrayHelper::getValue($this->_temp->attributes(), 'ИдетификаторДисциплины');
	}
	
	public function getTitle()
	{
	    return ArrayHelper::getValue($this->_temp->attributes(), 'Дис');
	}
	
	public function getUnits()
	{
	    return ArrayHelper::getValue($this->_temp->attributes(), 'КредитовНаДисциплину');
	}
	
	public function getLecturesHours()
	{
		$result = 0;
		foreach($this->semesters as $semester) $result += $semester->lectures;
		return $result;
	}
	
	public function getPracticHours()
	{
		$result = 0;
		foreach($this->semesters as $semester) $result += $semester->practics;
		return $result;
	}
	
	public function getLabHours()
	{
	    $result = 0;
	    foreach($this->semesters as $semester) $result += $semester->labs;
	    return $result;
	}
	
	public function getClassHours()
	{
		return $this->lecturesHours + $this->practicHours + $this->labHours;
	}
	
	public function getExamHours()
	{
		$result = 0;
		foreach($this->semesters as $semester) $result += $semester->examHours;
		return $result;
	}
	
	public function getZachHours()
	{
	    $result = 0;
	    foreach($this->semesters as $semester) $result += $semester->zachHours;
	    return $result;
	}
	
	public function getExamStr()
	{
	    $arr = str_split( ArrayHelper::getValue($this->_temp->attributes(), 'СемЭкз') );
		return implode(',', $arr);
	}
	
	public function getZachStr()
	{
	    $arr = str_split( ArrayHelper::getValue($this->_temp->attributes(), 'СемЗач') );
		return implode(',', $arr);
	}
	
	public function getKontrStr()
	{
	    $str = "";
	    foreach($this->semesters as $key => $semester)
	        if( $semester->kontr )
	            if($str == "") $str .= $key;
	            else $str .= ',' . $key;
	    return $str;
	}
	
	public function getKursStr()
	{
	    $arr = str_split( ArrayHelper::getValue($this->_temp->attributes(), 'СемКР') );
	    return implode(',', $arr);
	}
	
	private function getCompetencies()
	{
		$codes = explode('&', $this->_temp['КомпетенцииКоды']);
		$result = array();
		foreach($codes as $code)
		{
			$item = array();
			$elem = $this->_list->Строка[intval($code - 1)];

			if(intval($elem['Код']) == $code)
			{
				array_push($result, ['code' => $elem['Индекс']->__toString(), 'text' => $elem['Содержание']->__toString()]);
			}
			else
				array_push($result, ['code' => 'Error!', 'text' => 'Error!']);
		}
		return $result;
	}
}
