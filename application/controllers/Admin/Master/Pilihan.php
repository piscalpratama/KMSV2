<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pilihan extends CI_Controller {
	function __construct(){
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $hak_akses = $this->session->userdata('hak_akses');
        if ($hak_akses != "ADMIN" && $hak_akses != "EXPERT") {
            $this->session->set_flashdata('message','Hak akses ditolak.');
            redirect('Admin/Auth');
        }
        $this->load->model('Master/Tbl_master_pilihan');
    }

	public function index()
	{
		redirect('Admin/Master/Pertanyaan');
    }
    
    function Create(){
	    $rules[] = array('field' => 'pilihan', 'label' => 'Pilihan', 'rules' => 'required');
	    $rules[] = array('field' => 'nilai', 'label' => 'Jawaban', 'rules' => 'required');
		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('message',validation_errors());
			$this->session->set_flashdata('type_message','danger');
			redirect('Admin/Master/Pilihan/');
		}else{
			$data = array(
				'pilihan' 	=> $this->input->post('pilihan'),
				'nilai' 	=> $this->input->post('nilai'),
				'id_master_pertanyaan' 	=> $this->input->post('id_master_pertanyaan'),
                'created_by'     => $this->session->userdata('id_setting_users'),
                'updated_by'     => $this->session->userdata('id_setting_users'),
			);
			if ($this->Tbl_master_pilihan->create($data)) {
				$this->session->set_flashdata('message','Data berhasil disimpan.');
            	$this->session->set_flashdata('type_message','success');
            	redirect('Admin/Master/Pilihan/');
			}else{
				$this->session->set_flashdata('message','Terjadi kesalahan dalam tambah data.');
            	$this->session->set_flashdata('type_message','danger');
            	redirect('Admin/Master/Pilihan/');
			}
		}
	}

	function Update($id){
	    $rules[] = array('field' => 'pilihan', 'label' => 'Pilihan', 'rules' => 'required');
	    $rules[] = array('field' => 'nilai', 'label' => 'Jawaban', 'rules' => 'required');
		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('message',validation_errors());
			$this->session->set_flashdata('type_message','danger');
			redirect('Admin/Master/Pilihan/');
		}else{
			$rules = array(
                'where' => array(
                    'id_master_pilihan' => $id,
                ),
                'data'  => array(
                    'pilihan' 	=> $this->input->post('pilihan'),
                    'nilai' 	=> $this->input->post('nilai'),
                	'updated_by'     => $this->session->userdata('id_setting_users'),
                ),
            );
			if ($this->Tbl_master_pilihan->update($rules)) {
				$this->session->set_flashdata('message','Data berhasil diubah.');
            	$this->session->set_flashdata('type_message','success');
            	redirect('Admin/Master/Pilihan/');
			}else{
				$this->session->set_flashdata('message','Terjadi kesalahan dalam edit data.');
            	$this->session->set_flashdata('type_message','danger');
            	redirect('Admin/Master/Pilihan/');
			}
		}
	}

	function Delete($id){
		$where = array(
            'id_master_pilihan' => $id
        );
		if ($this->Tbl_master_pilihan->delete($where)) {
			$this->session->set_flashdata('message','Data berhasil dihapus.');
            $this->session->set_flashdata('type_message','success');
            redirect('Admin/Master/Pilihan/');
		}else{
			$this->session->set_flashdata('message','Terjadi kesalahan dalam hapus data.');
            $this->session->set_flashdata('type_message','danger');
            redirect('Admin/Master/Pilihan/');
		}
	}
}
