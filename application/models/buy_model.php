<?php

class Buy_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    public function cartList($user_id){
        $this->db->select('s.* , r.rname');
        $this->db->from('user u');
        $this->db->join('normaluser n', 'u.uno = n.uno');
        $this->db->join('shoppingbag s', 'n.nuno = s.nuno');
        $this->db->join('recipe r', 's.rno = r.rno');
        $this->db->where('u.uid', $user_id);
        $query = $this->db->get();

        return $query->result();
    }
    public function cartListCrops($user_id){
        $this->db->select('s.sno,c.cname');
        $this->db->from('user u');
        $this->db->join('normaluser n', 'u.uno = n.uno');
        $this->db->join('shoppingbag s', 'n.nuno = s.nuno');
        $this->db->join('smmanage sm', 's.sno = sm.sno');
        $this->db->join('material m', 'sm.mno = m.mno');
        $this->db->join('crops c', 'm.cno = c.cno');
        $this->db->where('u.uid', $user_id);
        $query = $this->db->get();

        return $query->result();
    }
    function get_nuno($user_id){
        $this->db->select('n.nuno');
        $this->db->from('user u');
        $this->db->join('normaluser n', 'u.uno = n.uno');
        $this->db->where('u.uid' , $user_id);
        $query = $this->db->get();

        return $query->row();
    }
    function insert_shoppingbag($shopping){
        $data = array(
            'sstock' => $shopping['sstock'],
            'rno' => $shopping['rno'],
            'nuno' => $shopping['nuno'],
            'sprice' => $shopping['sprice']
        );
        $this->db->insert('shoppingbag' , $data);
        $autoSoppingNum = $this->db->insert_id();
        return $autoSoppingNum;
    }
    function shoppingbag_check($rno, $nuno){
        $this->db->select('*');
        $this->db->where('rno', $rno);
        $this->db->where('nuno', $nuno);
        $query = $this->db->get('shoppingbag');

        return $query->row();
    }
    function insert_smmanage($mno, $sno){
        for($i = 0; $i < count($mno); $i++){
            $data = array(
                'sno' => $sno,
                'mno' => $mno[$i]
            );
            $this->db->insert('smmanage', $data);
        }  $autoSmmanage = $this->db->insert_id();
        return $autoSmmanage;
    }
    function insert_address($address){
        $data = array(
            'nuno' => $address['nuno']->nuno,
            'postcode' => $address['postcode'],
            'ad1' => $address['ad1'],
            'ad2' => $address['ad2'],
            'menstion' => $address['menstion'],
            'recipient' => $address['recipient'],
            'telephone' => $address['telephone']
        );
        $this->db->insert('address' , $data);
    }
    function select_address($user_id){
        $this->db->select('a.*');
        $this->db->from('user u');
        $this->db->join('normaluser n', 'u.uno = n.uno');
        $this->db->join('address a', 'n.nuno = a.nuno');
        $this->db->where('u.uid',$user_id);

        $query = $this->db->get();

        return $query->result();
    }
    function get_address($ano){
        $this->db->select('*');
        $this->db->where('ano' , $ano);

        $query = $this->db->get('address');

        return $query->row();
    }
    function insert_order($buy){
        $data = array(
            'nuno' => $buy['nuno'],
            'oday' => date("Y-m-d"),
            'oprice' => $buy['oprice'],
            'ostatus' => "배송전",
            'owishday' => $buy['owishday']
        );
        $this->db->insert('ordering' ,$data);
        $autoOrder = $this->db->insert_id();
        return $autoOrder;
    }
    function insert_orderlist($autoOrder, $rno){
        $data = array(
            'ono' => $autoOrder,
            'rno' => $rno
        );
        $this->db->insert('orderlist', $data);
    }

}