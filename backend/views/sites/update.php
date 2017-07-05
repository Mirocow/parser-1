<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ParserSites */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'Parser Sites',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Parser Sites'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="parser-sites-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
