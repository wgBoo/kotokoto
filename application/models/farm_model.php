<?php

class Farm_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    // 농장소개 입력
    public function write_farm_board($data)
    {
        $sql = "INSERT INTO farm (uno, fname, farmer, fintro, flocation, fphone, fcolor)
                VALUES ({$data['uno']}, '{$data['fname']}', '{$data['farmer']}', '{$data['fintro']}', '{$data['flocation']}', '{$data['fphone']}', '{$data['fcolor']}')";

        $this->db->query($sql);

        $last_id = $this->db->insert_id();

        return $last_id;
    }
    // 유저정보 출력
    public function get_user_info($user_id)
    {
        $sql = "SELECT *
                FROM user
                WHERE uid = '$user_id'";

        $query = $this->db->query($sql);

        return $query->row();
    }
    // 농장사진 입력
    public function write_fpicture_board($fno, $pic_name)
    {
        $sql = "INSERT INTO fpicture (fno, fpname)
                VALUES ({$fno}, '{$pic_name}')";

        $this->db->query($sql);
    }
    // 농장정보 출력
    public function get_farm_info($uno)
    {
        $sql = "SELECT *
                FROM farm f, fpicture p
                WHERE f.fno = p.fno
                AND f.uno = {$uno}";

        $query = $this->db->query($sql);

        return $query->row();
    }
    // 농장소개 수정
    public function modify_farm_board($data)
    {
        $sql = "UPDATE farm SET fname = '{$data['fname']}', fintro = '{$data['fintro']}', flocation = '{$data['flocation']}', farmer = '{$data['farmer']}'
                WHERE fno = {$data['fno']}";

        $this->db->query($sql);
    }
    // 농장사진 수정
    public function modify_fpicture_board($fpname, $pic_name)
    {
        $sql = "UPDATE fpicture SET fpname = '$pic_name'
                WHERE fpname = '$fpname'";

        $this->db->query($sql);
    }
    // 농장소개 삭제
    public function delete_farm_board($fno)
    {
        $sql = "DELETE FROM farm
                WHERE fno = $fno";

        $this->db->query($sql);
    }
    // 작물소개 입력
    public function write_crop_board($data)
    {
        $sql = "INSERT INTO crops (fno, cname, charvest, cstock, cintro, cdate)
                VALUES ({$data['fno']}, '{$data['cname']}', '{$data['charvest']}', '{$data['cstock']}', '{$data['cintro']}', now())";

        $this->db->query($sql);

        $last_id = $this->db->insert_id();



        return $last_id;
    }
    // 작물사진 입력
    public function write_cpicture_board($cno, $pic_name)
    {
        $sql = "INSERT INTO cpicture (cno, cpname)
                VALUES ({$cno}, '{$pic_name}')";

        $this->db->query($sql);
    }
    // 작물정보 출력 기본(등록↑)
    public function get_crops_info($fno)
    {
        $sql = "SELECT *
                FROM crops c, cpicture p
                WHERE c.cno = p.cno
                AND c.fno = $fno
                ORDER BY c.cdate DESC";

        $query = $this->db->query($sql);

        return $query->result();
    }
    // 작물정보 출력 모드
    public function get_crops_info_mode($fno, $mode)
    {
        $sql = "SELECT *
                FROM crops c, cpicture p
                WHERE c.cno = p.cno
                AND c.fno = $fno ";

        $sql_mode = null;

        switch($mode)
        {
            case 1:
                $sql_mode = "ORDER BY c.cdate DESC";
                break;
            case 2:
                $sql_mode = "ORDER BY c.cdate ASC";
                break;
            case 3:
                $sql_mode = "ORDER BY c.cname ASC";
                break;
            case 4:
                $sql_mode = "ORDER BY c.cname DESC";
                break;
            case 5:
                $sql_mode = "ORDER BY c.cstock DESC";
                break;
            case 6:
                $sql_mode = "ORDER BY c.cstock ASC";
                break;
            default:
                break;
        }
        $sql = $sql.$sql_mode;

        $query = $this->db->query($sql);

        return $query->result();
    }

    // 작물하나 출력
    public function get_crop_info($cno)
    {
        $sql = "SELECT *
                FROM crops c, cpicture p
                WHERE c.cno = p.cno
                AND c.cno = {$cno}";

        $query = $this->db->query($sql);

        return $query->row();
    }

    // 작물정보 삭제
    public function delete_crop($cno)
    {
        $sql = "DELETE FROM crops
                WHERE cno = $cno";

        $this->db->query($sql);

        $sql = "DELETE FROM cpicture
                WHERE cno = $cno";

        $this->db->query($sql);
    }
    // 작물정보 수정
    public function modify_crop_board($data)
    {
        $sql = "UPDATE crops SET cname = '{$data['cname']}', charvest = '{$data['charvest']}', cstock = '{$data['cstock']}', cintro = '{$data['cintro']}'
                WHERE cno = {$data['cno']}";

        $this->db->query($sql);
    }
    // 직믈사진 수정
    public function modify_cpicture_board($cpname, $pic_name)
    {
        $sql = "UPDATE cpicture SET cpname = '{$pic_name}'
                WHERE cpname = '{$cpname}'";

        $this->db->query($sql);
    }
    // 작물재고 증가
    public function modify_cstock_crop_board($data)
    {
        $cstock = $data['cstock'];

        $sql = "UPDATE crops SET cstock = cstock + {$cstock}
                WHERE cno = {$data['cno']}";

        $this->db->query($sql);

        return $cstock;
    }
    // 발주 자세히보기 출력
    public function get_corder_info($cono)
    {
        $sql = "SELECT *
                FROM material m, crops c, corder o, cpicture p
                WHERE c.cno = m.cno
                AND c.cno = o.cno
                AND c.cno = p.cno
                AND o.cono = $cono";

        $query = $this->db->query($sql);

        return $query->row();
    }
    // 발주 메세지 출력
    public function get_corder_message_info($cono)
    {
        $sql = "SELECT *
                FROM comessage c, user u
                WHERE c.uno = u.uno
                AND c.cono = $cono";

        $query = $this->db->query($sql);

        return $query->result();
    }
    // 발주 리스트 출력
    public function get_hope_info()
    {
        $sql = "SELECT *
                FROM corder o, crops c
                WHERE o.cno = c.cno";

        $query = $this->db->query($sql);

        return $query->result();
    }
    // 발주 진행
    public function next_order_status($cono)
    {
        $ing = 1;

        $sql = "UPDATE corder SET costatus = costatus + $ing
                WHERE cono = $cono";

        $this->db->query($sql);
    }
    // 발주 중지
    public function fail_order_status($cono)
    {
        $sql = "UPDATE corder SET costatus = 5
                WHERE cono = $cono";

        $this->db->query($sql);
    }
    // 발주 메세지 입력
    public function write_corder_content($data, $uno)
    {
        $sql = "INSERT INTO comessage (uno, cono, comcontent, comday)
                VALUES ({$uno}, {$data['cono']}, '{$data['comcontent']}', now())";

        $this->db->query($sql);
    }

    public function get_admin_order_info($fno)
    {
        $sql = "SELECT *
                FROM corder o, crops c, cpicture p, farm f
                WHERE o.cno = c.cno
                AND c.cno = p.cno
                AND f.fno = c.fno
                AND o.costatus IN (1, 3)
                AND f.fno = {$fno}
                ORDER BY o.coday DESC, cono DESC";

        $query = $this->db->query($sql);

        return $query->result();
    }
    // 발주 현황 출력2
    public function get_admin_order_info2($fno)
    {
        $sql = "SELECT *
                FROM corder o, crops c, cpicture p, farm f
                WHERE o.cno = c.cno
                AND c.cno = p.cno
                AND f.fno = c.fno
                AND o.costatus IN (0, 2)
                AND f.fno = {$fno}
                ORDER BY o.coday DESC, cono DESC";

        $query = $this->db->query($sql);

        return $query->result();
    }
    // 발주 현황 출력3
    public function get_admin_order_info3($fno)
    {
        $sql = "SELECT *
                FROM corder o, crops c, cpicture p, farm f
                WHERE o.cno = c.cno
                AND c.cno = p.cno
                AND f.fno = c.fno
                AND o.costatus = 4
                AND f.fno = {$fno}
                ORDER BY o.coday DESC, cono DESC";

        $query = $this->db->query($sql);

        return $query->result();
    }
    // 발주 현황 출력3
    public function get_admin_order_info4($fno)
    {
        $sql = "SELECT *
                FROM corder o, crops c, cpicture p, farm f
                WHERE o.cno = c.cno
                AND c.cno = p.cno
                AND f.fno = c.fno
                AND o.costatus = 5
                AND f.fno = {$fno}
                ORDER BY o.coday DESC, cono DESC";

        $query = $this->db->query($sql);

        return $query->result();
    }
    // 메시지 전체 조회
    public function select_message()
    {
        $sql = "SELECT *
                FROM comessage c, corder co
                WHERE c.cono = co.cono
                ORDER BY c.comday DESC, c.comno DESC";

        $query = $this->db->query($sql);

        return $query->result();
    }
    // 거래상태별 발주 현황
    public function corder_status($fno)
    {
        $sql = "SELECT co.costatus, count(co.costatus) count
                FROM corder co, farm f, crops c
                WHERE co.costatus = 4
                AND co.cno = c.cno
                AND f.fno = c.fno
                AND f.fno = {$fno}
                GROUP BY costatus
                ORDER BY costatus ASC";

        $query = $this->db->query($sql);

        return $query->result();
    }
    // 거래상태별 발주 현황2
    public function corder_status2($fno)
    {
        $sql = "SELECT co.costatus, count(co.costatus) count
                FROM corder co, farm f, crops c
                WHERE co.costatus != 5
                AND co.cno = c.cno
                AND f.fno = c.fno
                AND f.fno = {$fno}
                GROUP BY costatus
                ORDER BY costatus ASC";

        $query = $this->db->query($sql);

        return $query->result();
    }
    // 거래상태별 발주 현황3
    public function corder_status3($fno)
    {
        $sql = "SELECT co.costatus, count(co.costatus) count
                FROM corder co, farm f, crops c
                WHERE co.costatus = 5
                AND co.cno = c.cno
                AND f.fno = c.fno
                AND f.fno = {$fno}
                GROUP BY costatus
                ORDER BY costatus ASC";

        $query = $this->db->query($sql);

        return $query->result();
    }
    // 사진 이름
    public function get_fpname_info($fno)
    {
        $sql = "SELECT fpname
                FROM fpicture
                WHERE fno = {$fno}";

        $query = $this->db->query($sql);

        return $query->row();
    }
    // 농장1개의 총 량
    public function farm_mstock($fno)
    {
        $sql = "SELECT f.fno, f.fname, f.fcolor, c.cname, SUM(m.mstock) smt
                FROM farm f, material m, crops c
                WHERE f.fno = c.fno
                AND c.cno = m.cno
                AND f.fno = {$fno}";

        $query = $this->db->query($sql);

        return $query->row();
    }
    // 농장 정보
    public function crops_stock($fno)
    {
        $sql = "SELECT *
                FROM farm f, crops c, material m
                WHERE f.fno = c.fno
                AND c.cno = m.cno
                AND f.fno = {$fno}
                ORDER BY c.cname ASC";

        $query = $this->db->query($sql);

        return $query->result();
    }
}