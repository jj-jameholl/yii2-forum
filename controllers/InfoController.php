<?php
/**
 * Created by PhpStorm.
 * User: zhan
 * Date: 2016/11/19
 * Time: 下午11:04
 */
namespace app\controllers;
use app\models\Upload;
use yii;
use app\models\User;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\AccessControl;
use app\models\Log;

class InfoController extends Controller{
    public $enableCsrfValidation = false;

    public function actions()
    {
        return [
            'crop'=>[
                'class' => 'hyii2\avatar\CropAction',
                'config'=>[
                    'bigImageWidth' => '200',     //大图默认宽度
                    'bigImageHeight' => '200',    //大图默认高度
                    'middleImageWidth'=> '100',   //中图默认宽度
                    'middleImageHeight'=> '100',  //中图图默认高度
                    'smallImageWidth' => '50',    //小图默认宽度
                    'smallImageHeight' => '50',   //小图默认高度

                    //头像上传目录（注：目录前不能加"/"）
                    'uploadPath' => 'uploads/avatar/',
                ]
            ]
        ];

    }
public function actionIndex(){
    $upload = new Upload;
    $user = User::find()->where(['id'=>Yii::$app->user->identity->id])->one();
//    print_r($user->log);
//    exit;
    return $this->render('index',['user'=>$user,'file'=>$upload]);
}
public function actionLook($id){
    if(Yii::$app->request->isAjax){
        $user = User::findOne(['id'=>$id]);
        return $this->renderAjax('/site/_profile',['user'=>$user]);
    }
    $user = User::find()->where(['id'=>$id])->one();
    return $this->render('index',['user'=>$user]);
}
 public function actionEdit(){
//        $model = new User();
        $model = User::find()->where(['id'=>$_GET['user_id']])->one();
        if($model->load(Yii::$app->request->post())){
		if($model->newpass !=null){
            $saltpass = md5(time());
            $model->saltpass = $saltpass;
            $model->password = md5($model->newpass.$saltpass);
            $model->newpass = $model->repass = '';
		}
		if($model->save()){
                return $this->redirect(['/info/index']);
            }
            else{
                echo json_encode($model->getErrors());
            }
        }
    }
 public function actionCreate(){
     $model =new User();
     if($model->load(Yii::$app->request->post())) {
         $model->authKey = md5(time());
         $model->saltpass = md5(time());
         $model->password = md5($model->newpass.$model->saltpass);
         $model->newpass = $model->repass = '';
         if ($model->save()){
             $res = Yii::$app->mailer->compose('greet', [
                     'html' => 'html',
                     'title' => '文章回复',
                     'content' => '账户已创建,请登录网站使用!'
                 ]
             )->setTo($model->email)
                 ->setSubject("Love Story")
                 ->send();
             return $this->redirect(['/info/index']);
         }else{
             echo $model->username;
         }

     }
 }
 public function actionDownload(){
    // return Yii::warning("something wrong");
     //return \Yii::$app->response->sendFile('../User.sql');
//     \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
//     return [
//         'message' => 'hello world',
//         'code' => 100,
//     ];
 }
 public function actionUpload(){
     $upload = new Upload;
     $path = 'uploads/video/';
//     echo ini_get('post_max_size');
//     echo ini_get('upload_max_filesize');
//     exit;
     if(Yii::$app->request->isPost){
         $upload->file = yii\web\UploadedFile::getInstance($upload,'file');
         if(file_exists($path)){
             //echo $path.$upload->file->baseName.$upload->file->extension;
            // print_r($_FILES['file']['type']);
            // print_r($_POST['file']);

             //exit;
             $upload->file->saveAs($path.$upload->file->baseName.'.'.$upload->file->extension);
         }else{
             mkdir($path);
             $upload->file->saveAs($path.$upload->file->baseName.$upload->file->extension);
         }
//         exit;
     }
 }
}
