<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use kartik\dynagrid\DynaGrid;
use yii\helpers\ArrayHelper;
use common\models\Parser;




/* @var $this yii\web\View */
/* @var $searchModel common\models\ParserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Parsers');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parser-index">

    <?php

    $columns =
        [
            ['class'=>'kartik\grid\SerialColumn', 'order'=>DynaGrid::ORDER_FIX_LEFT],
            [
                'attribute'=>'product_name',
//                'filterType'=>GridView::FILTER_SELECT2,
//                'filter'=>ArrayHelper::map(Parser::find()->orderBy('product_name')->asArray()->all(), 'id', 'product_name'),

                'vAlign'=>'middle',
                'order'=>DynaGrid::ORDER_FIX_LEFT
            ],
            [
                'attribute'=>'product_sku',
//                'filterType'=>GridView::FILTER_SELECT2,
//                'filter'=>ArrayHelper::map(Parser::find()->orderBy('product_sku')->asArray()->all(), 'id', 'product_sku'),

                'vAlign'=>'middle',
                'format'=>'raw',
//                'width'=>'150px',
                'noWrap'=>true
            ],
            [
                'attribute'=>'site_name',
//                'filterType'=>GridView::FILTER_SELECT2,
//                'filter'=>ArrayHelper::map(Parser::find()->orderBy('site_name')->asArray()->all(), 'id', 'site_name'),
//                'filterInputOptions'=>['placeholder'=>'Все сайты'],
//                'format'=>'raw',
//                'width'=>'170px',
//                'visible'=>false,
            ],
            [
                'attribute'=>'price',
                'vAlign'=>'middle',
                'format'=>['decimal', 2],
//                'width'=>'250px',
//                'filterInputOptions'=>['placeholder'=>'Any author'],
            ],
            [
                'attribute'=>'price_old',
                'vAlign'=>'middle',
                'format'=>['decimal', 2],
            ],
            [
//                'class'=>'kartik\grid\BooleanColumn',
                'attribute'=>'available',
                'vAlign'=>'middle',
            ],
//            [
//                'class'=>'kartik\grid\ActionColumn',
//                'dropdown'=>false,
//                'urlCreator'=>function($action, $model, $key, $index) { return '#'; },
//                'viewOptions'=>['title'=>$viewMsg, 'data-toggle'=>'tooltip'],
//                'updateOptions'=>['title'=>$updateMsg, 'data-toggle'=>'tooltip'],
//                'deleteOptions'=>['title'=>$deleteMsg, 'data-toggle'=>'tooltip'],
//                'order'=>DynaGrid::ORDER_FIX_RIGHT
//            ],
//            ['class'=>'kartik\grid\CheckboxColumn', 'order'=>DynaGrid::ORDER_FIX_RIGHT],
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
                'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>Парсер</h3>',
//                'before' =>  '<div style="padding-top: 7px;"><em>* The table header sticks to the top in this demo as you scroll</em></div>',
                'after' => false
            ],
            'toolbar' =>  [
//                ['content'=>
//                    Html::button('<i class="glyphicon glyphicon-plus"></i>', ['type'=>'button', 'title'=>'Add Book', 'class'=>'btn btn-success', 'onclick'=>'alert("This will launch the book creation form.\n\nDisabled for this demo!");']) . ' '.
//                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['dynagrid-demo'], ['data-pjax'=>0, 'class' => 'btn btn-default', 'title'=>'Reset Grid'])
//                ],
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

