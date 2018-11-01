<?php
/**
 * Created by PhpStorm.
 * User: XYQ
 * Date: 2017/6/29
 * Time: 18:05
 */

namespace manage\controllers;

use common\extensions\Helper;
use Yii;
use yii\base\Action;
use yii\web\Controller;


class BaseController extends Controller
{
    /**
     * @name init
     * @author fch
     */
    public function init()
    {
        if (!(Yii::$app->session->get('account'))) {
            die(json_encode(Helper::msg('-1', '登录失效')));
        }
    }

    /**
     * @name beforeAction
     * @author fch
     * @param Action $action
     * @return bool
     */
    public function beforeAction($action)
    {
        return parent::beforeAction($action);
    }


}