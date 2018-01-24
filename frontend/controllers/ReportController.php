<?php

namespace frontend\controllers;

use common\models\Department;
use common\models\Plan;
use common\models\Faculty;
use common\models\Teacher;
use yii\data\ActiveDataProvider;

class ReportController extends \yii\web\Controller
{
    public function actionDepartment($id)
    {
	$model = Department::findOne($id);
	$plansDataProvider = new ActiveDataProvider([
		'query' => $model->getPlans(),
	]);
	$teachersDataProvider = new ActiveDataProvider([
		'query' => $model->getTeachers(),
	]);
	$lostPrograms = new ActiveDataProvider([
		'query' => $model->getPrograms()->where(['teacher_id' => null]),
		'pagination' => false,
	]);

	return $this->render('department', compact('model', 'plansDataProvider', 'teachersDataProvider', 'lostPrograms'));
    }

    public function actionPlan($id)
    {
        if (($model = Plan::findOne($id)) !== null) {
	        return $this->render('plan', compact('model'));
        }
        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionTeacher($id)
    {
        if (($model = Teacher::findOne($id)) !== null) {
        	return $this->render('teacher', compact('model'));
        }
        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionFaculty($id)
    {
        if (($model = Faculty::findOne($id)) !== null) {
		return $this->render('faculty', compact('model'));
        }
        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));

    }

    /**
     * Finds the Faculty model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Faculty the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Faculty::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
