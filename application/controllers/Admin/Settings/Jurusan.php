<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jurusan extends CI_Controller {
	function __construct(){
      parent::__construct();
      date_default_timezone_set('Asia/Jakarta');
			$level = $this->session->userdata('level');
			if ($level != "SUPERADMIN") {
					$this->session->set_flashdata('message','Hak akses ditolak.');
					redirect('Admin/Auth');
			}
      $this->load->model('Settings/Tbl_setting_jurusan');
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
        'title'         => 'Setting Jurusan | Admin Pelatihan ICT',
        'content'       => 'Admin/Settings/jurusan/content',
        'css'           => 'Admin/Settings/jurusan/css',
        'javascript'    => 'Admin/Settings/jurusan/javascript',
        'modal'         => 'Admin/Settings/jurusan/modal',
        'tblSJurusan'     => $this->Tbl_setting_jurusan->read($rules)->result(),
        'tblSFakultas'     => $this->Tbl_setting_fakultas->read($rules)->result()
    );
    $this->load->view('Admin/index', $data);
	}

  function Create(){
		$rules[] = array('field' => 'kode_jurusan',	'label' => 'Kode Jurusan',  'rules' => 'required');
		$rules[] = array('field' => 'jurusan',	'label' => 'Jurusan',  'rules' => 'required');
		$rules[] = array('field' => 'status',	'label' => 'Status',  'rules' => 'required');
		$rules[] = array('field' => 'id_fakultas',	'label' => 'Fakultas',  'rules' => 'required');
		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('message',validation_errors());
			$this->session->set_flashdata('type_message','danger');
			redirect('Admin/Settings/Jurusan/');
		}else{
		    try{
          $data = array(
            'kode_jurusan'	=> $this->input->post('kode_jurusan'),
            'jurusan'	=> $this->input->post('jurusan'),
            'id_fakultas'	=> $this->input->post('id_fakultas'),
            'status'	=> $this->input->post('status'),
						'created_by' => $this->session->userdata('id_users'),
						'updated_by' => $this->session->userdata('id_users'),
          );
          $this->Tbl_setting_jurusan->create($data);
          $this->session->set_flashdata('message','Data berhasil disimpan.');
          $this->session->set_flashdata('type_message','success');
          redirect('Admin/Settings/Jurusan/');
      }catch (Exception $e){
          $this->session->set_flashdata('message', $e->getMessage());
          $this->session->set_flashdata('type_message','danger');
          redirect('Admin/Settings/Jurusan/');
      }
		}
	}

	function Update($id){
		$rules[] = array('field' => 'kode_jurusan',	'label' => 'Kode Jurusan',  'rules' => 'required');
		$rules[] = array('field' => 'jurusan',	'label' => 'Jurusan',  'rules' => 'required');
		$rules[] = array('field' => 'id_fakultas',	'label' => 'Fakultas',  'rules' => 'required');
		$rules[] = array('field' => 'status',	'label' => 'Status',  'rules' => 'required');
		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('message',validation_errors());
			$this->session->set_flashdata('type_message','danger');
			redirect('Admin/Settings/Jurusan/');
		}else{
	    try{
        $data = array(
					'kode_jurusan'	=> $this->input->post('kode_jurusan'),
					'jurusan'	=> $this->input->post('jurusan'),
					'id_fakultas'	=> $this->input->post('id_fakultas'),
					'status'	=> $this->input->post('status'),
					'updated_by' => $this->session->userdata('id_users'),
        );
        $rules = array(
            'where' => array('kode_jurusan' => $id),
            'data'  => $data,
        );
        $this->Tbl_setting_jurusan->update($rules);
        $this->session->set_flashdata('message','Data berhasil diubah.');
        $this->session->set_flashdata('type_message','success');
        redirect('Admin/Settings/Jurusan/');
      }catch (Exception $e){
          $this->session->set_flashdata('message', $e->getMessage());
          $this->session->set_flashdata('type_message','danger');
          redirect('Admin/Settings/Jurusan/');
      }
		}
	}

	function Delete($id){
    try{
      $rules = array('kode_jurusan' => $id);
        $this->Tbl_setting_jurusan->delete($rules);
        $this->session->set_flashdata('message','Data berhasil dihapus.');
        $this->session->set_flashdata('type_message','success');
        redirect('Admin/Settings/Jurusan');
    }catch (Exception $e){
        $this->session->set_flashdata('message', $e->getMessage());
        $this->session->set_flashdata('type_message','danger');
        redirect('Admin/Settings/Jurusan');
    }
	}
}
