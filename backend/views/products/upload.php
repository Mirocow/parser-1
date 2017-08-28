
<?php
use yii\widgets\ActiveForm;
use kartik\widgets\FileInput;
use kartik\widgets\Alert;
use yii\helpers\html;
use yii\helpers\url;

?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

<?php
echo $form->field($model, 'file')->widget(FileInput::classname(),[
    'options'=>['accept'=>'text/*'],
    'pluginOptions'=>['allowedFileExtensions'=>['csv']]]);
?>

<?php ActiveForm::end() ?>

<?= Html::a('Скачать текущий прайс', ['../backend/web/uploads/' . 'price.csv'], ['class'=>'btn btn-primary', 'style' => 'float:right']) ?>
