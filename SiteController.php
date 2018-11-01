<?php
namespace manage\controllers;

use manage\modules\setting\services\PayService;
use Yii;
use yii\web\Controller;


/**
 * Site controller
 */
class SiteController extends Controller
{


    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }


    /**
     * @name 充值短信回调
     * @author fch
     */
    public function actionNotify()
    {
        $get = Yii::$app->request->get();
        $return = PayService::service()->notifyUrl($get);
        var_dump($return);
        exit;
    }

}
