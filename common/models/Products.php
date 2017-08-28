<?php

namespace common\models;


use Yii;
use yii\web\UploadedFile;
use yii\db\ActiveRecord;



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
 * @property Products $file
 */
class Products extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $file;
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
            [['file'], 'file', 'skipOnEmpty' => false,],
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
     * @inheritdoc
     * @return ProductsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductsQuery(get_called_class());
    }
}
