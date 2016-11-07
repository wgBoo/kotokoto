<?php

class Multi_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function multi_pickme($rname) {
/*
        $sql="
              SELECT *
              FROM   recipe r, multi m
              WHERE  r.rno = m.rno
              OR    r.rname = '$rname';

              ";
*/
/*
        $sql = "
                 select * 
                 from recipe r, multi m
                 where  r.rno = m.rno
                 and r.rname = '$rname';
                ";
*/
        $sql = "
                select r.rname, multiqr, s.stopt, s.during
                from  multi m, stoptime s, recipe r
                where m.rno = r.rno
                and  s.multino = m.multino
                and  r.english = '$rname'
                order by s.stopt asc;
               ";

        $query = $this->db->query($sql);

        return $query->result();
    }
}
