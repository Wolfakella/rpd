<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

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
            'link',
            'department_id',
            'year',
        ],
    ]) ?>
	
	<h2>Дисциплины</h2>

	<?= GridView::widget([
		'dataProvider' => $programs,
		'columns' => [
		    'code',
		    [
		        'attribute' => 'title',
		        'format' => 'html',
		        'value' => function ($model, $key, $index, $column){
		            return Html::a($model->name, ['plan/hours', 'id' => $model->plan_id, 'program' => $index]);
		        }
		    ],
		],
	]); ?>
</div>
