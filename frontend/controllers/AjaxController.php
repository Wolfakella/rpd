<?php

namespace frontend\controllers;

use Yii;
use backend\models\UploadPlan;
use common\models\Plan;
use common\models\Program;
use common\models\Teacher;
use common\models\AjaxQuery;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;

class AjaxController extends Controller
{

    /**
     * Updates an existing Plan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['report/faculty', 'id' => $model->department->faculty_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Displays a single Plan model.
     * @param integer $id
     * @return mixed
     */
    public function actionTest()
    {
	$ajax = new AjaxQuery();
        return $this->render('_form', [
            'model' => $ajax,
        ]);
    }

	public function actionData()
	{	
		$query = Yii::$app->request->get('query');
		$programs = Teacher::find()
			->select(['data'=>'id', 'value'=>'CONCAT_WS(\' \', lastname, firstname, middlename)'])
			->where(['like', 'lastname', $query])
			->orWhere(['like', 'firstname', $query])
			->orWhere(['like', 'middlename', $query])
			->asArray()->all();
		$response['query'] = $query;
		$response['suggestions'] = $programs;
		return Json::encode($response);
	}

	public function actionProcess()
	{
		$teacher_id = Yii::$app->request->get('teacher_id');
		$program_id = Yii::$app->request->get('program_id');

		$program = $this->findModel($program_id);
		$program->teacher_id = $teacher_id;
		if($program->validate() && $program->save())
			return Html::a(Teacher::findOne($teacher_id)->credentials, ['report/teacher', 'id'=>$teacher_id]);
		else
			return 'Database error!';	
	}


    /**
     * Finds the Plan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Plan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Program::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException("Cannot find program # $id");
    }
}
