<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Expert extends CI_Controller {

	function __construct(){
        parent::__construct();
        $hak_akses = $this->session->userdata('hak_akses');
        if ($hak_akses != "ADMIN" && $hak_akses != "EXPERT") {
            $this->session->set_flashdata('message','Hak akses ditolak.');
            redirect('Admin/Auth');
        }
		$this->load->model('Knowledge/Tbl_knowledge_expert');
		$this->load->model('Views/Knowledge/View_knowledge_expert');
    }

	function Create($id){
	    $rules[] = array('field' => 'pendapat', 'label' => 'Pendapat', 'rules' => 'required');
		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('message',validation_errors());
			$this->session->set_flashdata('type_message','danger');
			redirect('Admin/Master/Hadits/Detail/'.$id);
		}else{
			$data = array(
				'knowledge' 	=> $this->input->post('pendapat'),
				'id_master_hadits'		=> $id,
                'created_by'     => $this->session->userdata('id_setting_users'),
                'updated_by'     => $this->session->userdata('id_setting_users'),
			);
			if ($this->Tbl_knowledge_expert->create($data)) {
				$this->session->set_flashdata('message','Pendapat berhasil disimpan.');
            	$this->session->set_flashdata('type_message','success');
            	redirect('Admin/Master/Hadits/Detail/'.$id);
			}else{
				$this->session->set_flashdata('message','Terjadi kesalahan dalam tambah data.');
            	$this->session->set_flashdata('type_message','danger');
            	redirect('Admin/Master/Hadits/Detail/'.$id);
			}
		}
	}

	function Update($id, $id_expert){
	    $rules[] = array('field' => 'pendapat', 'label' => 'Pendapat', 'rules' => 'required');
		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('message',validation_errors());
			$this->session->set_flashdata('type_message','danger');
			redirect('Admin/Master/Hadits/Detail/'.$id);
		}else{
			$rules = array(
                'where' => array(
                    'id_knowledge_expert' => $id_expert,
                ),
                'data'  => array(
					'knowledge' 	=> $this->input->post('pendapat'),
                	'updated_by'     => $this->session->userdata('id_setting_users'),
                ),
            );
			if ($this->Tbl_knowledge_expert->update($rules)) {
				$this->session->set_flashdata('message','Pendapat berhasil diubah.');
            	$this->session->set_flashdata('type_message','success');
            	redirect('Admin/Master/Hadits/Detail/'.$id);
			}else{
				$this->session->set_flashdata('message','Terjadi kesalahan dalam edit data.');
            	$this->session->set_flashdata('type_message','danger');
            	redirect('Admin/Master/Hadits/Detail/'.$id);
			}
		}
	}

	function Delete($id, $id_expert){
		$where = array(
            'id_knowledge_Expert' => $id
        );
		if ($this->Tbl_knowledge_expert->delete($where)) {
			$this->session->set_flashdata('message','Pendapat berhasil dihapus.');
            $this->session->set_flashdata('type_message','success');
            redirect('Admin/Master/Hadits/Detail/'.$id);
		}else{
			$this->session->set_flashdata('message','Terjadi kesalahan dalam hapus data.');
            $this->session->set_flashdata('type_message','danger');
            redirect('Admin/Master/Hadits/Detail/'.$id);
		}
	}

}

