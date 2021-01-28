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
      $this->load->model('Views/Master/View_master_hadits');
      $this->load->model('Settings/Tbl_setting');
  }

	public function index($num = ''){
    $arr_unset = array(
      'id_master_bab', 'id_master_kitab', 'level_bab', 'keyword'
    );
    $this->session->unset_userdata($arr_unset);
    $perpage = 12;
    $offset = $this->uri->segment(3);
    $rules = array(
      'select'    => null,
      'where'     => array(
        'level_bab' => $this->session->userdata('level')
      ),
      'or_where'  => null,
      'order'     => null,
      'limit'     => array('awal' => $perpage, 'akhir' => $offset),
      'pagging'   => null,
    );
    $viewMHadits = $this->View_master_hadits->where($rules)->result();
    
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
    $config['base_url'] = site_url().'/Hadits/index/';
    $config['total_rows'] = $this->View_master_hadits->where($rules)->num_rows();
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
    $tblMBab = $this->Tbl_master_bab->read($rules)->result();
    $tblMKitab = $this->Tbl_master_kitab->read($rules)->result();

    $data = array(
      'title'         => 'Daftar Hadits | Knowledge Management System',
      'content'       => 'Hadits/list/content',
      'css'           => 'Hadits/list/css',
      'javascript'    => 'Hadits/list/javascript',
      'modal'         => 'Hadits/list/modal',
      'viewMHadits'   => $viewMHadits,
      'tblMBab'   => $tblMBab,
      'tblMKitab'   => $tblMKitab,
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
		$data = array(
      'title'         => 'Detail Hadits | Knowledge Management System',
			'content'       => 'Hadits/detail/content',
      'css'           => 'Hadits/detail/css',
      'javascript'    => 'Hadits/detail/javascript',
			'modal'         => 'Hadits/detail/modal',
			'tblMHadits'	=> $this->View_master_hadits->where($rules)->row(),
			'tblMKitab'	=> $this->Tbl_master_kitab->read($rules2)->result(),
			'tblMBab'	=> $this->Tbl_master_bab->read($rules2)->result()
		);
		$this->load->view('index',$data);
	}

  public function filter($num = ''){
    $perpage = 12;
    $offset = $this->uri->segment(3);
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
      'limit'     => array('awal' => $perpage, 'akhir' => $offset),
      'pagging'   => null,
    );
    $viewMHadits = $this->View_master_hadits->where($rules)->result();
    
    $rules = array(
      'select'    => null,
      'where'     => $arr,
      'or_where'  => null,
      'order'     => null,
      'limit'     => null,
      'pagging'   => null,
    );
    $config['base_url'] = site_url().'/Hadits/Filter/';
    $config['total_rows'] = $this->View_master_hadits->where($rules)->num_rows();
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
    $tblMBab = $this->Tbl_master_bab->read($rules)->result();
    $tblMKitab = $this->Tbl_master_kitab->read($rules)->result();
    $data = array(
      'title'         => 'Daftar Hadits | Knowledge Management System',
      'content'       => 'Hadits/list/content',
      'css'           => 'Hadits/list/css',
      'javascript'    => 'Hadits/list/javascript',
      'modal'         => 'Hadits/list/modal',
      'viewMHadits'   => $viewMHadits,
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
        'hadits_content' => $keyword
      ),
      'or_like'   =>  array(
        'hadits_name' => $keyword
      ),
      'order'     => null,
      'limit'     => array('awal' => $perpage, 'akhir' => $offset),
      'pagging'   => null,
    );
    $viewMHadits = $this->View_master_hadits->like($rules)->result();
    
    $rules = array(
      'select'    => null,
      'like'      => array(
        'hadits_content' => $keyword
      ),
      'or_like'   =>  array(
        'hadits_name' => $keyword
      ),
      'order'     => null,
      'limit'     => null,
      'pagging'   => null,
    );
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
    $tblMBab = $this->Tbl_master_bab->read($rules)->result();
    $tblMKitab = $this->Tbl_master_kitab->read($rules)->result();
    $data = array(
      'title'         => 'Daftar Hadits | Knowledge Management System',
      'content'       => 'Hadits/list/content',
      'css'           => 'Hadits/list/css',
      'javascript'    => 'Hadits/list/javascript',
      'modal'         => 'Hadits/list/modal',
      'viewMHadits'   => $viewMHadits,
      'tblMBab'   => $tblMBab,
      'tblMKitab'   => $tblMKitab,
    );
    $this->load->view('index', $data);
  }
}
