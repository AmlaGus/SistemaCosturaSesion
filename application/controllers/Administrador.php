<?php

class Administrador extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        if(!$this->session->userdata('admin'))
            redirect(base_url());
    }

    public function index(){
        $this->load->view('plantilla/header');
    }

    function logout(){
        $this->session->sess_destroy();
        redirect(base_url());
    }
}