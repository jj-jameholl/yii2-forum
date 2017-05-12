<?php
/**
 * Created by PhpStorm.
 * User: zhan
 * Date: 2017/2/11
 * Time: 下午1:01
 */
namespace app\controllers;
use Yii;
use yii\web\Controller;

class RbacController extends Controller{
    public function actionInit(){
        $auth = Yii::$app->authManager;
        $detail = $auth->createPermission('detail');
        $detail->description = 'look the detail';
        $auth->add($detail);

        $delete = $auth->createPermission('delete');
        $delete->description = 'delete the article';
        $auth->add($delete);

        $admin = $auth->createRole('admin');
        $auth->add($admin);

        $auth->addChild($admin,$detail);
        $auth->addChild($admin,$delete);

        $auth->assign($admin,1);
    }
}


