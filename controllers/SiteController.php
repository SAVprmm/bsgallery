<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use app\models\GalleryAddForm;
use app\models\UploadForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('gallery-view');
    }
    
    /**
     * Displays Gallery Add page/form
     *
     * @return void
     */
    public function actionGalleryAdd()
    {
        $model = new GalleryAddForm();

        $status = array( 'none' => true );

        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post())) {
            for($f = 0; $f < 5; $f++) {
                $myFile = 'imageFile'.$f;
                $model->$myFile = UploadedFile::getInstance($model, 'imageFile'.$f);
            }
            $status = $model->uploadImage();
            if (!$status['error']) {
                // file is uploaded successfully
                //print_r($status);
                //return;
            }
        }

        return $this->render('gallery-add', ['model' => $model, 'uploadStatus' => $status]);
    }
}
