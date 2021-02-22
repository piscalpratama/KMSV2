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
		$this->load->model('Master/Tbl_master_bab');
		$this->load->model('Histori/Tbl_histori_rekomendasi');
		$this->load->model('Histori/Tbl_histori_test');
		$this->load->model('Settings/Tbl_setting');
		$this->load->model('Views/Histori/View_histori_rekomendasi');
		$this->load->model('Views/Histori/View_histori_belajar');
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
		$tes_num = false;
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
		
		$rules_hb = array(
			'select'    => null,
			'where'     => array(
			  'created_by' => $id
			),
			'or_where'  => null,
			'order'     => null,
			'limit'     => null,
			'pagging'   => null,
		);
		$rules2 = array(
		'select'    => null,
		'where'     => array(
			'created_by' => $id
		),
		'or_where'  => null,
		'order'     => 'id_histori_tes DESC',
		'limit'     => null,
		'pagging'   => null,
		);
		$tblHTest = $this->Tbl_histori_test->where($rules2);
		if($tblHTest->num_rows() > 0){
		$tes_num = true;
		$tblHTest = $tblHTest->row();
		$rules2 = array(
			'select'    => null,
			'where'     => array(
			'id_histori_tes' => $tblHTest->id_histori_tes,
			),
			'or_where'  => null,
			'order'     => null,
			'limit'     => null,
			'pagging'   => null,
		);
		$tblHRekomendasi = $this->View_histori_rekomendasi->where($rules2)->result();
		$rules_pie = array(
			'select'    => null,
			'where'     => array(
			'created_by' => $id,
			'level' => $tblHTest->level,
			),
			'or_where'  => null,
			'order'     => null,
			'limit'     => null,
			'pagging'   => null,
		);
		$tblHRekomendasi_pie = $this->View_histori_rekomendasi->where($rules_pie)->result();
		$rekomendasi_tidakpaham = array();
		$rekomendasi_kurangpaham = array();
		$rekomendasi_paham = array();
		$rekomendasi_sangatpaham = array();
		
		foreach($tblHRekomendasi as $a):
			if($a->score < 25):
			$drekomendasi = array(
				'id_master_bab' => $a->id_master_bab,
				'bab_name' => $a->bab_name,
			);
			$rekomendasi_tidakpaham[] = $drekomendasi;
			elseif($a->score > 25 && $a->score <= 50):
			$drekomendasi = array(
				'id_master_bab' => $a->id_master_bab,
				'bab_name' => $a->bab_name,
			);
			$rekomendasi_kurangpaham[] = $drekomendasi;
			elseif($a->score > 50 && $a->score <= 75):
			$drekomendasi = array(
				'id_master_bab' => $a->id_master_bab,
				'bab_name' => $a->bab_name,
			);
			$rekomendasi_paham[] = $drekomendasi;
			else:
			$drekomendasi = array(
				'id_master_bab' => $a->id_master_bab,
				'bab_name' => $a->bab_name,
			);
			$rekomendasi_sangatpaham[] = $drekomendasi;
			endif;
		endforeach;

		$data_pie = array();
		$label_pie = array();
		foreach($tblHRekomendasi_pie as $a):
			$pie_label[] = $a->bab_name;
			$pie_data[] = $a->score;
		endforeach;
		}
		if(count($rekomendasi_kurangpaham) == 0 && count($rekomendasi_tidakpaham) == 0):
		$rekomendasi_selanjutnya1 = array();
		$rekomendasi_selanjutnya2 = array();
		else:
		$rekomendasi_selanjutnya1 = array();
		$rekomendasi_selanjutnya2 = array();
		foreach($rekomendasi_paham as $a){
			$rules2 = array(
			'select'    => null,
			'where'     => array(
				'parent_id' => $a['id_master_bab'],
			),
			'or_where'  => null,
			'order'     => null,
			'limit'     => null,
			'pagging'   => null,
			);
			$tblMBab = $this->Tbl_master_bab->where($rules2)->result();
			foreach($tblMBab as $b){
			if($a['id_master_bab'] == $b->parent_id):
				$rekomendasi_selanjutnya1[] = $b->bab_name;
			endif;
			}
		}
		foreach($rekomendasi_sangatpaham as $a){
			$rules2 = array(
			'select'    => null,
			'where'     => array(
				'parent_id' => $a['id_master_bab'],
			),
			'or_where'  => null,
			'order'     => null,
			'limit'     => null,
			'pagging'   => null,
			);
			$tblMBab = $this->Tbl_master_bab->where($rules2)->result();
			foreach($tblMBab as $b){
			if($a['id_master_bab'] == $b->parent_id):
				$rekomendasi_selanjutnya2[] = $b->bab_name;
			endif;
			}
		}
		endif;
		$data = array(
            'title'         => 'Detail Peserta Belajar | Admin KMS',
			'content'       => 'Admin/Knowledge/Users/detail/content',
            'css'           => 'Admin/Knowledge/Users/detail/css',
            'javascript'    => 'Admin/Knowledge/Users/detail/javascript',
			'modal'         => 'Admin/Knowledge/Users/detail/modal',
			'tblKUsers'     => $this->Tbl_knowledge_users->where($rules)->row(),
			'tblKProfil'     => $this->Tbl_knowledge_profil->where($rules)->row(),
			'tblHBelajar'     => $this->View_histori_belajar->where($rules_hb)->result(),
			'rekomendasi_tidakpaham' => ($tes_num == true) ? $rekomendasi_tidakpaham : null,
			'rekomendasi_kurangpaham' => ($tes_num == true) ? $rekomendasi_kurangpaham : null,
			'rekomendasi_paham' => ($tes_num == true) ? $rekomendasi_paham : null,
			'rekomendasi_sangatpaham' => ($tes_num == true) ? $rekomendasi_sangatpaham : null,
			'label_pie' => ($tes_num == true) ? json_encode($pie_label) : null,
			'data_pie' => ($tes_num == true) ? json_encode($pie_data) : null,
			'tes_num' => $tes_num,
			'rekomendasi_selanjutnya1' => $rekomendasi_selanjutnya1,
			'rekomendasi_selanjutnya2' => $rekomendasi_selanjutnya2
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
			$sub_array = array();
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

