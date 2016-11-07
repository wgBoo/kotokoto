<?php
session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Farm extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('Farm_model');
    }

    public function index()
    {
        $this->farm();
    }

    // 농장소개
    public function farm()
    {
        $user_id = isset($_SESSION['loginID']) ? $_SESSION['loginID'] : "";

        $farm['user_info'] = $this->Farm_model->get_user_info($user_id);
        $uno = $farm['user_info']->uno;
        $farm['farm_info'] = $this->Farm_model->get_farm_info($uno);

        $this->load->view('./_templates/header');
        $this->load->view('./farm/farm', $farm);
        $this->load->view('./_templates/footer');
    }

    // 농장등록
    public function farmWrite()
    {
        $user_id = isset($_SESSION['loginID']) ? $_SESSION['loginID'] : "";

        $farm['user_info'] = $this->Farm_model->get_user_info($user_id);

        $this->load->view('./_templates/header');
        $this->load->view('./farm/farm_write', $farm);
        $this->load->view('./_templates/footer');
    }

    // 농장 DB 입력
    public function farmWriteDB()
    {
        if (isset($_POST["submit_farm_write"])) {
            $last_id = $this->Farm_model->write_farm_board($_POST);

            $target = "./public/assets/img/farm/";
            $newName = "farm" . $last_id;
            $pic_name = $this->imgUpload($target, $newName);

            if($pic_name == false) {
                $this->Farm_model->delete_farm_board($last_id);
                echo "<script>alert('이 사진을 사용할 수 없습니다.');</script>";
            }else {
                $this->Farm_model->write_fpicture_board($last_id, $pic_name);
            }
        }
        $this->farm();
    }

    // 농장수정
    public function farmModify()
    {
        $user_id = isset($_SESSION['loginID']) ? $_SESSION['loginID'] : "";

        $farm['user_info'] = $this->Farm_model->get_user_info($user_id);
        $uno = $farm['user_info']->uno;
        $farm['farm_info'] = $this->Farm_model->get_farm_info($uno);

        $this->load->view('./_templates/header');
        $this->load->view('./farm/farm_modify', $farm);
        $this->load->view('./_templates/footer');
    }

    // 농장 DB 업데이트
    public function farmModifyDB()
    {
        if (isset($_POST["submit_farm_modify"])) {
            $user_id = isset($_SESSION['loginID']) ? $_SESSION['loginID'] : "";

            $farm['user_info'] = $this->Farm_model->get_user_info($user_id);
            $uno = $farm['user_info']->uno;
            $farm['farm_info'] = $this->Farm_model->get_farm_info($uno);
            $fno = $farm['farm_info']->fno;
            $farm['farm_info'] = $this->Farm_model->get_fpname_info($fno);
            if(isset($_FILES['picName'])) {
                $target = "./public/assets/img/farm/";
                $newName = "farm" . $fno;
                $fpname = $farm['farm_info']->fpname;
                $del_pic = $target.$fpname;
                $pic_name = $this->imgUpload($target, $newName);

                if($pic_name == false) {
                    echo "<script>alert('이 사진을 사용할 수 없습니다.');</script>";
                }else {
                    unlink($del_pic);
                    $this->Farm_model->modify_farm_board($_POST);
                    $this->Farm_model->modify_fpicture_board($fpname, $pic_name);
                }
            }else{
                $this->Farm_model->modify_farm_board($_POST);
            }
        }
        echo "<script type='text/javascript'>location.href='/Farm/farm';</script>";
    }

    // 작물리스트
    public function farmCrop()
    {
        $user_id = isset($_SESSION['loginID']) ? $_SESSION['loginID'] : "";

        $farm['user_info'] = $this->Farm_model->get_user_info($user_id);
        $uno = $farm['user_info']->uno;
        $farm['farm_info'] = $this->Farm_model->get_farm_info($uno);
        $fno = $farm['farm_info']->fno;
        $farm['crops_info'] = $this->Farm_model->get_crops_info($fno);

        $this->load->view('./_templates/header');
        $this->load->view('./farm/farm_crop', $farm);
        $this->load->view('./_templates/footer');
    }
    // 작물리스트 모드
    public function farmCropMode($mode)
    {
        $user_id = isset($_SESSION['loginID']) ? $_SESSION['loginID'] : "";

        $farm['user_info'] = $this->Farm_model->get_user_info($user_id);
        $uno = $farm['user_info']->uno;
        $farm['farm_info'] = $this->Farm_model->get_farm_info($uno);
        $fno = $farm['farm_info']->fno;
        $farm['crops_info'] = $this->Farm_model->get_crops_info_mode($fno, $mode);

        $this->load->view('./_templates/header');
        $this->load->view('./farm/farm_crop', $farm);
        $this->load->view('./_templates/footer');
    }

    // 작물등록
    public function cropWrite()
    {
        $user_id = isset($_SESSION['loginID']) ? $_SESSION['loginID'] : "";

        $farm['user_info'] = $this->Farm_model->get_user_info($user_id);
        $uno = $farm['user_info']->uno;
        $farm['farm_info'] = $this->Farm_model->get_farm_info($uno);

        $this->load->view('./_templates/header');
        $this->load->view('./farm/farm_crop_write', $farm);
        $this->load->view('./_templates/footer');
    }

    // 작물 DB 입력
    public function cropWriteDB()
    {
        if (isset($_POST["submit_crop_write"])) {
            $last_id = $this->Farm_model->write_crop_board($_POST);

            $target = "./public/assets/img/crops/";
            $newName = "crops" . $last_id;
            $pic_name = $this->imgUpload($target, $newName);

            if($pic_name == false) {
                $this->Farm_model->delete_crop($last_id);
                echo "<script>alert('이 사진을 사용할 수 없습니다.');</script>";
            }else {
                $this->Farm_model->write_cpicture_board($last_id, $pic_name);
            }
        }
        echo "<script type='text/javascript'>location.href='/Farm/cropDetail/{$last_id}';</script>";
    }

    // 작물 자세히
    public function cropDetail($cno)
    {
        $farm['crop_info'] = $this->Farm_model->get_crop_info($cno);

        $this->load->view('./_templates/header');
        $this->load->view('./farm/farm_crop_detail', $farm);
        $this->load->view('./_templates/footer');
    }

    // 작물 수정
    public function cropsModify($cno)
    {
        $farm['crop_info'] = $this->Farm_model->get_crop_info($cno);

        $this->load->view('./_templates/header');
        $this->load->view('./farm/farm_crop_modify', $farm);
        $this->load->view('./_templates/footer');
    }

    // 작물 DB 업데이트
    public function cropModifyDB()
    {
        if (isset($_POST["submit_crop_modify"])) {
            $cno = $_POST['cno'];
            $farm['crop_info'] = $this->Farm_model->get_crop_info($cno);

            $target = "./public/assets/img/crops/";
            $newName = "crop" . $cno;
            $cpname = $farm['crop_info']->cpname;
            $del_pic = $target.$cpname;
            $pic_name = $this->imgUpload($target, $newName);

            if($pic_name == false) {
                echo "<script>alert('이 사진을 사용할 수 없습니다.');</script>";
            }else {
                unlink($del_pic);
                $this->Farm_model->modify_crop_board($_POST);
                $this->Farm_model->modify_cpicture_board($cpname, $pic_name);
            }
        }
        $this->farmCrop();
    }

    // 작물삭제
    public function cropsDelete($cno)
    {
        $farm['crop_info'] = $this->Farm_model->get_crop_info($cno);
        $target = "./public/assets/img/crops/";
        $cpname = $farm['crop_info']->cpname;
        $del_pic = $target.$cpname;
        unlink($del_pic);
        $this->Farm_model->delete_crop($cno);

        header('location:/farm/farmCrop');
    }

    // 작물재고 상승
    public function cropStockUP()
    {
        if (isset($_POST['submit_crop_stock'])) {
            $cstock = $this->Farm_model->modify_cstock_crop_board($_POST);
            echo "<script>alert('재고가 {$cstock} 만큼 증가하였습니다.')</script>";
        }
        echo "<script type='text/javascript'>location.href='/Farm/farmCrop';</script>";
    }

    // 통계
    public function farmGraph()
    {
        $this->load->view('./_templates/header');
        $this->load->view('./farm/farm_graph');
        $this->load->view('./_templates/footer');
    }

    // 이미지 업로드
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
    // 발주현황 자세히보기
    public function farmHopeDetail($cono)
    {
        $farm['corder_info'] = $this->Farm_model->get_corder_info($cono);
        $farm['message_info'] = $this->Farm_model->get_corder_message_info($cono);

        $this->load->view('./_templates/header');
        $this->load->view('./farm/farm_hope_detail', $farm);
        $this->load->view('./_templates/footer');
    }
    // 발주리스트
    public function farmHope()
    {
        $user_id = isset($_SESSION['loginID']) ? $_SESSION['loginID'] : "";

        $farm['user_info'] = $this->Farm_model->get_user_info($user_id);
        $uno = $farm['user_info']->uno;
        $farm['farm_info'] = $this->Farm_model->get_farm_info($uno);
        $fno = $farm['farm_info']->fno;

        $farm['corders_info'] = $this->Farm_model->get_admin_order_info($fno);
        $farm['corders_info2'] = $this->Farm_model->get_admin_order_info2($fno);
        $farm['corders_info3'] = $this->Farm_model->get_admin_order_info3($fno);
        $farm['corders_info4'] = $this->Farm_model->get_admin_order_info4($fno);
        $farm['message_info'] = $this->Farm_model->select_message();
        $farm['status_info'] = $this->Farm_model->corder_status($fno);
        $farm['status_info2'] = $this->Farm_model->corder_status2($fno);
        $farm['status_info3'] = $this->Farm_model->corder_status3($fno);

        $this->load->view('./_templates/header');
        $this->load->view('./farm/farm_hope', $farm);
        $this->load->view('./_templates/footer');
    }
    // 발주 진행
    public function order_ing($cono)
    {
        $this->Farm_model->next_order_status($cono);

        $this->farmHopeDetail($cono);
    }
    // 발주 거절
    public function order_ing_fail($cono)
    {
        $this->Farm_model->fail_order_status($cono);

        $this->farmHopeDetail($cono);
    }
    public function farmSchedule()
    {
        $this->load->view('./_templates/header');
        $this->load->view('./farm/farm_schedule');
        $this->load->view('./_templates/footer');
    }
    // 발주 메시지
    public function writeContent()
    {
        $user_id = isset($_SESSION['loginID']) ? $_SESSION['loginID'] : "";

        $admin['user_info'] = $this->Farm_model->get_user_info($user_id);
        $uno = $admin['user_info']->uno;

        $this->Farm_model->write_corder_content($_POST, $uno);

        $cono = $_POST['cono'];

        $this->farmHopeDetail($cono);
    }

    public function farmStock()
    {
        $user_id = isset($_SESSION['loginID']) ? $_SESSION['loginID'] : "";

        $farm['user_info'] = $this->Farm_model->get_user_info($user_id);
        $uno = $farm['user_info']->uno;
        $farm['farm_info'] = $this->Farm_model->get_farm_info($uno);
        $fno = $farm['farm_info']->fno;

        $farm['total_mstock'] = $this->Farm_model->farm_mstock($fno);
        $farm['crops_stock'] = $this->Farm_model->crops_stock($fno);
        
        $this->load->view('./_templates/header');
        $this->load->view('./farm/farm_stock', $farm);
        $this->load->view('./_templates/footer');
    }
}