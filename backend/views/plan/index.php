<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\PlanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Plans');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plan-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Plan'), ['create'], ['class' => 'btn btn-success']) ?>
	<?= Html::a(Yii::t('app', 'Upload Plan'), ['upload'], ['class' => 'btn btn-warning']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'code',
            'title',
            'profile',
            'type',
            //'link',
            [
                'attribute' => 'Department ID',
                'format' => 'html',
                'value' => function ($model, $key, $index, $column){
                    return Html::a($model->department->name, ['department/view', 'id' => $model->department_id]);
                }
            ],
            'year',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
