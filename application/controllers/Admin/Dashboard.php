<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	function __construct(){
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $hak_akses = $this->session->userdata('hak_akses');
        if ($hak_akses != "ADMIN" && $hak_akses != "EXPERT") {
            $this->session->set_flashdata('message','Hak akses ditolak.');
            redirect('Admin/Auth');
        }
    }

	public function index()
	{
		$data = array(
            'title'         => 'Dashboard | Admin KMS',
            'content'       => 'Admin/dashboard/content',
            'css'           => 'Admin/dashboard/css',
            'javascript'    => 'Admin/dashboard/javascript',
            'modal'         => 'Admin/dashboard/modal',
        );
    	$this->load->view('Admin/index', $data);
	}
}
