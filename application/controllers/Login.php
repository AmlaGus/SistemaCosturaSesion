<?php


class Login extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        if($this->session->userdata('admin'))
            redirect(base_url()."Administrador");
    }

    function index()
    {
        $this->load->view('admin/login');
    }

    /*function verify(){
        $usuario = $this->input->post('usuario');
        $password = $this->input->post('password');
        $this->load->model('Admin_Model');
        $check = $this->Admin_Model->validate($usuario, $password);

        if($check)
        {
            $this->session->set_userdata('admin', '1');
            redirect(base_url('Administrador'));
        }else{
            redirect(base_url());
        }
    }*/

    function verify(){

        $this->load->model('Admin_Model');
        $check = $this->Admin_Model->validate();

        if($check)
        {
            $this->session->set_userdata('admin', '1');
            redirect(base_url('Administrador'));
        }else{
            redirect(base_url());
        }
    }
}