<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm; // or yii\widgets\ActiveForm
use kartik\widgets\FileInput;
use yii\helpers\Url;
use kartik\dynagrid\DynaGrid;
use yii\web\View;
use dosamigos\fileupload\FileUpload;
use yii\helpers\FileHelper;




// or 'use kartik\file\FileInput' if you have only installed
// yii2-widget-fileinput in isolation


/* @var $this yii\web\View */
/* @var $searchModel common\models\ProductsSearch */
/* @var $model common\models\Products */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Products');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-index">


    <p>
        <?php echo Html::a(Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Products',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

<!--    --><?php //echo GridView::widget([
//        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
//        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
//
////            'id',
//            'name',
//            'sku',
//            'site_id',
//            'url:url',
//
//            ['class' => 'yii\grid\ActionColumn'],
//        ],
//    ]);
    $columns =
        [
            ['class'=>'kartik\grid\SerialColumn', 'order'=>DynaGrid::ORDER_FIX_LEFT],
            [
                'attribute'=>'name',
                'vAlign'=>'middle',
                'order'=>DynaGrid::ORDER_FIX_LEFT
            ],
            [
                'attribute'=>'sku',
                'vAlign'=>'middle',
                'format'=>'raw',
                'noWrap'=>true
            ],
            [
                'attribute'=>'site_id',
//                'visible'=>false,
            ],
            [
                'attribute'=>'url',
                'format'=>'url',
                'vAlign'=>'middle',
            ]
//
    ];
    $dynagrid = DynaGrid::begin([
        'columns' => $columns,
        'theme'=>'panel-info',
        'showPersonalize'=>true,
        'storage' => 'session',
        'gridOptions'=>[
            'dataProvider'=>$dataProvider,
            'filterModel'=>$searchModel,
            'showPageSummary'=>true,
            'floatHeader'=>true,
            'pjax'=>true,
            'responsiveWrap'=>false,
            'panel'=>[
                'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>Товары</h3>',
                'after' => false
            ],
            'toolbar' =>  [
                ['content'=>'{dynagridFilter}{dynagridSort}{dynagrid}'],
                '{export}',
            ]
        ],
        'options'=>['id'=>'dynagrid-1'] // a unique identifier is important
    ]);
    if (substr($dynagrid->theme, 0, 6) == 'simple') {
        $dynagrid->gridOptions['panel'] = false;
    }
    DynaGrid::end();

    ?>

</div>
