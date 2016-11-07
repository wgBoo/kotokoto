<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->model('Recipe_model');
    }

    public function index()
    {
        $index['index'] = 'index';

        $recipe['mainRecipe'] = $this->Recipe_model->get_main_recipe();
        $recipe['mainCrops'] = $this->Recipe_model->get_main_crops($recipe);
        $recipe['mainInterest'] = $this->Recipe_model->get_interest($recipe);


        $this->load->view('./_templates/header',$index);
        $this->load->view('./home/index', $recipe);
        $this->load->view('./_templates/footer');
    }
}