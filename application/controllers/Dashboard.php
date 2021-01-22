<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	function __construct(){
      parent::__construct();
      date_default_timezone_set('Asia/Jakarta');
      if (!$this->session->userdata('logged')) {
					$this->session->set_flashdata('message','Hak akses ditolak.');
          redirect('Auth/');
      }
      $this->load->model('Knowledge/Tbl_knowledge_users');
      $this->load->model('Knowledge/Tbl_knowledge_profil');
      $this->load->model('Settings/Tbl_setting');
  }

	public function index()
	{
  $data = array(
      'title'         => 'Dashboard | Knowledge Management System',
      'content'       => 'dashboard/content',
      'css'           => 'dashboard/css',
      'javascript'    => 'dashboard/javascript',
      'modal'         => 'dashboard/modal',
    );
    $this->load->view('index', $data);
  }
}
