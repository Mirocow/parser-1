<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Parser */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="parser-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->field($model, 'product_name')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'product_sku')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'site_name')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'price_old')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'available')->textInput() ?>

    <?php echo $form->field($model, 'error_code')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'error_text')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
