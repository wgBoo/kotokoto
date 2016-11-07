<?php

class Mybook_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function getOrderList($uno){
        $sql = "SELECT * FROM normaluser n, ordering o, orderlist ol, recipe r
                WHERE n.uno = '$uno' AND n.nuno = o.nuno AND o.ono = ol.ono
                AND ol.rno = r.rno
                ";
        $query = $this->db->query($sql);

        return $query->result();
    }

    function getRecipeList($id){
        $sql="select *
              from diary d, recipe r, user u , normaluser n
              where d.rno = r.rno AND d.nuno = n.nuno AND n.uno = u.uno
              and u.uid = '$id';
              ";

        $query = $this->db->query($sql);

        return $query->result();
    }

    function diaryInfo($uno){
        $sql = "SELECT * FROM user u, normaluser n, diary d, picturecomment p,
                recipe r
                WHERE u.uno = '$uno' AND u.uno = n.uno AND n.nuno = d.nuno
                AND d.dno = p.dno AND d.rno = r.rno ORDER BY d.dno DESC";
        $query = $this->db->query($sql);

        return $query->result();
    }

    function orderStatus($uid){
        $sql= "SELECT * from user u, normaluser n, ordering o, orderlist ol,recipe r
               where u.uno = n.uno
               AND n.nuno = o.nuno
               AND o.ono = ol.ono
               AND ol.rno = r.rno
               AND u.uid = '$uid'
               GROUP BY r.rname;
              ";

        $query = $this->db->query($sql);



        return $query->result();
    }

    function getNuno($uno){
        $sql = "select nuno from normaluser where uno = '$uno'";
        $query = $this->db->query($sql);

        return $query->row();
    }

    function getAutoIncrementNum(){
        return mysql_insert_id();
    }

    function insertDiary($nuno,$ono,$rno){
        $sql = "INSERT INTO diary (ono, nuno, rno)
                VALUES ('$ono','$nuno','$rno')";
        $this->db->query($sql);

        $dno = $this->getAutoIncrementNum();

        return $dno;
    }

    function insertFile($dno,$saveFileNameWithExt){
        $sql = "INSERT INTO picturecomment(dno,pcname)
                VALUES('$dno', '$saveFileNameWithExt')";
        $this->db->query($sql);

        $pcno = mysql_insert_id();
        return $pcno;
    }

    function diaryModifyComment($key,$comment){
        $sql = "UPDATE picturecomment p, diary d SET d.duday = NOW() ,p.pccontent = '$comment'
                WHERE p.pcno = '$key' AND p.dno = d.dno";
        $this->db->query($sql);
    }

    function diaryPcInfo($dno){
        $sql = "select * from picturecomment where dno = '$dno'";
        $query = $this->db->query($sql);
        return $query->result();
    }

    function diaryDelete($uno){
        $sql = "DELETE d,p FROM user u, normaluser n, diary d, picturecomment p
                WHERE u.uno = '$uno' AND u.uno = n.uno AND n.nuno = d.nuno
                AND d.dno = p.dno";
        $this->db->query($sql);
    }

    function diaryPageDelete($pcno){
        $sql = "DELETE d,p FROM diary d, picturecomment p
                WHERE d.dno = p.dno AND pcno='$pcno'";
        $this->db->query($sql);
    }

    function cancelBtnImgDelete1($pcname){
        $sql = "DELETE d FROM diary d, picturecomment p
                WHERE d.dno = p.dno AND pcname='$pcname'";
        $this->db->query($sql);
    }

    function cancelBtnImgDelete2($pcname){
        $sql = "DELETE FROM picturecomment
                WHERE pcname = '$pcname'";
        $this->db->query($sql);
    }

    //안드로이드 레시피 이름 가져오기
    function getRname($uid){
        $sql= "select DISTINCT r.rname from user u, normaluser n, ordering o, orderlist ol,recipe r
              where u.uid = '$uid' AND u.uno = n.uno AND n.nuno = o.nuno
              AND o.ono = ol.ono AND ol.rno = r.rno;
              ";

        $query = $this->db->query($sql);

        return $query->result();
    }

    // 갤러리 사진 insert
    function galleryImageInsert($dno,$saveFileName,$comment){

        $sql = "insert into picturecomment(dno, pcname, pccontent) values('$dno', '$saveFileName', '$comment');";
        $this->db->query($sql);

    }

    function getUno($userid){
        $sql = "select * from user where uid= '$userid'";
        $query = $this->db->query($sql);

        return $query->row();
    }

    function permission($permission,$uno){
        $sql = "UPDATE user SET uprivacy = $permission
                WHERE uno = $uno";
        $result = $this->db->query($sql);
        return $result;
    }
}
