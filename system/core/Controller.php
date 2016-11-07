<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		EllisLab Dev Team
 * @copyright		Copyright (c) 2008 - 2014, EllisLab, Inc.
 * @copyright		Copyright (c) 2014 - 2015, British Columbia Institute of Technology (http://bcit.ca/)
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Application Controller Class
 *
 * This class object is the super class that every library in
 * CodeIgniter will be assigned to.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		EllisLab Dev Team
 * @link		http://codeigniter.com/user_guide/general/controllers.html
 */
class CI_Controller {

	private static $instance;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		self::$instance =& $this;

		// Assign all the class objects that were instantiated by the
		// bootstrap file (CodeIgniter.php) to local class variables
		// so that CI can run as one big super object.
		foreach (is_loaded() as $var => $class)
		{
			$this->$var =& load_class($class);
		}

		$this->load =& load_class('Loader', 'core');

		$this->load->initialize();
		
		log_message('debug', "Controller Class Initialized");
	}

	public static function &get_instance()
	{
		return self::$instance;
	}

	function singleFileUpload($uploadFileInfo, $uploadPath, $saveFileName, $fileMaxSize){

		$targetDir = $uploadPath; //이미지 저장경로
		$targetFile = $targetDir.basename($saveFileName); //경로와 파일을붙여준다!!
		$imageFileType = pathinfo($targetFile,PATHINFO_EXTENSION);//확장자를 때준다.


		$check = getimagesize($uploadFileInfo["tmp_name"]); //이미지 크기를 가져오는 내장함수
		if($check != false) { //파일 이미지크기가 있을때!
			$returnArr['msg'][0] = "File is an image - " . $check["mime"] . ".";
			$returnArr['uploadOk'] = 1;
		} else {
			$returnArr['msg'][0] = "File is not an image.";
			$returnArr['uploadOk'] = 0;
		}


		if (file_exists($targetFile)) { //파일이나 디렉토리가 존재하는지 여부 판별, 존재하면 true반환
			$returnArr['msg'][1] = "Sorry, file already exists.";
			$returnArr['uploadOk'] = 0;
		}


		if ($uploadFileInfo["size"] > $fileMaxSize) { //업로드한 파일사이즈가 최대사이즈보다 클때
			$returnArr['msg'][2] = "Sorry, your file is too large.";
			$returnArr['uploadOk'] = 0;
		}


		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" //이미지확장자가 아닐때
				&& $imageFileType != "gif" ) {
			$returnArr['msg'][3] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			$returnArr['uploadOk'] = 0;
		}


		if ($returnArr['uploadOk'] == 0) {
			$returnArr['msg'][4] = "Sorry, your file was not uploaded."; //위에중에 하나라도 0이있으면 파일없로드실패!
		} else { //임시저장소에 파일주소와 파일이름을붙인 경로를 옮긴다
			if (move_uploaded_file($uploadFileInfo["tmp_name"], $targetFile)) {//업로드 파일을 새로운위치로 옮긴다
				$returnArr['msg'][5] = "The file ". basename( $uploadFileInfo["name"]). " has been uploaded.";
			} else {
				$returnArr['msg'][5] = "Sorry, there was an error uploading your file.";
			}
		}

		return $returnArr;
	}
}
// END Controller class

/* End of file Controller.php */
/* Location: ./system/core/Controller.php */