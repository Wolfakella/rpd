<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $model common\models\Department */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Departments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="department-view">

    <h1><?= Html::encode($this->title) ?>
	</br>	
	<small><?= $model->faculty->name ?></small>
    </h1>

    <table class="table">
	<tr>
		<th scope="col">РПД входящие</th>
		<th scope="col">РПД исходящие</th>
	</tr>
	<tr>
		<td><?= $model->plansSuccess ?></td>
		<td><?= $model->programsSuccess ?></td>
	</tr>
    </table>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'short_name',
//            'faculty_id',
            [
                'attribute' => 'Факультет',
                'format' => 'html',
                'value' => function ($model, $widget){
			if(isset($model->faculty))
	                    	return Html::a($model->faculty->name, ['report/faculty', 'id' => $model->faculty_id]);
			else
				return null;
                }
            ],
        ],
    ]) ?>
      <div class="row">
	<div class="col-xs-6">
	<div class="panel panel-default">
	  <div class="panel-heading"><h4>Статистика РПД по учебным планам</h4></div>
	  <div class="panel-body">
		    <?= GridView::widget([
			'dataProvider' => $plansDataProvider,
			//'filterModel' => $searchModel,
			'columns' => [
			  //  ['class' => 'yii\grid\SerialColumn'],

			    'code',
			    'title',
			    'percent',
				['class' => 'yii\grid\ActionColumn',
				'controller' => 'plan',
				'template' => '{view}',
				],
			],
		    ]); ?>
	  </div>
	</div>
	</div>

	<div class="col-xs-6">
	<div class="panel panel-default">
	  <div class="panel-heading"><h4>Статистика РПД по преподавателям</h4></div>
	  <div class="panel-body">
		    <?= GridView::widget([
			'dataProvider' => $teachersDataProvider,
			//'filterModel' => $searchModel,
			'columns' => [
			  //  ['class' => 'yii\grid\SerialColumn'],

			    'lastname',
			    'firstname',
			    'percent',
				['class' => 'yii\grid\ActionColumn',
				'controller' => 'teacher',
				'template' => '{view}',
				],
			],
		    ]); ?>
	  </div>
	</div>
	</div>
      </div>

	<div class="row">
	<div class="col-xs-12">
	   <div class="panel panel-danger">
	   	   <div class="panel-heading"><h4>РПД, за которые никто не отвечает</h4></div>
		   <div class="panel-body">
			<?= GridView::widget([
				'dataProvider' => $lostPrograms,
				//'filterModel' => $searchModel,
				'columns' => [
				  //  ['class' => 'yii\grid\SerialColumn'],

				    'code',
				    'name',
				    'plan.title',
					[
						'attribute' => 'Преподаватель',
						'format' => 'html',
						'content' => function ($model, $key, $index, $column){
						    return $this->renderAjax('@frontend/views/ajax/_form');
						}
					],
				    ['class' => 'yii\grid\ActionColumn'],
				],
			    ]); ?>
		   </div>
	   </div>
	</div>
	</div>
</div>
