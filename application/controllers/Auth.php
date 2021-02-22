<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('Knowledge/Tbl_knowledge_users');
		$this->load->model('Knowledge/Tbl_knowledge_profil');
		$this->load->model('Settings/Tbl_setting');
	}

	public function index()
	{
		$rules = array(
			'select'    => null,
			'where'     => array(
				'id_setting' => 1
			),
			'or_where'  => null,
			'order'     => null,
			'limit'     => null,
			'pagging'   => null,
		);
		$tblSLogin = $this->Tbl_setting->where($rules)->row();
		$data = array(
			'tblSLogin' => $tblSLogin,
		);
		$this->load->view('login', $data);
	}
	
	public function Register()
	{
		$rules = array(
			'select'    => null,
			'where'     => array(
				'id_setting' => 1
			),
			'or_where'  => null,
			'order'     => null,
			'limit'     => null,
			'pagging'   => null,
		);
		$tblSLogin = $this->Tbl_setting->where($rules)->row();
		$data = array(
			'tblSLogin' => $tblSLogin,
		);
		$this->load->view('register', $data);
	}

	function actionLogin(){
        $tanggal = date('Y-m-d H:i:s');
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
		$tblKUsers = $this->Tbl_knowledge_users->where($rules);
		if($tblKUsers->num_rows() > 0){
			$tblKUsers = $tblKUsers->row();
			$rules = array(
				'select'    => null,
				'where'     => array(
					'id_setting' => 1
				),
				'or_where'  => null,
				'order'     => null,
				'limit'     => null,
				'pagging'   => null,
			);
			$tblSLogin = $this->Tbl_setting->where($rules)->row();
			if($tblSLogin->setting != 'AKTIF'){
				$this->session->set_flashdata('message',"Website sedang ".$tblSLogin->nama_setting.".");
				$this->session->set_flashdata('type_message','warning');
				redirect('Auth/');
			}
			$rules = array(
				'select'    => null,
				'where'     => array(
					'id_users' => $tblKUsers->id_users
				),
				'or_where'  => null,
				'order'     => null,
				'limit'     => null,
				'pagging'   => null,
			);
			$tblKProfil = $this->Tbl_knowledge_profil->where($rules)->row();
			$data = array(
				'logged' 	=> TRUE,
				'id_users'		=> $tblKUsers->id_users,
				'username'		=> $tblKUsers->username,
				'nama'			=> $tblKUsers->nama,
				'level'			=> $tblKProfil->level,
				'hak_akses'		=> $tblKUsers->hak_akses,
			);
			$this->session->set_userdata($data);
			redirect('Dashboard');
		}else{
			$this->session->set_flashdata('message','Username atau password salah.');
			$this->session->set_flashdata('type_message','danger');
			redirect('Auth');
		}
	}

	function actionRegister(){
		$tanggal = date('Y-m-d H:i:s');
		$rules = array(
			'select'    => null,
			'where'     => array(
				'id_setting' => 1
			),
			'or_where'  => null,
			'order'     => null,
			'limit'     => null,
			'pagging'   => null,
		);
		$tblSLogin = $this->Tbl_setting->where($rules)->row();
		if($tblSLogin->setting != 'AKTIF'){
			$this->session->set_flashdata('message',"Website sedang ".$tblSLogin->nama_setting.".");
			$this->session->set_flashdata('type_message','warning');
			redirect('Auth/Register');
		}
		$rules = array(
			'select'    => null,
			'where'     => array(
				'username' => $this->input->post('username')
			),
			'or_where'  => null,
			'order'     => null,
			'limit'     => null,
			'pagging'   => null,
		);
		$tblKUsers = $this->Tbl_knowledge_users->where($rules);
		if($tblKUsers->num_rows() == 0){
			if($this->input->post('password') != $this->input->post('repassword')){
				$this->session->set_flashdata('message','Password tidak sama. silahkan ulangi kembali');
				$this->session->set_flashdata('type_message','danger');
				redirect('Auth/Register');
			}else{
				$data = array(
					'username' => $this->input->post('username'),
					'password' => md5(md5($this->input->post('password'))),
					'nama' => $this->input->post('nama'),
					'ip_login' => '-',
					'ip_logout' => '-',
				);
				if($this->Tbl_knowledge_users->create($data)){
					$insert_id = $this->db->insert_id();
					$data = array(
						'id_users' => $insert_id,
						'foto' => '-',
						'level' => '0',
						'alamat' => '-',
						'jenis_kelamin' => 'L',
						'no_telp' => '0',
						'tempat_lahir' => '-',
						'tgl_lahir' => '2000-09-09',
					);
					$this->Tbl_knowledge_profil->create($data);
					$this->session->set_flashdata('message','Berhasil daftar.');
					$this->session->set_flashdata('type_message','success');
					redirect('Auth');
				}else{
					$this->session->set_flashdata('message','Daftar gagal. Silahkan coba kembali.');
					$this->session->set_flashdata('type_message','danger');
					redirect('Auth/Register');
				}
			}
		}else{
			$this->session->set_flashdata('message','Username telah terdaftar.');
			$this->session->set_flashdata('type_message','danger');
			redirect('Auth/Register');
		}
	}

	public function Logout(){
		$this->session->sess_destroy();
		redirect('Auth');
	}
}
