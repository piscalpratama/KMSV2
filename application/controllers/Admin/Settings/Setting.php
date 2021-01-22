<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller {
	function __construct(){
      parent::__construct();
      date_default_timezone_set('Asia/Jakarta');
			$hak_akses = $this->session->userdata('hak_akses');
			if ($hak_akses != "ADMIN") {
					$this->session->set_flashdata('message','Hak akses ditolak.');
					redirect('Admin/Auth');
			}
      $this->load->model('Settings/Tbl_setting');
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
        'title'         => 'Setting KMS | Admin KMS',
        'content'       => 'Admin/Settings/setting/content',
        'css'           => 'Admin/Settings/setting/css',
        'javascript'    => 'Admin/Settings/setting/javascript',
        'modal'         => 'Admin/Settings/setting/modal',
        'tblISetting'     => $this->Tbl_setting->read($rules)->result()
    );
    $this->load->view('Admin/index', $data);
	}

  function Create(){
		$rules[] = array('field' => 'nama_setting',	'label' => 'Nama Setting',  'rules' => 'required');
		$rules[] = array('field' => 'setting',	'label' => 'Setting',  'rules' => 'required');
		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('message',validation_errors());
			$this->session->set_flashdata('type_message','danger');
			redirect('Admin/Settings/Setting/');
		}else{
		    try{
          $data = array(
            'nama_setting'	=> $this->input->post('nama_setting'),
            'setting'	=> $this->input->post('setting'),
						'created_by' => $this->session->userdata('id_users'),
						'updated_by' => $this->session->userdata('id_users'),
          );
          $this->Tbl_setting->create($data);
          $this->session->set_flashdata('message','Data berhasil disimpan.');
          $this->session->set_flashdata('type_message','success');
          redirect('Admin/Settings/Setting/');
      }catch (Exception $e){
          $this->session->set_flashdata('message', $e->getMessage());
          $this->session->set_flashdata('type_message','danger');
          redirect('Admin/Settings/Setting/');
      }
		}
	}

	function Update($id){
		$rules[] = array('field' => 'setting',	'label' => 'Setting',  'rules' => 'required');
		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('message',validation_errors());
			$this->session->set_flashdata('type_message','danger');
			redirect('Admin/Settings/Setting/');
		}else{
	    try{
        $data = array(
					'setting'	=> $this->input->post('setting'),
					'updated_by' => $this->session->userdata('id_users'),
        );
        $rules = array(
            'where' => array('id_setting' => $id),
            'data'  => $data,
        );
        $this->Tbl_setting->update($rules);
        $this->session->set_flashdata('message','Data berhasil diubah.');
        $this->session->set_flashdata('type_message','success');
        redirect('Admin/Settings/Setting/');
      }catch (Exception $e){
          $this->session->set_flashdata('message', $e->getMessage());
          $this->session->set_flashdata('type_message','danger');
          redirect('Admin/Settings/Setting/');
      }
		}
	}

	function Delete($id){
    try{
      $rules = array('id_setting' => $id);
      $this->Tbl_setting->delete($rules);
      $this->session->set_flashdata('message','Data berhasil dihapus.');
      $this->session->set_flashdata('type_message','success');
      redirect('Admin/Settings/Setting');
    }catch (Exception $e){
      $this->session->set_flashdata('message', $e->getMessage());
      $this->session->set_flashdata('type_message','danger');
      redirect('Admin/Settings/Setting');
    }
	}
}
