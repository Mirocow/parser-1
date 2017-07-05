<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "parser_products".
 *
 * @property integer $id
 * @property string $name
 * @property string $sku
 * @property string $site_id
 * @property string $url
 *
 * @property Parser $id0
 * @property Sites $site
 */
class Products extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'parser_products';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'sku', 'site_id', 'url'], 'required'],
            [['id'], 'integer'],
            [['name', 'url', 'site_id'], 'string', 'max' => 255],
            [['sku'], 'string', 'max' => 64],
//            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => Parser::className(), 'targetAttribute' => ['id' => 'product_id']],
//            [['site_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sites::className(), 'targetAttribute' => ['site_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'sku' => Yii::t('app', 'Sku'),
            'site_id' => Yii::t('app', 'Site ID'),
            'url' => Yii::t('app', 'Url'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
//    public function getId0()
//    {
//        return $this->hasOne(Parser::className(), ['product_id' => 'id']);
//    }
//
//    /**
//     * @return \yii\db\ActiveQuery
//     */
//    public function getSite()
//    {
//        return $this->hasOne(ParserSites::className(), ['id' => 'site_id']);
//    }

    /**
     * @inheritdoc
     * @return ProductsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductsQuery(get_called_class());
    }
}
