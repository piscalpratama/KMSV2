<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class SS_knowledge_users extends CI_Model {
	var $table = "view_knowledge_users";  //table yang ingin di tampilkan
	var $select_column = array(
		'id_users',
		'username',
		'nama',
		'foto',
		'level',
		'alamat',
		'jenis_kelamin',
		'no_telp',
		'tempat_lahir',
		'tgl_lahir'
    );  //sesuaikan dengan nama field table
	var $order_column = array(
        null,
        'id_users',
		'username',
		'nama',
		'foto',
		'level',
		'alamat',
		'jenis_kelamin',
		'no_telp',
		'tempat_lahir',
		'tgl_lahir'
    );

	function make_query(){
		$this->db->select($this->select_column);
		$this->db->from($this->table);
		if(isset($_POST["search"]["value"])) {
			$this->db->or_like("username", $_POST["search"]["value"]);
			$this->db->or_like("nama", $_POST["search"]["value"]);
			$this->db->or_like("level", $_POST["search"]["value"]);
			$this->db->or_like("jenis_kelamin", $_POST["search"]["value"]);
		}
		if(isset($_POST["order"])) {
			$this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else {
			$this->db->order_by('id_users', 'ASC');
		}
	}

	function make_datatables(){
		$this->make_query();
		if($_POST["length"] != -1) {
			$this->db->limit($_POST['length'], $_POST['start']);
		}
		$query = $this->db->get();
		return $query->result();
	}

	function get_filtered_data(){
		$this->make_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	function get_all_data(){
		$this->db->select("*");
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}
}