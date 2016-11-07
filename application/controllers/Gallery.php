
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gallery extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('Mybook_model');
    }

    public function index()
    {
      
      $content = isset($_REQUEST['contents']) ? $_REQUEST['contents'] : 'failed';
      $file_path = "./public/assets/img/diary/";

      if($content){
        
        $file_path = $file_path.basename($_FILES['uploaded_file']['name']);
        if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $file_path)) {
            echo "1".$content."!!!!!!!";
            $this -> Mybook_model -> prac($content);
        }
        else {
            echo "file_uploaded failed";    
        }
      }
      else {
          echo "text failed";
      //echo $_FILES['uploaded_file']['name'];    
     /**
      $file_path = $file_path . basename($_FILES['uploaded_file']['name']);
     
              if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $file_path)) {
                          echo "1"."$content "." "."!!!!!!!!!!!!!!!";
                      } 
              else{
                       echo "ha...";
                }
      }
      **/
     }
  }
}
