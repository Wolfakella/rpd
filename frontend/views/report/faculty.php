<?php

use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\Department */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Departments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="department-view">

    <h1><?= Html::encode($this->title) ?> <small class="text-muted">ID# <?= $model->id ?></small></h1>

    <table class="table">
	<tr>
		<th scope="col">Состояние РПД</th>
		<th scope="col">Состояние учебных планов</th>
		<th scope="col">Результат</th>
	</tr>
	<tr>
		<td></td>
		<td></td>
		<td></td>
	</tr>
    </table>
      
		<h3>Кафедры</h3>
			<?= GridView::widget([
				'dataProvider' => new ActiveDataProvider([
					'query' => $model->getDepartments(),
					'pagination' => false,
				]),
				//'filterModel' => $searchModel,
				'layout' => '{items}',
				'options' => ['class'=>'grid-view table-responsive'],
				'columns' => [
				    [
					'attribute' => 'Кафедра',
					'format' => 'html',
					'value' => function ($model, $widget){
						    	return Html::a($model->name, ['report/department', 'id' => $model->id]);
					}
				    ],
				    'programsSuccess',
				    'plansSuccess',
				],
			    ]); ?>
		<h3>Учебные планы
		<?= Html::a(Yii::t('app', 'Upload Plan'), ['plan/upload'], ['class' => 'btn btn-warning']) ?>
		</h3>
			<?= GridView::widget([
				'dataProvider' => new ActiveDataProvider([
					'query' => $model->getPlans(),
					'pagination' => false,
				]),
				//'filterModel' => $searchModel,
				'layout' => '{items}',
				'options' => ['class'=>'grid-view table-responsive'],
				'columns' => [
				    'id',
				    [
					'attribute' => 'Учебный план',
					'format' => 'html',
					'value' => function ($model, $widget){
						    	return Html::a($model->title, ['report/plan', 'id' => $model->id]);
					}
				    ],
				    'department.name',
				    'percent',
            				['class' => 'yii\grid\ActionColumn',
					'controller' => 'plan',
					'template' => '{delete}'
					],
				],
			    ]); ?>
</div>
