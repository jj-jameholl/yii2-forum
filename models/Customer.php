<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "City".
 *
 * @property integer $id
 * @property integer $pid
 * @property string $name
 */
class Customer extends \yii\redis\ActiveRecord
{
    /**
     * @inheritdoc
     */
public function attributes(){
    return ['id','name','address'];
}
public function getArticle(){
    return $this->hasMany(Article::className(),['user_id'=>'id']);
}
    public static function active($query)
    {
        $query->andWhere(['status' => 1]);
    }
}
