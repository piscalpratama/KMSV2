<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
	function __construct(){
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $hak_akses = $this->session->userdata('hak_akses');
        if ($hak_akses != "ADMIN") {
            $this->session->set_flashdata('message','Hak akses ditolak.');
            redirect('Admin/Auth');
        }
        $this->load->model('Settings/Tbl_setting_users');
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
        'title'         => 'Setting Users | Admin KMS',
        'content'       => 'Admin/Settings/users/content',
        'css'           => 'Admin/Settings/users/css',
        'javascript'    => 'Admin/Settings/users/javascript',
        'modal'         => 'Admin/Settings/users/modal',
        'tblSUsers'     => $this->Tbl_setting_users->read($rules)->result()
    );
    $this->load->view('Admin/index', $data);
	}

  function Create(){
		$rules[] = array('field' => 'username',	'label' => 'Username',  'rules' => 'required');
		$rules[] = array('field' => 'password',	'label' => 'Password',  'rules' => 'required');
		$rules[] = array('field' => 'nama',     'label' => 'Nama',      'rules' => 'required');
		$rules[] = array('field' => 'hak_akses',	'label' => 'Level',     'rules' => 'required');
		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('message',validation_errors());
			$this->session->set_flashdata('type_message','danger');
			redirect('Admin/Settings/Users/');
		}else{
		    try{
          $hak_akses = $this->input->post('hak_akses');
          $data = array(
              'username'	=> strtolower(str_replace(' ', '', $this->input->post('username')).'@'.$this->input->post('hak_akses')),
              'password'	=> md5(md5($this->input->post('password'))),
              'nama'		=> strtoupper($this->input->post('nama')),
              'hak_akses'		=> $hak_akses,
              'keterangan'=> '-',
          );
          $this->Tbl_setting_users->create($data);
          $this->session->set_flashdata('message','Data berhasil disimpan.');
          $this->session->set_flashdata('type_message','success');
          redirect('Admin/Settings/Users/');
      }catch (Exception $e){
          $this->session->set_flashdata('message', $e->getMessage());
          $this->session->set_flashdata('type_message','danger');
          redirect('Admin/Settings/Users/');
      }
		}
	}

	function Update($id){
    $rules[] = array('field' => 'username',	'label' => 'Username',  'rules' => 'required');
    $rules[] = array('field' => 'nama',     'label' => 'Nama',      'rules' => 'required');
    $rules[] = array('field' => 'hak_akses',	'label' => 'Level',     'rules' => 'required');
		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('message',validation_errors());
			$this->session->set_flashdata('type_message','danger');
			redirect('Admin/Settings/Users/');
		}else{
	    try{
        $hak_akses = $this->input->post('hak_akses');
        $password = $this->input->post('password');
        if (!empty($password)) {
            $data = array(
                'username'	=> strtolower(str_replace(' ', '', $this->input->post('username')).'@'.$this->input->post('hak_akses')),
                'password'	=> md5(md5($password)),
                'nama'		=> strtoupper($this->input->post('nama')),
                'hak_akses'		=> $hak_akses,
                'keterangan'=> '-',
            );
        }else{
            $data = array(
                'username'	=> strtolower(str_replace(' ', '', $this->input->post('username')).'@'.$this->input->post('hak_akses')),
                'nama'		=> strtoupper($this->input->post('nama')),
                'hak_akses'		=> $hak_akses,
                'keterangan'=> $keterangan,
            );
        }
        $rules = array(
            'where' => array('id_setting_users' => $id),
            'data'  => $data,
        );
        $this->Tbl_setting_users->update($rules);
        $this->session->set_flashdata('message','Data berhasil diubah.');
        $this->session->set_flashdata('type_message','success');
        redirect('Admin/Settings/Users/');
      }catch (Exception $e){
          $this->session->set_flashdata('message', $e->getMessage());
          $this->session->set_flashdata('type_message','danger');
          redirect('Admin/Settings/Users/');
      }
		}
	}

	function Delete($id){
    try{
      $rules = array('id_setting_users' => $id);
        $this->Tbl_setting_users->delete($rules);
        $this->session->set_flashdata('message','Data berhasil dihapus.');
        $this->session->set_flashdata('type_message','success');
        redirect('Admin/Settings/Users');
    }catch (Exception $e){
        $this->session->set_flashdata('message', $e->getMessage());
        $this->session->set_flashdata('type_message','danger');
        redirect('Admin/Settings/Users');
    }
	}
}
