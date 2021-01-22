<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Tbl_histori_jawaban extends CI_Model {

    var $database = "tbl_histori_jawaban";

    public function create($data){
        if($this->db->insert($this->database,$data)){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    /**
     * Rules Attributed Read Data
     * $rules = array(
     *  'select'    => null,
     *  'order'     => null,
     *  'limit'     => null,
     *  'pagging'   => null,
     * );
     **/
    public function read($rules){
        if ($rules['select'] != null){
            $this->db->select($rules['select']);
        }
        if ($rules['order'] != null){
            $this->db->order_by($rules['order']);
        }
        if ($rules['limit'] != null){
            $limit = $rules['limit'];
            $this->db->limit($limit['awal'], $limit['akhir']);
        }
        if ($rules['pagging'] != null){
            $pagging = $rules['pagging'];
            return $this->db->get($this->database, $pagging['num'], $pagging['offset']);
        }else{
            return $this->db->get($this->database);
        }
    }

    /**
     * Rules Attributed Update Data
     * $rules = array(
     *  'where' => not null,
     *  'data'  => not null,
     * );
     **/
    public function update($rules){
        $this->db->where($rules['where']);
        if($this->db->update($this->database,$rules['data'])){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function delete($where){
        $this->db->where($where);
        if($this->db->delete($this->database)){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    /* Extra */

    /**
     * Rules Attributed Where Data
     * $rules = array(
     *  'select'    => null,
     *  'where'     => not null or null,
     *  'or_where'  => not null or null,
     *  'order'     => null,
     *  'limit'     => null,
     *  'pagging'   => null,
     * );
     **/
    public function where($rules){
        if ($rules['select'] != null){
            $this->db->select($rules['select']);
        }
        if ($rules['where'] != null && $rules['or_where'] != null){
            $this->db->where($rules['where']);
            $this->db->or_where($rules['or_where']);
        }else if ($rules['where'] != null){
            $this->db->where($rules['where']);
        }else if ($rules['or_where'] != null){
            $this->db->or_where($rules['or_where']);
        }else{
            $this->db->where(1);
        }
        if ($rules['order'] != null){
            $this->db->order_by($rules['order']);
        }
        if ($rules['limit'] != null){
            $limit = $rules['limit'];
            $this->db->limit($limit['awal'], $limit['akhir']);
        }
        if ($rules['pagging'] != null){
            $pagging = $rules['pagging'];
            return $this->db->get($this->database, $pagging['num'], $pagging['offset']);
        }else{
            return $this->db->get($this->database);
        }
    }

    /**
     * Rules Attributed Like Data
     * $rules = array(
     *  'select'    => null,
     *  'like'      => not null or null,
     *  'or_like'    => not null or null,
     *  'order'     => null,
     *  'limit'     => null,
     *  'pagging'   => null,
     * );
     **/
    public function like($rules){
        if ($rules['select'] != null){
            $this->db->select($rules['select']);
        }
        if ($rules['like'] != null && $rules['or_like'] != null){
            $this->db->like($rules['like']);
            $this->db->or_like($rules['or_like']);
        }else if ($rules['like'] != null){
            $this->db->like($rules['like']);
        }else if ($rules['or_like'] != null){
            $this->db->or_like($rules['or_like']);
        }else{
            $this->db->where(1);
        }
        if ($rules['order'] != null){
            $this->db->order_by($rules['order']);
        }
        if ($rules['limit'] != null){
            $limit = $rules['limit'];
            $this->db->limit($limit['awal'], $limit['akhir']);
        }
        if ($rules['pagging'] != null){
            $pagging = $rules['pagging'];
            return $this->db->get($this->database, $pagging['num'], $pagging['offset']);
        }else{
            return $this->db->get($this->database);
        }
    }

    /**
     * Rules Attributed Distinc Data
     * $rules = array(
     *  'select'    => not null,
     *  'where'     => null,
     *  'order'     => null,
     * );
     **/
    public function distinct($rules){
        $this->db->distinct();
        $this->db->select($rules['select']);
        if ($rules['where'] != null){
            $this->db->where($rules['where']);
        }
        if ($rules['order'] != null){
            $this->db->order_by($rules['order']);
        }
        return $this->db->get($this->database);
    }

}
