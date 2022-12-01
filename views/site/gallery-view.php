<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use app\models\ArGallery;
use yii\data\ActiveDataProvider;

?>
<?php
$this->title = 'View images';


$arg = new ArGallery();

$provider = new ArrayDataProvider([
	'allModels' => $arg::find()->asArray()->all(),
	'pagination' => [
		'pageSize' => 10,
	],
	'sort' => [
		'attributes' => ['image', 'alt', 'file_date', 'create_at'],
	],
]);

echo GridView::widget([
	'dataProvider' => $provider,
	
	'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
         //'id', 
         'image',
		 'alt',
		 'file_date',
		 'create_at',
        ['class' => 'yii\grid\ActionColumn',
            'buttons' => [
                'view_icon' => function ($url, $model, $key) {
                    return Html::a ( '<span class="bsgallery"><span class="preview"><div style="background-image: url(\''.Yii::$app->params['galleryFolder'].Yii::$app->params['tumblFolder'].'100x100_'.$model['image'].'\')"></div></span></span>', '@web/maingallery/'.$model['image'], ['target' => '_new'] );
                },
            ],
            'template' => '{view_icon}'


        ],
    ],
]);

?>