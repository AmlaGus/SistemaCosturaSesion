<?php

class Administrador extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('Admin_Model');
        if(!$this->session->userdata('admin'))
            redirect(base_url());
    }

    public function index(){
        $this->load->view('plantilla/header');
        $this->load->view('plantilla/footer');
    }

    function logout(){
        $this->session->sess_destroy();
        redirect(base_url());
    }


    function registrarEmpleado(){

        $this->load->view("plantilla/header");
        $this->load->view("admin/trabajadores/crud");
        $this->load->view("plantilla/footer");
    }

    public function ajax_list()
    {

        $this->load->model('Admin_Model','person');
        $this->load->helper('url');

        $list = $this->person->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $person) {
            $no++;
            $row = array();
            $row[] = $person->nombre;
            $row[] = $person->ape_paterno;
            $row[] = $person->ape_materno;
            $row[] = $person->fecha_nacimiento;
            $row[] = $person->cargo;
            $row[] = $person->direccion;
            if($person->foto)
                $row[] = '<a href="'.base_url('upload/'.$person->foto).'" target="_blank"><img src="'.base_url('upload/'.$person->foto).'" class="img-responsive" width="200px" height="200px" /></a>';
            else
                $row[] = '(No Foto)';

            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_person('."'".$person->id_trabajador."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_person('."'".$person->id_trabajador."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->person->count_all(),
            "recordsFiltered" => $this->person->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id_trabajador)
    {
        $this->load->model('Admin_Model','person');

        $data = $this->person->get_by_id($id_trabajador);
        $data->fecha_nacimiento = ($data->fecha_nacimiento == '0000-00-00') ? '' : $data->fecha_nacimiento; // if 0000-00-00 set tu empty for datepicker compatibility
        echo json_encode($data);
    }

    public function ajax_add()
    {
        $this->load->model('Admin_Model','person');

        $this->_validate();

        $data = array(
            'nombre' => $this->input->post('nombre'),
            'ape_paterno' => $this->input->post('ape_paterno'),
            'ape_materno' => $this->input->post('ape_materno'),
            'fecha_nacimiento' => $this->input->post('fecha_nacimiento'),
            'cargo' => $this->input->post('cargo'),
            'direccion' => $this->input->post('direccion'),
        );

        if(!empty($_FILES['foto']['name']))
        {
            $upload = $this->_do_upload();
            $data['foto'] = $upload;
        }

        $insert = $this->person->save($data);

        echo json_encode(array("status" => TRUE));
    }

    public function ajax_update()
    {
        $this->load->model('Admin_Model','person');

        $this->_validate();
        $data = array(
            'nombre' => $this->input->post('nombre'),
            'ape_paterno' => $this->input->post('ape_paterno'),
            'ape_materno' => $this->input->post('ape_materno'),
            'fecha_nacimiento' => $this->input->post('fecha_nacimiento'),
            'cargo' => $this->input->post('cargo'),
            'direccion' => $this->input->post('direccion'),
        );

        if($this->input->post('remove_photo')) // if remove photo checked
        {
            if(file_exists('upload/'.$this->input->post('remove_photo')) && $this->input->post('remove_photo'))
                unlink('upload/'.$this->input->post('remove_photo'));
            $data['foto'] = '';
        }

        if(!empty($_FILES['foto']['name']))
        {
            $upload = $this->_do_upload();

            //delete file
            $person = $this->person->get_by_id($this->input->post('id_trabajador'));
            if(file_exists('upload/'.$person->foto) && $person->foto)
                unlink('upload/'.$person->foto);

            $data['foto'] = $upload;
        }

        $this->person->update(array('id_trabajador' => $this->input->post('id_trabajador')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_delete($id_trabajador)
    {
        $this->load->model('Admin_Model','person');

        //delete file
        $person = $this->person->get_by_id($id_trabajador);
        if(file_exists('upload/'.$person->foto) && $person->foto)
            unlink('upload/'.$person->foto);

        $this->person->delete_by_id($id_trabajador);
        echo json_encode(array("status" => TRUE));
    }

    private function _do_upload()
    {
        $config['upload_path']          = 'upload/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']= 20000; // Can be set to particular file size , here it is 2 MB(2048 Kb)
        $config['max_width']            = 2000; // set max width image allowed
        $config['max_height']           = 2000; // set max height allowed
        $config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name

        $this->load->library('upload', $config);

        if(!$this->upload->do_upload('foto')) //upload and validate
        {
            $data['inputerror'][] = 'foto';
            $data['error_string'][] = 'Upload error: '.$this->upload->display_errors('',''); //show ajax error
            $data['status'] = FALSE;
            echo json_encode($data);
            exit();
        }
        return $this->upload->data('file_name');
    }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if($this->input->post('nombre') == '')
        {
            $data['inputerror'][] = 'nombre';
            $data['error_string'][] = 'First name is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('ape_paterno') == '')
        {
            $data['inputerror'][] = 'ape_paterno';
            $data['error_string'][] = 'Apellido paterno es requerido';
            $data['status'] = FALSE;
        }

        if($this->input->post('ape_materno') == '')
        {
            $data['inputerror'][] = 'ape_materno';
            $data['error_string'][] = 'Apellido materno es requerido';
            $data['status'] = FALSE;
        }

        if($this->input->post('fecha_nacimiento') == '')
        {
            $data['inputerror'][] = 'fecha_nacimiento';
            $data['error_string'][] = 'Date of Birth is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('cargo') == '')
        {
            $data['inputerror'][] = 'cargo';
            $data['error_string'][] = 'Cargo es requerido';
            $data['status'] = FALSE;
        }

        if($this->input->post('direccion') == '')
        {
            $data['inputerror'][] = 'direccion';
            $data['error_string'][] = 'Addess is required';
            $data['status'] = FALSE;
        }

        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }

}