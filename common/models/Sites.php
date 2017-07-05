<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "parser_sites".
 *
 * @property integer $id
 * @property string $name
 * @property string $price_tag
 * @property string $price_new_tag
 * @property string $url
 * @property string $tag_inactive
 * @property string $tag_active
 */
class Sites extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'parser_sites';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'price_tag'], 'required'],
            [['name', 'price_tag', 'price_new_tag', 'tag_active', 'tag_inactive'], 'string', 'max' => 255],
            [['url'], 'string', 'max' => 500],
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
            'price_tag' => Yii::t('app', 'Price Tag'),
            'price_new_tag' => Yii::t('app', 'Price New Tag'),
            'url' => Yii::t('app', 'Url'),
            'tag_active' => Yii::t('app', 'Active tag'),
            'tag_inactive' => Yii::t('app', 'Inactive tag'),
        ];
    }

    /**
     * @inheritdoc
     * @return \backend\models\query\ParserSitesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \backend\models\query\ParserSitesQuery(get_called_class());
    }
}
