<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Kategori extends CI_Controller {

	function __construct(){
        parent::__construct();
        $hak_akses = $this->session->userdata('hak_akses');
        if ($hak_akses != "ADMIN" && $hak_akses != "EXPERT") {
            $this->session->set_flashdata('message','Hak akses ditolak.');
            redirect('Admin/Auth');
        }
        $this->load->model('Master/Tbl_master_kategori');
    }

	function index(){
		$rules = array(
            'select'    => null,
            'order'     => null,
            'limit'     => null,
            'pagging'   => null,
        );
		$data = array(
            'title'         => 'Master Kategori | Admin KMS',
			'content'       => 'Admin/Master/kategori/content',
            'css'           => 'Admin/Master/kategori/css',
            'javascript'    => 'Admin/Master/kategori/javascript',
            'modal'         => 'Admin/Master/kategori/modal',
			'tblMKategori' => $this->Tbl_master_kategori->read($rules)->result(),
		);
		$this->load->view('Admin/index',$data);
	}

	function Create(){
	    $rules[] = array('field' => 'kategori_name', 'label' => 'Nama Kategori', 'rules' => 'required');
		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('message',validation_errors());
			$this->session->set_flashdata('type_message','danger');
			redirect('Admin/Master/Kategori/');
		}else{
			$data = array(
				'kategori_name' 	=> strtoupper($this->input->post('kategori_name')),
                'created_by'     => $this->session->userdata('id_setting_users'),
                'updated_by'     => $this->session->userdata('id_setting_users'),
			);
			if ($this->Tbl_master_kategori->create($data)) {
				$this->session->set_flashdata('message','Data berhasil disimpan.');
            	$this->session->set_flashdata('type_message','success');
            	redirect('Admin/Master/Kategori/');
			}else{
				$this->session->set_flashdata('message','Terjadi kesalahan dalam tambah data.');
            	$this->session->set_flashdata('type_message','danger');
            	redirect('Admin/Master/Kategori/');
			}
		}
	}

	function Update($id){
	    $rules[] = array('field' => 'kategori_name', 'label' => 'Nama Kategori', 'rules' => 'required');
		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('message',validation_errors());
			$this->session->set_flashdata('type_message','danger');
			redirect('Admin/Master/Kategori/');
		}else{
			$rules = array(
                'where' => array(
                    'id_master_kategori' => $id,
                ),
                'data'  => array(
					'kategori_name' 	=> strtoupper($this->input->post('kategori_name')),
                	'updated_by'     => $this->session->userdata('id_setting_users'),
                ),
            );
			if ($this->Tbl_master_kategori->update($rules)) {
				$this->session->set_flashdata('message','Data berhasil diubah.');
            	$this->session->set_flashdata('type_message','success');
            	redirect('Admin/Master/Kategori/');
			}else{
				$this->session->set_flashdata('message','Terjadi kesalahan dalam edit data.');
            	$this->session->set_flashdata('type_message','danger');
            	redirect('Admin/Master/Kategori/');
			}
		}
	}

	function Delete($id){
		$where = array(
            'id_master_kategori' => $id
        );
		if ($this->Tbl_master_kategori->delete($where)) {
			$this->session->set_flashdata('message','Data berhasil dihapus.');
            $this->session->set_flashdata('type_message','success');
            redirect('Admin/Master/Kategori/');
		}else{
			$this->session->set_flashdata('message','Terjadi kesalahan dalam hapus data.');
            $this->session->set_flashdata('type_message','danger');
            redirect('Admin/Master/Kategori/');
		}
	}

}

