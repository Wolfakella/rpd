<?php 
namespace common\models;

use yii\helpers\ArrayHelper;

class Semester extends \yii\base\Model
{
    private $_data;
    private $_zaoch;
    
    public function __construct($object, $zaoch = false)
    {
        $this->_data = $object;
        $this->_zaoch = $zaoch;
    }
    
    public function getNum()
    {
        return ArrayHelper::getValue($this->_data->attributes(), 'Ном');
    }
    
    public function getLectures()
    {
        return ArrayHelper::getValue($this->_data->attributes(), 'Лек');
    }
    
    public function getPractics()
    {
        return ArrayHelper::getValue($this->_data->attributes(), 'Пр');
    }
    
    public function getLabs()
    {
        return ArrayHelper::getValue($this->_data->attributes(), 'Лаб');
    }
    
    public function getSRS()
    {
        return ArrayHelper::getValue($this->_data->attributes(), 'СРС');
    }
    
    public function getExamHours()
    {
        if($this->_zaoch)
            return 9 * ArrayHelper::getValue($this->_data->attributes(), 'Экз');
        else 
            return ArrayHelper::getValue($this->_data->attributes(), 'ЧасЭкз');
    }
    
    public function getZachHours()
    {
        if($this->_zaoch)
            return 4 * ArrayHelper::getValue($this->_data->attributes(), 'Зач');
        else
            return ArrayHelper::getValue($this->_data->attributes(), 'ЧасЭкз');
    }
    
    public function getTotal()
    {
        return $this->lectures + $this->practics + $this->labs + $this->srs + $this->examHours + $this->zachHours;
    }
    
    public function getKontr()
    {
        if( ArrayHelper::getValue($this->_data->attributes(), 'КонтрРаб') )
            return true;
        else
            return false;
    }
}
