<?php


namespace manage\controllers;


use common\extensions\Helper;
use common\models\UploadCategory;
use common\models\UploadFile;
use manage\services\UploadfileService;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;

class UploadfileController extends Controller
{
    public $enableCsrfValidation = false;

    /**
     * @name 图片上传到服务器
     * @author zfy
     */
    public function actionUpimg()
    {
        //header('Access-Control-Allow-Origin: http://www.baidu.com'); //设置http://www.baidu.com允许跨域访问
        //header('Access-Control-Allow-Headers: X-Requested-With,X_Requested_With'); //设置允许的跨域header
        date_default_timezone_set("Asia/chongqing");
        error_reporting(E_ERROR);
        header("Content-Type: text/html; charset=utf-8");
        $CONFIG = json_decode(preg_replace("/\/\*[\s\S]+?\*\//", "", file_get_contents(__DIR__ . "/../../common/extensions/upload/config.json")), true);
        $action = $_GET['action'];
        switch ($action) {
            case 'config':
                $result = json_encode($CONFIG);
                break;

            /* 上传图片 */
            case 'uploadimage':
                /* 上传涂鸦 */
            case 'uploadscrawl':
                /* 上传视频 */
            case 'uploadvideo':
                /* 上传音频 */
            case 'uploadaudio':
                /* 上传文件 */
            case 'uploadfile':
                $result = include(__DIR__ . "/../../common/extensions/upload/action_upload.php");
                break;

            /* 列出图片 */
            case 'listimage':
                $result = include(__DIR__ . "/../../common/extensions/upload/action_list.php");
                break;
            /* 列出文件 */
            case 'listfile':
                $result = include(__DIR__ . "/../../common/extensions/upload/action_list.php");
                break;

            /* 抓取远程文件 */
            case 'catchimage':
                $result = include(__DIR__ . "/../../common/extensions/upload/action_crawler.php");
                break;

            default:
                $result = json_encode(array(
                    'state' => '请求地址出错'
                ));
                break;
        }

        /* 输出结果 */
        if (isset($_GET["callback"])) {
            if (preg_match("/^[\w_]+$/", $_GET["callback"])) {
                echo htmlspecialchars($_GET["callback"]) . '(' . $result . ')';
            } else {
                echo json_encode(array(
                    'state' => 'callback参数不合法'
                ));
            }
        } else {

            if (Json::decode($result)['state'] == 'SUCCESS') {
                $data = Json::decode($result);
                $data['url'] =  "http://wyatest.oss-cn-hangzhou.aliyuncs.com/" . $data['url'];;
                echo Json::encode(['status' => 1, 'msg' => 'success', 'data' => $data]);
            } else {
                $data = Json::decode($result);
                echo Json::encode(['status' => 0, 'msg' => $data['state'], 'data' => $data]);
            }
        }
    }

    /**
     * @name 我的图片库 ,获取目录结构
     * @author zfy
     */
    public function actionGetfolder()
    {

        $result = ['status' => 0, 'data' => [], 'msg' => ''];
        // 先统计当前分类文件数
        $query_file = UploadfileService::service()->getFile();
        $file_list = [];
        $total = 0;
        foreach ($query_file as $row) {
            $total += $row['count_cnts'];
            $file_list[$row['cat_id']] = $row['count_cnts'];
        }
        $query_cat = UploadfileService::service()->getCate();
        // 返回数据
        $data_tree = [];
        //全部图片
        $count = 0;
        foreach ($query_cat as $cat) {
            if (isset($file_list[$cat['cat_id']])) {
                $count += $file_list[$cat['cat_id']];
            }
        }
        $data_tree[] = ['cat_name' => '全部图片', 'cat_id' => '0', 'count' => $count];

        foreach ($query_cat as $cat) {
            $picNum = 0;
            if (isset($file_list[$cat['cat_id']])) {
                $picNum = $file_list[$cat['cat_id']];
            }

            $data_tree[] = ['cat_name' => $cat['cat_name'], 'cat_id' => $cat['cat_id'], 'count' => $picNum];
        }

        $result['status'] = 1;
        $result['data'] = array('paths' => $data_tree);
        echo json_encode($result);

    }

    /**
     * @name 我的图片库 ,获取图片列表
     * @author zfy
     * @return array
     */
    public function actionImglist()
    {
        $page_size = 20;
        $cat_id = Yii::$app->request->get('cat_id', 0);
        $file_name = Yii::$app->request->get('file_name');
        $page = Yii::$app->request->get('page', 1);

        return UploadfileService::service()->imgList($page_size, $cat_id, $file_name, $page);
    }

