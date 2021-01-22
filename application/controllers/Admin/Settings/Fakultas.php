<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fakultas extends CI_Controller {
	function __construct(){
      parent::__construct();
      date_default_timezone_set('Asia/Jakarta');
			$level = $this->session->userdata('level');
			if ($level != "SUPERADMIN") {
					$this->session->set_flashdata('message','Hak akses ditolak.');
					redirect('Admin/Auth');
			}
      $this->load->model('Settings/Tbl_setting_fakultas');
  }

	public function index()
	{
    $rules = array(
      'select'    => null,
      'order'     => null,
      'limit'     => null,
      'pagging'   => null,
    );
		$data = array(
        'title'         => 'Setting Fakultas | Admin Pelatihan ICT',
        'content'       => 'Admin/Settings/fakultas/content',
        'css'           => 'Admin/Settings/fakultas/css',
        'javascript'    => 'Admin/Settings/fakultas/javascript',
        'modal'         => 'Admin/Settings/fakultas/modal',
        'tblSFakultas'     => $this->Tbl_setting_fakultas->read($rules)->result()
    );
    $this->load->view('Admin/index', $data);
	}

  function Create(){
		$rules[] = array('field' => 'fakultas',	'label' => 'Fakultas',  'rules' => 'required');
		$rules[] = array('field' => 'status',	'label' => 'Status',  'rules' => 'required');
		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('message',validation_errors());
			$this->session->set_flashdata('type_message','danger');
			redirect('Admin/Settings/Fakultas/');
		}else{
		    try{
          $data = array(
            'fakultas'	=> $this->input->post('fakultas'),
            'status'	=> $this->input->post('status'),
						'created_by' => $this->session->userdata('id_users'),
						'updated_by' => $this->session->userdata('id_users'),
          );
          $this->Tbl_setting_fakultas->create($data);
          $this->session->set_flashdata('message','Data berhasil disimpan.');
          $this->session->set_flashdata('type_message','success');
          redirect('Admin/Settings/Fakultas/');
      }catch (Exception $e){
          $this->session->set_flashdata('message', $e->getMessage());
          $this->session->set_flashdata('type_message','danger');
          redirect('Admin/Settings/Fakultas/');
      }
		}
	}

	function Update($id){
		$rules[] = array('field' => 'fakultas',	'label' => 'Fakultas',  'rules' => 'required');
		$rules[] = array('field' => 'status',	'label' => 'Status',  'rules' => 'required');
		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('message',validation_errors());
			$this->session->set_flashdata('type_message','danger');
			redirect('Admin/Settings/Fakultas/');
		}else{
	    try{
        $data = array(
					'fakultas'	=> $this->input->post('fakultas'),
					'status'	=> $this->input->post('status'),
					'updated_by' => $this->session->userdata('id_users'),
        );
        $rules = array(
            'where' => array('id_fakultas' => $id),
            'data'  => $data,
        );
        $this->Tbl_setting_fakultas->update($rules);
        $this->session->set_flashdata('message','Data berhasil diubah.');
        $this->session->set_flashdata('type_message','success');
        redirect('Admin/Settings/Fakultas/');
      }catch (Exception $e){
          $this->session->set_flashdata('message', $e->getMessage());
          $this->session->set_flashdata('type_message','danger');
          redirect('Admin/Settings/Fakultas/');
      }
		}
	}

	function Delete($id){
    try{
      $rules = array('id_fakultas' => $id);
        $this->Tbl_setting_fakultas->delete($rules);
        $this->session->set_flashdata('message','Data berhasil dihapus.');
        $this->session->set_flashdata('type_message','success');
        redirect('Admin/Settings/Fakultas');
    }catch (Exception $e){
        $this->session->set_flashdata('message', $e->getMessage());
        $this->session->set_flashdata('type_message','danger');
        redirect('Admin/Settings/Fakultas');
    }
	}
}
