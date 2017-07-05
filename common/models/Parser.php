<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "parser".
 *
 * @property integer $id
 * @property string $product_name
 * @property string $product_sku
 * @property string $site_name
 * @property string $price
 * @property string $price_old
 * @property integer $available
 * @property string $error_code
 * @property string $error_text
 */
class Parser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'parser';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
//            [['product_name', 'product_sku', 'site_name', 'price', 'price_old', 'available', 'error_code', 'error_text'], 'required'],
            [['price', 'price_old'], 'number'],
            [['available'], 'integer'],
            [['product_name', 'site_name', 'error_code', 'error_text'], 'string', 'max' => 255],
            [['product_sku'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'product_name' => Yii::t('app', 'Product Name'),
            'product_sku' => Yii::t('app', 'Product Sku'),
            'site_name' => Yii::t('app', 'Site Name'),
            'price' => Yii::t('app', 'Price'),
            'price_old' => Yii::t('app', 'Price Old'),
            'available' => Yii::t('app', 'Available'),
            'error_code' => Yii::t('app', 'Error Code'),
            'error_text' => Yii::t('app', 'Error Text'),
        ];
    }

    /**
     * @inheritdoc
     * @return ParserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ParserQuery(get_called_class());
    }
}
