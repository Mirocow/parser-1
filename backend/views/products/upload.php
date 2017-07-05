<?php

use yii\helpers\Html;
use yii\helpers\Url;


use yii\widgets\ActiveForm; // or yii\widgets\ActiveForm
use kartik\widgets\FileInput;
// or 'use kartik\file\FileInput' if you have only installed
// yii2-widget-fileinput in isolation
?>

<?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>
<?php echo $form->field($model, 'file')->fileInput(); ?>
<div class="form-group">
    <?php echo Html::submitButton('Отправить') ?>
</div>

<?php //echo FileInput::widget([
//    'name' => 'file',
//    'options'=>[
//        'multiple'=>false
//    ],
//    'pluginOptions' => [
//        'uploadUrl' => Url::to(['uploads/' . 'price.csv']),
//    ]
//]); ?>


<?php ActiveForm::end(); ?>


