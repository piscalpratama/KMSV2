<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Users extends CI_Controller {

	function __construct(){
        parent::__construct();
        $hak_akses = $this->session->userdata('hak_akses');
        if ($hak_akses != "ADMIN" && $hak_akses != "EXPERT") {
            $this->session->set_flashdata('message','Hak akses ditolak.');
            redirect('Admin/Auth');
        }
        $this->load->model('Knowledge/Tbl_knowledge_users');
        $this->load->model('Knowledge/Tbl_knowledge_profil');
        $this->load->model('Views/Knowledge/View_knowledge_users');
        $this->load->model('ServerSide/SS_knowledge_users');
    }

	function index(){
		$rules = array(
            'select'    => null,
            'order'     => null,
            'limit'     => null,
            'pagging'   => null,
        );
		$data = array(
            'title'         => 'Peserta Belajar | Admin KMS',
			'content'       => 'Admin/Knowledge/Users/read/content',
            'css'           => 'Admin/Knowledge/Users/read/css',
            'javascript'    => 'Admin/Knowledge/Users/read/javascript',
            'modal'         => 'Admin/Knowledge/Users/read/modal',
		);
		$this->load->view('Admin/index',$data);
	}

	function Detail($id){
		$rules = array(
			'select'    => null,
			'where'     => array(
				'id_users' => $id
			),
			'or_where'  => null,
			'order'     => null,
			'limit'     => null,
			'pagging'   => null,
		);
		$data = array(
            'title'         => 'Detail Peserta Belajar | Admin KMS',
			'content'       => 'Admin/Knowledge/Users/detail/content',
            'css'           => 'Admin/Knowledge/Users/detail/css',
            'javascript'    => 'Admin/Knowledge/Users/detail/javascript',
			'modal'         => 'Admin/Knowledge/Users/detail/modal',
			'tblKUsers'		=> $this->View_knowledge_users->where($rules)->row()
		);
		$this->load->view('Admin/index',$data);
	}

	function Update($id){
	    $rules[] = array('field' => 'username', 'label' => 'Username', 'rules' => 'required');
	    $rules[] = array('field' => 'nama', 'label' => 'Nama', 'rules' => 'required');
	    $rules[] = array('field' => 'alamat', 'label' => 'Alamat', 'rules' => 'required');
	    $rules[] = array('field' => 'jenis_kelamin', 'label' => 'Jenis Kelamin', 'rules' => 'required');
	    $rules[] = array('field' => 'no_telp', 'label' => 'No Telp', 'rules' => 'required');
	    $rules[] = array('field' => 'tempat_lahir', 'label' => 'Tempat Lahir', 'rules' => 'required');
	    $rules[] = array('field' => 'tgl_lahir', 'label' => 'Tanggal Lahir', 'rules' => 'required');
		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('message',validation_errors());
			$this->session->set_flashdata('type_message','danger');
			redirect('Admin/Knowledge/Users/Detail/'.$id);
		}else{
			if(!empty($this->input->post('password'))){
				$rules = array(
					'where' => array(
						'id_users' => $id,
					),
					'data'  => array(
						'username' 	=> $this->input->post('username'),
						'nama' 	=> $this->input->post('nama'),
						'password' => $this->input->post('password'),
					),
				);
			}else{
				$rules = array(
					'where' => array(
						'id_users' => $id,
					),
					'data'  => array(
						'username' 	=> $this->input->post('username'),
						'nama' 	=> $this->input->post('nama'),
					),
				);
			}
			if ($this->Tbl_knowledge_users->update($rules)) {
				$rules = array(
					'where' => array(
						'id_users' => $id,
					),
					'data'  => array(
						'alamat' 	=> $this->input->post('alamat'),
						'jenis_kelamin' 	=> $this->input->post('jenis_kelamin'),
						'no_telp' 	=> $this->input->post('no_telp'),
						'tempat_lahir' 	=> $this->input->post('tempat_lahir'),
						'tgl_lahir' 	=> $this->input->post('tgl_lahir'),
					),
				);
				if ($this->Tbl_knowledge_profil->update($rules)) {
					$this->session->set_flashdata('message','Data berhasil diubah.');
					$this->session->set_flashdata('type_message','success');
					redirect('Admin/Knowledge/Users/Detail/'.$id);
				}else{
					$this->session->set_flashdata('message','Terjadi kesalahan dalam edit data.');
					$this->session->set_flashdata('type_message','danger');
					redirect('Admin/Knowledge/Users/Detail/'.$id);
				}
			}else{
				$this->session->set_flashdata('message','Terjadi kesalahan dalam edit data.');
				$this->session->set_flashdata('type_message','danger');
				redirect('Admin/Knowledge/Users/Detail/'.$id);
			}
		}
	}

	function Delete($id){
		$where = array(
            'id_knowledge_users' => $id
        );
		if ($this->Tbl_knowledge_users->delete($where)) {
			$this->session->set_flashdata('message','Data berhasil dihapus.');
            $this->session->set_flashdata('type_message','success');
            redirect('Admin/Knowledge/Users/');
		}else{
			$this->session->set_flashdata('message','Terjadi kesalahan dalam hapus data.');
            $this->session->set_flashdata('type_message','danger');
            redirect('Admin/Knowledge/Users/');
		}
	}

	function Json(){
		$fetch_data = $this->SS_knowledge_users->make_datatables();
		$data = array();
		$no = 1;
		foreach($fetch_data as $row){
			$sub_array[] = "
			  <a class=\"btn btn-primary btn-xs\" href=\"".base_url('Admin/Knowledge/Users/Detail/'.$row->id_users)."\" target=\"_blank\"><i class=\"fas fa-paste\"></i></a>
			";
			$sub_array[] = $no++;
			$sub_array[] = $row->nama;
			$sub_array[] = $row->username;
			$sub_array[] = $row->foto;
			$sub_array[] = $row->level;
			$data[] = $sub_array;
		}
		$output = array(
			"draw"				=>	intval($_POST["draw"]),
			"recordsTotal"		=>	$this->SS_knowledge_users->get_all_data(),
			"recordsFiltered"	=>	$this->SS_knowledge_users->get_filtered_data(),
			"data"				=>	$data
		);
		echo json_encode($output);
	}
}

