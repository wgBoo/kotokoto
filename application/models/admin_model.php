<?php

class Admin_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    // 노말유저 리스트 출력
    public function get_normal_users_info()
    {
        $sql = "SELECT *
                FROM user u, normaluser n
                WHERE u.uno = n.uno
                AND u.uclass = 2";

        $query = $this->db->query($sql);

        return $query->result();
    }

    // 유저 삭제
    public function delete_normal_user($uno)
    {
        $sql = "DELETE FROM user
                WHERE uno = $uno";

        $this->db->query($sql);
    }

    // 재고 현황 출력
    public function get_material_stock_info()
    {
        $sql = "SELECT *
                FROM material m, crops c, farm f, cpicture p
                WHERE m.cno = c.cno
                AND c.fno = f.fno
                AND c.cno = p.cno
                ORDER BY c.cname ASC";

        $query = $this->db->query($sql);

        return $query->result();
    }

    // 발주 현황 출력
    public function get_admin_order_info()
    {
        $sql = "SELECT *
                FROM corder o, crops c, cpicture p, farm f
                WHERE o.cno = c.cno
                AND c.cno = p.cno
                AND f.fno = c.fno
                AND o.costatus IN (1, 3)
                ORDER BY o.coday DESC, cono DESC";

        $query = $this->db->query($sql);

        return $query->result();
    }
    // 발주 현황 출력2
    public function get_admin_order_info2()
    {
        $sql = "SELECT *
                FROM corder o, crops c, cpicture p, farm f
                WHERE o.cno = c.cno
                AND c.cno = p.cno
                AND f.fno = c.fno
                AND o.costatus IN (0, 2)
                ORDER BY o.coday DESC, cono DESC";

        $query = $this->db->query($sql);

        return $query->result();
    }
    // 발주 현황 출력3
    public function get_admin_order_info3()
    {
        $sql = "SELECT *
                FROM corder o, crops c, cpicture p, farm f
                WHERE o.cno = c.cno
                AND c.cno = p.cno
                AND f.fno = c.fno
                AND o.costatus = 4
                ORDER BY o.coday DESC, cono DESC";

        $query = $this->db->query($sql);

        return $query->result();
    }
    // 발주 현황 출력3
    public function get_admin_order_info4()
    {
        $sql = "SELECT *
                FROM corder o, crops c, cpicture p, farm f
                WHERE o.cno = c.cno
                AND c.cno = p.cno
                AND f.fno = c.fno
                AND o.costatus = 5
                ORDER BY o.coday DESC, cono DESC";

        $query = $this->db->query($sql);

        return $query->result();
    }

    // 발주 자세히보기 출력
    public function get_corder_info($cono)
    {
        $sql = "SELECT *
                FROM material m, crops c, corder o, cpicture p, farm f
                WHERE c.cno = m.cno
                AND c.cno = o.cno
                AND c.cno = p.cno
                AND f.fno = c.fno
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

    // 발주 진행
    public function next_order_status($cono)
    {
        $ing = 1;

        $sql = "UPDATE corder SET costatus = costatus + $ing
                WHERE cono = $cono";

        $this->db->query($sql);
    }

    // 완료 후 재고 증가
    public function end_plus_mstock($cno, $stock)
    {
        $sql = "UPDATE material SET mstock = mstock + $stock
                WHERE cno = $cno";

        $this->db->query($sql);
    }

    // 발주 메세지 입력
    public function write_corder_content($data, $uno)
    {
        $sql = "INSERT INTO comessage (uno, cono, comcontent, comday)
                VALUES ({$uno}, {$data['cono']}, '{$data['comcontent']}', now())";

        $this->db->query($sql);
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

    // 발주를 위한 재료 하나의 정보
    public function get_material_info($mno)
    {
        $sql = "SELECT *
                FROM material m, crops c, farm f, fpicture fp, cpicture cp
                WHERE m.cno = c.cno
                AND c.fno = f.fno
                AND f.fno = fp.fno
                AND c.cno = cp.cno
                AND m.mno = $mno";

        $query = $this->db->query($sql);

        return $query->row();
    }

    // 주문리스트 출력
    public function get_order_list()
    {
        $sql = "SELECT *
                FROM ordering o , address a
                WHERE o.ano = a.ano";

        $query = $this->db->query($sql);

        return $query->result();
    }

    // 주문리스트 레시피 출력
    public function get_order_receipe_list()
    {
        $sql = "SELECT *
                FROM orderlist l, receipe r
                WHERE l.rno = r.rno";

        $query = $this->db->query($sql);

        return $query->result();
    }

    // 발주
    public function write_corder($data, $cno, $cstock)
    {
        $sql = "INSERT INTO corder (cno, costock, cotime, costatus)
                VALUES ({$cno}, {$cstock}, '{$data['cotime']}', 0)";

        $this->db->query($sql);
    }

    public function get_crops()
    {
        $this->db->select('*');
        $this->db->from('crops c');
        $this->db->join('farm f', 'c.fno = f.fno');
        $this->db->join('material m', 'c.cno = m.cno');
        $this->db->order_by("c.cname", "asc");
        $query = $this->db->get();

        return $query->result();
    }

    public function get_crop($mno)
    {
        $this->db->select('c.cname,f.fname, m.mno');
        $this->db->from('farm f');
        $this->db->join('crops c', 'f.fno = c.fno');
        $this->db->join('material m', 'c.cno = m.cno');
        $this->db->where('m.mno', $mno[0]);
        for ($i = 1; $i < count($mno); $i++) {
            $this->db->or_where('m.mno', $mno[$i]);
        }
        $query = $this->db->get();

        return $query->result();
    }

    public function insert_recipe($addRecipe)
    {
        $data = array(
            'rname' => $addRecipe['rname'],
            'rtime' => $addRecipe['rtime'],
            'rprice' => $addRecipe['rprice'],
            'rpicture' => $addRecipe['rpicture']
        );
        $this->db->insert('recipe', $data);
        $autoRecipe_num = $this->db->insert_id();
        return $autoRecipe_num;
    }

    public function modify_picture($pic_name, $rno){
        $data = array(
            'rpicture' => $pic_name
        );
        $this->db->where('rno', $rno);
        $this->db->update('recipe', $data);
    }

    public function insert_rmmanage($checkreciperm, $rno)
    {
        for ($i = 0; $i < count($checkreciperm['mno']); $i++) {
            $data = array(
                'rno' => $rno,
                'mno' => $checkreciperm['mno'][$i],
                'rmmstock' => $checkreciperm['rmmstock'][$i],
                'rmexclude' => 0
            );
            $this->db->insert('rmmanage', $data);
        }
        for ($i = 0; $i < count($checkreciperm['rmexclude']); $i++) {
            $data = array(
                'rmexclude' => 1
            );
            $this->db->where('mno', $checkreciperm['rmexclude'][$i]);
            $this->db->where('rno', $rno);
            $this->db->update('rmmanage', $data);
        }
    }

    public function select_interest()
    {
        $this->db->select('*');
        $this->db->from('interest');
        $query = $this->db->get();

        return $query->result();
    }

    public function insert_rimanage($rno, $ino)
    {
        for ($i = 0; $i < count($ino); $i++) {
            $data = array(
                'rno' => $rno,
              'ino' => $ino[$i]
            );
            $this->db->insert('rimanage' , $data);
        }
    }
    public function select_recipe(){
        $this->db->select('*');
        $this->db->from('recipe');
        $query = $this->db->get();

        return $query->result();
    }
    // 남 녀 비율 통계
    public function sex_rate()
    {
        $sql = "SELECT old, sex, count(*) cnt
                FROM normaluser
                GROUP BY old, sex";

        $query = $this->db->query($sql);

        return $query->result();
    }
    // 남 녀 비율 통계2
    public function sex_rate2()
    {
        $sql = "SELECT old, count(*) total
                FROM normaluser
                GROUP BY old";

        $query = $this->db->query($sql);

        return $query->result();
    }
    // 레시피별 판매량
    public function recipe_rate()
    {
        $sql = "SELECT r.rname, SUM(l.orstock) cnt
                FROM orderlist l, recipe r
                WHERE l.rno = r.rno
                GROUP BY l.rno
                ORDER BY cnt ASC";

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
    // 작물 검색
    public function search_crops($str)
    {
        $sql = "SELECT cno
                FROM crops c
                WHERE cname LIKE '%{$str}%'";

        $query = $this->db->query($sql);

        return $query->result();
    }
    // 농장 조회
    public function get_farm_info($num)
    {
        if($num == 0) {
            $sql = "SELECT *
                FROM farm
                WHERE ftype != {$num}
                ORDER BY ftype ASC, fname ASC";
        } else {
            $sql = "SELECT *
                FROM farm
                WHERE ftype = {$num}
                ORDER BY fname ASC";
        }

        $query = $this->db->query($sql);

        return $query->result();
    }
    /*public function get_farm_info()
    {
        $sql = "SELECT *
                FROM farm
                ORDER BY ftype ASC, fname ASC";

        $query = $this->db->query($sql);

        return $query->result();
    }*/
    // 총 재료 갯수
    public function total_mstock($num)
    {
        if($num == 0) {
            $sql = "SELECT SUM(m.mstock) smt
                FROM material m, crops c, farm f
                WHERE m.cno = c.cno
                AND c.fno = f.fno
                AND f.ftype != {$num}";
        } else {
            $sql = "SELECT SUM(m.mstock) smt
                FROM material m, crops c, farm f
                WHERE m.cno = c.cno
                AND c.fno = f.fno
                AND f.ftype = {$num}";
        }

        $query = $this->db->query($sql);

        return $query->row();
    }
   /* public function total_mstock()
    {
        $sql = "SELECT SUM(mstock) smt
                FROM material";

        $query = $this->db->query($sql);

        return $query->row();
    }*/
    // 농장별 재료 갯수
    public function farms_stock($num)
    {
        if($num == 0) {
            $sql = "SELECT f.fno, f.fname, SUM(mstock) smt, f.fcolor
                FROM material m, crops c, farm f
                WHERE m.cno = c.cno
                AND c.fno = f.fno
                AND f.ftype != {$num}
                GROUP BY f.fno
                ORDER BY ftype ASC, f.fname ASC";
        } else {
            $sql = "SELECT f.fno, f.fname, SUM(mstock) smt, f.fcolor
                FROM material m, crops c, farm f
                WHERE m.cno = c.cno
                AND c.fno = f.fno
                AND f.ftype = {$num}
                GROUP BY f.fno
                ORDER BY f.fname ASC";
        }

        $query = $this->db->query($sql);

        return $query->result();
    }
    /*public function farms_stock()
    {
        $sql = "SELECT f.fno, f.fname, SUM(mstock) smt, f.fcolor
                FROM material m, crops c, farm f
                WHERE m.cno = c.cno
                AND c.fno = f.fno
                GROUP BY f.fno
                ORDER BY f.ftype ASC, f.fname ASC";

        $query = $this->db->query($sql);

        return $query->result();
    }*/
    // 농장별 작물
    public function farms_crops($num)
    {
        if($num == 0) {
            $sql = "SELECT *
                FROM crops c, farm f, material m 
                WHERE m.cno = c.cno
                AND c.fno = f.fno
                AND f.ftype != {$num}
                ORDER BY f.fname ASC, m.mstock DESC";
        } else {
            $sql = "SELECT *
                FROM crops c, farm f, material m 
                WHERE m.cno = c.cno
                AND c.fno = f.fno
                AND f.ftype = {$num}
                ORDER BY m.mstock DESC";
        }

        $query = $this->db->query($sql);

        return $query->result();
    }
    /*public function farms_crops()
    {
        $sql = "SELECT *
                FROM crops c, farm f, material m
                WHERE m.cno = c.cno
                AND c.fno = f.fno
                ORDER BY f.ftype ASC, f.fname ASC, m.mstock DESC";

        $query = $this->db->query($sql);

        return $query->result();
    }*/
    // 거래상태별 발주 현황
    public function corder_status()
    {
        $sql = "SELECT costatus, count(costatus) count
                FROM corder
                WHERE costatus = 4
                GROUP BY costatus
                ORDER BY costatus ASC";

        $query = $this->db->query($sql);

        return $query->result();
    }
    // 거래상태별 발주 현황2
    public function corder_status2()
    {
        $sql = "SELECT costatus, count(costatus) count
                FROM corder
                WHERE costatus NOT IN (4, 5)
                ORDER BY costatus ASC";

        $query = $this->db->query($sql);

        return $query->result();
    }
    // 거래상태별 발주 현황3
    public function corder_status3()
    {
        $sql = "SELECT costatus, count(costatus) count
                FROM corder
                WHERE costatus = 5
                GROUP BY costatus
                ORDER BY costatus ASC";

        $query = $this->db->query($sql);

        return $query->result();
    }
}