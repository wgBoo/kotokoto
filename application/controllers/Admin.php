<?php
session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('Admin_model');
    }

    public function index()
    {
        $this->adminStock();
    }

    public function info()
    {
        $this->load->view('./admin/phpinfo');
    }

    // 재고 현황
    public function adminStock()
    {
        $admin['material_stock_info'] = $this->Admin_model->get_material_stock_info();
        $admin['farm0'] = $this->Admin_model->get_farm_info(0);
        $admin['total_mstock0'] = $this->Admin_model->total_mstock(0);
        $admin['farms_mstock0'] = $this->Admin_model->farms_stock(0);
        $admin['farms_crops0'] = $this->Admin_model->farms_crops(0);
        $admin['farm1'] = $this->Admin_model->get_farm_info(1);
        $admin['total_mstock1'] = $this->Admin_model->total_mstock(1);
        $admin['farms_mstock1'] = $this->Admin_model->farms_stock(1);
        $admin['farms_crops1'] = $this->Admin_model->farms_crops(1);
        $admin['farm2'] = $this->Admin_model->get_farm_info(3);
        $admin['total_mstock2'] = $this->Admin_model->total_mstock(3);
        $admin['farms_mstock2'] = $this->Admin_model->farms_stock(3);
        $admin['farms_crops2'] = $this->Admin_model->farms_crops(3);
        $admin['farm3'] = $this->Admin_model->get_farm_info(2);
        $admin['total_mstock3'] = $this->Admin_model->total_mstock(2);
        $admin['farms_mstock3'] = $this->Admin_model->farms_stock(2);
        $admin['farms_crops3'] = $this->Admin_model->farms_crops(2);

        $this->load->view('./_templates/header');
        $this->load->view('./admin/admin_stock', $admin);
        $this->load->view('./_templates/footer');
    }

    // 멤버 리스트
    public function adminMember()
    {
        $admin['users_info'] = $this->Admin_model->get_normal_users_info();

        $this->load->view('./_templates/header');
        $this->load->view('./admin/admin_member', $admin);
        $this->load->view('./_templates/footer');
    }

    // 유저 삭제
    public function adminDelteMem($uno)
    {
        $this->Admin_model->delete_normal_user($uno);

        echo "<script type='text/javascript'>location.href='/Admin/adminMember';</script>";
    }

    // 재료 하나의 정보
    public function materialInfo($mno)
    {
        $admin['material_info'] = $this->Admin_model->get_material_info($mno);

        $modal_form ="
<form>
<h2 style='margin-top: 10px'>詳細情報</h2>
<table align='center' style='font-family: Meiryo'>
<tr>
<td style='padding: 10px 10px 10px 60px; float: inherit'><img src='/public/assets/img/crops/{$admin['material_info']->cpname}' width='120' height='120' style='border-radius: 5px'></td>
<td style='padding: 10px; float: inherit; text-align: left; padding-left: 100px;' >品名 : {$admin['material_info']->cname}<br>
 残量 : {$admin['material_info']->mstock} kg</td>
</tr>
<tr>
<td style='padding: 10px 10px 10px 60px; float: inherit'><img src='/public/assets/img/farm/{$admin['material_info']->fpname}' width='120' height='120' style='border-radius: 5px'></td>
<td style='padding: 10px; float: inherit; text-align: left; padding-left: 100px;'>生産地名 : {$admin['material_info']->fname}<br>
 生産者 : {$admin['material_info']->farmer}<br>
 電話番号 : {$admin['material_info']->fphone}</td>
</tr>
<tr><td style='padding-top: 20px; padding-bottom: 0' colspan='2' align='center'>位置</td></tr>
</table></form>";

        echo json_encode(array('result' => 'success', 'modal' => $modal_form, 'flocation'=>$admin['material_info']->flocation));
    }

    // 발주현황
    public function adminOrder()
    {
        $admin['corders_info'] = $this->Admin_model->get_admin_order_info();
        $admin['corders_info2'] = $this->Admin_model->get_admin_order_info2();
        $admin['corders_info3'] = $this->Admin_model->get_admin_order_info3();
        $admin['corders_info4'] = $this->Admin_model->get_admin_order_info4();
        $admin['message_info'] = $this->Admin_model->select_message();
        $admin['status_info'] = $this->Admin_model->corder_status();
        $admin['status_info2'] = $this->Admin_model->corder_status2();
        $admin['status_info3'] = $this->Admin_model->corder_status3();

        $this->load->view('./_templates/header');
        $this->load->view('./admin/admin_order', $admin);
        $this->load->view('./_templates/footer');
    }

    // 발주현황 자세히보기
    public function adminOrderDetail($cono)
    {
        $admin['corder_info'] = $this->Admin_model->get_corder_info($cono);
        $admin['message_info'] = $this->Admin_model->get_corder_message_info($cono);

        $this->load->view('./_templates/header');
        $this->load->view('./admin/admin_order_detail', $admin);
        $this->load->view('./_templates/footer');
    }

    // 발주 진행
    public function order_ing($cono)
    {
        $this->Admin_model->next_order_status($cono);

        $corder_info = $this->Admin_model->get_corder_info($cono);

        $cno = $corder_info->cno;
        $status = $corder_info->costatus;
        $stock = $corder_info->costock;

        if ($status == 4) {
            $this->Admin_model->end_plus_mstock($cno, $stock);
        }

        $this->adminOrderDetail($cono);
    }

    // 발주 메시지
    public function writeContent()
    {
        $user_id = isset($_SESSION['loginID']) ? $_SESSION['loginID'] : "";

        $admin['user_info'] = $this->Admin_model->get_user_info($user_id);
        $uno = $admin['user_info']->uno;

        $this->Admin_model->write_corder_content($_POST, $uno);

        $cono = $_POST['cono'];

        $this->adminOrderDetail($cono);
    }

    // 발주 DB 등록
    public function corderDB()
    {
        if (isset($_POST["submit_admin_corder"])) {

            foreach ($_POST['cno'] as $row) {
                if($_POST['costock'][$row]) {
                    $cstock = $_POST['costock'][$row];
                }
                $this->Admin_model->write_corder($_POST, $row, $cstock);
            }
        }
        echo "<script type='text/javascript'>location.href='/Admin/adminOrder';</script>";
    }

    // 주문리스트
    public function adminOrderManage()
    {
        $admin['order_list'] = $this->Admin_model->get_order_list();
        $damin['order_receipe_list'] = $this->Admin_model->get_order_receipe_list();

        $this->load->view('./_templates/header');
        $this->load->view('./admin/admin_ordermanage', $admin);
        $this->load->view('./_templates/footer');
    }

    // 잠재고객
    public function adminGraph($startDate, $endDate, $type)
    {

        $date['startDate'] = $startDate;
        $date['endDate'] = $endDate;
        $date['type'] = $type;

        $this->load->view('./_templates/header');

        $this->load->view('./_templates/adminLaside');

        $this->load->view('./admin/HelloAnalytics', $date);

        $this->load->view('./_templates/footer');

    }

    // 실시간
    public function adminRealtime(){
        $this->load->view('./_templates/header');
        $this->load->view('./_templates/adminLaside');
        $this->load->view('./admin/realtime');
        $this->load->view('./_templates/footer');
    }

    public function adminGraphs($num)
    {
        if ($num == 2) {
            $admin['recipe_rate'] = $this->Admin_model->recipe_rate();
            $admin['num'] = $num;
            $cnt = count($admin['recipe_rate']);
            $admin['sum'] = 0;
            for ($i = 0; $i < $cnt; $i++) {
                $temp = $admin['recipe_rate'][$i]->cnt;
                $admin['sum'] += $temp;
            }
        }

        $this->load->view('./_templates/header');
        $this->load->view('./admin/admin_graph', $admin);
        $this->load->view('./_templates/footer');
    }

    // 레시피 관리
    public function adminRecipe()
    {
        $recipe['recipeList'] = $this->Admin_model->select_recipe();

        $this->load->view('./_templates/header');
        $this->load->view('./admin/admin_recipe', $recipe);
        $this->load->view('./_templates/footer');
    }

    public function adminRecipeAdd()
    {

        $admin['crops'] = $this->Admin_model->get_crops();

        $this->load->view('./_templates/header');
        $this->load->view('./admin/admin_recipe_add', $admin);
        $this->load->view('./_templates/footer');
    }

    public function recipeAdd()
    {
        $addRecipe['rname'] = isset($_REQUEST['rname']) ? $_REQUEST['rname'] : null;
        $addRecipe['rtime'] = isset($_REQUEST['rtime']) ? $_REQUEST['rtime'] : null;
        $addRecipe['rprice'] = isset($_REQUEST['rprice']) ? $_REQUEST['rprice'] : null;
        $addRecipe['rpicture'] = "";
        $crops = isset($_REQUEST['checkCrops']) ? $_REQUEST['checkCrops'] : null;

        $addRecipe['rno'] = $this->Admin_model->insert_recipe($addRecipe);
        $addRecipe['crops'] = $this->Admin_model->get_crop($crops);

        $target = "./public/assets/img/recipe/";
        $newName = "recipe";
        $pic_name = $this->imgUpload($target, $newName);

        $this->Admin_model->modify_picture($pic_name, $addRecipe['rno']);

        $this->load->view('./_templates/header');
        $this->load->view('./admin/admin_recipe_addck', $addRecipe);
        $this->load->view('./_templates/footer');
    }

    public function imgUpload($target, $newName)
    {
        $pic_name = $_FILES['picName']['name'];
        $tmp_name = $_FILES['picName']['tmp_name'];
        $error = $_FILES['picName']['error'];

        if ($pic_name && $error == 0) {

            $type = pathinfo($pic_name, PATHINFO_EXTENSION); // 확장자 추출

            $date = date("his");
            $new_pic_name = $date . $newName . "." . $type;
            $target_pic = $target . $new_pic_name;
            move_uploaded_file($tmp_name, $target_pic);

            return $new_pic_name;
        } else {
            return false;
        }
    }

    public function recipeAddCk()
    {
        $select['rno'] = isset($_REQUEST['rno']) ? $_REQUEST['rno'] : null;
        $checkRecipeRm['rmexclude'] = isset($_REQUEST['rmexclude']) ? $_REQUEST['rmexclude'] : null; //제외만
        $checkRecipeRm['rmmstock'] = isset($_REQUEST['rmmstock']) ? $_REQUEST['rmmstock'] : null;
        $checkRecipeRm['mno'] = isset($_REQUEST['checkCrops']) ? $_REQUEST['checkCrops'] : null; //모두

//rmmanage 추가 후 제외불가는 수정하기

        $this->Admin_model->insert_rmmanage($checkRecipeRm, $select['rno']);
        $select['interests'] = $this->Admin_model->select_interest();

        $this->load->view('./_templates/header');
        $this->load->view('./admin/admin_recipe_interest', $select);
        $this->load->view('./_templates/footer');
    }

    public function interestAdd()
    {

        $rno = isset($_REQUEST['rno']) ? $_REQUEST['rno'] : null;
        $ino = isset($_REQUEST['ino']) ? $_REQUEST['ino'] : null;

        $this->Admin_model->insert_rimanage($rno, $ino);
        $recipe['recipeList'] = $this->Admin_model->select_recipe();
        $this->load->view('./_templates/header');
        $this->load->view('./admin/admin_recipe', $recipe);
        $this->load->view('./_templates/footer');
    }

    public function liveSearch()
    {
        $val = $_POST['search_data'];

        $result = "";

        $search_data = $this->Admin_model->search_crops($val);

        if(count($search_data) > 0) {

            for($i = 0; $i < count($search_data); $i++){
                if($i == 0){
                    $result = $search_data[$i]->cno;
                } else {
                    $result = $result . "/" . $search_data[$i]->cno;
                }
            }
        } else {
            $result = "none";
        }

        echo $result;

        /* header('Content-Type: application/json; charset=UTF-8');

 // 컨텐츠 타입이 JSON 인지 확인한다


         $rawBody = file_get_contents("php://input"); // 본문을 불러옴
         $sorts =json_decode($rawBody);

         if(isset($sorts->sort) && $sorts->sort != new stdClass()) {

             $count = 0;
             $where = " WHERE ";
             foreach ($sorts->sort as $not_order) {
                 $count += count($not_order);
             }
             $count = $count - 1;

             if(isset($sorts->sort->ext) && count($sorts->sort->ext)!=0){

                 $ext_array = $sorts->sort->ext;
                 $where .= " ( ";
                 for($i = 0; $i < count($ext_array); $i++){
                     $where .= $ext_array[$i];
                     if(count($ext_array) > 1 && $i != (count($ext_array)-1) ){
                         $where .= " OR ";
                         $count--;
                     }

                 }
                 $where .= " ) ";
             }
             if(isset($sorts->sort->search) && count($sorts->sort->search)!=0) {
                 if ($count != 0) {
                     $where .= " AND ";
                     $count--;
                 }

                 switch ($sorts->search_mod) {
                     case "before" :
                         $where .= " f_origin_name regexp '^(" . $sorts->sort->search[0] . ")+[*\\/+?{}()]*[가-힇]*[[:space:]]*[[:alnum:]]*[*\\/+?{}()]*[가-힇]*[[:space:]]*[[:alnum:]]*' ";
                         break;
                     case "mid" :
                         $where .= " f_origin_name regexp '[*\\/+?{}()]*[가-힇]*[[:space:]]*[[:alnum:]]*[*\\/+?{}]*[가-힇]*[[:space:]]*[[:alnum:]]*(".$sorts->sort->search[0]. ")+[*\\/+?{}()]*[가-힇]*[[:space:]]*[[:alnum:]]*[*\\/+?{}()]*[가-힇]*[[:space:]]*[[:alnum:]]*' ";
                         break;
                     case "after" :
                         $where .= " f_origin_name regexp '[*\\/+?{}()]*[가-힇]*[[:space:]]*[[:alnum:]]*[*\\/+?{}]*[가-힇]*[[:space:]]*[[:alnum:]]*(".$sorts->sort->search[0]. ")+$' ";
                         break;
                 }
             }

         }else{
             $where = "";
         }
         if(isset($sorts->order) && count($sorts->order)!=0) {
             $where .= " ORDER BY ".$sorts->order[0];
         }
         if($where != "") {

             $result = $this->Admin_model->getFilesBySort($where);
         }
         else{
             $result = $this->Admin_model->getData();
         }
         $this->load->view('./admin/admin_stock/'.$sorts->view_mode,array('files'=>$result));*/

        /*$val = $_POST['q'];
        $search_data = $this->Admin_model->search_crops($str);

        if (strlen($str)>0) {
            $result="";
            foreach($search_data as $row) {
                if ($result == "") {
                    $result = "<div id='drag_{$row->cno}' draggable='true' ondragstart='drag(event)'>
                <span draggable='false' data-toggle='modal' data-target='#orderStart' class='order_start_btn'
                      id='cno{$row->cno}' onclick='ajax({$row->mno})'>
                  <img id='img_{$row->cno}' draggable='false' class='drag'
                       src='/public/assets/img/crops/{$row->cpname}'>
                  <p id='drag_name_{$row->cno}' draggable='false'
                     style='font-size: 18px; color: black; margin: 0; text-align: center'>
                     {$row->fname} - {$row->cname}</p>
                </span>
                            <p id='drag_order_{$row->cno}' draggable='false' style='font-size: 13pt; display: none;'>발주량 &nbsp;&nbsp;&nbsp;<input id='drag_num_{$row->cno}' draggable='false' type='number' name='costock[{$row->cno}]' step='5' style='width: 50px; height: 25px; font-size: 12pt' min='5' value='5'> &nbsp;&nbsp;kg</p>
                            <input draggable='false' type='hidden' name='cno[{$row->cno}]' value='{$row->cno}'>";
                } else {
                    $result = $result."<div id='drag_{$row->cno}' draggable='true' ondragstart='drag(event)'>
                <span draggable='false' data-toggle='modal' data-target='#orderStart' class='order_start_btn'
                      id='cno{$row->cno}' onclick='ajax({$row->mno})'>
                  <img id='img_{$row->cno}' draggable='false' class='drag'
                       src='/public/assets/img/crops/{$row->cpname}'>
                  <p id='drag_name_{$row->cno}' draggable='false'
                     style='font-size: 18px; color: black; margin: 0; text-align: center'>
                     {$row->fname} - {$row->cname}</p>
                </span>
                            <p id='drag_order_{$row->cno}' draggable='false' style='font-size: 13pt; display: none;'>발주량 &nbsp;&nbsp;&nbsp;<input id='drag_num_{$row->cno}' draggable='false' type='number' name='costock[{$row->cno}]' step='5' style='width: 50px; height: 25px; font-size: 12pt' min='5' value='5'> &nbsp;&nbsp;kg</p>
                            <input draggable='false' type='hidden' name='cno[{$row->cno}]' value='{$row->cno}'>";
                }
            }
        }

        if(count($search_data) == 0) {
            $result = "no data";
        }

        //return HttpResponse($result);

        echo json_encode(array('data' => $result));*/
    }
}
