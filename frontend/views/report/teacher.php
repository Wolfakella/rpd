<?php

use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\Department */

$this->title = $model->credentials;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Departments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="department-view">

    <h1><?= Html::encode($this->title) ?> <small class="text-muted">ID# <?= $model->id ?></small>
	<br/>
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
		<h3>Рабочие программы дисциплин</h3>
			<?= GridView::widget([
				'dataProvider' => new ActiveDataProvider([
					'query' => $model->getPrograms(),
					'pagination' => false,
				]),
				//'filterModel' => $searchModel,
				'layout' => '{items}',
				'options' => ['class'=>'grid-view table-responsive'],
				'columns' => [
				    'id',
				    'name',
				    'department.name',
				],
			    ]); ?>
</div>
