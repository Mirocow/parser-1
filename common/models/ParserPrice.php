<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "parser_price".
 *
 * @property integer $id
 * @property string $price
 */
class ParserPrice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'parser_price';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['price'], 'required'],
            [['price'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'price' => Yii::t('app', 'Price'),
        ];
    }

    /**
     * @inheritdoc
     * @return ParserPriceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ParserPriceQuery(get_called_class());
    }
}
