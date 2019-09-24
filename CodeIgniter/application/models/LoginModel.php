<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoginModel extends CI_Model{

    private $db =null;

    function __construct()
    {
        parent::__construct();
        #Cargamos la conexion base de datos
        //echo  $this->db->query("select VERSION()")->row('version');
        $this->db = $this ->load->database('default', true);
        //$this->db = $this->load->database();
    }

    public function ExecuteArrayResults( $sql)
    {
        $query = $this->db->query( $sql);
        $rows = $query->result_array();
        $query->free_result();
        return ($rows);
    }

    public function login($datos){
        $sql = "select * from users where cui = '".$datos['cui']."' and password = '".$datos['password']."'";
        return ($this->ExecuteArrayResults($sql));
    }
}

