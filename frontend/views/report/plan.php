<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\Department */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Departments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="department-view">

    <h1><?= Html::encode($this->title) ?>
	</br>	
	<small><?= $model->department->name ?></small>
    </h1>

    <table class="table">
	<tr>
		<th scope="col">РПД готово</th>
		<th scope="col">РПД всего</th>
		<th scope="col">Результат</th>
	</tr>
	<tr>
		<td></td>
		<td></td>
		<td></td>
	</tr>
    </table>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'code',
            'title',
//            'faculty_id',
            [
                'attribute' => 'Кафедра',
                'format' => 'html',
                'value' => function ($model, $widget){
			if(isset($model->department))
	                    	return Html::a($model->department->name, ['department/view', 'id' => $model->department_id]);
			else
				return null;
                }
            ],
        ],
    ]) ?>
      
	<div class="row">
	<div class="col-xs-12">
	   <div class="panel panel-info">
	   	   <div class="panel-heading"><h4>Рабочие программы дисциплин</h4></div>
		   <div class="panel-body">
			<?= GridView::widget([
				'dataProvider' => new ActiveDataProvider([
					'query' => $model->getPrograms(),
					'pagination' => false,
				]),
				//'filterModel' => $searchModel,
				'layout' => '{items}',
				'options' => ['class'=>'grid-view table-responsive'],
				'columns' => [
				  //  ['class' => 'yii\grid\SerialColumn'],

				    ['attribute' => 'code',
				     'options' => ['class' => 'col-xs-1'],
				    ],
				    ['attribute' => 'name',
				     'options' => ['class' => 'col-xs-3'],
				     'contentOptions' => [
						'style'=>'white-space: normal'
				    		],
				    ],
				    //'name',
				    'link',
				    'teacher.lastname',
				    ['attribute' => 'department.name',
				     'options' => ['class' => 'col-xs-3'],
				     'contentOptions' => [
						'style'=>'white-space: normal'
				    		],
				    ],
				    ['class' => 'yii\grid\ActionColumn'],
				],
			    ]); ?>
		   </div>
	   </div>
	</div>
	</div>
</div>
