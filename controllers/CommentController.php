<?php
/**
 * Created by PhpStorm.
 * User: zhan
 * Date: 2016/11/9
 * Time: 下午11:24
 */
namespace app\controllers;
use app\models\Article;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\models\Comment;
use app\models\Updown;
use app\models\User;
use app\models\Log;
use yii\base\Exception;
use yii\web\NotFoundHttpException;

error_reporting (E_ALL & ~E_NOTICE);
class CommentController extends Controller{
public $enableCsrfValidation = false;   
 public function behaviors()
    {
        return[];
    }
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    public function actionCreate(){
        $model = new Comment();
        $log = new Log();
        //$article= new Comment();
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $model->load(Yii::$app->request->post());
            $model->username = Yii::$app->user->identity->username;
            $model->user_id = $log->from_uid = Yii::$app->user->identity->id;
            $model->article_id = $log->article_id = $_GET['id'];
            $log->to_uid = $_GET['author'];
            $log->content = $model->content;
            $email = User::findemailbyid($_GET['author']);
            $model->createdTime = $log->created_time = time() + 8 * 3600;
        //$log->goit($model->user_id,$_GET['author'],$model->article_id,'',$model->createdTime,$model->content);
//        if($log->goit($model->user_id,$_GET['author'],$model->article_id,'',$model->createdTime,$model->content)) {
//            return $this->renderAjax('/comment/content', ['model' => $model, 'id' => $model->article_id]);
//        }else{
//            echo "wrong";
//            exit;
//        }
        //$log->hello(1);
//            $t = $log->goit($model->user_id,$_GET['author'],$model->article_id,'',$model->createdTime,$model->content);
//            if($log->save()){
//                echo "yes";
//            }else{
//                echo json_encode($log->errors);
//            }
//            exit;
            $model->send_email($model->username, $email);
            if($model->save()&&$log->goit($model->user_id,$_GET['author'],$model->article_id,'',$model->createdTime,$model->content)) {
                $transaction->commit();
            }else{
//                Yii::error("it is wrong!");
                //throw new NotFoundHttpException();
            }
                return $this->renderAjax('/comment/content', ['model' => $model, 'id' => $model->article_id]);
        } catch (Exception $e){
            //echo json_encode($e);
            //exit;
            $transaction->rollBack();
            echo "fff";
            exit;
            return $this->render('error', ['exception' => $e]);
            //Yii::error("it is wrong!");
            //throw new NotFoundHttpException();
        } catch(\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }
    }
    public function actionCreateson(){

        $model = new Comment();
        $log = new Log();
 //       $model->load(Yii::$app->request->post());
	   $model->content = $_GET['content'];
        $model->username = Yii::$app->user->identity->username;
        $model->user_id = Yii::$app->user->identity->id;
//        $model->parent_id = $_POST['id'];
        $model->parent_id = $_GET['id'];
        if(isset($_GET['towho'])){
            $model->towho = $_GET['towho'];
        }
        $to_uid = isset($_GET['towho'])?$_GET['towho']:$model->parent_id;
        $model->createdTime = time()+8*3600;
        //$t = $log->goit($model->user_id,$to_uid,' ',$model->parent_id,$model->createdTime,$model->content);
        if($model->save()&&$log->goit($model->user_id,$to_uid,$_GET['article_id'],$model->parent_id,$model->createdTime,$model->content)){
              //  echo "1232";
//            return $this->renderAjax('/comment/_content',['model'=>$model]);
//            return $this->renderAjax('commentlist',['id'=>$_GET['article_id']]);
            echo "1";

        }
        else{
            print_r($model);
        }
    }

       public function actionThumbup(){
        $comment_id = $_GET["comment_id"];
        $user_id = $_GET["user_id"];
        $new_updown = new Updown();
        $comment = Comment::find()->where(['id'=>$comment_id])->one();
        $updown = Updown::find()->where(['comment_id'=>$comment_id,'user_id'=>$user_id])->orderBy('createdtime DESC')->one();
        if($updown){
            if(time()+8*3600-$updown->createdtime > 60){
                $comment->up=$comment->up+1;
                $comment->save();
                $updown->type = 0;
                $updown->createdtime = time()+8*3600;
                if($updown->save()){
                    echo "done";
                    exit;
                }else{
                    echo "wrong";
                    exit;
                }
            }else{
                echo "short";
                exit;
            }

        }else {
            $comment->up=$comment->up+1;
            $comment->save();
            $new_updown->type = 0;
            $new_updown->user_id = $user_id;
            $new_updown->comment_id = $comment_id;
            $new_updown->createdtime = time()+8*3600;
            if($new_updown->save()){
                echo "done";
                exit;
            }else{
                echo $comment_id;
                exit;
            }
        }
    }
    public function actionThumbdown(){
        $comment_id = $_GET["comment_id"];
        $user_id = $_GET["user_id"];
        $new_updown = new Updown();
        $comment = Comment::find()->where(['id'=>$comment_id])->one();
        $updown = Updown::find()->where(['comment_id'=>$comment_id,'user_id'=>$user_id])->orderBy('createdtime DESC')->one();
        if($updown){
            if(time()+8*3600-$updown->createdtime > 60){
                $comment->down=$comment->down+1;
                $comment->save();
                $updown->type = 1;
                $updown->createdtime = time()+8*3600;
                if($updown->save()){
                    echo "done";
                    exit;
                }else{
                    echo "wrong";
                    exit;
                }
            }else{
                echo "short"    ;
                exit;
            }

        }else {
            $comment->down=$comment->down+1;
            $comment->save();
            $new_updown->type = 0;
            $new_updown->user_id = $user_id;
            $new_updown->comment_id = $comment_id;
            $new_updown->createdtime = time()+8*3600;
            if($new_updown->save()){
                echo "done";
                exit;
            }else{
                echo $user_id.$comment_id;
                exit;
            }
        }
    }
}

