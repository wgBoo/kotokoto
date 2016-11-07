<?php
session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Mypage extends CI_Controller
{

    function __construct()
    {

        parent::__construct();
        $this->load->database();
        $this->load->model('Mybook_model');
    }

    public function order_check()
    {
        $uno = isset($_SESSION['uno']) ? $_SESSION['uno']: null;

        $result['orderList'] = $this->Mybook_model->getOrderList($uno);

        $sidebar['sidebar'] = 'sidebar';

        $this->load->view('./_templates/header',$sidebar);
        $this->load->view('./_templates/Laside');
        $this->load->view('./mypage/order_check',$result);
        $this->load->view('./_templates/footer',$sidebar);
    }

    public function turnjs_insertAfterView($dno){ //insert하고나서 view-ajax에서사용되는함수
        $diaryInfo['diaryInfo'] = $this->Mybook_model->diaryInfo($dno);
        $this->load->view('./turnjs/page_insertAfterView',$diaryInfo);
    }

    public function diary_insert(){
        //일기 추가 구별
        $addDistinction = isset($_REQUEST['addDistinction']) ? $_REQUEST['addDistinction'] : null;

        //폰갤러리사진
        $galleryImage = isset($_REQUEST['galleryImage'])?$_REQUEST['galleryImage'] : null;

        $uno = isset($_SESSION['uno']) ? $_SESSION['uno']: null;
        $diary_write = isset($_REQUEST['diary_write']) ? $_REQUEST['diary_write']:null;

        if($diary_write){
            $no = isset($_REQUEST['no']) ? $_REQUEST['no']:null;
            $nums = explode(",",$no);
            $rno = $nums[0];
            $ono = $nums[1];

            $nuno = $this->Mybook_model->getNuno($uno); //nuno 함수써서 가져오기


            $dno = $this->Mybook_model->insertDiary($nuno->nuno,$ono,$rno);

            $mybookImgSavePath = "./public/assets/img/diary/";
            $mybookVideoSavePath = "./public/assets/video/";
            $fileMaxSize = 2000000;

            //폰갤러리 등록사진이 있으면
            if($galleryImage){
                $k = 0;
                foreach ($galleryImage as $row) {
                    $pcno = $this->Mybook_model->insertFile($dno, $row); //고유한 파일이름을 저장한다.

                    if ($addDistinction) {
                        $diaryInfo['addDistinction'] = $addDistinction;
                        $diaryInfo['addImageName'][$k] = $pcno;
                    }
                    $k++;
                }

            }

            //비디오를 업로드했으면
            if($_FILES['diary_video']['name'][0]) {
                for ($h = 0; $h < count($_FILES['diary_video']['name']); $h++) {

                    $upVideoFileInfo['name'] = $_FILES['diary_video']['name'][$h];
                    $upVideoFileInfo['tmp_name'] = $_FILES['diary_video']['tmp_name'][$h]; //임시저장소
                    $upVideoFileInfo['type'] = $_FILES['diary_video']['type'][$h];
                    $upVideoFileInfo['size'] = $_FILES['diary_video']['size'][$h];
                    $upVideoFileInfo['error'] = $_FILES['diary_video']['error'][$h];
                    //$_FILES는 최근에 클라이언트에서 서버로 업로드한 파일의 정보를 받는 환경변수이다.


                    if ($upVideoFileInfo['name'] && $upVideoFileInfo['error'] == 0) { //값을 잘 받았고 에러가 없으면

                        $VideoFileType = pathinfo($upVideoFileInfo['name'], PATHINFO_EXTENSION); //확장자 추출

                        $saveFileName = 'V' . date("His") . strval($ono) . "_" . strval($h); // 고유값을 붙여 파일이름을생성!
                        $saveFileNameWithExt = $saveFileName . "." . strval($VideoFileType); // C12.jpg같은 완전한 파일이름 생성!
                        //파일이름에 특수문자가있으면 저장이안된다. ㅜㅜㅜ
                        $retArr = move_uploaded_file($upVideoFileInfo['tmp_name'], $mybookVideoSavePath . $saveFileNameWithExt);

                        //$reArr2 업로드한 결과 메세지값을 담고있다.
                        if ($retArr) {
                            $pcno = $this->Mybook_model->insertFile($dno, $saveFileNameWithExt); //고유한 파일이름을 저장한다.
                            if ($addDistinction) {
                                if (!isset($k)) {
                                    $k = 0;
                                }
                                $diaryInfo['addDistinction'] = $addDistinction;
                                $diaryInfo['addImageName'][$h + $k] = $pcno;
                            }
                        }
                    }
                }
            }

            //이미지를 업로드했으면
                for ($i = 0; $i < count($_FILES['diary_image']['name']); $i++) {

                    $upImgFileInfo['name'] = $_FILES['diary_image']['name'][$i];
                    $upImgFileInfo['tmp_name'] = $_FILES['diary_image']['tmp_name'][$i]; //임시저장소
                    $upImgFileInfo['type'] = $_FILES['diary_image']['type'][$i];
                    $upImgFileInfo['size'] = $_FILES['diary_image']['size'][$i];
                    $upImgFileInfo['error'] = $_FILES['diary_image']['error'][$i];
                    //$_FILES는 최근에 클라이언트에서 서버로 업로드한 파일의 정보를 받는 환경변수이다.


                    if ($upImgFileInfo['name'] && $upImgFileInfo['error'] == 0) { //값을 잘 받았고 에러가 없으면

                        $imgFileType = pathinfo($upImgFileInfo['name'], PATHINFO_EXTENSION); //확장자 추출

                        $saveFileName = date("His") . strval($ono) . "_" . strval($i); // 고유값을 붙여 파일이름을생성!
                        $saveFileNameWithExt = $saveFileName . "." . strval($imgFileType); // C12.jpg같은 완전한 파일이름 생성!
                        //파일이름에 특수문자가있으면 저장이안된다. ㅜㅜㅜ
                        $retArr2 = $this->singleFileUpload($upImgFileInfo, $mybookImgSavePath, $saveFileNameWithExt, $fileMaxSize);

                        //$reArr2 업로드한 결과 메세지값을 담고있다.
                        if ($retArr2['uploadOk']) {
                            $pcno = $this->Mybook_model->insertFile($dno, $saveFileNameWithExt); //고유한 파일이름을 저장한다.
                            if ($addDistinction) {
                                if(!isset($k)){
                                    $k = 0;
                                }
                                if(!isset($h)){
                                    $h = 0;
                                }
                                $diaryInfo['addDistinction'] = $addDistinction;
                                $diaryInfo['addImageName'][$i+$k+$h] = $pcno;
                            }
                        }
                    }
                }

        };

        $diaryInfo['diaryInfo'] = $this->Mybook_model->diaryInfo($uno);
        $sidebar['sidebar'] = 'sidebar';

        $this->load->view('./_templates/header',$sidebar);
        $this->load->view('./_templates/Laside');
        $this->load->view('./mypage/mybook_insert_comment',$diaryInfo);
        $this->load->view('./_templates/footer', $sidebar);
    }


    public function diary_insert_view() //처음입력메서드
    {
        $gallery = $this->get_gallery_fileOfId(); //갤러리 이미지 불러오기
        $uid = isset($_SESSION['loginID']) ? $_SESSION['loginID'] : null;

        $orderStatus['orderStatus'] = $this->Mybook_model->orderStatus($uid);
        $orderStatus['gallery'] = $gallery;
        $sidebar['sidebar'] = 'sidebar';


        $this->load->view('./_templates/header', $sidebar);
        $this->load->view('./_templates/Laside');
        $this->load->view('./mypage/mybook_insert', $orderStatus);
        $this->load->view('./_templates/footer', $sidebar);
    }


    public function diary_Info(){
        $uno = isset($_SESSION['uno']) ? $_SESSION['uno']: null;
        $diaryInfo['diaryInfo'] = $this->Mybook_model->diaryInfo($uno);
        $sidebar['sidebar'] = 'sidebar';

        $this->load->view('./_templates/header',$sidebar);
        $this->load->view('./_templates/Laside');
        $this->load->view('./mypage/mybook_view',$diaryInfo);
        $this->load->view('./_templates/footer', $sidebar);

    }

    public function diary_insert_comment(){
        $insert_comment = isset($_REQUEST['insert_comment']) ? $_REQUEST['insert_comment']:null;
        if($insert_comment){
            $diary_comment = isset($_REQUEST['diary_comment']) ? $_REQUEST['diary_comment']:null;
            $diary_comment_keys = array_keys($diary_comment); //key값을가져옴
            foreach($diary_comment_keys as $key){
                if($diary_comment[$key]) {
                    $this->Mybook_model->diaryModifyComment($key, $diary_comment[$key]);
                }
            }
        }
        $this->diary_Info();
    }

    public function diary_modify_view(){
        $uno = isset($_SESSION['uno']) ? $_SESSION['uno']: null;
        $diaryInfo['diaryInfo'] = $this->Mybook_model->diaryInfo($uno);
        $sidebar['sidebar'] = 'sidebar';

        $this->load->view('./_templates/header',$sidebar);
        $this->load->view('./_templates/Laside');
        $this->load->view('./mypage/mybook_modify_view',$diaryInfo);
        $this->load->view('./_templates/footer', $sidebar);
    }

    public function diary_modify()
    {
        $diaryModify = isset($_REQUEST['diaryModify']) ? $_REQUEST['diaryModify'] : null;
        $mybookImgSavePath = "./public/assets/img/diary/";
        $mybookVideoSavePath = "./public/assets/video/";

        if ($diaryModify) {
            //$diary_image변수는 이미지와 비디오 전부 담겨있다.
            $diary_image = isset($_REQUEST['diary_image']) ? $_REQUEST['diary_image'] : null;
            $diary_comment = isset($_REQUEST['diary_comment']) ? $_REQUEST['diary_comment'] : null;

            //삭제하는 것만 배열안에 남김 , 나머지는 전부 삭제
            foreach ($diary_image as $k => $v) {
                if ($v == '') {
                    unset($diary_image[$k]);
                }
            }

            //데이터, 이미지 모두 삭제
            if ($diary_image) {
                $diary_image_keys = array_keys($diary_image); //키값을 뽑아줌.

                foreach ($diary_image_keys as $key) {
                    //비디오일때 사진일때 구분해서 삭제
                    if(substr($diary_image[$key],0,1) == 'V'){
                        unlink($mybookVideoSavePath.$diary_image[$key]);
                    }else{
                        unlink($mybookImgSavePath.$diary_image[$key]);
                    }

                    //DB값 삭제
                    $this->Mybook_model->diaryPageDelete($key);
                }
            }

            //코멘트삽입
            $diary_comment_keys = array_keys($diary_comment);
            foreach ($diary_comment_keys as $key) {
                $this->Mybook_model->diaryModifyComment($key, $diary_comment[$key]);
            }

            $this->diary_Info();
        }

    }

    public function diary_delete(){
        $uno = isset($_SESSION['uno']) ? $_SESSION['uno']: null;
        $diaryInfo = $this->Mybook_model->diaryInfo($uno);

        foreach($diaryInfo as $row){
            $FileExists = file_exists('./public/assets/img/diary/'.$row->pcname);
            if($FileExists) {
                unlink('./public/assets/img/diary/'.$row->pcname);
            }
        }
        $this->Mybook_model->diaryDelete($uno);
        $this->diary_Info();
    }

    public function diary_add_view(){
        $gallery = $this->get_gallery_fileOfId(); //갤러리 이미지 불러오기

        $uid = isset($_SESSION['loginID']) ? $_SESSION['loginID'] : null;
        $orderStatus['orderStatus'] = $this->Mybook_model->orderStatus($uid);
        $orderStatus['gallery'] = $gallery;
        $orderStatus['addDistinction'] = 'addDistinction';
        $sidebar['sidebar'] = 'sidebar';


        $this->load->view('./_templates/header',$sidebar);
        $this->load->view('./_templates/Laside');
        $this->load->view('./mypage/mybook_insert',$orderStatus);
        $this->load->view('./_templates/footer',$sidebar);
    }


    public function cancelDelete(){ //취소버튼을 눌렀을때 이미지 삭제
        $user_id = isset($_SESSION['loginID']) ? $_SESSION['loginID'] : null;
        $searchName = $user_id;

        $pcname = isset($_SESSION['pcname']) ? $_SESSION['pcname'] : null;

        $this->Mybook_model->cancelBtnImgDelete1($pcname[0]); //diary dno같은것삭제
        foreach($pcname as $row) {
            if(strpos($row, $searchName) == false) { //해당문자열을 발견하지 못했으면
                $FileExists = file_exists('./public/assets/img/diary/' . $row);
                if ($FileExists) {
                    unlink('./public/assets/img/diary/' . $row);
                }

                $this->Mybook_model->cancelBtnImgDelete2($row); //picturecomment 사진정보삭제
            }
        }
        unset($_SESSION['pcname']); //세션삭제

        $this->diary_Info();
    }

    //구매목록 아이디를 이용해서 레시피목록을가져와 안드로이드로보여줌
    public function get_orderStatus($uid){
        $orderStatus = $this->Mybook_model->orderStatus($uid);

        echo json_encode($orderStatus);
    }

    //휴대폰 사진촬영시 사진,코멘트 다이어리에등록
    public function gallery_image_save()
    {
        //db를다녀와서 rname을 구할 수 있으면 rno와 ono도 구할수있는것아닌가?
        //그래서 원래 웹에서 insert시키는것 처럼
        $uno = isset($_REQUEST['uno']) ? $_REQUEST['uno']:null;
        $rno = isset($_REQUEST['rno']) ? $_REQUEST['rno']:null;
        $ono = isset($_REQUEST['ono']) ? $_REQUEST['ono']:null;
        $comment = isset($_REQUEST['contents']) ? $_REQUEST['contents'] : 'failed';
        $file_path = "./public/assets/img/diary/";


        $nuno = $this->Mybook_model->getNuno($uno); //nuno 함수써서 가져오기


        $dno = $this->Mybook_model->insertDiary($nuno->nuno,$ono,$rno);

        if ($comment) {
            //기본폰트,크기 자동적용
            $newcomment = '<p><span style="font-size:18px"><span style="font-family:TAKUMIYFONTMINI">'.$comment.'</span></span></p>';

            $saveFileName = basename($_FILES['uploaded_file']['name']);
            $file_path = $file_path.$saveFileName;

            if (move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $file_path)) {

                $this->image_rotate($file_path); //이미지리사이징
                //이미지이름,코멘트 저장
                $this->Mybook_model->galleryImageInsert($dno,$saveFileName,$newcomment);

            } else {
                echo "file_uploaded failed";
            }
        } else {
            echo "text failed";
        }
    }

    //파일이름에 해당아이디가 포함된것을 반환
    public function get_gallery_fileOfId(){
        $user_id = isset($_SESSION['loginID']) ? $_SESSION['loginID'] : null;
        $searchName = $user_id; //원래는 유저아이디를 받아야한다 - 나중에 수정!!!!
        $categoryName = $this->get_file_names();

        //ajax값 받기
        /* $galleryAjax = isset($_REQUEST['gallery']) ? $_REQUEST['gallery']: null;*/
        if($categoryName) {
            foreach ($categoryName as $Name) {
                if (strpos($Name, $searchName) !== false)
                    $gallery[] = $Name; // 아이디값이 포함된 파일명을 담는다
            }
        }

        $gallery = isset($gallery) ? $gallery : null; //아무것도없을때 오류방지

        return $gallery;
    }

    //디렉토리내 파일명 가져오기
    public function get_file_names() {
        $directory = './public/assets/img/diary/';
        $handler = opendir($directory);

        while ($file = readdir($handler)) {
            if ($file != '.' && $file != '..' && is_dir($file) != '1') {
                $results[] = $file;
            }
        }
        $results = isset($results) ? $results : null; //아무것도없을때 오류방지

        closedir($handler);

        return $results;
    }

    //폰이미지 리사이징
    public function image_rotate($file_path){

        //File rotation
        $degrees = 270;

        //Content type
        header('Content-type: image/jpeg');

        //이미지만들고
        $source = imagecreatefromjpeg($file_path);

        //이미지돌리고
        $rotate = imagerotate($source, $degrees, 0);

        // 이미지저장
        imagejpeg($rotate,$file_path);

    }

    public function turnjs(){ //ajax에서사용되는함수
        $uno = isset($_SESSION['uno']) ? $_SESSION['uno']: null;
        $shareuno = isset($_SESSION['shareuno']) ? $_SESSION['shareuno']: null;

        if(isset($uno)) {
            $diaryInfo['diaryInfo'] = $this->Mybook_model->diaryInfo($uno);
        }else{
            $diaryInfo['diaryInfo'] = $this->Mybook_model->diaryInfo($shareuno);
        }

        $this->load->view('./turnjs/page',$diaryInfo);
    }


    //pdf 출력
    public function pdfinfo(){
        $html = isset($_REQUEST['pageHtml']) ? $_REQUEST['pageHtml']: null;

        $html = explode('<!--pdfcut-->',$html);

        $array1 = array('class="center-pic"','<span class="page-number" style="font-size: 15px">','</span><!---->','<!--cutstart-->','<!--cutend-->','<span style="font-size','</span></span>','<a',350,230);
        $array2   = array('align="center"','<!--','--><!--','<!--','-->','--><span style="font-size','</span></span><!--','<a style="color: #0a94e3"',390,220);

        $html = str_replace($array1,$array2,$html);

        $html[sizeof($html)-2] = str_replace('none','inline',$html[sizeof($html)-2]);

        //video가 들어간 코드 배열값 삭제
        $i = 0;
        foreach($html as $ml) {
                if (strpos($ml, 'video') !== false) {
                    unset($html[$i]);
                }elseif(strpos($ml,'vjs-default-skin') !== false){
                    unset($html[$i]);
                    $page['videocheck'] = 'video';
                }
            $i++;
        }


        end($html); //배열열내부포인터가 마지막 원소를 가리킴

        //마지막 목차를 0번째 인덱스로 옮김
        $html[0] = $html[key($html)];
        unset($html[key($html)]);

        ksort($html); //key값순으로 차례대로 정렬

        end($html); //배열열내부포인터가 마지막 원소를 가리킴

        //배열 재정렬
        $cnt = 0;
        for($j = 0; $j <= key($html) ; $j++){
            if(isset($html[$j])){
                $pagehtml[$cnt] = $html[$j];
                $cnt++;
            }
        }
        //exit(var_dump($pagehtml));
        $page['pagehtml'] = $pagehtml;
        $this->load->view('./mypage/tcpdf/pdf_view',$page);
    }

    public function sharepage($userid){
        //회원정보 가져오기
        $userInfo = $this->Mybook_model->getUno($userid);

        if($userInfo->uprivacy == 0){
                $diaryInfo['closed'] = 'closed';
        }
            //세션담기
            $_SESSION['shareuno'] = $userInfo->uno;
            $diaryInfo['diaryInfo'] = $this->Mybook_model->diaryInfo($userInfo->uno);

            $this->load->view('./_templates/header');
            $this->load->view('./mypage/mybook_share', $diaryInfo);
            $this->load->view('./_templates/footer');

    }

    public function uprivacyPermission(){
        $uno = isset($_SESSION['uno']) ? $_SESSION['uno']: null;
        $permission = isset($_REQUEST['permission']) ? $_REQUEST['permission'] : 0;
        $result = $this->Mybook_model->permission($permission,$uno);

        if($result){
            echo "true";
        }
    }

    public function exam(){
        $this->load->view('./mypage/tcpdf/exam');
    }


}
