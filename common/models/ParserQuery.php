<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Parser]].
 *
 * @see Parser
 */
class ParserQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Parser[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Parser|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
