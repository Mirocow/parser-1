<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[ParserSites]].
 *
 * @see ParserSites
 */
class ParserSitesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return ParserSites[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ParserSites|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
