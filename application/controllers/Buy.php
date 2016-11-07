<?php
defined('BASEPATH') OR exit('No direct script access allowed');
session_start();

class Buy extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->model('Buy_model');
        $this->load->model('Mybook_model');
    }

    public function cart()
    {
        $user_id = isset($_SESSION['loginID']) ? $_SESSION['loginID'] : null;
        $cart['cartList'] = $this->Buy_model->cartList($user_id);
        //  $buy['cartCheck'] = $this->Cart_model->cartListCrops($user_id);

        $this->load->view('./_templates/header');
        $this->load->view('./buy/cart', $cart);
        $this->load->view('./_templates/footer');
    }

    public function insert_shoppingbag()
    {
        $shopping['rno'] = isset($_REQUEST['rno']) ? $_REQUEST['rno'] : null;
        $shopping['sstock'] = isset($_REQUEST['sstock']) ? $_REQUEST['sstock'] : null;
        $shopping['sprice'] = isset($_REQUEST['rprice']) ? $_REQUEST['rprice'] : null;
        $mno = isset($_REQUEST['mno']) ? $_REQUEST['mno'] : null;
        $user_id = isset($_SESSION['loginID']) ? $_SESSION['loginID'] : null;
        $nuno = $this->Buy_model->get_nuno($user_id);
        $shopping['nuno'] = $nuno->nuno;

        $shoppingbag_check = $this->Buy_model->shoppingbag_check($shopping['rno'], $shopping['nuno']);

        if($shoppingbag_check==null){
            $sno = $this->Buy_model->insert_shoppingbag($shopping);

            if ($sno) {
                if ($mno) {
                    $autoSmmanage = $this->Buy_model->insert_smmanage($mno, $sno);
                    if ($autoSmmanage) {
                        echo "장바구니에 담았습니다.";
                    } else {
                        echo "장바구니 담기에 실패했습니다.";
                    }
                } else {
                    echo "장바구니에 담았습니다.";
                }
            } else {
                echo "장바구니 담기에 실패했습니다.";
            }
        }else{
            echo "이미 장바구니에 담겨있습니다.";
        }
    }

    public function address()
    {
        $user_id = isset($_SESSION['loginID']) ? $_SESSION['loginID'] : null;

        $address['oprice'] = isset($_REQUEST['price']) ? $_REQUEST['price'] : null;
        $address['owishday'] = isset($_REQUEST['owishday']) ? $_REQUEST['owishday'] : null;
        $address['rno'] = isset($_REQUEST['rno']) ? $_REQUEST['rno'] : null;

        $address['addressList'] = $this->Buy_model->select_address($user_id);

        $this->load->view('./_templates/header');
        $this->load->view('./buy/address', $address);
        $this->load->view('./_templates/footer');
    }

    public function addressAdd()
    {
        $user_id = isset($_SESSION['loginID']) ? $_SESSION['loginID'] : null;
        $address['recipient'] = isset($_REQUEST['recipient']) ? $_REQUEST['recipient'] : null;
        $address['postcode'] = isset($_REQUEST['postcode']) ? $_REQUEST['postcode'] : null;
        $address['ad1'] = isset($_REQUEST['ad1']) ? $_REQUEST['ad1'] : null;
        $address['ad2'] = isset($_REQUEST['ad2']) ? $_REQUEST['ad2'] : null;
        $address['menstion'] = isset($_REQUEST['menstion']) ? $_REQUEST['menstion'] : null;
        $address['telephone'] = isset($_REQUEST['telephone']) ? $_REQUEST['telephone'] : null;

        $address['nuno'] = $this->Buy_model->get_nuno($user_id);

        $this->Buy_model->insert_address($address);
        $address['addressList'] = $this->Buy_model->select_address($user_id);


        $this->load->view('./_templates/header');
        $this->load->view('./buy/address', $address);
        $this->load->view('./_templates/footer');
    }

    public function address_change()
    {
        $ano = isset($_REQUEST['ano']) ? $_REQUEST['ano'] : null;

        $address['addressList'][0] = $this->Buy_model->get_address($ano);


        $this->load->view('./_templates/header');
        $this->load->view('./buy/address', $address);
        $this->load->view('./_templates/footer');
    }
    public function buy(){
        $buy['oprice'] = isset($_REQUEST['oprice']) ? $_REQUEST['oprice']:null;
        $buy['owishday'] = isset($_REQUEST['owishday']) ? $_REQUEST['owishday']:null;
        $user_id = isset($_SESSION['loginID']) ? $_SESSION['loginID'] : null;
        $nuno = $this->Buy_model->get_nuno($user_id);
        $buy['nuno'] = $nuno->nuno;

        $rno = isset($_REQUEST['rno']) ? $_REQUEST['rno']:null;

          $autoOrder = $this->Buy_model->insert_order($buy);
          $this->Buy_model->insert_orderlist($autoOrder, $rno);
        $uno = isset($_SESSION['uno']) ? $_SESSION['uno']: null;
        $result['orderList'] = $this->Mybook_model->getOrderList($uno);

        $this->load->view('./_templates/header');
        $this->load->view('./mypage/order_check',$result);
        $this->load->view('./_templates/footer');


    }

}