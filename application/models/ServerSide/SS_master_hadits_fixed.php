<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class SS_master_hadits_fixed extends CI_Model {
	var $table = "view_master_hadits_fixed";  //table yang ingin di tampilkan
	var $select_column = array(
		'id_master_hadits',
		'hadits_name',
		'hadits_content',
		'hadits_arab',
		'keterangan',
		'bab_name',
		'kitab_name'
    );  //sesuaikan dengan nama field table
	var $order_column = array(
        null,
        'id_master_hadits',
		'hadits_name',
		'hadits_content',
		'hadits_arab',
		'keterangan',
		'bab_name',
		'kitab_name'
    );

	function make_query(){
		$this->db->select($this->select_column);
		$this->db->from($this->table);
		if(isset($_POST["search"]["value"])) {
			$this->db->or_like("hadits_name", $_POST["search"]["value"]);
			$this->db->or_like("hadits_content", $_POST["search"]["value"]);
			$this->db->or_like("hadits_arab", $_POST["search"]["value"]);
			$this->db->or_like("keterangan", $_POST["search"]["value"]);
			$this->db->or_like("bab_name", $_POST["search"]["value"]);
			$this->db->or_like("kitab_name", $_POST["search"]["value"]);
		}
		if(isset($_POST["order"])) {
			$this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else {
			$this->db->order_by('id_master_hadits', 'ASC');
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
