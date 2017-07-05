<?php

namespace backend\models\query;

/**
 * This is the ActiveQuery class for [[\backend\models\Sites]].
 *
 * @see \backend\models\Sites
 */
class ParserSitesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \backend\models\Sites[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \backend\models\Sites|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
