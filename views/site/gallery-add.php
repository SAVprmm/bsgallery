<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;

?>
<?php
$this->title = 'Add images';

if(isset($uploadStatus, $uploadStatus['error'])){
    if($uploadStatus['error'] === true) {
        //display uploading error
        echo Html::tag('div', 'Error uploading one or more images', ['class' => 'msg_box error_msg']);
    } else {
        $data = array();
        
        //preparing success message 
        foreach($uploadStatus['files'] as $index => $status) {
            $data[] = array(
                //'id' => $index,
                'file name' => $status['name'],
                'storage' => ($status['save'] ? '✓': 'x'),
                'bd' => $status['insert'] ? '✓': 'x'
            );
        }
        
        //preparing Array as Provider 
        $provider = new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
            'attributes' => [/*'id', 'name', 'save', 'insert'*/],
            ],
        ]);
        
        //build Array Provider as Grid
        $grid = GridView::widget([
            'dataProvider' => $provider,
            'summary' => ''
        ]);

        //display
        echo Html::tag('div', 'Images was uploaded' . $grid, ['class' => 'msg_box ok_msg']);
        unset($grid, $provider, $data, $uploadStatus);
    } 
}
?>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'class' => 'form-uf']]) ?>
<?php
    //build input files and hidden 
    foreach([['Add an image'],['Add another image'],['Add another image'],['Add another image'],['Add last image']] as $fileId => $file) {
        echo $form->field($model, 'imageFile'.$fileId, ['options' => ['class' => 'form-group form_file_box']])
            ->fileInput(['multiple' => false, 'accept' => 'image/*', 'onchange' => 'ffinfo(\'galleryaddform-imagefile'.$fileId.'\');'])
            ->label($file[0]);

        echo $form->field($model, 'imageFile'.$fileId.'lastModify')
            ->hiddenInput([])
            ->label(false);
    }
?>
<div class="doadd">
    <button class="aao" type="button" onclick="return false;">+Add another one</button> <button type="submit" class="s">Submit</button>
    <div class="clear"><div>
<div>

<?php ActiveForm::end() ?>
<?php
//JavaScript/jQuery
////for working +button
////function for reading lastModified on client side in browser
$script = <<< JS
    $('.form_file_box').each(function(index, value){
        if(index != 0) {
            $(this).hide();
        }
    });
    $('.doadd > .aao').click(function(){
        $('.form_file_box').each(function(index, value){
            if($(this).css('display') == 'none') {
                $(this).show();
                return false;
            }
            if(index == 3) {
                $('.doadd > .aao').css('visibility', 'hidden');
            }
    });
    });

    ffinfo = function(_id) {
        var el = document.getElementById(_id).files[0];
        if(el != null && el.lastModified != undefined) {
            d = new Date(el.lastModified);
            el = document.getElementById(_id+'lastmodify');
            if(el != null) {
                el.value = d.toISOString();
            }
        }
    }
JS;
$this->registerJs($script);
?>