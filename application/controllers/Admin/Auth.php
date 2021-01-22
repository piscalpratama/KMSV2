<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('Settings/Tbl_setting');
		$this->load->model('Settings/Tbl_setting_users');
	}

	public function index()
	{
		$this->load->view('admin/login');
	}

	function actionLogin(){
		$rules = array(
			'select'    => null,
			'where'     => array(
				'username' => $this->input->post('username'),
				'password' => md5(md5($this->input->post('password'))),
			),
			'or_where'  => null,
			'order'     => null,
			'limit'     => null,
			'pagging'   => null,
		);
		$tblSUsers = $this->Tbl_setting_users->where($rules);
		if($tblSUsers->num_rows() > 0){
			$tblSUsers = $tblSUsers->row();
			$data = array(
				'logged' 	=> TRUE,
				'id_setting_users'		=> $tblSUsers->id_setting_users,
				'username'		=> $tblSUsers->username,
				'nama'			=> $tblSUsers->nama,
				'hak_akses'		=> $tblSUsers->hak_akses,
			);
			$this->session->set_userdata($data);
			redirect('Admin/Dashboard');
		}else{
			$this->session->set_flashdata('message','Username atau password salah.');
			$this->session->set_flashdata('type_message','danger');
			redirect('Admin/Auth');
		}
	}

	public function Logout(){
		$this->session->sess_destroy();
		redirect('Admin/Auth');
	}
}
