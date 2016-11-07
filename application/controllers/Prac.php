<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Prac extends CI_Controller
{

  function __construct()
  {
      parent::__construct();

  }
  public function index()
  {
      require_once "prac.html";
  }

  public function highchart()
  {
    require_once "highchart.html";
  }

}
