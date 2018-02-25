<?php

namespace common\models;

use Yii;
use yii\base\Model;

class AjaxQuery extends Model
{
	public $query;

	public function rules()
	{
		return [
			['query', 'string'],
		];
	}
}
