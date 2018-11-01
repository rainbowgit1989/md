<?php
/**
 * Created by PhpStorm.
 * User: tsukeirodoriniji
 * Date: 2018/4/18
 * Time: 上午8:35
 */

namespace manage\controllers;


use common\extensions\Helper;
use yii\web\Controller;

class TestController extends Controller
{
    function actionTest()
    {
        $post = Helper::request();
        if (isset($post['error'])) {
            if ($post['error'] == 500) {
                echo $a;
            }
            if ($post['error'] == 0) {
                return Helper::msg(false, '开发测试');
            }
        }

        if (isset($post['page'])) {
            $return = ['list' => [1, 2, 3],
                'totalCount' => 3,
                'totalPage' => 1,
                'currentPage' => $post['page'],
            ];
            return Helper::msg(true, 'success', $return);
        }

        return Helper::msg(true, 'success');
    }



}