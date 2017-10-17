<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ProgramSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Programs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="program-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Program'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'index',
            'title',
//            'plan_id',
//            'user_id',
            [
                'attribute' => 'Учебный план',
                'format' => 'html',
                'value' => function ($model, $key, $index, $column){
			if(isset($model->plan))
	                    	return Html::a($model->plan->title, ['plan/view', 'id' => $model->plan_id]);
			else
				return null;
                }
            ],
            [
                'attribute' => 'Преподаватель',
                'format' => 'html',
                'value' => function ($model, $key, $index, $column){
			if(isset($model->user))
	                    	return Html::a($model->user->title, ['user/view', 'id' => $model->user_id]);
			else
				return null;
                }
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
