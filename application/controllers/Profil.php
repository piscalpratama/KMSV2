<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profil extends CI_Controller {

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
      $this->load->model('Histori/Tbl_histori_rekomendasi');
      $this->load->model('Histori/Tbl_histori_test');
      $this->load->model('Histori/Tbl_histori_belajar');
      $this->load->model('Settings/Tbl_setting');
      $this->load->model('Views/Histori/View_histori_rekomendasi');
      $this->load->model('Views/Histori/View_histori_belajar');
  }

	public function index() {
    $tes_num = false;
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
    $rules_hb = array(
      'select'    => null,
      'where'     => array(
        'created_by' => $this->session->userdata('id_users')
      ),
      'or_where'  => null,
      'order'     => null,
      'limit'     => null,
      'pagging'   => null,
    );
    $rules2 = array(
      'select'    => null,
      'where'     => array(
        'created_by' => $this->session->userdata('id_users')
      ),
      'or_where'  => null,
      'order'     => 'id_histori_tes DESC',
      'limit'     => null,
      'pagging'   => null,
    );
    $tblHTest = $this->Tbl_histori_test->where($rules2);
    
    $rekomendasi_tidakpaham = array();
    $rekomendasi_kurangpaham = array();
    $rekomendasi_paham = array();
    $rekomendasi_sangatpaham = array();

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
          'created_by' => $this->session->userdata('id_users'),
          'level' => $tblHTest->level,
        ),
        'or_where'  => null,
        'order'     => null,
        'limit'     => null,
        'pagging'   => null,
      );
      $tblHRekomendasi_pie = $this->View_histori_rekomendasi->where($rules_pie)->result();
      
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
        'title'         => 'Profil | Knowledge Management System',
        'content'       => 'profil/content',
        'css'           => 'profil/css',
        'javascript'    => 'profil/javascript',
        'modal'         => 'profil/modal',
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
      $this->load->view('index', $data);
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
      redirect('Profil');
    }else{
      if(!empty($this->input->post('password'))){
        $rules = array(
          'where' => array(
            'id_users' => $id,
          ),
          'data'  => array(
            'username' 	=> $this->input->post('username'),
            'nama' 	=> $this->input->post('nama'),
            'password' => md5(md5($this->input->post('password'))),
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
        if (!empty($_FILES["foto"]["name"])) {
          $config['upload_path']          = './uploads/foto/';
          $config['allowed_types']        = 'jpg|png|JPG|PNG';
          $config['file_name']            = $id;
          $config['overwrite']			= true;
          $config['max_size']             = 1024; // 1MB
          // $config['max_width']            = 1024;
          // $config['max_height']           = 768;
  
          $this->upload->initialize($config);

          if ($this->upload->do_upload('foto')) {
            $upload_data = $this->upload->data();
            $file_name = $upload_data['file_name'];
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
                'foto'  => $file_name
              ),
            );
            if ($this->Tbl_knowledge_profil->update($rules)) {
              $this->session->set_flashdata('message','Data berhasil diubah.');
              $this->session->set_flashdata('type_message','success');
              redirect('Profil');
            }else{
              $this->session->set_flashdata('message','Terjadi kesalahan dalam edit data.');
              $this->session->set_flashdata('type_message','danger');
              redirect('Profil');
            }
          }else{
            $this->session->set_flashdata('message', $this->upload->display_errors());
            $this->session->set_flashdata('type_message','danger');
            redirect('Profil');
          }
        }else{
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
            redirect('Profil');
          }else{
            $this->session->set_flashdata('message','Terjadi kesalahan dalam edit data.');
            $this->session->set_flashdata('type_message','danger');
            redirect('Profil');
          }
        }
      }else{
        $this->session->set_flashdata('message','Terjadi kesalahan dalam edit data.');
        $this->session->set_flashdata('type_message','danger');
        redirect('Profil');
      }
    }
  }

  function BabTreeJson(){
    $rules = array(
      'select'    => 'id_master_bab as id, bab_name as name, parent_id as parent',
      'order'     => null,
      'limit'     => null,
      'pagging'   => null,
    );
    
    $tblMBab = $this->Tbl_master_bab->read($rules)->result();

    $tree = $this->buildTree($tblMBab);
    
    $final_response['name'] = "ROOT";
    $final_response['color'] = "black";
    $final_response['children'] = $tree;

    echo json_encode($final_response);
  }

  function BabTreeJson2(){
    $rules = array(
      'select'    => 'id_master_bab as id, bab_name as name, parent_id as parent',
      'order'     => null,
      'limit'     => null,
      'pagging'   => null,
    );
    
    $tblMBab = $this->Tbl_master_bab->read($rules)->result();

    $tree = $this->buildTree2($tblMBab);
    
    $final_response['name'] = "ROOT";
    $final_response['color'] = "black";
    $final_response['children'] = $tree;

    echo json_encode($final_response);
  }

  function buildTree(array $elements, $parentId = 0) {
    $color = "black";
    $branch = array();

    foreach ($elements as $element) {
      if ($element->parent == $parentId) {
        $rules = array(
          'select'    => null,
          'where'     => array(
            'created_by' => $this->session->userdata('id_users')
          ),
          'or_where'  => null,
          'order'     => null,
          'limit'     => null,
          'pagging'   => null,
        );
        $tblHTest = $this->Tbl_histori_test->where($rules);
        //var_dump($rules);
        // echo $tblHTest->num_rows();
        // exit();
        if($tblHTest->num_rows() > 0){
          $tblHTest = $tblHTest->result();
          foreach($tblHTest as $b){
            $rules = array(
              'select'    => null,
              'where'     => array(
                'id_master_bab' => $element->id,
                'id_histori_tes' => $b->id_histori_tes,
              ),
              'or_where'  => null,
              'order'     => null,
              'limit'     => null,
              'pagging'   => null,
            );
            $tblHRekomendasi = $this->Tbl_histori_rekomendasi->where($rules);
            if($tblHRekomendasi->num_rows() > 0){
              $rules = array(
                'select'    => null,
                'where'     => array(
                  'id_master_bab' => $element->id,
                  'id_histori_tes' => $b->id_histori_tes,
                ),
                'or_where'  => null,
                'order'     => null,
                'limit'     => null,
                'pagging'   => null,
              );
              $tblHRekomendasi_row = $this->Tbl_histori_rekomendasi->where($rules)->row();
              if($tblHRekomendasi_row->score > 75){
                $color = 'green';
              }else if($tblHRekomendasi_row->score > 50){
                $color = 'orange';
              }else{
                $color = 'black';
              }
            }else{
              $color = 'black';
            }
          }
        }else{
          $color = 'black';
        }
        $element->color = $color;

        $children = $this->buildTree($elements, $element->id);
        if ($children) {
            $element->children = $children;
        }
        $branch[] = $element;
      }
    }
    
    return $branch;
  }

  function buildTree2(array $elements, $parentId = 0) {
    $color = "black";
    $branch = array();

    foreach ($elements as $element) {
      if ($element->parent == $parentId) {
        $element->color = $color;

        $children = $this->buildTree2($elements, $element->id);
        if ($children) {
            $element->children = $children;
        }
        $branch[] = $element;
      }
    }
    
    return $branch;
  }

}
