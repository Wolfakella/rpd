<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Plan */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Plans'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plan-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'code',
            'title',
            'profile',
            'type',
	    [
	    	'attribute' => 'link',
		'format' => 'url'
	    ],
//            'department_id',
            [
                'attribute' => 'Факультет',
                'format' => 'html',
                'value' => function ($model, $widget){
			if(isset($model->department))
	                    	return Html::a($model->department->name, ['department/view', 'id' => $model->department_id]);
			else
				return null;
                }
            ],
            'year',
        ],
    ]) ?>

</div>
