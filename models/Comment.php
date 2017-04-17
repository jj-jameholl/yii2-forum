<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\di\Container;
use app\models\Note;

/**
 * This is the model class for table "Comment".
 *
 * @property integer $id
 * @property string $username
 * @property string $content
 * @property integer $user_id
 * @property integer $towho
 * @property integer $parent_id
 * @property integer $up
 * @property integer $down
 * @property integer $article_id
 * @property integer $createdTime
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $_note;
    private $test;
//    public function __construct(Note $note)
//    {
//        //parent::__construct($config);
//        $this->_note = $note;
//    }
    public function yy(){
        $this->test ='hh';
        echo $this->test;
    }
    public function hhh(){
        $this->_note->go();
    }
    public static function tableName()
    {
        return 'Comment';
    }
     public function __toString()
     {
         return "this is a object";
         // TODO: Implement __toString() method.
     }
    public function __invoke()
    {
        // TODO: Implement __invoke() method.
    echo "this is auto function";
    }
    public function __call($name,$arguments){
        echo $name.'不让你用!';
    }
    private function fff(){
        return "yes";
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'content', 'user_id', 'createdTime'], 'required','message'=>'{attribute}不能为空!'],
            [['content'], 'string'],
            [['user_id', 'towho', 'parent_id', 'up', 'down', 'article_id', 'createdTime'], 'integer'],
            [['username','tousername'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'content' => '评论',
            'user_id' => 'User ID',
            'towho' => 'Towho',
            'parent_id' => 'Parent ID',
            'up' => 'Up',
            'down' => 'Down',
            'article_id' => 'Article ID',
            'createdTime' => 'Created Time',
            'tousername' => 'To Username',
        ];
    }
    public static function search($id){
        $query = self::find()->where(['article_id'=>$id])->orderBy('id');
        $dataprovider = new ActiveDataProvider([
            'query'=>$query,
            'pagination'=>[
                'pageSize'=>8
            ],
        ]);
        return $dataprovider;
    }
    public static function count($id){
        $count = self::find()->where(['article_id'=>$id])->count();
        return $count;
    }
    public function search_son($id){
        $query = self::find()->where(['parent_id'=>$id])->orderBy('id');
        $dataprovider = new ActiveDataProvider([
            'query'=>$query,
            'pagination'=>[
                'pageSize'=>15
            ],
        ]);
        return $dataprovider;
    }
    public function getImg(){
            $model = User::find()->where(['id'=>$this->user_id])->one();
            return $model->photo;
    }
    public static function findwriterbyid($id){
        $model = self::find()->where(['id'=>$id])->one();
        return $model->user_id;
    }
    public function send_email($username,$email)
    {
        $info = [$username,$email];
       $this->on(self::EVENT_BEFORE_INSERT,[$this,'send'],$info);
    }
    public function send($event){
        $res = Yii::$app->mailer->compose('greet', [
            'html' => 'html',
            'title' => '文章回复',
           'content' => $event->data[0],
        ])
            ->setTo($event->data[1])
            ->setSubject("Love Story")
            ->send();
    }
}

