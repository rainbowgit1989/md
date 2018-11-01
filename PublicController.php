<?php


namespace manage\controllers;


use common\extensions\Helper;
use common\extensions\Setting;
use common\services\AddressOpenService;
use common\services\UserOpenService;
use Yii;

class PublicController extends BaseController
{
    /**
     * @name 一些公共数据
     * @author fch
     * @return array
     */
    function actionGetData()
    {
        $data['level'] = UserOpenService::service()->userLevelSimple();
        if (Yii::$app->session->get('is_open_head_module', 0) == 1) {
            $data['head_level'] = UserOpenService::service()->headLevelSimple();
        } else {
            $data['head_level'] = [];
        }
        $activity_type = Setting::actionType();
        $data['activity_type'] = [];
        foreach ($activity_type as $k => $v) {
            $data['activity_type'][] = ['activity_type' => $k, 'name' => $v];
        }
        return Helper::msg(true, 'success', $data);
    }

    /**
     * @name 地址下拉框
     * @author fch
     * @return array
     */
    function actionGetRegions()
    {
        $data['regions'] = AddressOpenService::service()->getRegions();
        return Helper::msg(true, 'success', $data);
    }
}