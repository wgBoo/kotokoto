<?php
session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('Member_model');
    }
    public function index()
    {
        $this->load->view('./_templates/header');
        $this->load->view('./home/index');
        $this->load->view('./_templates/footer');
    }
    // 회원가입
    public function join()
    {
        $this->load->view('./_templates/header');
        $this->load->view('./member/join');
        $this->load->view('./_templates/footer');
    }
    // 회원가입 DB저장
    public function joinDB()
    {
        if (isset($_POST["submit_join"])) {
            $this->Member_model->write_user_board($_POST);

            $this->joinLogin($_POST);
        }
    }
    // 회원가입 후 자동로그인
    public function joinLogin($data)
    {
        $_SESSION['loginID'] = $data['uid'];

        $this->load->view('./_templates/header');
        $this->load->view('./home/index');
        $this->load->view('./_templates/footer');
    }
    // 일반 로그인
    public function login()
    {
        if (isset($_POST["submit_login"])) {
            $member['member_info'] = $this->Member_model->get_user_info($_POST);

            $_SESSION['loginID'] = $member['member_info']->uid;
            $_SESSION['uno'] = $member['member_info']->uno;
            $_SESSION['loginClass'] = $member['member_info']->uclass;

            if($_SESSION['loginClass'] == 0) {
                echo "<script type='text/javascript'>location.href='/Admin/adminStock';</script>";
            } else if($_SESSION['loginClass'] == 1) {
                echo "<script type='text/javascript'>location.href='/Farm/farmHope';</script>";
            } else {
                echo "<script type='text/javascript'>location.href='/home/index';</script>";
            }
        }
    }
    // 로그아웃
    public function logout()
    {
        @session_destroy();

        echo "<script type='text/javascript'>location.href='/home/index';</script>";

    }

    //회원정보 수정
    public function member_modify_view()
    {
        $uno = isset($_SESSION['uno']) ? $_SESSION['uno']: null;
        $result['memberModifyInfo'] = $this->Member_model->getModifyInfo($uno);
        $result['interestInfo'] = $this->Member_model->getInterestInfo();


        $sidebar['sidebar'] = 'sidebar';

        $this->load->view('./_templates/header', $sidebar);
        $this->load->view('./_templates/Laside');
        $this->load->view('./mypage/member_modify',$result);
        $this->load->view('./_templates/footer',$sidebar);

    }

    // ajax 호출
    public function ajax_listen(){
        $uno = isset($_SESSION['uno']) ? $_SESSION['uno']: null;
        $result['memberModifyInfo'] = $this->Member_model->getModifyInterestInfo($uno);

        echo json_encode($result['memberModifyInfo']);
    }

    //회원정보 수정
    public function member_modify(){
        $uno = isset($_SESSION['uno']) ? $_SESSION['uno']: null;
        $submitModify = isset($_REQUEST['submit_modify']) ? $_REQUEST['submit_modify'] : null;

        if($submitModify){
            $modifyInfo['pw'] = isset($_REQUEST['pw'])?$_REQUEST['pw'] : null;
            $modifyInfo['email'] = isset($_REQUEST['email'])?$_REQUEST['email'] : null;
            $sex = isset($_REQUEST['sex'])?$_REQUEST['sex'] : null;
            if($sex=='남'){
                $modifyInfo['sex'] = 0;
            }else{
                $modifyInfo['sex'] = 1;
            }
            $modifyInfo['old'] = isset($_REQUEST['old'])?$_REQUEST['old'] : null;
            $interest = isset($_REQUEST['interest'])?$_REQUEST['interest'] : null;

            if($interest) {
                $interestInfo = $this->Member_model->getInterestInfo();
                $i = 0;
                foreach ($interestInfo as $row) {
                    foreach ($interest as $value) {
                        if ($row->iname == $value)
                            $interestNum[$i] = $row->ino;
                        $i++;
                    }
                }
                //기존 관심사정보 삭제
                $this->Member_model->deleteInterest($uno);
                //normaluser번호(nuno) 받아오기
                $nuno = $this->Member_model->getNormaluserNum($uno);
                //수정한 관심사정보 삽입
                foreach ($interestNum as $row) {
                    $this->Member_model->insertInterest($nuno->nuno, $row);
                }
            }else{
                //관심사정보를 다삭제해서 보냈을 경우
                $this->Member_model->deleteInterest($uno);
            }

            //회원정보 수정정
            $this->Member_model->memberModify($uno,$modifyInfo);
        }

        $this->member_modify_view();
    }

    public function member_leave(){
        $uno = isset($_SESSION['uno']) ? $_SESSION['uno']: null;
        $this->Member_model->memberInfoDelete($uno);

        $this->logout();
    }
}
