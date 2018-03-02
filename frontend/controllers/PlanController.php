<?php

namespace frontend\controllers;

use Yii;
use backend\models\UploadPlan;
use common\models\Plan;
use common\models\Program;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;

class PlanController extends Controller
{
	public function actionUpload()
	{
		$uploadPlan = new UploadPlan();
		if (Yii::$app->request->isPost) {
			$uploadPlan->department_id = Yii::$app->request->post('UploadPlan')['department_id'];
			$uploadPlan->uploadedFile = UploadedFile::getInstance($uploadPlan, 'uploadedFile');

			if ($uploadPlan->upload()) {
				$model = new Plan($uploadPlan->department_id, $uploadPlan->getFilePath());

				if($model->save())
				{
					$transaction = Plan::getDb()->beginTransaction();
					for($i = 0; $i < $model->programCount; $i++)
					{					
						$program = new Program($model->link, $i);
						$program->plan_id = $model->id;
						if(!$program->validate('departmen_id')) $program->department_id = NULL;
						if(!$program->save())
						{
							$transaction->rollBack();
							$model->delete();
							print_r($program);
							return $this->render(
								'@app/views/site/error', 
								['message' => 'Database insertion error: Program #'. $i]
							);					
						}
					}
					$transaction->commit();
					return $this->redirect(['update', 'id' => $model->id]);        		
				} else
					return $this->render(
						'@app/views/site/error', 
						['message' => 'Database insertion error: '.$model->errors]
					);
			} else 
				return $this->render(
					'@app/views/site/error', 
					['message' => 'File upload error: '.$uploadPlan->uploadedFile->error]
				);
		} else
			return $this->render('upload', [
				'model' => $uploadPlan,
			]);

	}

    public function actionHours($id, $program)
    {
    	$model = $this->findModel($id);
    	
    	$subject = new Program($model->link, $program);
    	return $this->render('program', ['model' => $model, 'subject'=>$subject]);
    }

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
    public function actionView($id)
    {
	$model = $this->findModel($id);
	$programs = new ActiveDataProvider([
		'query' => $model->getPrograms(),
		'pagination' => false,
	]);
        return $this->render('view', compact(['model', 'programs']));
    }

    /**
     * Deletes an existing Plan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
	$facultyID = $model->department->faculty_id;
	$model->delete();

        return $this->redirect(['report/faculty', 'id'=>$facultyID]);
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
        if (($model = Plan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
