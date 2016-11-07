<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Multimedia extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->model('Multi_model');
    }

    public function index($rname)
    {

        $data = $this->Multi_model->multi_pickme($rname);

        //echo $rname;
        echo json_encode($data);
    }
}
