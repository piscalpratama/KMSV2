<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Bab extends CI_Controller {

	function __construct(){
        parent::__construct();
        $hak_akses = $this->session->userdata('hak_akses');
        if ($hak_akses != "ADMIN" && $hak_akses != "EXPERT") {
            $this->session->set_flashdata('message','Hak akses ditolak.');
            redirect('Admin/Auth');
        }
        $this->load->model('Master/Tbl_master_bab');
        $this->load->model('Master/Tbl_master_kategori');
        $this->load->model('Views/Master/View_master_bab');
    }

	function index(){
		$rules = array(
            'select'    => null,
            'order'     => null,
            'limit'     => null,
            'pagging'   => null,
        );
		$data = array(
            'title'         => 'Master Bab | Admin KMS',
			'content'       => 'Admin/Master/bab/content',
            'css'           => 'Admin/Master/bab/css',
            'javascript'    => 'Admin/Master/bab/javascript',
            'modal'         => 'Admin/Master/bab/modal',
			'tblMBab' => $this->View_master_bab->read($rules)->result(),
			'tblMKategori' => $this->Tbl_master_kategori->read($rules)->result(),
		);
		$this->load->view('Admin/index',$data);
	}

	function Create(){
	    $rules[] = array('field' => 'bab_name', 'label' => 'Nama Bab', 'rules' => 'required');
	    $rules[] = array('field' => 'id_master_kategori', 'label' => 'Kategori', 'rules' => 'required');
		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('message',validation_errors());
			$this->session->set_flashdata('type_message','danger');
			redirect('Admin/Master/Bab/');
		}else{
			$rules = array(
				'select'    => null,
				'where'     => array(
					'id_master_bab' => $this->input->post('parent_id')
				),
				'or_where'  => null,
				'order'     => null,
				'limit'     => null,
				'pagging'   => null,
			);
			$tblMBab = $this->Tbl_master_bab->where($rules)->row();
			if($this->input->post('parent_id') == '0'){
				$level = 0;
			}else{
				$level = $tblMBab->level+1;
			}
			$data = array(
				'bab_name' 	=> strtoupper($this->input->post('bab_name')),
				'id_master_kategori' 	=> $this->input->post('id_master_kategori'),
				'parent_id' 	=> $this->input->post('parent_id'),
				'level' 	=> $level,
                'created_by'     => $this->session->userdata('id_setting_users'),
                'updated_by'     => $this->session->userdata('id_setting_users'),
			);
			if ($this->Tbl_master_bab->create($data)) {
				$this->session->set_flashdata('message','Data berhasil disimpan.');
            	$this->session->set_flashdata('type_message','success');
            	redirect('Admin/Master/Bab/');
			}else{
				$this->session->set_flashdata('message','Terjadi kesalahan dalam tambah data.');
            	$this->session->set_flashdata('type_message','danger');
            	redirect('Admin/Master/Bab/');
			}
		}
	}

	function Update($id){
	    $rules[] = array('field' => 'bab_name', 'label' => 'Nama Bab', 'rules' => 'required');
	    $rules[] = array('field' => 'id_master_kategori', 'label' => 'Kategori', 'rules' => 'required');
		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('message',validation_errors());
			$this->session->set_flashdata('type_message','danger');
			redirect('Admin/Master/Bab/');
		}else{
			$rules = array(
				'select'    => null,
				'where'     => array(
					'id_master_bab' => $this->input->post('parent_id')
				),
				'or_where'  => null,
				'order'     => null,
				'limit'     => null,
				'pagging'   => null,
			);
			$tblMBab = $this->Tbl_master_bab->where($rules)->row();
			if($this->input->post('parent_id') == 0){
				$level = 0;
			}else{
				$level = $tblMBab->level+1;
			}
			$rules = array(
                'where' => array(
                    'id_master_bab' => $id,
                ),
                'data'  => array(
					'bab_name' 	=> strtoupper($this->input->post('bab_name')),
					'id_master_kategori' 	=> $this->input->post('id_master_kategori'),
					'parent_id' 	=> $this->input->post('parent_id'),
					'level' 	=> $level,
                	'updated_by'     => $this->session->userdata('id_setting_users'),
                ),
            );
			if ($this->Tbl_master_bab->update($rules)) {
				$this->session->set_flashdata('message','Data berhasil diubah.');
            	$this->session->set_flashdata('type_message','success');
            	redirect('Admin/Master/Bab/');
			}else{
				$this->session->set_flashdata('message','Terjadi kesalahan dalam edit data.');
            	$this->session->set_flashdata('type_message','danger');
            	redirect('Admin/Master/Bab/');
			}
		}
	}

	function Delete($id){
		$where = array(
            'id_master_bab' => $id
        );
		if ($this->Tbl_master_bab->delete($where)) {
			$this->session->set_flashdata('message','Data berhasil dihapus.');
            $this->session->set_flashdata('type_message','success');
            redirect('Admin/Master/Bab/');
		}else{
			$this->session->set_flashdata('message','Terjadi kesalahan dalam hapus data.');
            $this->session->set_flashdata('type_message','danger');
            redirect('Admin/Master/Bab/');
		}
	}

}

