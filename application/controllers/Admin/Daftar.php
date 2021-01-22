<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once './vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Daftar extends CI_Controller {
	var $url_salam = "https://api.uinsgd.ac.id/salam/";
	function __construct(){
    parent::__construct();
    date_default_timezone_set('Asia/Jakarta');
    $level = $this->session->userdata('level');
    if ($level != "SUPERADMIN" && $level != "ADMIN") {
        $this->session->set_flashdata('message','Hak akses ditolak.');
        redirect('Admin/Auth');
    }
    $this->load->model('Settings/Tbl_setting_tipe_file');
    $this->load->model('Settings/Tbl_setting_kabupaten');
    $this->load->model('Settings/Tbl_setting_kecamatan');
    $this->load->model('Settings/Tbl_setting_kelurahan');
    $this->load->model('Settings/Tbl_setting_provinsi');
    $this->load->model('Settings/Tbl_setting_fakultas');
    $this->load->model('PPA/Tbl_file');
    $this->load->model('PPA/Tbl_daftar');
    $this->load->model('PPA/Tbl_orangtua');
    $this->load->model('Views/View_orangtua');
    $this->load->model('Views/View_daftar');
    $this->load->model('Views/View_setting_fakultas_jurusan');
    $this->load->model('ServerSide/SS_daftar');
    $this->load->model('ServerSide/SS_daftar_mengajukan');
  }

	public function Mengajukan()
	{
    $rules = array(
      'select'    => 'YEAR(date_created) as tahun',
      'where'     => null,
      'order'     => null,
    );
    $tahun = $this->Tbl_daftar->distinct($rules)->result();
    $rules = array(
      'select'    => null,
      'order'     => null,
      'limit'     => null,
      'pagging'   => null,
    );
    $tblSFakultas = $this->Tbl_setting_fakultas->read($rules)->result();
		$data = array(
        'title'         => 'Data Daftar | Admin Pelatihan ICT',
        'content'       => 'Admin/Daftar/read_mengajukan/content',
        'css'           => 'Admin/Daftar/read_mengajukan/css',
        'javascript'    => 'Admin/Daftar/read_mengajukan/javascript',
        'modal'         => 'Admin/Daftar/read_mengajukan/modal',
        'tahun'         => $tahun,
        'tblSFakultas'         => $tblSFakultas,
    );
    $this->load->view('Admin/index', $data);
  }

  public function index()
	{
    $rules = array(
      'select'    => 'YEAR(date_created) as tahun',
      'where'     => null,
      'order'     => null,
    );
    $tahun = $this->Tbl_daftar->distinct($rules)->result();
    $rules = array(
      'select'    => null,
      'order'     => null,
      'limit'     => null,
      'pagging'   => null,
    );
    $tblSFakultas = $this->Tbl_setting_fakultas->read($rules)->result();
		$data = array(
        'title'         => 'Data Daftar | Admin Pelatihan ICT',
        'content'       => 'Admin/Daftar/read/content',
        'css'           => 'Admin/Daftar/read/css',
        'javascript'    => 'Admin/Daftar/read/javascript',
        'modal'         => 'Admin/Daftar/read/modal',
        'tahun'         => $tahun,
        'tblSFakultas'         => $tblSFakultas,
    );
    $this->load->view('Admin/index', $data);
  }
  
  public function Detail($nim)
	{
    $url = $this->url_salam."/Api/ProfileMhs/?nim=".$nim."&token=b97c190ce853064efe15ff431565dcf1";
    $mahasiswa = json_decode($this->curlGET($url));
    $parrams = array(
			'url' => 'https://simak.uinsgd.ac.id/akademik/services/my_service/get_ipk.php',
			'header' => array(
				"Content-Type: multipart/form-data",
			),
			'request' => array(
				"token" => 'XjDfKZvYiZu2w7qiS64fjagqEcGzkZ18txWjAfKnLb4P8NxOo1OBZ4QTgRVYFjm9',
				"nim" => $nim,
			),
		);
		$ipk = json_decode($this->curlPOST($parrams));
		$rules = array(
        'select'    => null,
        'where'     => array(
            'kategori' => 'PENGAJUAN'
        ),
        'or_where'  => null,
        'order'     => null,
        'limit'     => null,
        'pagging'   => null,
    );
    $tblSTipeFile = $this->Tbl_setting_tipe_file->where($rules)->result();
    $rules = array(
      'select'    => null,
      'where'     => array(
          'nim' => $nim
      ),
      'or_where'  => null,
      'order'     => null,
      'limit'     => null,
      'pagging'   => null,
    );
    $tblDaftar = $this->Tbl_daftar->where($rules)->row();
		foreach($tblSTipeFile as $a){
      $rules = array(
          'select'    => null,
          'where'     => array(
              'id_tipe_file' => $a->id_tipe_file,
              'id_daftar' => $tblDaftar->id_daftar,
          ),
          'or_where'  => null,
          'order'     => null,
          'limit'     => null,
          'pagging'   => null,
      );
      $tblFile[$a->id_tipe_file] = $this->Tbl_file->where($rules)->row();
    }
    $rules = array(
        'select'    => null,
        'order'     => null,
        'limit'     => null,
        'pagging'   => null,
    );
    $tbProv = $this->Tbl_setting_provinsi->read($rules)->result();
    $rules = array(
        'select'    => null,
        'where'     => array(
            'id_daftar' => $tblDaftar->id_daftar
        ),
        'or_where'  => null,
        'order'     => null,
        'limit'     => null,
        'pagging'   => null,
    );
    $tblOrangtua = $this->View_orangtua->where($rules)->row();
    $rules = array(
      'select'    => null,
      'where'     => array(
          'id_fakultas' => $mahasiswa->data->jurusan->fak_kode
      ),
      'or_where'  => null,
      'order'     => null,
      'limit'     => null,
      'pagging'   => null,
    );
    $tblSFakultas = $this->Tbl_setting_fakultas->where($rules)->row();
		$data = array(
      'title'         => 'Detail Mahasiswa | Admin Beasiswa PPA',
      'content'       => 'Admin/Daftar/detail/content',
      'css'           => 'Admin/Daftar/detail/css',
      'javascript'    => 'Admin/Daftar/detail/javascript',
      'modal'         => 'Admin/Daftar/detail/modal',
      'mahasiswa'     => $mahasiswa,
			'tblSTipeFile' => $tblSTipeFile,
			'tblSFakultas' => $tblSFakultas,
			'tblDaftar' => $tblDaftar,
			'tblFile' => $tblFile,
			'tbProv' => $tbProv,
      'tblOrangtua' => $tblOrangtua,
      'ipk' => $ipk
    );
    $this->load->view('Admin/index', $data);
  }

  function UpdateStatus($id, $nim){
    $rules = array(
      'where' => array(
          'id_daftar' => $id,
      ),
      'data'  => array(
          'status' 	=> $this->input->post('status'),
          'updated_by' => $this->session->userdata('id_users')
      ),
    );
    if ($this->Tbl_daftar->update($rules)) {
        $this->session->set_flashdata('message','Data berhasil diubah');
        $this->session->set_flashdata('type_message','success');
        redirect('Admin/Daftar/Detail/'.$nim);	
    }else{
        $this->session->set_flashdata('message','Terjadi kesalahan dalam proses simpan data');
        $this->session->set_flashdata('type_message','danger');
        redirect('Admin/Daftar/Detail/'.$nim);
    }
  }

  function ExportExcel(){
    ini_set('max_execution_time', 0);
    ini_set('memory_limit', '-1');
    $status = $this->input->post('status');
    $fakultas = $this->input->post('fakultas');
    $tahun = $this->input->post('tahun');
    if($fakultas == '-'){
      $rules = array(
          'select'    => null,
          'where'     => array(
            'status' => $status,
            'YEAR(date_created)' => $tahun,
          ),
          'or_where'  => null,
          'order'     => null,
          'limit'     => null,
          'pagging'   => null,
      );
      $tblDaftar = $this->View_daftar->where($rules);
    }else{

      $rules = array(
        'select'    => null,
        'where'     => array(
          'status' => $status,
          'id_fakultas' => $fakultas,
          'YEAR(date_created)' => $tahun,
        ),
        'or_where'  => null,
        'order'     => null,
        'limit'     => null,
        'pagging'   => null,
      );
      $tblDaftar = $this->View_daftar->where($rules);
    }
    if ($tblDaftar->num_rows() > 0){
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $spreadsheet->getActiveSheet()->getPageSetup()->setFitToWidth(1);
      $spreadsheet->getActiveSheet()->getPageSetup()->setFitToHeight(1);
      //table header
      $cols = array("A","B","C","D","E","F","G");
      $val = array(
          "No.","NIM","Nama", "Fakultas", "Jurusan", "IPK", "Status"
      );
      for ($a = 0; $a < 7; $a++) {
          $sheet->setCellValue($cols[$a].'1', $val[$a]);
      }
      $baris  = 2;
      $no = 1;
      foreach ($tblDaftar->result() as $value){
        //pemanggilan sesuaikan dengan nama kolom tabel
        if($value->status == '1'):
          $stat = "Mengajukan";
        elseif($value->status == '2'):
          $stat = "Lolos";
        else:
          $stat = "Melakukan Login";
        endif;
        $sheet->setCellValue("A".$baris, $no);
        $sheet->setCellValue("B".$baris, $value->nim);
        $sheet->setCellValue("C".$baris, $value->nama);
        $sheet->setCellValue("D".$baris, $value->jurusan);
        $sheet->setCellValue("E".$baris, $value->fakultas);
        $sheet->setCellValue("F".$baris, $value->ipk);
        $sheet->setCellValue("G".$baris, $stat);

        //Set number value
        //$objPHPExcel->getActiveSheet()->getStyle('C1:C'.$baris)->getNumberFormat()->setFormatCode('0');

        $baris++;
        $no++;
      }
      $writer = new Xlsx($spreadsheet);
      $filename = urlencode("DataDaftar_".date("Y_m_d_H_i_s").".xlsx");
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="'.$filename.'"');
      header('Cache-Control: max-age=0');
      $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
      $writer->save('php://output');
    }else{
      $this->session->set_flashdata('message','Data kosong.');
      $this->session->set_flashdata('type_message','danger');
      redirect('Admin/Daftar/');
    }
  }

  function ImportExcel(){
    $config = array(
			'upload_path'   => './import/ppa/',
			'allowed_types' => 'xls|xlsx|csv|ods|ots',
			'max_size'      => 51200,
			'overwrite'     => TRUE,
			'file_name'     => 'DATA_DAFTAR_STATUS_'.date('Y').'_'.date('H i s d m Y'),
		);
		$this->upload->initialize($config);
		if(!$this->upload->do_upload('file_import')){
			$this->session->set_flashdata('message',$this->upload->display_errors());
			$this->session->set_flashdata('type_message','danger');
			redirect('Admin/Daftar/');
		}else{
			$file = $this->upload->data();
			$inputFileName = 'import/ppa/'.$file['file_name'];
			try {
				$inputFileType = 'Xlsx'; // Xls, Xlsx, Xml, Ods, Slk, Gnumeric, Csv
				/**  Create a new Reader of the type defined in $inputFileType  **/
				$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
				/**  Advise the Reader that we only want to load cell data  **/
				$reader->setReadDataOnly(true);
				/**  Advise the Reader of which WorkSheets we want to load  **/
				//$reader->setLoadSheetsOnly($sheetname);
				/**  Load $inputFileName to a Spreadsheet Object  **/
				$spreadsheet = $reader->load($inputFileName);
			} catch (Exception $e) {
				die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'" : '.$e->getMessage());
			}
			$sheet	= $spreadsheet->getSheet(0);
			$highestRow	= $sheet->getHighestRow();
			for ($row = 2; $row <= $highestRow; $row++) {
				$nim	= $sheet->getCellByColumnAndRow(1,$row)->getValue();
				$nama			= str_replace('\'','`',strtoupper($sheet->getCellByColumnAndRow(2,$row)->getValue()));
				$status	= $sheet->getCellByColumnAndRow(3,$row)->getValue();
				$rules = array(
					'select'    => null,
					'where'      => array(
            'nim' => $nim,
					),
					'or_where'   => null,
					'order'     => null,
					'limit'     => null,
					'pagging'   => null,
				);
        $tblDaftar_num = $this->Tbl_daftar->where($rules)->num_rows();
				$tblDaftar = $this->Tbl_daftar->where($rules)->row();
				if($tblDaftar_num > 0){
					$rules2 = array(
						'where' => array(
							'id_daftar' => $tblDaftar->id_daftar
						),
						'data'  => array(
							'status' => "$status",
							'date_updated' => date('Y-m-d H:i:s'),
						),
					);
					$this->Tbl_daftar->update($rules2);
        }
			}
			$this->session->set_flashdata('message','Import berhasil.');
			$this->session->set_flashdata('type_message','success');
			redirect('Admin/Daftar/');
		}
  }
  
  function getIPKAll(){
    $rules = array(
      'select'    => null,
      'order'     => null,
      'limit'     => null,
      'pagging'   => null,
    );
    $tblDaftar = $this->Tbl_daftar->read($rules)->result();
    $num=1;
    foreach($tblDaftar as $a){
      $parrams = array(
        'url' => 'https://simak.uinsgd.ac.id/akademik/services/my_service/get_ipk.php',
        'header' => array(
          "Content-Type: multipart/form-data",
        ),
        'request' => array(
          "token" => 'XjDfKZvYiZu2w7qiS64fjagqEcGzkZ18txWjAfKnLb4P8NxOo1OBZ4QTgRVYFjm9',
          "nim" => $a->nim,
        ),
      );
      $dipk = json_decode($this->curlPOST($parrams));
      // var_dump($dipk[0]->ipk);
      // exit();
      $rules = array(
        'where' => array(
          'id_daftar' => $a->id_daftar
        ),
        'data'  => array(
          'ipk' => $dipk[0]->ipk
        ),
      );
      if($this->Tbl_daftar->update($rules)){
        $num++;
      }
    }
    echo 'berhasil = '.$num;
  }

  function getIPK(){
    $rules = array(
      'select'    => null,
      'order'     => null,
      'limit'     => null,
      'pagging'   => null,
    );
    $tblDaftar = $this->Tbl_daftar->read($rules)->result();
    $num=1;
    foreach($tblDaftar as $a){
      if($a->ipk != ''){
        continue;
      }
      $parrams = array(
        'url' => 'https://simak.uinsgd.ac.id/akademik/services/my_service/get_ipk.php',
        'header' => array(
          "Content-Type: multipart/form-data",
        ),
        'request' => array(
          "token" => 'XjDfKZvYiZu2w7qiS64fjagqEcGzkZ18txWjAfKnLb4P8NxOo1OBZ4QTgRVYFjm9',
          "nim" => $a->nim,
        ),
      );
      $dipk = json_decode($this->curlPOST($parrams));
      // var_dump($dipk[0]->ipk);
      // exit();
      $rules = array(
        'where' => array(
          'id_daftar' => $a->id_daftar
        ),
        'data'  => array(
          'ipk' => $dipk[0]->ipk
        ),
      );
      if($this->Tbl_daftar->update($rules)){
        $num++;
      }
    }
    echo 'berhasil = '.$num;
  }

  function getNamaAll(){
    $rules = array(
      'select'    => null,
      'order'     => null,
      'limit'     => null,
      'pagging'   => null,
    );
    $tblDaftar = $this->Tbl_daftar->read($rules)->result();
    $num=0;
    foreach($tblDaftar as $a){
      $url = $this->url_salam."/Api/ProfileMhs/?nim=".$a->nim."&token=b97c190ce853064efe15ff431565dcf1";
      $mahasiswa = json_decode($this->curlGET($url));
      // var_dump($mahasiswa->data->mahasiswa->nama);
      // exit();
      $rules = array(
        'where' => array(
          'id_daftar' => $a->id_daftar
        ),
        'data'  => array(
          'nama' => $mahasiswa->data->mahasiswa->nama
        ),
      );
      if($this->Tbl_daftar->update($rules)){
        $num++;
      }
    }
    echo 'berhasil = '.$num;
  }

  function getNama(){
    $rules = array(
      'select'    => null,
      'order'     => null,
      'limit'     => null,
      'pagging'   => null,
    );
    $tblDaftar = $this->Tbl_daftar->read($rules)->result();
    $num=0;
    foreach($tblDaftar as $a){
      if($a->nama != ''){
        continue;
      }
      $url = $this->url_salam."/Api/ProfileMhs/?nim=".$a->nim."&token=b97c190ce853064efe15ff431565dcf1";
      $mahasiswa = json_decode($this->curlGET($url));
      // var_dump($mahasiswa->data->mahasiswa->nama);
      // exit();
      $rules = array(
        'where' => array(
          'id_daftar' => $a->id_daftar
        ),
        'data'  => array(
          'nama' => $mahasiswa->data->mahasiswa->nama
        ),
      );
      if($this->Tbl_daftar->update($rules)){
        $num++;
      }
    }
    echo 'berhasil = '.$num;
  }

  function curlPOST($data){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_URL, $data['url']);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data['request']);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $data['header']);
		$respond = curl_exec ($ch); //print_r($data);
		curl_close ($ch);
		//$respond = json_decode($data);
		return $respond;
	}

  function curlGET($url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($ch);
		curl_close($ch);
		return $output;
  }
  
  function Json(){
    $fetch_data = $this->SS_daftar->make_datatables();
    $data = array();
    $no = 1;
    foreach($fetch_data as $row){
        $sub_array = array();
        if($row->status == '0'):
          $status = '<div class="badge badge-default">melakukan login</div>';
        elseif($row->status == '1'):
          $status = '<div class="badge badge-warning">mengajukan</div>';
        elseif($row->status == '2'):
          $status = '<div class="badge badge-success">lolos</div>';
        else:
          $status = '<div class="badge badge-danger">tidak lolos</div>';
        endif;
        $sub_array[] = "
          <a class=\"btn btn-primary btn-xs\" href=\"".base_url('Admin/Daftar/Detail/'.$row->nim)."\" target=\"_blank\"><i class=\"fas fa-paste\"></i></a>
        ";
        $sub_array[] = $no++;
        $sub_array[] = $row->nim;
        $sub_array[] = $row->nama;
        $sub_array[] = $row->ipk;
        $sub_array[] = $row->jurusan;
        $sub_array[] = $row->fakultas;
        $sub_array[] = $status;
        $data[] = $sub_array;
    }
    $output = array(
        "draw"				=>	intval($_POST["draw"]),
        "recordsTotal"		=>	$this->SS_daftar->get_all_data(),
        "recordsFiltered"	=>	$this->SS_daftar->get_filtered_data(),
        "data"				=>	$data
    );
    echo json_encode($output);
  }

  function Json2(){
    $fetch_data = $this->SS_daftar_mengajukan->make_datatables();
    $data = array();
    $no = 1;
    foreach($fetch_data as $row){
        $sub_array = array();
        if($row->status == '0'):
          $status = '<div class="badge badge-default">melakukan login</div>';
        elseif($row->status == '1'):
          $status = '<div class="badge badge-warning">mengajukan</div>';
        elseif($row->status == '2'):
          $status = '<div class="badge badge-success">lolos</div>';
        else:
          $status = '<div class="badge badge-danger">tidak lolos</div>';
        endif;
        $sub_array[] = "
        <a class=\"btn btn-primary btn-xs\" href=\"".base_url('Admin/Daftar/Detail/'.$row->nim)."\" target=\"_blank\"><i class=\"fas fa-paste\"></i></a>
        ";
        $sub_array[] = $no++;
        $sub_array[] = $row->nim;
        $sub_array[] = $row->nama;
        $sub_array[] = $row->ipk;
        $sub_array[] = $row->jurusan;
        $sub_array[] = $row->fakultas;
        $sub_array[] = $status;
        $data[] = $sub_array;
    }
    $output = array(
        "draw"				=>	intval($_POST["draw"]),
        "recordsTotal"		=>	$this->SS_daftar_mengajukan->get_all_data(),
        "recordsFiltered"	=>	$this->SS_daftar_mengajukan->get_filtered_data(),
        "data"				=>	$data
    );
    echo json_encode($output);
  }
}
