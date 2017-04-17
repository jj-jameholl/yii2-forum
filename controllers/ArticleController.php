<?php
/**rticle();
        if(isset($_POST["find"])){
            Yii::$app->session->set('q',$_POST["find"]);
        }
        $q = Yii::$app->session->get('q');
        $dataProvider = $model->search($q);
        return $this->render('index',['dataProvider'=>$dataProvider]);
 * Created by PhpStorm.
 * User: zhan
 * Date: 2016/10/30
 * Time: 上午11:13
 */
namespace app\controllers;
use app\models\UserFinder;
use Yii;
use ReflectionClass;
use yii\filters\AccessControl;
use yii\web\IdentityInterface;
use app\models\User;
//use app\models\Article;
use app\models\Note;
use yii\web\Controller;
use app\models\Tags;
use app\models\Customer;
use app\models\Noteupdown;
use yii\base\Event;
use yii\di\Container;
use yii\web\HttpException;
use app\models\Comment;
use yii\web\NotAcceptableHttpException;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

class ArticleController extends Controller{
    public $enableCsrfValidation = false;
    public function behaviors(){
        return [
           // 'access'=>[
              //  'class'=>AccessControl::className(),
              //  'only'=>['index'],
             //   'rules'=>[
               //     'actions' => ['index'],
             //       'allow' => true,
           //         'roles' => ['@'],
         //       ],
       //     ]
		   	'access' => [
            'class' => AccessControl::className(),
            'only' => ['index', 'create'],
            'rules' => [
                // 允许认证用户
                [
                    'allow' => true,
                    'roles' => ['@'],
                ],
                // 默认禁止其他用户
            ],
        ],
        ];
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
    public function actionEmail(){
        $email = Yii::$app->mailer->compose('greet',[
            'title'=> '333',
            'content'=> 'hhhhh',
        ])
            ->setTo('1135560676@qq.com')
            ->setSubject("Love Story")
            ->send();
    }
    public function actionRbac(){
        $auth = Yii::$app->authManager;

//        $rule = new \app\rbac\AuthorRule();
//        $auth->add($rule);
//        $edit_self = $auth->getPermission('edit_self');
//        $edit_self->ruleName = $rule->name;
//        $delete_self = $auth->getPermission('delete_self');
//        $delete_self->ruleName = $rule->name;
//        $auth->add($edit_self);
//        $auth->add($delete_self);
//
//        $auth->removeAll();
//        $edit = $auth->createPermission('edit');
//        $edit->description = "编辑文章";
//        $auth->add($edit);
//
//        $delete = $auth->createPermission('delete');
//        $delete->description = "删除文章";
//        $auth->add($delete);
//
//        $admin = $auth->createRole('admin');
//        $admin->description = '管理员';
//        $auth->add($admin);
//        $auth->addChild($admin,$edit);
//        $auth->addChild($admin,$delete);
//
//        $edit_self = $auth->createPermission('edit_self');
//        $edit_self->description = '编辑自己的文章';
//        $auth->add($edit_self);
//
//        $delete_self = $auth->createPermission('delete_self');
//        $delete_self->description = '删除自己的文章';
//        $auth->add($delete_self);
//
//        $auth->addChild($edit_self,$edit);
//        $auth->addChild($delete_self,$delete);
//
        $author = $auth->getRole('author');
        $author->description = '作者';
        $auth->add($author);
        $edit_self = $auth->getPermission('edit_self');
        $delete_self = $auth->getPermission('delete_self');
        $auth->addChild($author,$delete_self);
        $auth->addChild($author,$edit_self);
//
//        $auth->assign($admin,1);
//        $auth->assign($author,2);
    }


    public function actionCreate(){
	if(isset($_POST['id'])){
	$model = Article::find()->where(['id'=>$_POST['id']])->one();
	$done = 1;
	}else{
        $model = new Article();
	$done = 0;
	}
        if($model->load(Yii::$app->request->post())){
            //$model->last_edit = $model->created = time()+8*3600;
            $model->writer = Yii::$app->user->identity->username;
            $model->user_id = Yii::$app->user->identity->id;
                       foreach(explode(" ",$model->tag) as $key=>$value){
                $tags = new Tags();
                if($tag = $tags::find()->where(['name'=>$value])->one()){
                    if($done == 0) {
                        $tag->times++;
                        $tag->save();
                    }
                }
                else{
                    $tags->name = $value;
                    $tags->times = 1;
                    $tags->save();
                }
            }
		 $model->save();
	return $this->redirect(['article/index']);
        }
        return $this->render('create',['model'=>$model]);
    }
    public function actionIndex(){
//        if(class_exists('Article',false)){
//            echo "33";
//            exit;
//        }else{
//            echo "44";
//            exit;
//        }
//        return $this->render('test');
//        exit;
        //echo Yii::getAlias('@vendor');
        //Yii::setAlias('@photo','@app/photo');

        //echo __DIR__;
 //       exit;
//       Yii::$app->cache->flush();
        //$t = Yii::$app->cache->get('q');
        //$t = Yii::$app->cache->get("q");
        //echo $t;
       // exit;
       // throw new ServerErrorHttpException();
        $model = new Comment;
        $article= new Comment;


        //$transaction = Yii::$app->db->beginTransaction();
//         try{
//             $model->username = 'ssss';
//             $model->user_id = '1';
//             $model->createdTime = '154654654';
//             $model->save();
//             $article->username = 'hhhhh';
//             $article->save();
//             $transaction->commit();
//             echo "22";
//             exit;

//         }catch (Exception $e){
//             $transaction->rollBack();
//             echo "rollback";
//             exit;
//         }

//       Yii::$container->set('Article','app\models\Article');
//       $test = Yii::$container->get('Article');
//        //$reflect=new ReflectionClass($test);
//        //$test = new Article();
//        $test->test1();
//        $test->test2();
        //echo json_encode($reflect->getMethod('test1'));
        //exit;



//        $res = Yii::$app->db->createCommand("call test2(4,1,@s)")->queryOne();
//        //$res = $cmd->queryOne();
//        $s = Yii::$app->db->createCommand("select @s")->queryOne();
//       // $ret = $s->queryOne();
//        echo $res['sum'];
//        echo $s['@s'];
//        exit;



        //redis数据库的使用
  //  $customer = new Customer();
//        $customer->attributes = ['name' => 'test'];
//        $customer->save();
//     $customer = Customer::find()->where(['id' => '1'])->one();
//        echo $customer->article[6]->article;
//  echo $customer->name;
  //      exit;
//        $customer->name = "james";
//        $customer->address = "www";
//        $customer->save();
//        exit;

        //简单with的用法
//        $user = User::find()->with(['article'=> function($query){
//                $query->andWhere(['tag'=>'测试']);
//        }]
//    )->all();
//        $articles = $user[3]->article;
//        foreach ($articles as $article){
//            echo $article->article;
//            echo $article->writer;
//        }
//        exit;

        //joinwith的用法
//$user = User::find()->select('user.*')->leftJoin('article',"article.user_id = user.id")->
//    where(['article.tag'=>'都是'])->with('article')->all();
//
//                $articles = $user[0]->article;
//        foreach ($articles as $article){
//            echo $article->article;
//            echo $article->writer;
//        }
//        exit;
//        $user = User::find()->joinWith('article')->where(['article.tag'=>'测试'])->all();
//        $articles = $user[0]->article;
//        foreach ($articles as $article){
//            echo $article->article;
//        }
//        exit;


//        $file = dirname(__DIR__).'/models/Article.php';
//        include($file);

        $model = new \Article;

//        echo Yii::getAlias('@' . str_replace('\\', '/', 'app\models\Article') . '.php', false);
//        exit;
        $dataProvider = $model->search(null);
        return $this->render('index',['model'=>$model,'dataProvider'=>$dataProvider]);
    }
    public function actionDetail($id){

        Yii::beginProfile('block1');
          $model = new Article;
        //$this->on(Article::EVENT_LET_IN,[$model,'letin'],"cnm");
        //$this->trigger(Article::EVENT_LET_IN);
           $article = Article::find()->where(['id'=>$id])->with('user')->one();
            //$user = User::find()->where(['id'=>$article->user_id])->one();
        Yii::endProfile('block1');
        return $this->render('detail',['article'=>$article]);
    }
 public function actionSearch(){
		        $model = new Article();
        if(isset($_GET["find"])){
            Yii::$app->session->set('q',$_GET["find"]);
        }
        $q = Yii::$app->session->get('q');
        $dataProvider = $model->search($q);
        return $this->render('index',['dataProvider'=>$dataProvider]);  
  }
	    public function actionEdit(){
            $model = new Article();
           // $model->start();
        $model = Article::find()->where(['id'=>$_GET['article_id']])->one();
        return $this->render('create',['model'=>$model,'id'=>$_GET['article_id']]);
    }
    public function actionDelete(){
        $post = Article::find()->where(['id'=>$_GET['article_id']])->one();

//        $this->on(Article::EVENT_LET_IN,[$model,'letin']);
//        $this->trigger(Article::EVENT_LET_IN);
        if(Article::deleteAll(['id'=>$_GET['article_id']])){
            return $this->redirect(['article/index']);
        }
    }
	 public function actionNote(){
        $note = new Note();
        $note->content = $_GET["content"];
        $note->user_id = Yii::$app->user->identity->id;
        $note->createdtime = time();
        if($note->save()){
            echo "1";
        }
        else{
            echo json_encode($note->getErrors());
        }
    }

public function actionThumbup(){
        $note_id = $_GET["note_id"];
        $user_id = $_GET["user_id"];
        $new_noteupdown = new Noteupdown();
        $note = Note::find()->where(['id'=>$note_id])->one();
        $noteupdown = Noteupdown::find()->where(['note_id'=>$note_id,'user_id'=>$user_id])->orderBy('createdtime DESC')->one();
        if($noteupdown){
            if(time()+8*3600-$noteupdown->createdtime > 60){
                $note->up=$note->up+1;
                $note->save();
                $noteupdown->type = 0;
                $noteupdown->createdtime = time()+8*3600;
                if($noteupdown->save()){
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
            $note->up=$note->up+1;
            $note->save();
            $new_noteupdown->type = 0;
            $new_noteupdown->user_id = $user_id;
            $new_noteupdown->note_id = $note_id;
            $new_noteupdown->createdtime = time()+8*3600;
            if($new_noteupdown->save()){
                echo "done";
                exit;
            }else{
                echo $user_id.$note_id;
                exit;
            }
        }
    }
    public function actionThumbdown(){
        $note_id = $_GET["note_id"];
        $user_id = $_GET["user_id"];
        $new_noteupdown = new Noteupdown();
        $note = Note::find()->where(['id'=>$note_id])->one();
        $noteupdown = Noteupdown::find()->where(['note_id'=>$note_id,'user_id'=>$user_id])->orderBy('createdtime DESC')->one();
        if($noteupdown){
            if(time()+8*3600-$noteupdown->createdtime > 60){
                $note->down=$note->down+1;
                $note->save();
                $noteupdown->type = 0;
                $noteupdown->createdtime = time()+8*3600;
                if($noteupdown->save()){
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
            $note->down=$note->down+1;
            $note->save();
            $new_noteupdown->type = 0;
            $new_noteupdown->user_id = $user_id;
            $new_noteupdown->note_id = $note_id;
            $new_noteupdown->createdtime = time()+8*3600;
            if($new_noteupdown->save()){
                echo "done";
                exit;
            }else{
                echo $user_id.$note_id;
                exit;
            }
        }
    }
}
