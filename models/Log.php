<?php
/**
 * Created by PhpStorm.
 * User: zhan
 * Date: 2017/5/10
 * Time: 上午7:56
 */
namespace app\models;

use yii;
//use yii\base\Object;

class Log extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'Log'; // TODO: Change the autogenerated stub
    }

    public function rules()
    {
        return [
            [['from_uid','created_time'],'required'],
            [['from_uid','to_uid','article_id','comment_id','created_time'],'integer'],
            [['content'],'string'],
        ]; // TODO: Change the autogenerated stub
    }
    public function goit($from,$to=null,$article_id=null,$comment_id=null,$created_time,$content){
        $this->from_uid = $from;
        $this->to_uid = $to;
        $this->article_id = $article_id;
        $this->comment_id = $comment_id;
        $this->created_time = $created_time;
        $this->content = $content;
        return $this->save();
    }
    public function hello($name){
        echo "hello world".$name;
        exit;
    }
}
