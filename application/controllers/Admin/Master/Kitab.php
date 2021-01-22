<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Kitab extends CI_Controller {

	function __construct(){
        parent::__construct();
        $hak_akses = $this->session->userdata('hak_akses');
        if ($hak_akses != "ADMIN" && $hak_akses != "EXPERT") {
            $this->session->set_flashdata('message','Hak akses ditolak.');
            redirect('Admin/Auth');
        }
        $this->load->model('Master/Tbl_master_kitab');
    }

	function index(){
		$rules = array(
            'select'    => null,
            'order'     => null,
            'limit'     => null,
            'pagging'   => null,
        );
		$data = array(
            'title'         => 'Master Kitab | Admin KMS',
			'content'       => 'Admin/Master/kitab/content',
            'css'           => 'Admin/Master/kitab/css',
            'javascript'    => 'Admin/Master/kitab/javascript',
            'modal'         => 'Admin/Master/kitab/modal',
			'tblMKitab' => $this->Tbl_master_kitab->read($rules)->result(),
		);
		$this->load->view('Admin/index',$data);
	}

	function Create(){
	    $rules[] = array('field' => 'kitab_name', 'label' => 'Nama Kitab', 'rules' => 'required');
		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('message',validation_errors());
			$this->session->set_flashdata('type_message','danger');
			redirect('Admin/Master/Kitab/');
		}else{
			$data = array(
				'kitab_name' 	=> strtoupper($this->input->post('kitab_name')),
                'created_by'     => $this->session->userdata('id_setting_users'),
                'updated_by'     => $this->session->userdata('id_setting_users'),
			);
			if ($this->Tbl_master_kitab->create($data)) {
				$this->session->set_flashdata('message','Data berhasil disimpan.');
            	$this->session->set_flashdata('type_message','success');
            	redirect('Admin/Master/Kitab/');
			}else{
				$this->session->set_flashdata('message','Terjadi kesalahan dalam tambah data.');
            	$this->session->set_flashdata('type_message','danger');
            	redirect('Admin/Master/Kitab/');
			}
		}
	}

	function Update($id){
	    $rules[] = array('field' => 'kitab_name', 'label' => 'Nama Kitab', 'rules' => 'required');
		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('message',validation_errors());
			$this->session->set_flashdata('type_message','danger');
			redirect('Admin/Master/Kitab/');
		}else{
			$rules = array(
                'where' => array(
                    'id_master_kitab' => $id,
                ),
                'data'  => array(
					'kitab_name' 	=> strtoupper($this->input->post('kitab_name')),
                	'updated_by'     => $this->session->userdata('id_setting_users'),
                ),
            );
			if ($this->Tbl_master_kitab->update($rules)) {
				$this->session->set_flashdata('message','Data berhasil diubah.');
            	$this->session->set_flashdata('type_message','success');
            	redirect('Admin/Master/Kitab/');
			}else{
				$this->session->set_flashdata('message','Terjadi kesalahan dalam edit data.');
            	$this->session->set_flashdata('type_message','danger');
            	redirect('Admin/Master/Kitab/');
			}
		}
	}

	function Delete($id){
		$where = array(
            'id_master_kitab' => $id
        );
		if ($this->Tbl_master_kitab->delete($where)) {
			$this->session->set_flashdata('message','Data berhasil dihapus.');
            $this->session->set_flashdata('type_message','success');
            redirect('Admin/Master/Kitab/');
		}else{
			$this->session->set_flashdata('message','Terjadi kesalahan dalam hapus data.');
            $this->session->set_flashdata('type_message','danger');
            redirect('Admin/Master/Kitab/');
		}
	}

}

