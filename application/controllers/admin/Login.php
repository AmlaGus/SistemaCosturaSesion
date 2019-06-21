<?php


class Login extends CI_Controller {

    function index()
    {
        $this->load->view('admin/login');
    }

    function verify(){
        $usuario = $this->input->post('usuario');
        $password = $this->input->post('password');
        $this->load->model('Admin_Model');
        $check = $this->Admin_Model->validate($usuario, $password);

        if($check)
        {
            echo "Credenciales correctas";
        }else{
            redirect(base_url());
        }
    }
}