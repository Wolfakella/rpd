<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use yii\helpers\Url;
use common\models\Department;

class UploadPlan extends Model
{
	public $uploadedFile;
	public $department_id;

	public $uploadPath = '/uploads/';

	public function rules()
	{
		return [
			['department_id', 'exist', 'targetClass' => Department::className(), 'targetAttribute' => 'id'],
        		[['uploadedFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'xml'],
		];
	}

    public function attributeLabels()
    {
        return [
            'department_id' => 'Кафедра',
            'uploadedFile' => 'Учебный план',
        ];
    }

    public function getLinkText()
    {
    	return Url::to($this->link, true);
    }
    
    public function getHeader()
    {
        return $this->code . ' ' . $this->title . '. Профиль "' . $this->profile . '"';
    }
    
    public function upload()
    {
    	if ($this->validate()) {
		//return print_r($this->uploadedFile->name);		
    		$this->uploadedFile->saveAs(Yii::getAlias('@common') . $this->uploadPath . $this->uploadedFile->name);
    		return true;
    	} else {
    		print_r($this->errors);
    		return false;
    	}
    }
    
    public function getFilePath()
    {
	return Yii::getAlias('@common') . $this->uploadPath . $this->uploadedFile->name;
    }

}
