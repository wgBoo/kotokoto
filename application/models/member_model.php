<?php

class Member_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    public function write_user_board($data)
    {
        $sql = "INSERT INTO user (uid, upwd)
                VALUES ('{$data['uid']}', '{$data['upwd']}')";

        $this->db->query($sql);

        $last_id = $this->db->insert_id();

        $now = now();

        $sql = "INSERT INTO normaluser (uno, sex, old, email, joinday, pwday)
                VALUES ({$last_id}, {$data['sex']}, {$data['old']}, '{$data['email']}', '{$now}', '{$now}')";

        $this->db->query($sql);
    }
    public function get_user_info($data)
    {
        $sql = "SELECT *
                FROM user
                WHERE uid = '{$data['uid']}'";

        $query = $this->db->query($sql);

        return $query->row();
    }

    public function getNormaluserNum($uno){
        $sql = "SELECT nuno FROM normaluser WHERE uno = '$uno'";

        $query = $this->db->query($sql);
        return $query->row();
    }

    public function getModifyInfo($uno){
        $sql = "SELECT * FROM user u, normaluser n
                WHERE u.uno = '$uno' AND u.uno = n.uno";
        $query = $this->db->query($sql);

        return $query->result();
    }

    public function getModifyInterestInfo($uno){
        $sql = "SELECT * FROM user u, normaluser n, imanage im, interest i
                WHERE u.uno = '$uno' AND u.uno = n.uno AND n.nuno = im.nuno
                AND im.ino = i.ino";
        $query = $this->db->query($sql);

        return $query->result();
    }

    public function getInterestInfo(){
        $sql = "SELECT * FROM interest";
        $query = $this->db->query($sql);

        return $query->result();
    }

    public function deleteInterest($uno){
        $sql = "DELETE i FROM imanage i, normaluser n WHERE n.uno = '$uno' AND n.nuno = i.nuno";
        $this->db->query($sql);
    }

    public function memberModify($uno,$modifyInfo){
        $sql = "UPDATE user u, normaluser n SET u.upwd= '{$modifyInfo['pw']}',
                n.email = '{$modifyInfo['email']}', n.sex = '{$modifyInfo['sex']}',
                n.old = '{$modifyInfo['old']}'
                WHERE u.uno = '$uno' AND n.uno = u.uno
                ";
        $this->db->query($sql);
    }

    public function insertInterest($nuno,$ino){
        $sql = "INSERT INTO imanage (ino, nuno)
                VALUES ('$ino', '$nuno')";
        $this->db->query($sql);
    }

    public function memberInfoDelete($uno){
        $sql = "DELETE FROM user WHERE uno = '$uno'";
        $this->db->query($sql);
    }
}