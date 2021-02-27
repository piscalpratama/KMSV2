<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tes extends CI_Controller {

	function __construct(){
      parent::__construct();
      date_default_timezone_set('Asia/Jakarta');
      if (!$this->session->userdata('logged')) {
					$this->session->set_flashdata('message','Hak akses ditolak.');
          redirect('Auth/');
      }
      $this->load->model('Histori/Tbl_histori_test');
      $this->load->model('Histori/Tbl_histori_jawaban');
      $this->load->model('Histori/Tbl_histori_rekomendasi');
      $this->load->model('Knowledge/Tbl_knowledge_profil');
      $this->load->model('Master/Tbl_master_pilihan');
      $this->load->model('Views/Master/View_master_pertanyaan');
      $this->load->model('Views/Histori/View_histori_jawaban');
      $this->load->model('Views/Histori/View_histori_rekomendasi');
  }

	public function index(){
    $rules = array(
      'select'    => null,
      'where'     => array(
        'created_by' => $this->session->userdata('id_users')
      ),
      'or_where'  => null,
      'order'     => 'level DESC',
      'limit'     => null,
      'pagging'   => null,
    );
    $rules2 = array(
      'select'    => null,
      'where'     => array(
        'created_by' => $this->session->userdata('id_users')
      ),
      'or_where'  => null,
      'order'     => 'level DESC',
      'limit'     => null,
      'pagging'   => null,
    );
    $last_test_id = $this->Tbl_histori_test->where($rules2)->row();
    $data = array(
      'title'         => 'Tes | Knowledge Management System',
      'content'       => 'Tes/read/content',
      'css'           => 'Tes/read/css',
      'javascript'    => 'Tes/read/javascript',
      'modal'         => 'Tes/read/modal',
      'tblHTest'      => $this->Tbl_histori_test->where($rules)->result(),
      'last_test_id'   => (!empty($last_test_id)) ? $last_test_id : '-',
    );
    $this->load->view('index', $data);
  }

  function Confirm(){
    $rules = array(
      'select'    => null,
      'where'     => array(
        'level' => $this->session->userdata('level'),
        'created_by' => $this->session->userdata('id_users')
      ),
      'or_where'  => null,
      'order'     => null,
      'limit'     => null,
      'pagging'   => null,
    );
    $tblHTest = $this->Tbl_histori_test->where($rules);
    if($tblHTest->num_rows() == 0){
      $data = array(
				'level' 	=> $this->session->userdata('level'),
        'summit' 	=> 1,
				'status' 	=> '0',
        'created_by'     => $this->session->userdata('id_users'),
        'updated_by'     => $this->session->userdata('id_users'),
			);
			if ($this->Tbl_histori_test->create($data)) {
				$this->session->set_flashdata('message','Berhasil memulai tes.');
        $this->session->set_flashdata('type_message','success');
        redirect('Tes/Exam');
			}else{
				$this->session->set_flashdata('message','Terjadi kesalahan dalam proses confirm.');
        $this->session->set_flashdata('type_message','danger');
        redirect('Test/');
			}
    }else{
      $tblHTest = $tblHTest->row();
      if($tblHTest->status == '0'){
        $rules = array(
          'where' => array(
              'id_histori_tes' => $tblHTest->id_histori_tes,
          ),
          'data'  => array(
            'status' 	=> '0',
            'updated_by'     => $this->session->userdata('id_users'),
          ),
        );
      }else{
        $rules = array(
          'where' => array(
            'id_histori_tes' => $tblHTest->id_histori_tes,
          ),
          'data'  => array(
            'summit' 	=> $tblHTest->status+1,
            'status' 	=> '0',
            'updated_by'     => $this->session->userdata('id_users'),
          ),
        );
      }
      if ($this->Tbl_histori_test->update($rules)) {
				$this->session->set_flashdata('message','Berhasil memulai tes.');
        $this->session->set_flashdata('type_message','success');
        redirect('Tes/Exam');
			}else{
				$this->session->set_flashdata('message','Terjadi kesalahan dalam proses confirm.');
        $this->session->set_flashdata('type_message','danger');
        redirect('Tes/');
			}
    }
  }

  function Exam($num = ''){
    $perpage = 1;
    $offset = $this->uri->segment(3);
    $rules = array(
      'select'    => null,
      'where'     => array(
        'level' => $this->session->userdata('level'),
        'isDeleted' => '0'
      ),
      'or_where'  => null,
      'order'     => null,
      'limit'     => array('awal' => $perpage, 'akhir' => $offset),
      'pagging'   => null,
    );
    $tblMPertanyaan = $this->View_master_pertanyaan->where($rules)->result();
    foreach($tblMPertanyaan as $a){
      $rules = array(
        'select'    => null,
        'where'     => array(
          'id_master_pertanyaan' => $a->id_master_pertanyaan,
        ),
        'or_where'  => null,
        'order'     => null,
        'limit'     => null,
        'pagging'   => null,
      );
      $tblMPilihan[$a->id_master_pertanyaan] = $this->Tbl_master_pilihan->where($rules)->result();
    }
    $rules = array(
      'select'    => null,
      'where'     => array(
        'level' => $this->session->userdata('level'),
        'isDeleted' => '0'
      ),
      'or_where'  => null,
      'order'     => null,
      'limit'     => null,
      'pagging'   => null,
    );
    $config['base_url'] = site_url().'/Tes/Exam/';
    $config['total_rows'] = $this->View_master_pertanyaan->where($rules)->num_rows();
    $config['per_page'] = $perpage;
    $config['num_links'] = $this->View_master_pertanyaan->where($rules)->num_rows();
    $config['first_link']       = FALSE;
    $config['last_link']        = FALSE;
    $config['next_link']        = 'Selanjutnya';
    $config['prev_link']        = 'Sebelumnya';
    $config['full_tag_open']    = '<ul class="pagination pagination-sm m-t-xs m-b-xs justify-content-center">';
    $config['full_tag_close']   = '</ul>';
    $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
    $config['num_tag_close']    = '</span></li>';
    $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
    $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
    $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
    $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
    $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
    $config['prev_tagl_close']  = '</span>Next</li>';
    $this->pagination->initialize($config);

    $data = array(
      'title'         => 'Tes | Knowledge Management System',
      'content'       => 'Tes/exam/content',
      'css'           => 'Tes/exam/css',
      'javascript'    => 'Tes/exam/javascript',
      'modal'         => 'Tes/exam/modal',
      'tblMPertanyaan'  => $tblMPertanyaan,
      'tblMPilihan'  => $tblMPilihan,
      'num' => (!empty($this->uri->segment(3)) ? $this->uri->segment(3)+1 : '1'),
      'total_row' => $config['total_rows'],
    );
    $this->load->view('index', $data);
  }

  function InputJawaban(){
    $rules = array(
      'select'    => null,
      'where'     => array(
        'level' => $this->session->userdata('level'),
        'created_by' => $this->session->userdata('id_users')
      ),
      'or_where'  => null,
      'order'     => null,
      'limit'     => null,
      'pagging'   => null,
    );
    $tblHTest = $this->Tbl_histori_test->where($rules)->row();

    $rules = array(
      'select'    => null,
      'where'     => array(
        'id_master_pilihan' => $this->input->post('id_master_pilihan'),
      ),
      'or_where'  => null,
      'order'     => null,
      'limit'     => null,
      'pagging'   => null,
    );
    $tblMPilihan = $this->Tbl_master_pilihan->where($rules)->row();

    $rules = array(
      'select'    => null,
      'where'     => array(
        'id_histori_tes' => $tblHTest->id_histori_tes,
        'id_master_pertanyaan' => $tblMPilihan->id_master_pertanyaan,
        'created_by' => $this->session->userdata('id_users')
      ),
      'or_where'  => null,
      'order'     => null,
      'limit'     => null,
      'pagging'   => null,
    );
    $tblHJawaban = $this->View_histori_jawaban->where($rules);
    if($tblHJawaban->num_rows() == 0):
      $data = array(
				'id_master_pilihan' 	=> $this->input->post('id_master_pilihan'),
        'id_histori_tes' 	=> $tblHTest->id_histori_tes,
        'created_by'     => $this->session->userdata('id_users'),
        'updated_by'     => $this->session->userdata('id_users'),
			);
      $this->Tbl_histori_jawaban->create($data);
      return TRUE;
    else:
      $tblHJawaban = $tblHJawaban->row();
      $rules = array(
        'where' => array(
          'id_histori_jawaban' => $tblHJawaban->id_histori_jawaban,
        ),
        'data'  => array(
          'id_master_pilihan' 	=> $this->input->post('id_master_pilihan'),
          'created_by'     => $this->session->userdata('id_users'),
        ),
      );
      $this->Tbl_histori_jawaban->update($rules);
      return TRUE;
    endif;
  }

  function SubmitTes(){
    $rules = array(
      'select'    => null,
      'where'     => array(
        'level' => $this->session->userdata('level'),
        'created_by' => $this->session->userdata('id_users')
      ),
      'or_where'  => null,
      'order'     => null,
      'limit'     => null,
      'pagging'   => null,
    );
    $tblHTest = $this->Tbl_histori_test->where($rules)->row();

    $rules = array(
      'select'    => null,
      'where'     => array(
        'level' => $this->session->userdata('level'),
        'isDeleted' => '0'
      ),
      'or_where'  => null,
      'order'     => null,
      'limit'     => null,
      'pagging'   => null,
    );
    $tblMPertanyaan = $this->View_master_pertanyaan->where($rules)->num_rows();

    $rules = array(
      'select'    => null,
      'where'     => array(
        'id_histori_tes' => $tblHTest->id_histori_tes,
        'created_by' => $this->session->userdata('id_users')
      ),
      'or_where'  => null,
      'order'     => null,
      'limit'     => null,
      'pagging'   => null,
    );
    $tblHJawaban = $this->View_histori_jawaban->where($rules);
    if($tblMPertanyaan != $tblHJawaban->num_rows()){
      $this->session->set_flashdata('message','Anda belum menjawab semua soal. Silahkan cek kembali.');
      $this->session->set_flashdata('type_message','danger');
      redirect('Tes/Exam');
    }

    $command = escapeshellcmd("python3 ".FCPATH."file\py\submit_tes.py ".$this->session->userdata('id_users')." ".$this->session->userdata('level')." ".$tblHTest->id_histori_tes);
    $output = shell_exec($command);
    // echo $command;
    // exit();
    if($output == true){
      $rules = array(
        'where' => array(
            'id_histori_tes' => $tblHTest->id_histori_tes,
        ),
        'data'  => array(
          'status' 	=> '1',
          'updated_by'     => $this->session->userdata('id_users'),
        ),
      );
      $this->Tbl_histori_test->update($rules);
      $this->session->set_flashdata('message','Anda berhasil menyelesaikan tes.');
      $this->session->set_flashdata('type_message','success');
      redirect('Tes/');
    }else{
      $this->session->set_flashdata('message','Silahkan submit ulang tes.');
      $this->session->set_flashdata('type_message','warning');
      redirect('Tes/Exam');
    }
  }

  function Detail($id){
    $rules = array(
      'select'    => null,
      'where'     => array(
        'id_histori_tes' => $id
      ),
      'or_where'  => null,
      'order'     => null,
      'limit'     => null,
      'pagging'   => null,
    );
    $rules2 = array(
      'select'    => null,
      'where'     => array(
        'id_histori_tes' => $id
      ),
      'or_where'  => null,
      'order'     => 'score DESC',
      'limit'     => null,
      'pagging'   => null,
    );
    $data = array(
      'title'         => 'Detail Tes | Knowledge Management System',
      'content'       => 'Tes/detail/content',
      'css'           => 'Tes/detail/css',
      'javascript'    => 'Tes/detail/javascript',
      'modal'         => 'Tes/detail/modal',
      'tblHJawaban'      => $this->View_histori_jawaban->where($rules)->result(),
      'tblHRekomendasi'      => $this->View_histori_rekomendasi->where($rules2)->result()
    );
    $this->load->view('index', $data);
  }

  function NextLevel(){
    $rules = array(
      'select'    => null,
      'where'     => array(
        'id_users' => $this->session->userdata('id_users')
      ),
      'or_where'  => null,
      'order'     => null,
      'limit'     => null,
      'pagging'   => null,
    );
    $tblKProfil = $this->Tbl_knowledge_profil->where($rules)->row();
    $rules = array(
      'where' => array(
          'id_users' => $this->session->userdata('id_users'),
      ),
      'data'  => array(
        'level' 	=> $tblKProfil->level+1
      ),
    );
    $this->Tbl_knowledge_profil->update($rules);
    $this->session->set_userdata('level', $rules['data']['level']);
    $this->session->set_flashdata('message','Berhasil melanjutkan tes. Silahkan pelajari bab yang telah disediakan.');
    $this->session->set_flashdata('type_message','success');
    redirect('Hadits/');
  }
}
