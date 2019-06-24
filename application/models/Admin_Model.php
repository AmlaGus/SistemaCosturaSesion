<?php

class Admin_Model extends CI_Model {


    /*function validate($usuario, $password){

        $this->db->select('usuario, password');
        $this->db->from('usuario');
        $this->db->where('usuario', $usuario);
        $this->db->where('password',$password);
        $query = $this->db->get();
        if($query->num_rows()>0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }

        
        //return $this->db->get_where('usuario',$usuario, $password)->row();
    }*/

    function validate()
    {
        $arr['usuario'] = $this->input->post('usuario');
        $arr['password'] = sha1($this->input->post('password'));
        return $this->db->get_where('usuario',$arr)->row();

    }
    }