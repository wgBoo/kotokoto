<?php

class Recipe_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function get_best_recipe()
    {
        $sql = "select count(o.rno),r.* from orderlist o, recipe r WHERE o.rno=r.rno GROUP BY o.rno, r.rname order by count(o.rno) desc";
        $query = $this->db->query($sql);

        return $query->result();

    }

    function get_main_recipe()
    {
        $sql = "select count(o.rno),r.* from orderlist o, recipe r WHERE o.rno=r.rno GROUP BY o.rno, r.rname order by count(o.rno) desc Limit 4";
        $query = $this->db->query($sql);

        return $query->result();
    }

    function get_recipe($lineup)
    {
        $this->db->select('*');
        if ($lineup == 2) {
            $this->db->order_by("rprice", "desc");
        } elseif ($lineup == 1) {
            $this->db->order_by("rprice", "asc");
        } else {
            $this->db->order_by("rname", "asc");
        }
        $query = $this->db->get("recipe");

        return $query->result();
    }

    function get_needs_recipe($user_id)
    {
        $this->db->select('r.*,i.icontent,i.iname');
        $this->db->from('user u');
        $this->db->join('normaluser n', 'u.uno = n.uno');
        $this->db->join('imanage im', 'n.nuno = im.nuno');
        $this->db->join('interest i', 'i.ino = im.ino');
        $this->db->join('rimanage ri', 'i.ino = ri.ino');
        $this->db->join('recipe r', 'ri.rno = r.rno');
        $this->db->where(array('u.uid' => $user_id));
        $query = $this->db->get();
        if ($query->num_rows() != 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function get_needs_crops($recipe)
    {
        $this->db->select('r.rname,c.cname,rm.rmexclude');
        $this->db->from('recipe r');
        $this->db->join('rmmanage rm', 'r.rno = rm.rno');
        $this->db->join('material m', 'rm.mno = m.mno');
        $this->db->join('crops c', 'm.cno = c.cno');
        $this->db->where(array('r.rno' => $recipe['needsRecipe'][0]->rno));
        for ($i = 1; $i < count($recipe['needsRecipe']); $i++) {
            $this->db->or_where('r.rno', $recipe['needsRecipe'][$i]->rno);
        }
        $query = $this->db->get();

        return $query->result();
    }

    function get_main_crops($recipe)
    {
        $this->db->select('r.rname,c.cname,rm.rmexclude');
        $this->db->from('recipe r');
        $this->db->join('rmmanage rm', 'r.rno = rm.rno');
        $this->db->join('material m', 'rm.mno = m.mno');
        $this->db->join('crops c', 'm.cno = c.cno');
        $this->db->where(array('r.rno' => $recipe['mainRecipe'][0]->rno));
        for ($i = 1; $i < count($recipe['mainRecipe']); $i++) {
            $this->db->or_where('r.rno', $recipe['mainRecipe'][$i]->rno);
        }
        $query = $this->db->get();

        return $query->result();
    }

    function get_interest($recipe)
    {
        $this->db->select('i.*,r.rname');
        $this->db->from('recipe r');
        $this->db->join('rimanage ri', 'r.rno = ri.rno');
        $this->db->join('interest i', 'ri.ino = i.ino');
        $this->db->where(array('r.rno' => $recipe['mainRecipe'][0]->rno));
        for ($i = 1; $i < count($recipe['mainRecipe']); $i++) {
            $this->db->or_where('r.rno', $recipe['mainRecipe'][$i]->rno);
        }
        $query = $this->db->get();

        return $query->result();
    }

    function detail_recipe($rno)
    {
        $this->db->select('*');
        $this->db->where('rno', $rno);
        $query = $this->db->get("recipe");

        return $query->row();
    }

    function get_crops($rno)
    {
        $this->db->select('r.*,m.*,c.*,cp.cpname,f.fname');
        $this->db->from('rmmanage r');
        $this->db->join('material m', 'r.mno = m.mno');
        $this->db->join('crops c', 'm.cno = c.cno');
        $this->db->join('cpicture cp', 'c.cno = cp.cno');
        $this->db->join('farm f', 'c.fno = f.fno');
        $this->db->where(array('r.rno' => $rno));
        $query = $this->db->get();
        if ($query->num_rows() != 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function search_recipe($sgap)
    {
        $this->db->select('*');
        $this->db->like('rname', $sgap[0]);
        for ($i = 1; $i < count($sgap); $i++) {
            $this->db->or_like('rname', $sgap[$i]);
        }
        $query = $this->db->get("recipe");
        return $query->result();
    }

    function search_material($sgap)
    {
        $this->db->select('re.*');
        $this->db->from('crops c');
        $this->db->join('material m', 'c.cno = m.cno');
        $this->db->join('rmmanage r', 'm.mno = r.mno');
        $this->db->join('recipe re', 'r.rno = re.rno');
        $this->db->like('c.cname', $sgap[0]);
        $this->db->or_like('re.rname', $sgap[0]);
        for ($i = 1; $i < count($sgap); $i++) {
            $this->db->or_like('c.cname', $sgap[$i]);
            $this->db->or_like('re.rname', $sgap[$i]);
        }
        $this->db->group_by('re.rno');

        $query = $this->db->get();
        return $query->result();
    }

    function get_nuno($user_id)
    {
        $this->db->select('n.nuno');
        $this->db->from('user u');
        $this->db->join('normaluser n', 'u.uno = n.uno');
        $this->db->where('u.uid', $user_id);
        $query = $this->db->get();

        return $query->row();
    }

    function insert_shoppingbag($shopping)
    {
        $data = array(
            'sstock' => $shopping['sstock'],
            'rno' => $shopping['rno'],
            'nuno' => $shopping['nuno'],
            'sprice' => $shopping['sprice']
        );
        $this->db->insert('shoppingbag', $data);
        $autoSoppingNum = $this->db->insert_id();
        return $autoSoppingNum;
    }

    function get_mno($cname)
    {
        $this->db->select('m.mno');
        $this->db->from('crops c');
        $this->db->join('material m', 'c.cno = m.mno');
        $this->db->where('c.cname', $cname[0]);
        for ($i = 1; $i < count($cname); $i++) {
            $this->db->or_where('c.cname', $cname[$i]);
        }
        $query = $this->db->get();

        return $query->result();
    }

    function insert_smmanage($mno, $sno)
    {
        for ($i = 0; $i < count($mno); $i++) {
            $data = array(
                'sno' => $sno,
                'mno' => $mno[$i]->mno
            );
            $this->db->insert('smmanage', $data);
            $autoSmmanage = $this->db->insert_id();
            return $autoSmmanage;
        }
    }
    function get_farms($cname){
        $this->db->select('f.fname,c.cname,c.cno,m.mprice');
        $this->db->from('crops c');
        $this->db->join('farm f', 'c.fno = f.fno');
        $this->db->join('material m', 'c.cno = m.cno');

        $this->db->where('c.cname' , $cname);
        $query = $this->db->get();
        return $query->result();
    }

    function get_farminfor($fname){
        $this->db->select('f.farmer,f.fname,f.fintro,f.flocation,f.fphone,p.fpname');
        $this->db->from('farm f');
        $this->db->join('fpicture p', 'f.fno = p.fno');
        $this->db->where('fname', $fname);
        $query = $this->db->get();
        return $query->result();
    }
}