<?php

namespace backend\controllers;

use Yii;
use yii\helpers\VarDumper;
use common\models\Plan;
use common\models\PlanSearch;
use common\models\Program;
use backend\models\UploadPlan;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PlanController implements the CRUD actions for Plan model.
 */
class PlanController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Plan models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PlanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Plan model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Plan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Plan();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
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
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Plan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

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
