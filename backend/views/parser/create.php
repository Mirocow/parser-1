<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Parser */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Parser',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Parsers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parser-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