    /**
     * @name 我的图片库 ,对目录名称重命名
     * @author zfy
     */
    public function actionRenameCat()
    {
        try {
            $cat_id = intval(yii::$app->request->post('cat_id'));
            $cat_name = yii::$app->request->post('cat_name');
            if (!$cat_id) {
                echo Json::encode(array('status' => false, 'msg' => '传入参数不正确'));
                exit;
            }
            if (mb_strlen($cat_name, 'utf8') > 50) {
                echo Json::encode(array('status' => false, 'msg' => '分类名称不能大于50个字符'));
                exit;
            }
            UploadCategory::updateAll(['cat_name' => $cat_name], ['cat_id' => $cat_id]);
        } catch (\Exception $e) {
            echo Json::encode(Helper::msg(0, '修改失败'));
            exit;
        }
        echo Json::encode(Helper::msg(1, '修改成功'));
        exit;

    }


    /**
     * @name 我的图片库 :删除目录、或目录文件
     * @author zfy
     * type：1 => 不删除图片；2 => 同时删除图片
     */
    public function actionDelCat()
    {
        $cat_id = intval(Yii::$app->request->post('cat_id'));
        if (!$cat_id) {
            echo json_encode(array('status' => 0, 'msg' => '传入参数不正确'));
            exit;
        }
        $result = UploadCategory::deleteAll(['cat_id' => $cat_id]);
        if ($result) {
            echo Json::encode(Helper::msg(1, '删除成功'));
            exit;
        } else {
            echo Json::encode(Helper::msg(0, '删除失败'));
            exit;
        }
    }

    /**
     * @name 我的图片库 ,添加图片目录
     * @author zfy
     */
    public function actionAddCat()
    {
        $name = Yii::$app->request->post('cat_name');
        //$parent_id = Yii::$app->request->getBodyParam('parent_id');
        if (!$name) {
            echo Json::encode(array('status' => 0, 'msg' => '传入参数不正确'));
            exit;
        }
        $result = UploadfileService::service()->add($name);
        echo Json::encode($result);
    }

    /**
     * @name 我的图片库 ,修改图片名称
     * @author zfy
     */
    public function actionRenameImg()
    {
        try {
            $file_name = Yii::$app->request->post('file_name');
            $file_id = intval(Yii::$app->request->post('file_id'));
            if (!$file_id || !$file_name) {
                echo json_encode(array('status' => false, 'msg' => '传入参数不正确'));
                exit;
            }
            UploadFile::updateAll(['file_name' => $file_name], ['file_id' => $file_id]);
        } catch (\Exception $e) {
            echo Json::encode(Helper::msg(0, '修改失败'));
            exit;
        }
        echo Json::encode(Helper::msg(1, '修改成功'));
        exit;
    }

    /**
     * @name 我的图片库 ,删除选中的图片
     * @author zfy
     */
    public function actionDelImg()
    {
        $file_list = Yii::$app->request->post('file_id');
        if (empty($file_list)) {
            echo json_encode(array('status' => false, 'msg' => '传入参数不正确'));
            exit;
        }
        $result = UploadfileService::service()->delImg($file_list);
        if ($result) {
            echo Json::encode(Helper::msg(1, '删除成功'));
            exit;
        } else {
            echo Json::encode(Helper::msg(0, '删除失败'));
            exit;
        }
    }

    /**
     * @name 上传图片
     * @author zfy
     * @throws \Exception
     * @return array
     */
    public function actionUploadImg()
    {
        $cat_id = intval(Yii::$app->request->getBodyParam('cat_id'));
        $img_url = Yii::$app->request->getBodyParam('file_url');
        $img_name = Yii::$app->request->getBodyParam('file_name');

        //$upload_img_host = Yii::$app->params['upload_img_host'];
       // $upload_img_host = "http://oss.ruishan666.com";

        if (empty($img_url) || empty($img_name)) {
            echo Json::encode(array('status' => false, 'msg' => '传入参数不正确'));
            exit;
        }
        // 保存上传图片信息
        return UploadfileService::service()->uploadImg($cat_id, $img_url, $img_name);
    }


    /**
     * @name 我的图片库 ,移动选中的图片到另外一个目录
     * @author zfy
     */
    public function actionMoveImg()
    {
        $cate_id = intval(Yii::$app->request->post('cat_id'));
        $file_list = Yii::$app->request->post('file_id');
        if (empty($file_list)) {
            echo json_encode(array('status' => false, 'msg' => '传入参数不正确'));
            exit;
        }
        $result = UploadfileService::service()->moveImg($file_list, $cate_id);
        if ($result) {
            echo Json::encode(Helper::msg(1, '移动成功'));
            exit;
        } else {
            echo Json::encode(Helper::msg(0, '移动失败'));
            exit;
        }
    }


}