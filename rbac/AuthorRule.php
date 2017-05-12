<?php
/**
 * Created by PhpStorm.
 * User: zhan
 * Date: 2017/2/11
 * Time: 下午3:11
 */
namespace app\rbac;
use yii\rbac\Rule;

class AuthorRule extends Rule{
    public $name = 'isAuthor';

    /**
     * @param string|integer $user the user ID.
     * @param Item $item the role or permission that this rule is associated with
     * @param array $params parameters passed to ManagerInterface::checkAccess().
     * @return boolean a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user, $item, $params)
    {
        return isset($params['post']) ? $params['post']->user_id == $user : false;
    }
}


