<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ParserSites */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Parser Sites',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Parser Sites'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parser-sites-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
