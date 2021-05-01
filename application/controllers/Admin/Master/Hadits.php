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
        $this->load->model('Knowledge/Tbl_knowledge_expert');
        $this->load->model('Views/Master/View_master_hadits');
        $this->load->model('Views/Knowledge/View_knowledge_expert');
        $this->load->model('ServerSide/SS_master_hadits');
        $this->load->model('ServerSide/SS_master_hadits_fixed');
        $this->load->model('ServerSide/SS_master_hadits_summarizing');
        $this->load->model('ServerSide/SS_master_hadits_expert');
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
			'content'       => 'Admin/Master/Hadits/read/content',
            'css'           => 'Admin/Master/Hadits/read/css',
            'javascript'    => 'Admin/Master/Hadits/read/javascript',
            'modal'         => 'Admin/Master/Hadits/read/modal'
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
			'content'       => 'Admin/Master/Hadits/kombinasi/content',
            'css'           => 'Admin/Master/Hadits/kombinasi/css',
            'javascript'    => 'Admin/Master/Hadits/kombinasi/javascript',
            'modal'         => 'Admin/Master/Hadits/kombinasi/modal',
			'tblMBab'		=> $this->Tbl_master_bab->read($rules)->result()
		);
		$this->load->view('Admin/index',$data);
	}

	function DetailKombinasi($id){
		$rules2 = array(
            'select'    => null,
            'order'     => null,
            'limit'     => null,
            'pagging'   => null,
		);
		$rules3 = array(
			'select'    => null,
			'where'     => array(
				'id_master_bab' => $id
			),
			'or_where'  => null,
			'order'     => null,
			'limit'     => null,
			'pagging'   => null,
		);
		if(empty($this->input->post('id_master_kitab'))){
            $data_kosong = TRUE;
        }else{
			$data_kosong = FALSE;
			$rules = array(
				'select'    => null,
				'where'     => array(
					'id_master_bab' => $id,
					'id_master_kitab' => $this->input->post('id_master_kitab')
				),
				'or_where'  => null,
				'order'     => null,
				'limit'     => null,
				'pagging'   => null,
			);
			$tblMHadits = $this->View_master_hadits->where($rules)->result();
		}
		
		$data = array(
            'title'         => 'List Hadits Kombinasi | Admin KMS',
			'content'       => 'Admin/Master/Hadits/detail_kombinasi/content',
            'css'           => 'Admin/Master/Hadits/detail_kombinasi/css',
            'javascript'    => 'Admin/Master/Hadits/detail_kombinasi/javascript',
			'modal'         => 'Admin/Master/Hadits/detail_kombinasi/modal',
			'tblMHadits'	=> ($data_kosong == FALSE ? (!empty($tblMHadits)) ? $tblMHadits : NULL : NULL),
			'tblMKitab'	=> $this->Tbl_master_kitab->read($rules2)->result(),
			'bab_name'	=> $this->View_master_hadits->where($rules3)->row(),
			'id_master_kitab'	=> ($data_kosong == FALSE ? $this->input->post('id_master_kitab') : NULL),
			'data_kosong'	=> $data_kosong
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
			'content'       => 'Admin/Master/Hadits/detail/content',
            'css'           => 'Admin/Master/Hadits/detail/css',
            'javascript'    => 'Admin/Master/Hadits/detail/javascript',
			'modal'         => 'Admin/Master/Hadits/detail/modal',
			'tblMHadits'	=> $this->View_master_hadits->where($rules)->row(),
			'tblMKitab'	=> $this->Tbl_master_kitab->read($rules2)->result(),
			'tblMBab'	=> $this->Tbl_master_bab->read($rules2)->result(),
			'tblKExpert'	=> $this->View_knowledge_expert->where($rules)->result(),
		);
		$this->load->view('Admin/index',$data);
	}

	function Create(){
	    $rules[] = array('field' => 'hadits_name', 'label' => 'Nama Hadits', 'rules' => 'required');
	    $rules[] = array('field' => 'hadits_content', 'label' => 'Isi Hadits / Bahasan', 'rules' => 'required');
	    $rules[] = array('field' => 'hadits_arab', 'label' => 'Hadits (Arab)', 'rules' => 'required');
	    $rules[] = array('field' => 'id_master_bab', 'label' => 'Bab', 'rules' => 'required');
	    $rules[] = array('field' => 'id_master_kitab', 'label' => 'Kitab', 'rules' => 'required');
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
				'keterangan' 	=> 'expert',
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
				$keterangan = '<div class="badge badge-primary">Kitab 9 Imam</div>';
			elseif($row->keterangan == 'summarizing'):
				$keterangan = '<div class="badge badge-warning">Summarizing</div>';
			elseif($row->keterangan == 'expert'):
				$keterangan = '<div class="badge badge-success">Expert</div>';
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
			'content'       => 'Admin/Master/Hadits/knowledge/content',
            'css'           => 'Admin/Master/Hadits/knowledge/css',
            'javascript'    => 'Admin/Master/Hadits/knowledge/javascript',
			'modal'         => 'Admin/Master/Hadits/knowledge/modal',
			'tblMBab' => $this->Tbl_master_bab->read($rules)->result(),
			'tblMKitab' => $this->Tbl_master_kitab->read($rules)->result(),
		);
		$this->load->view('Admin/index', $data);
	}

	function ResultSummarizing(){
		$forum = $this->input->post('forum');
		$url = $this->input->post('web_link');

		// if($forum == 'mashara'){
		// 	$command = escapeshellcmd("py ".FCPATH."file\py\\result_mashara.py ".$url);
		// 	$output = shell_exec($command);
		// }else if($forum == 'other1'){
		// 	$command = escapeshellcmd("py ".FCPATH."file\py\\result_other1.py ".$url);
		// 	$output = shell_exec($command);
		// }else{
		// 	$command = escapeshellcmd("py ".FCPATH."file\py\\result_other2.py ".$url);
		// 	$output = shell_exec($command);
		// }
		if($forum == 'mashara'){
			//$command = "sudo python3 ".FCPATH."file/py/test.py 2>&1";
			$command = FCPATH."file/py/env/bin/python3 ".FCPATH."file/py/result_mashara.py ".$url." 2>&1";
			exec($command, $output, $return_var);
		}else if($forum == 'other1'){
			$command = FCPATH."file/py/env/bin/python3 ".FCPATH."file/py/result_other1.py ".$url." 2>&1";
			exec($command, $output, $return_var);
		}else{
			$command = FCPATH."file/py/env/bin/python3 ".FCPATH."file/py/result_other2.py ".$url." 2>&1";
			exec($command, $output, $return_var);
		}
		var_dump($command);
		var_dump($output);
		exit();
		$data_summarizing = json_decode($output);
		// var_dump($data_summarizing);
		// exit();
		$rules = array(
            'select'    => null,
            'order'     => null,
            'limit'     => null,
            'pagging'   => null,
        );
		$data = array(
            'title'         => 'Search Knowledge | Admin KMS',
			'content'       => 'Admin/Master/Hadits/result_summarizing/content',
            'css'           => 'Admin/Master/Hadits/result_summarizing/css',
            'javascript'    => 'Admin/Master/Hadits/result_summarizing/javascript',
			'modal'         => 'Admin/Master/Hadits/result_summarizing/modal',
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
				$keterangan = '<div class="badge badge-primary">Kitab 9 Imam</div>';
			elseif($row->keterangan == 'summarizing'):
				$keterangan = '<div class="badge badge-warning">Summarizing</div>';
			elseif($row->keterangan == 'expert'):
				$keterangan = '<div class="badge badge-success">Expert</div>';
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
				$keterangan = '<div class="badge badge-primary">Kitab 9 Imam</div>';
			elseif($row->keterangan == 'summarizing'):
				$keterangan = '<div class="badge badge-warning">Summarizing</div>';
			elseif($row->keterangan == 'expert'):
				$keterangan = '<div class="badge badge-success">Expert</div>';
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

	function Json4(){
		$fetch_data = $this->SS_master_hadits_expert->make_datatables();
		$data = array();
		$no = 1;
		foreach($fetch_data as $row){
			$sub_array = array();
			if($row->keterangan == 'fixed'):
			  $keterangan = '<div class="badge badge-primary">Kitab 9 Imam</div>';
			elseif($row->keterangan == 'summarizing'):
				$keterangan = '<div class="badge badge-warning">Summarizing</div>';
			elseif($row->keterangan == 'expert'):
				$keterangan = '<div class="badge badge-success">Expert</div>';
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

