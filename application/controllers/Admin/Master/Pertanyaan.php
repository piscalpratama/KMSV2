<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pertanyaan extends CI_Controller {
	function __construct(){
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $hak_akses = $this->session->userdata('hak_akses');
        if ($hak_akses != "ADMIN" && $hak_akses != "EXPERT") {
            $this->session->set_flashdata('message','Hak akses ditolak.');
            redirect('Admin/Auth');
        }
        $this->load->model('Master/Tbl_master_bab');
        $this->load->model('Master/Tbl_master_pertanyaan');
        $this->load->model('Master/Tbl_master_pilihan');
        $this->load->model('Views/Master/View_master_pertanyaan');
    }

	public function index()
	{
		$rules = array(
            'select'    => null,
            'order'     => null,
            'limit'     => null,
            'pagging'   => null,
        );
        if(empty($this->input->post('id_master_bab'))){
            $data_kosong = TRUE;
        }else{
            $data_kosong = FALSE;
            $rules2 = array(
                'select'    => null,
                'where'     => array(
                    'id_master_bab' => $this->input->post('id_master_bab'),
                    'isDeleted' => '0'
                ),
                'or_where'  => null,
                'order'     => null,
                'limit'     => null,
                'pagging'   => null,
            );
            $tblMPertanyaan = $this->View_master_pertanyaan->where($rules2)->result();
            if(!empty($tblMPertanyaan)):
                foreach($tblMPertanyaan as $a){
                    $rules2 = array(
                        'select'    => null,
                        'where'     => array(
                            'id_master_pertanyaan' => $a->id_master_pertanyaan
                        ),
                        'or_where'  => null,
                        'order'     => null,
                        'limit'     => null,
                        'pagging'   => null,
                    );
                    $tblMPilihan[$a->id_master_pertanyaan] = $this->Tbl_master_pilihan->where($rules2)->result();
                }
            else:
                $tblMPilihan = NULL;
            endif;
        }
		$data = array(
            'title'         => 'Master Pertanyaan | Admin KMS',
            'content'       => 'Admin/Master/Pertanyaan/content',
            'css'           => 'Admin/Master/Pertanyaan/css',
            'javascript'    => 'Admin/Master/Pertanyaan/javascript',
            'modal'         => 'Admin/Master/Pertanyaan/modal',
			'tblMBab'	=> $this->Tbl_master_bab->read($rules)->result(),
			'tblMPertanyaan'	=> ($data_kosong == FALSE ? (!empty($tblMPertanyaan)) ? $tblMPertanyaan : NULL : NULL),
			'tblMPilihan'	=> ($data_kosong == FALSE ? (!empty($tblMPilihan)) ? $tblMPilihan : NULL : NULL),
			'id_master_bab'	=> ($data_kosong == FALSE ? $this->input->post('id_master_bab') : NULL),
			'data_kosong'	=> $data_kosong
        );
    	$this->load->view('Admin/index', $data);
    }
    
    function Create(){
	    $rules[] = array('field' => 'pertanyaan', 'label' => 'Pertanyaan', 'rules' => 'required');
		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('message',validation_errors());
			$this->session->set_flashdata('type_message','danger');
			redirect('Admin/Master/Pertanyaan/');
		}else{
			$data = array(
				'pertanyaan' 	=> $this->input->post('pertanyaan'),
				'id_master_bab' 	=> $this->input->post('id_master_bab'),
				'isDeleted' 	=> '0',
                'created_by'     => $this->session->userdata('id_setting_users'),
                'updated_by'     => $this->session->userdata('id_setting_users'),
			);
			if ($this->Tbl_master_pertanyaan->create($data)) {
                $insert_id = $this->db->insert_id();
                $rules = array(
                    'select'    => null,
                    'where'     => array(
                        'id_master_bab' => $this->input->post('id_master_bab'),
                    ),
                    'or_where'  => null,
                    'order'     => null,
                    'limit'     => null,
                    'pagging'   => null,
                );
                $tblMBab = $this->Tbl_master_bab->where($rules)->row();
                if($tblMBab->level == '0'){
                    $datapilihan = array('Tidak Paham', 'Kurang Paham', 'Paham', 'Sangat Paham');
                    $datanilai = array('0', '1', '2', '3');
                    for($i = 0; $i <= 3; $i++){
                        $data = array(
                            'pilihan' 	=> $datapilihan[$i],
                            'nilai' 	=> $datanilai[$i],
                            'id_master_pertanyaan' 	=> $insert_id,
                            'created_by'     => $this->session->userdata('id_setting_users'),
                            'updated_by'     => $this->session->userdata('id_setting_users'),
                        );
                        $this->Tbl_master_pilihan->create($data);
                    }
                }
				$this->session->set_flashdata('message','Data berhasil disimpan.');
            	$this->session->set_flashdata('type_message','success');
            	redirect('Admin/Master/Pertanyaan/');
			}else{
				$this->session->set_flashdata('message','Terjadi kesalahan dalam tambah data.');
            	$this->session->set_flashdata('type_message','danger');
            	redirect('Admin/Master/Pertanyaan/');
			}
		}
	}

	function Update($id){
	    $rules[] = array('field' => 'pertanyaan', 'label' => 'Pertanyaan', 'rules' => 'required');
		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('message',validation_errors());
			$this->session->set_flashdata('type_message','danger');
			redirect('Admin/Master/Pertanyaan/');
		}else{
			$rules = array(
                'where' => array(
                    'id_master_pertanyaan' => $id,
                ),
                'data'  => array(
					'pertanyaan_name' 	=> $this->input->post('pertanyaan'),
                	'updated_by'     => $this->session->userdata('id_setting_users'),
                ),
            );
			if ($this->Tbl_master_pertanyaan->update($rules)) {
				$this->session->set_flashdata('message','Data berhasil diubah.');
            	$this->session->set_flashdata('type_message','success');
            	redirect('Admin/Master/Pertanyaan/');
			}else{
				$this->session->set_flashdata('message','Terjadi kesalahan dalam edit data.');
            	$this->session->set_flashdata('type_message','danger');
            	redirect('Admin/Master/Pertanyaan/');
			}
		}
	}

	function Delete($id){
		$rules = array(
            'where' => array(
                'id_master_pertanyaan' => $id,
            ),
            'data'  => array(
                'isDeleted' 	=> '1',
                'updated_by'     => $this->session->userdata('id_setting_users'),
            ),
        );
		if ($this->Tbl_master_pertanyaan->update($rules)) {
			$this->session->set_flashdata('message','Data berhasil dihapus.');
            $this->session->set_flashdata('type_message','success');
            redirect('Admin/Master/Pertanyaan/');
		}else{
			$this->session->set_flashdata('message','Terjadi kesalahan dalam hapus data.');
            $this->session->set_flashdata('type_message','danger');
            redirect('Admin/Master/Pertanyaan/');
		}
	}
}
