<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "faculty".
 *
 * @property int $id
 * @property string $name
 * @property string $short_name
 *
 * @property Department[] $departments
 */
class Faculty extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'faculty';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'short_name'], 'string', 'max' => 255],
            [['name'], 'unique'],
			[['secretary_id'], 'exist', 'skipOnError' => true, 'targetClass' => Teacher::className(), 'targetAttribute' => ['secretary_id' => 'id']],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSecretary()
    {
        return $this->hasOne(Teacher::className(), ['id' => 'secretary_id']);
    }
	
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartments()
    {
        return $this->hasMany(Department::className(), ['faculty_id' => 'id']);
    }

    public function getPlans()
    {
	return $this->hasMany(Plan::className(), ['department_id' => 'id'])
		->viaTable('department', ['faculty_id' => 'id']);
    }
}
