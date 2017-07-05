<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ParserSites */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="parser-sites-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'price_tag')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'price_new_tag')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'tag_active')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'tag_inactive')->textInput(['maxlength' => true]) ?>


    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
