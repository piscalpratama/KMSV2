<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Hadits extends CI_Controller {

	function __construct(){
        parent::__construct();
        $hak_akses = $this->session->userdata('hak_akses');
        if ($hak_akses != "ADMIN" && $hak_akses != "EXPERT") {
            $this->session->set_flashdata('message','Hak akses ditolak.');
            redirect('Admin/Auth');
        }
        $this->load->model('Master/Tbl_master_hadits');
        $this->load->model('Master/Tbl_master_bab');
        $this->load->model('Master/Tbl_master_kitab');
        $this->load->model('Views/Master/View_master_hadits');
        $this->load->model('ServerSide/SS_master_hadits');
        $this->load->model('ServerSide/SS_master_hadits_fixed');
        $this->load->model('ServerSide/SS_master_hadits_summarizing');
    }

	function index(){
		$rules = array(
            'select'    => null,
            'order'     => null,
            'limit'     => null,
            'pagging'   => null,
        );
		$data = array(
            'title'         => 'Master Hadits | Admin KMS',
			'content'       => 'Admin/Master/hadits/read/content',
            'css'           => 'Admin/Master/hadits/read/css',
            'javascript'    => 'Admin/Master/hadits/read/javascript',
            'modal'         => 'Admin/Master/hadits/read/modal'
		);
		$this->load->view('Admin/index',$data);
	}

	function Kombinasi(){
		$rules = array(
            'select'    => null,
            'order'     => null,
            'limit'     => null,
            'pagging'   => null,
        );
		$data = array(
            'title'         => 'Hadits (Kombinasi) | Admin KMS',
			'content'       => 'Admin/Master/hadits/kombinasi/content',
            'css'           => 'Admin/Master/hadits/kombinasi/css',
            'javascript'    => 'Admin/Master/hadits/kombinasi/javascript',
            'modal'         => 'Admin/Master/hadits/kombinasi/modal',
			'tblMBab'	=> $this->Tbl_master_bab->read($rules)->result()
		);
		$this->load->view('Admin/index',$data);
	}

	function DetailKombinasi($id){
		$rules = array(
			'select'    => null,
			'where'     => array(
				'id_master_bab' => $id
			),
			'or_where'  => null,
			'order'     => null,
			'limit'     => null,
			'pagging'   => null,
		);
		$rules2 = array(
            'select'    => null,
            'order'     => null,
            'limit'     => null,
            'pagging'   => null,
        );
		$data = array(
            'title'         => 'List Hadits Kombinasi | Admin KMS',
			'content'       => 'Admin/Master/hadits/detail_kombinasi/content',
            'css'           => 'Admin/Master/hadits/detail_kombinasi/css',
            'javascript'    => 'Admin/Master/hadits/detail_kombinasi/javascript',
			'modal'         => 'Admin/Master/hadits/detail_kombinasi/modal',
			'tblMHadits'	=> $this->View_master_hadits->where($rules)->result(),
			'bab_name'	=> $this->View_master_hadits->where($rules)->row(),
		);
		$this->load->view('Admin/index',$data);
	}

	function Detail($id){
		$rules = array(
			'select'    => null,
			'where'     => array(
				'id_master_hadits' => $id
			),
			'or_where'  => null,
			'order'     => null,
			'limit'     => null,
			'pagging'   => null,
		);
		$rules2 = array(
            'select'    => null,
            'order'     => null,
            'limit'     => null,
            'pagging'   => null,
        );
		$data = array(
            'title'         => 'Master Hadits | Admin KMS',
			'content'       => 'Admin/Master/hadits/detail/content',
            'css'           => 'Admin/Master/hadits/detail/css',
            'javascript'    => 'Admin/Master/hadits/detail/javascript',
			'modal'         => 'Admin/Master/hadits/detail/modal',
			'tblMHadits'	=> $this->View_master_hadits->where($rules)->row(),
			'tblMKitab'	=> $this->Tbl_master_kitab->read($rules2)->result(),
			'tblMBab'	=> $this->Tbl_master_bab->read($rules2)->result()
		);
		$this->load->view('Admin/index',$data);
	}

	function Create(){
	    $rules[] = array('field' => 'hadits_name', 'label' => 'Nama Hadits', 'rules' => 'required');
	    $rules[] = array('field' => 'hadits_content', 'label' => 'Isi Hadits / Bahasan', 'rules' => 'required');
	    $rules[] = array('field' => 'hadits_arab', 'label' => 'Hadits (Arab)', 'rules' => 'required');
	    $rules[] = array('field' => 'id_master_bab', 'label' => 'Bab', 'rules' => 'required');
	    $rules[] = array('field' => 'id_master_kitab', 'label' => 'Kitab', 'rules' => 'required');
	    $rules[] = array('field' => 'keterangan', 'label' => 'Keterangan', 'rules' => 'required');
		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('message',validation_errors());
			$this->session->set_flashdata('type_message','danger');
			redirect('Admin/Master/Hadits/');
		}else{
			$data = array(
				'hadits_name' 	=> $this->input->post('hadits_name'),
				'hadits_content' 	=> $this->input->post('hadits_content'),
				'hadits_arab' 	=> $this->input->post('hadits_arab'),
				'id_master_bab' 	=> $this->input->post('id_master_bab'),
				'id_master_jenis' 	=> $this->input->post('id_master_jenis'),
				'id_master_kitab' 	=> $this->input->post('id_master_kitab'),
				'keterangan' 	=> $this->input->post('keterangan'),
                'created_by'     => $this->session->userdata('id_setting_users'),
                'updated_by'     => $this->session->userdata('id_setting_users'),
			);
			if ($this->Tbl_master_hadits->create($data)) {
				$this->session->set_flashdata('message','Data berhasil disimpan.');
            	$this->session->set_flashdata('type_message','success');
            	redirect('Admin/Master/Hadits/');
			}else{
				$this->session->set_flashdata('message','Terjadi kesalahan dalam tambah data.');
            	$this->session->set_flashdata('type_message','danger');
            	redirect('Admin/Master/Hadits/');
			}
		}
	}

	function Update($id){
	    $rules[] = array('field' => 'hadits_name', 'label' => 'Nama Hadits', 'rules' => 'required');
	    $rules[] = array('field' => 'hadits_content', 'label' => 'Isi Hadits / Bahasan', 'rules' => 'required');
	    $rules[] = array('field' => 'hadits_arab', 'label' => 'Hadits (Arab)', 'rules' => 'required');
	    $rules[] = array('field' => 'id_master_bab', 'label' => 'Bab', 'rules' => 'required');
	    $rules[] = array('field' => 'id_master_kitab', 'label' => 'Kitab', 'rules' => 'required');
	    $rules[] = array('field' => 'keterangan', 'label' => 'Keterangan', 'rules' => 'required');
		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('message',validation_errors());
			$this->session->set_flashdata('type_message','danger');
			redirect('Admin/Master/Hadits/Detail/'.$id);
		}else{
			$rules = array(
                'where' => array(
                    'id_master_hadits' => $id,
                ),
                'data'  => array(
					'hadits_name' 	=> $this->input->post('hadits_name'),
					'hadits_content' 	=> $this->input->post('hadits_content'),
					'hadits_arab' 	=> $this->input->post('hadits_arab'),
					'id_master_bab' 	=> $this->input->post('id_master_bab'),
					'id_master_kitab' 	=> $this->input->post('id_master_kitab'),
					'keterangan' 	=> $this->input->post('keterangan'),
                	'updated_by'     => $this->session->userdata('id_setting_users'),
                ),
            );
			if ($this->Tbl_master_hadits->update($rules)) {
				$this->session->set_flashdata('message','Data berhasil diubah.');
            	$this->session->set_flashdata('type_message','success');
            	redirect('Admin/Master/Hadits/Detail/'.$id);
			}else{
				$this->session->set_flashdata('message','Terjadi kesalahan dalam edit data.');
            	$this->session->set_flashdata('type_message','danger');
            	redirect('Admin/Master/Hadits/Detail/'.$id);
			}
		}
	}

	function Delete($id){
		$where = array(
            'id_master_hadits' => $id
        );
		if ($this->Tbl_master_hadits->delete($where)) {
			$this->session->set_flashdata('message','Data berhasil dihapus.');
            $this->session->set_flashdata('type_message','success');
            redirect('Admin/Master/Hadits/');
		}else{
			$this->session->set_flashdata('message','Terjadi kesalahan dalam hapus data.');
            $this->session->set_flashdata('type_message','danger');
            redirect('Admin/Master/Hadits/');
		}
	}

	function Json(){
		$fetch_data = $this->SS_master_hadits->make_datatables();
		$data = array();
		$no = 1;
		foreach($fetch_data as $row){
			$sub_array = array();
			if($row->keterangan == 'fixed'):
			  $keterangan = '<div class="badge badge-primary">Fixed</div>';
			elseif($row->keterangan == 'summarizing'):
			  $keterangan = '<div class="badge badge-warning">Summarizing</div>';
			endif;
			$sub_array[] = "
			  <a class=\"btn btn-primary btn-xs\" href=\"".base_url('Admin/Master/Hadits/Detail/'.$row->id_master_hadits)."\" target=\"_blank\"><i class=\"fas fa-paste\"></i></a>
			";
			$sub_array[] = $no++;
			$sub_array[] = $row->hadits_name;
			$sub_array[] = substr($row->hadits_content, 0, 100)."...<a href=\"".base_url('Admin/Master/Hadits/Detail/'.$row->id_master_hadits)."\" target=\"_blank\">Detail</a>";
			$sub_array[] = mb_substr($row->hadits_arab, 0, 100, 'utf-8')."...<a href=\"".base_url('Admin/Master/Hadits/Detail/'.$row->id_master_hadits)."\" target=\"_blank\">Detail</a>";
			$sub_array[] = $row->bab_name;
			$sub_array[] = $row->kitab_name;
			$sub_array[] = $keterangan;
			$data[] = $sub_array;
		}
		$output = array(
			"draw"				=>	intval($_POST["draw"]),
			"recordsTotal"		=>	$this->SS_master_hadits->get_all_data(),
			"recordsFiltered"	=>	$this->SS_master_hadits->get_filtered_data(),
			"data"				=>	$data
		);
		echo json_encode($output);
	}

	function Knowledge(){
		$rules = array(
            'select'    => null,
            'order'     => null,
            'limit'     => null,
            'pagging'   => null,
        );
		$data = array(
            'title'         => 'Tambah Knowledge | Admin KMS',
			'content'       => 'Admin/Master/hadits/knowledge/content',
            'css'           => 'Admin/Master/hadits/knowledge/css',
            'javascript'    => 'Admin/Master/hadits/knowledge/javascript',
			'modal'         => 'Admin/Master/hadits/knowledge/modal',
			'tblMBab' => $this->Tbl_master_bab->read($rules)->result(),
			'tblMKitab' => $this->Tbl_master_kitab->read($rules)->result(),
		);
		$this->load->view('Admin/index', $data);
	}

	function ResultSummarizing(){
		$forum = $this->input->post('forum');
		$url = $this->input->post('web_link');

		if($forum == 'mashara'){
			$command = escapeshellcmd("py ".FCPATH."file\py/result_mashara.py ".$url);
			$output = shell_exec($command);
		}else if($forum == 'other1'){
			$command = escapeshellcmd("py ".FCPATH."file\py/result_other1.py ".$url);
			$output = shell_exec($command);
		}else{
			$command = escapeshellcmd("py ".FCPATH."file\py/result_other2.py ".$url);
			$output = shell_exec($command);
		}
		$data_summarizing = json_decode($output);
		$rules = array(
            'select'    => null,
            'order'     => null,
            'limit'     => null,
            'pagging'   => null,
        );
		$data = array(
            'title'         => 'Search Knowledge | Admin KMS',
			'content'       => 'Admin/Master/hadits/result_summarizing/content',
            'css'           => 'Admin/Master/hadits/result_summarizing/css',
            'javascript'    => 'Admin/Master/hadits/result_summarizing/javascript',
			'modal'         => 'Admin/Master/hadits/result_summarizing/modal',
			'data_summarizing' => $data_summarizing,
			'tblMBab'		=> $this->Tbl_master_bab->read($rules)->result()
		);
		$this->load->view('Admin/index', $data);
	}
	
	function Json2(){
		$fetch_data = $this->SS_master_hadits_fixed->make_datatables();
		$data = array();
		$no = 1;
		foreach($fetch_data as $row){
			$sub_array = array();
			if($row->keterangan == 'fixed'):
			  $keterangan = '<div class="badge badge-primary">Fixed</div>';
			elseif($row->keterangan == 'summarizing'):
			  $keterangan = '<div class="badge badge-warning">Summarizing</div>';
			endif;
			$sub_array[] = "
			  <a class=\"btn btn-primary btn-xs\" href=\"".base_url('Admin/Master/Hadits/Detail/'.$row->id_master_hadits)."\" target=\"_blank\"><i class=\"fas fa-paste\"></i></a>
			";
			$sub_array[] = $no++;
			$sub_array[] = $row->hadits_name;
			$sub_array[] = substr($row->hadits_content, 0, 100)."...<a href=\"".base_url('Admin/Master/Hadits/Detail/'.$row->id_master_hadits)."\" target=\"_blank\">Detail</a>";
			$sub_array[] = mb_substr($row->hadits_arab, 0, 100, 'utf-8')."...<a href=\"".base_url('Admin/Master/Hadits/Detail/'.$row->id_master_hadits)."\" target=\"_blank\">Detail</a>";
			$sub_array[] = $row->bab_name;
			$sub_array[] = $row->kitab_name;
			$sub_array[] = $keterangan;
			$data[] = $sub_array;
		}
		$output = array(
			"draw"				=>	intval($_POST["draw"]),
			"recordsTotal"		=>	$this->SS_master_hadits_fixed->get_all_data(),
			"recordsFiltered"	=>	$this->SS_master_hadits_fixed->get_filtered_data(),
			"data"				=>	$data
		);
		echo json_encode($output);
	}

	function Json3(){
		$fetch_data = $this->SS_master_hadits_summarizing->make_datatables();
		$data = array();
		$no = 1;
		foreach($fetch_data as $row){
			$sub_array = array();
			if($row->keterangan == 'fixed'):
			  $keterangan = '<div class="badge badge-primary">Fixed</div>';
			elseif($row->keterangan == 'summarizing'):
			  $keterangan = '<div class="badge badge-warning">Summarizing</div>';
			endif;
			$sub_array[] = "
			  <a class=\"btn btn-primary btn-xs\" href=\"".base_url('Admin/Master/Hadits/Detail/'.$row->id_master_hadits)."\" target=\"_blank\"><i class=\"fas fa-paste\"></i></a>
			";
			$sub_array[] = $no++;
			$sub_array[] = $row->hadits_name;
			$sub_array[] = substr($row->hadits_content, 0, 100)."...<a href=\"".base_url('Admin/Master/Hadits/Detail/'.$row->id_master_hadits)."\" target=\"_blank\">Detail</a>";
			$sub_array[] = substr($row->hadits_arab, 0, 100)."...<a href=\"".base_url('Admin/Master/Hadits/Detail/'.$row->id_master_hadits)."\" target=\"_blank\">Detail</a>";
			$sub_array[] = $row->bab_name;
			$sub_array[] = $row->kitab_name;
			$sub_array[] = $keterangan;
			$data[] = $sub_array;
		}
		$output = array(
			"draw"				=>	intval($_POST["draw"]),
			"recordsTotal"		=>	$this->SS_master_hadits_summarizing->get_all_data(),
			"recordsFiltered"	=>	$this->SS_master_hadits_summarizing->get_filtered_data(),
			"data"				=>	$data
		);
		echo json_encode($output);
	}
}
