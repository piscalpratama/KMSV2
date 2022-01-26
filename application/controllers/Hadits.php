<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hadits extends CI_Controller {

	function __construct(){
      parent::__construct();
      date_default_timezone_set('Asia/Jakarta');
      if (!$this->session->userdata('logged')) {
					$this->session->set_flashdata('message','Hak akses ditolak.');
          redirect('Auth/');
      }
      $this->load->model('Knowledge/Tbl_knowledge_users');
      $this->load->model('Knowledge/Tbl_knowledge_profil');
      $this->load->model('Master/Tbl_master_bab');
      $this->load->model('Master/Tbl_master_kitab');
      $this->load->model('Histori/Tbl_histori_belajar');
      $this->load->model('Histori/Tbl_histori_test');
      $this->load->model('Histori/Tbl_histori_rekomendasi');
      $this->load->model('Views/Knowledge/View_knowledge_expert');
      $this->load->model('Views/Master/View_master_hadits');
      $this->load->model('Views/Master/View_master_bab');
      $this->load->model('Settings/Tbl_setting');
  }

	public function index(){
    $arr_unset = array(
      'id_master_bab', 'id_master_kitab', 'level_bab', 'keyword'
    );
    $this->session->unset_userdata($arr_unset);
    if($this->session->userdata('level') == 0){
      $rules = array(
        'select'    => null,
        'where'     => array(
          'level_bab' => $this->session->userdata('level')
        ),
        'or_where'  => null,
        'order'     => null,
        'limit'     => null,
        'pagging'   => null,
      );
      $list_hadits = $this->View_master_hadits->where($rules)->result();
      
      $rules = array(
        'select'    => null,
        'order'     => null,
        'limit'     => null,
        'pagging'   => null,
      );
      $rules2 = array(
        'select'    => null,
        'where'     => array(
          'level' => $this->session->userdata('level')
        ),
        'or_where'  => null,
        'order'     => null,
        'limit'     => null,
        'pagging'   => null,
      );
      $list_bab = $this->Tbl_master_bab->where($rules2)->result();
      $list_kitab = $this->Tbl_master_kitab->read($rules)->result();
    }else{
      $rules = array(
        'select'    => null,
        'where'     => array(
          'created_by' => $this->session->userdata('id_users')
        ),
        'or_where'  => null,
        'order'     => "level DESC",
        'limit'     => array(
          'awal' => "1",
          'akhir' => "0"
        ),
        'pagging'   => null,
      );
      $tblHTes = $this->Tbl_histori_test->where($rules);
      if($tblHTes->num_rows() > 0){
        $list_bab = array();
        $list_kitab = array();
        $tblHTes = $tblHTes->row();
        $rules = array(
          'select'    => null,
          'where'     => array(
            'id_histori_tes' => $tblHTes->id_histori_tes,
            'score >' => '75'
          ),
          'or_where'  => null,
          'order'     => null,
          'limit'     => null,
          'pagging'   => null,
        );
        $tblHRekomendasi = $this->Tbl_histori_rekomendasi->where($rules);
        if($tblHRekomendasi->num_rows() > 0){
          $tblHRekomendasi = $tblHRekomendasi->result();
          $list_hadits = array();
          foreach($tblHRekomendasi as $a){
            $rules = array(
              'select'    => null,
              'where'     => array(
                'parent_id' => $a->id_master_bab,
              ),
              'or_where'  => null,
              'order'     => null,
              'limit'     => null,
              'pagging'   => null,
            );
            $viewMBab = $this->View_master_bab->where($rules);
            if($viewMBab->num_rows() > 0){
              $viewMBab = $viewMBab->result();
              foreach($viewMBab as $c){
                $list_bab[] = array(
                  'id_master_bab' => $c->id_master_bab,
                  'bab_name' => $c->bab_name,
                  'level' => $c->level
                );
                $rules = array(
                  'select'    => 'id_master_kitab, kitab_name',
                  'where'     => array( 'id_master_bab' => $a->id_master_bab ),
                  'order'     => null,
                );
                $distKitab = $this->View_master_hadits->distinct($rules);
                if($distKitab->num_rows() > 0){
                  $distKitab = $distKitab->result();
                  foreach($distKitab as $d){
                    $list_kitab[] = array(
                      'id_master_kitab' => $d->id_master_kitab,
                      'kitab_name' => $d->kitab_name
                    );
                  }
                }
              }
            }
            $rules = array(
              'select'    => null,
              'where'     => array(
                'id_master_bab' => $a->id_master_bab,
                'level_bab' => $this->session->userdata('level')
              ),
              'or_where'  => null,
              'order'     => null,
              'limit'     => null,
              'pagging'   => null,
            );
            $viewMHadits = $this->View_master_hadits->where($rules);
            if($viewMHadits->num_rows() > 0){
              $viewMHadits = $viewMHadits->result();
              foreach($viewMHadits as $b){
                $list_hadits[] = array(
                  'id_master_hadits' => $b->id_master_hadits,
                  'hadits_name' => $b->hadits_name,
                  'hadits_content' => $b->hadits_content,
                  'hadits_arab' => $b->hadits_arab,
                  'keterangan' => $b->keterangan,
                );
              }
            }else{
              //tidak ada haditsnyaa
              $this->session->set_flashdata('message','Data hadits tidak ada.');
              $this->session->set_flashdata('type_message','danger');
              //redirect('Hadits/');
            }
          }
        }else{
          //belum ada rekomendasi yang sangat paham
          $this->session->set_flashdata('message','Silahkan tes ulang hingga salah satu bab level ini sudah sangat paham.');
          $this->session->set_flashdata('type_message','danger');
          //redirect('Tes/');
        }
      }
    }
    // var_dump($list_kitab);
    // exit();
    $data = array(
      'title'         => 'Daftar Hadits | Knowledge Management System',
      'content'       => 'Hadits/list/content',
      'css'           => 'Hadits/list/css',
      'javascript'    => 'Hadits/list/javascript',
      'modal'         => 'Hadits/list/modal',
      'viewMHadits'   => json_encode($list_hadits),
      'tblMBab'   => json_encode($list_bab),
      'tblMKitab'   => json_encode($list_kitab),
    );
    $this->load->view('index', $data);
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
    $rules3 = array(
			'select'    => null,
			'where'     => array(
				'id_master_hadits' => $id,
				'created_by' => $this->session->userdata('id_users'),
			),
			'or_where'  => null,
			'order'     => null,
			'limit'     => null,
			'pagging'   => null,
    );
    $tblHBelajar = $this->Tbl_histori_belajar->where($rules3);
    if($tblHBelajar->num_rows() > 0){
      $tblHBelajar = $tblHBelajar->row();
      $rules4 = array(
        'where' => array(
          'id_master_hadits' => $id,
          'created_by' => $this->session->userdata('id_users'),
        ),
        'data' => array(
          'count' => $tblHBelajar->count+1,
          'id_master_hadits' => $id,
          'updated_by' => $this->session->userdata('id_users')
        )
      );
      $this->Tbl_histori_belajar->update($rules4);
    }else{
      $data = array(
        'count' => 1,
        'id_master_hadits' => $id,
        'created_by' => $this->session->userdata('id_users'),
        'updated_by' => $this->session->userdata('id_users')
      );
      $this->Tbl_histori_belajar->create($data);
    }
		$data = array(
      'title'         => 'Detail Hadits | Knowledge Management System',
			'content'       => 'Hadits/detail/content',
      'css'           => 'Hadits/detail/css',
      'javascript'    => 'Hadits/detail/javascript',
			'modal'         => 'Hadits/detail/modal',
			'tblMHadits'	=> $this->View_master_hadits->where($rules)->row(),
			'tblMKitab'	=> $this->Tbl_master_kitab->read($rules2)->result(),
			'tblMBab'	=> $this->Tbl_master_bab->read($rules2)->result(),
			'tblKExpert'	=> $this->View_knowledge_expert->where($rules)->result(),
		);
		$this->load->view('index',$data);
	}

  public function filter(){
    $bab = $this->input->post('id_master_bab');
    $kitab = $this->input->post('id_master_kitab');
    $keyword = $this->input->post('keyword');
    $arr_unset = array(
      'id_master_bab', 'id_master_kitab', 'level_bab'
    );
    if($bab != 'semua' && $kitab == 'semua'){
      $data = array(
        'level_bab' => $this->session->userdata('level'),
        'id_master_bab' => $bab,
      );
      $this->session->set_userdata(array('id_master_kitab' => 'semua'));
      $this->session->set_userdata($data);
      $arr = array(
        'level_bab' => $this->session->userdata('level'),
        'id_master_bab' => $this->session->userdata('id_master_bab'),
      );
    }
    else if($bab == 'semua' && $kitab != 'semua'){
      $data = array(
        'level_bab' => $this->session->userdata('level'),
        'id_master_kitab' => $kitab,
      );
      $this->session->set_userdata(array('id_master_bab' => 'semua'));
      $this->session->set_userdata($data);
      $arr = array(
        'level_bab' => $this->session->userdata('level'),
        'id_master_kitab' => $this->session->userdata('id_master_kitab'),
      );
    }
    else if($bab != 'semua' && $kitab != 'semua'){
      if($offset > 0){
        if($this->session->userdata('id_master_bab') != 'semua' && $this->session->userdata('id_master_kitab') == 'semua'){
          $data = array(
            'level_bab' => $this->session->userdata('level'),
            'id_master_bab' => $this->session->userdata('id_master_bab'),
          );
          $this->session->set_userdata(array('id_master_kitab' => 'semua'));
          $this->session->set_userdata($data);
          $arr = array(
            'level_bab' => $this->session->userdata('level'),
            'id_master_bab' => $this->session->userdata('id_master_bab'),
          );
        }
        else if($this->session->userdata('id_master_bab') == 'semua' && $this->session->userdata('id_master_kitab') != 'semua'){
          $data = array(
            'level_bab' => $this->session->userdata('level'),
            'id_master_kitab' => $this->session->userdata('id_master_kitab'),
          );
          $this->session->set_userdata(array('id_master_bab' => 'semua'));
          $this->session->set_userdata($data);
          $arr = array(
            'level_bab' => $this->session->userdata('level'),
            'id_master_kitab' => $this->session->userdata('id_master_kitab'),
          );
        }
        else if($this->session->userdata('id_master_bab') != 'semua' && $this->session->userdata('id_master_kitab') != 'semua'){
          $data = array(
            'level_bab' => $this->session->userdata('level'),
            'id_master_bab' => $this->session->userdata('id_master_bab'),
            'id_master_kitab' => $this->session->userdata('id_master_kitab'),
          );
          $this->session->set_userdata($data);
          $arr = array(
            'level_bab' => $this->session->userdata('level'),
            'id_master_bab' => $this->session->userdata('id_master_bab'),
            'id_master_kitab' => $this->session->userdata('id_master_kitab'),
          );
        }
      }else{
        $data = array(
          'level_bab' => $this->session->userdata('level'),
          'id_master_bab' => $bab,
          'id_master_kitab' => $kitab,
        );
        $this->session->set_userdata($data);
        $arr = array(
          'level_bab' => $this->session->userdata('level'),
          'id_master_bab' => $this->session->userdata('id_master_bab'),
          'id_master_kitab' => $this->session->userdata('id_master_kitab'),
        );
      }
    }
    else{
      $this->session->unset_userdata($arr_unset);
      redirect('Hadits/');
    }
    $rules = array(
      'select'    => null,
      'where'     => $arr,
      'or_where'  => null,
      'order'     => null,
      'limit'     => null,
      'pagging'   => null,
    );
    $viewMHadits = $this->View_master_hadits->where($rules)->result();

    if($this->View_master_hadits->where($rules)->num_rows() == 0){
      $this->session->set_flashdata('message','Data hadits tidak ada.');
      $this->session->set_flashdata('type_message','danger');
      redirect('Hadits/Filter');
    }
    
    $rules = array(
      'select'    => null,
      'order'     => null,
      'limit'     => null,
      'pagging'   => null,
    );

    $rules2 = array(
      'select'    => null,
      'where'     => array(
        'level' => $this->session->userdata('level')
      ),
      'or_where'  => null,
      'order'     => null,
      'limit'     => null,
      'pagging'   => null,
    );
    $tblMBab = $this->Tbl_master_bab->where($rules2)->result();
    $tblMKitab = $this->Tbl_master_kitab->read($rules)->result();
    $data = array(
      'title'         => 'Daftar Hadits | Knowledge Management System',
      'content'       => 'Hadits/list/content',
      'css'           => 'Hadits/list/css',
      'javascript'    => 'Hadits/list/javascript',
      'modal'         => 'Hadits/list/modal',
      'viewMHadits'   => json_encode($viewMHadits),
      'tblMBab'   => $tblMBab,
      'tblMKitab'   => $tblMKitab,
    );
    $this->load->view('index', $data);
  }

  public function Search($num = ''){
    $perpage = 12;
    $offset = $this->uri->segment(3);
    $keyword = "";
    if(!empty($this->input->post('keyword'))){
      $arr_unset = array(
        'id_master_bab', 'id_master_kitab', 'level_bab'
      );
      $this->session->unset_userdata($arr_unset);
      $keyword = $this->input->post('keyword');
      $this->session->set_userdata(array("keyword"=>$keyword));
    }else{
      if($offset > 0){
        $keyword = $this->session->userdata('keyword');
      }else if(empty($this->input->post('keyword'))){
        $arr_unset = array(
          'keyword'
        );
        $this->session->unset_userdata($arr_unset);
        redirect('Hadits/');
      }
    }
    $rules = array(
      'select'    => null,
      'like'      => array(
        'hadits_content' => $keyword,
        'level_bab' => $this->session->userdata('level')
      ),
      'or_like'   =>  array(
        'hadits_name' => $keyword,
        'level_bab' => $this->session->userdata('level')
      ),
      'order'     => null,
      'limit'     => array('awal' => $perpage, 'akhir' => $offset),
      'pagging'   => null,
    );
    $viewMHadits = $this->View_master_hadits->like($rules)->result();
    
    $rules = array(
      'select'    => null,
      'like'      => array(
        'hadits_content' => $keyword,
        'level_bab' => $this->session->userdata('level')
      ),
      'or_like'   =>  array(
        'hadits_name' => $keyword,
        'level_bab' => $this->session->userdata('level')
      ),
      'order'     => null,
      'limit'     => null,
      'pagging'   => null,
    );
    if($this->View_master_hadits->like($rules)->num_rows() == 0){
      $this->session->set_flashdata('message','Data hadits tidak ada.');
      $this->session->set_flashdata('type_message','danger');
      redirect('Hadits');
    }
    $config['base_url'] = site_url().'/Hadits/Search/';
    $config['total_rows'] = $this->View_master_hadits->like($rules)->num_rows();
    $config['per_page'] = $perpage;
    $config['first_link']       = 'Pertama';
    $config['last_link']        = 'Terakhir';
    $config['next_link']        = 'Selanjutnya';
    $config['prev_link']        = 'Sebelumnya';
    $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
    $config['full_tag_close']   = '</ul></nav></div>';
    $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
    $config['num_tag_close']    = '</span></li>';
    $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
    $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
    $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
    $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
    $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
    $config['prev_tagl_close']  = '</span>Next</li>';
    $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
    $config['first_tagl_close'] = '</span></li>';
    $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
    $config['last_tagl_close']  = '</span></li>';
    $this->pagination->initialize($config);

    $rules = array(
      'select'    => null,
      'order'     => null,
      'limit'     => null,
      'pagging'   => null,
    );
    $rules2 = array(
      'select'    => null,
      'where'     => array(
        'level' => $this->session->userdata('level')
      ),
      'or_where'  => null,
      'order'     => null,
      'limit'     => null,
      'pagging'   => null,
    );
    $tblMBab = $this->Tbl_master_bab->where($rules2)->result();
    $tblMKitab = $this->Tbl_master_kitab->read($rules)->result();
    $data = array(
      'title'         => 'Daftar Hadits | Knowledge Management System',
      'content'       => 'Hadits/list/content',
      'css'           => 'Hadits/list/css',
      'javascript'    => 'Hadits/list/javascript',
      'modal'         => 'Hadits/list/modal',
      'viewMHadits'   => json_encode($viewMHadits),
      'tblMBab'   => $tblMBab,
      'tblMKitab'   => $tblMKitab,
    );
    $this->load->view('index', $data);
  }
}
