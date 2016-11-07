<?php
session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Recipe extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->model('Recipe_model');
        $this->load->helper(array('form', 'url'));
    }

    public function best()
    {
        $recipe['bestRecipe'] = $this->Recipe_model->get_best_recipe();

        $this->load->view('./_templates/header');
        $this->load->view('./recipe/best', $recipe);
        $this->load->view('./_templates/footer');
    }

    public function all($lineup)
    {
        $recipe['allRecipe'] = $this->Recipe_model->get_recipe($lineup);

        $this->load->view('./_templates/header');
        $this->load->view('./recipe/all', $recipe);
        $this->load->view('./_templates/footer');

    }

    public function needs()
    {
        $user_id = isset($_SESSION['loginID']) ? $_SESSION['loginID'] : null;
        if ($user_id) {
            $recipe['needsRecipe'] = $this->Recipe_model->get_needs_recipe($user_id);
            $recipe['needsCrops'] = $this->Recipe_model->get_needs_crops($recipe);

        } else {
            $lineup = 0;
            $recipe['needsRecipe'] = null;
            $recipe['allRecipe'] = $this->Recipe_model->get_recipe($lineup);
        }
        $this->load->view('./_templates/header');
        $this->load->view('./recipe/needs', $recipe);
        $this->load->view('./_templates/footer');
    }

    public function detail($rno)
    {
        $recipe['detail'] = $this->Recipe_model->detail_recipe($rno);
        $recipe['crops'] = $this->Recipe_model->get_crops($rno);

        $this->load->view('./_templates/header');
        $this->load->view('./recipe/detail', $recipe);
        $this->load->view('./_templates/footer');
    }

    public function search()
    {

        $scontent = isset($_REQUEST['scontent']) ? ($_REQUEST['scontent']) : null;
        $first = substr($scontent, 0, 1);
        if ($first == "#") {
            $scontent = substr($scontent, 1);
        }

        $sgap = explode('#', $scontent);

        $recipe['searchRecipe'] = $this->Recipe_model->search_material($sgap);


        $this->load->view('./_templates/header');
        $this->load->view('./recipe/search', $recipe);
        $this->load->view('./_templates/footer');
    }

    public function get_farms()
    {
        $cname = isset($_REQUEST['checkcrops']) ? ($_REQUEST['checkcrops']) : null;
        $result['test'] = $this->Recipe_model->get_farms($cname);

        echo json_encode($result,JSON_UNESCAPED_UNICODE);
    }
    public function get_farminfor()
    {
        $fname = isset($_REQUEST['fname']) ? ($_REQUEST['fname']) : null;
        $result = $this->Recipe_model->get_farminfor($fname);

        echo json_encode($result,JSON_UNESCAPED_UNICODE);
    }

}