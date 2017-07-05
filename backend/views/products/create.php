<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Products */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Products',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
