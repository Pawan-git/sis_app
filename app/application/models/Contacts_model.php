<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contacts_model extends CI_model{

	var $table = 'contacts';

	public function __construct(){

		parent::__construct();
		
		$this->load->database();

	}
	
	/*
	*@method: count_all: count all records
	*@return: number
	*/
	public function count_all()
	{
		$this->db->from($this->table);
		
		$query = $this->db->get();
		
		return $query->num_rows();
	}
	
	/*
	*@method: get_all_contact
	*@params: $email{String}
	*@params: $pass{String}
	*@return: array of contacts
	*/
	public function get_all_contact($offset, $limit=false)
	{
		$this->db->from($this->table);
		$this->db->order_by("contact_name", "ASC");
		if($limit)
			$this->db->limit($limit, $offset);
		
		$query = $this->db->get();
		
		return $query->result();
	}
 
	/*
	*@method: get_by_id
	*@params: $id{int}
	*@return: row
	*/
	public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('contact_id',$id);
		$query = $this->db->get();
 
		return $query->row();
	}
 
 	/*
	*@method: contact_add
	*@params: $data{array}
	*@return: boolean
	*/
	public function contact_add($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}
	
 	/*
	*@method: contact_update
	*@params: $where{array}
	*@params: $data{String}
	*@return: integer
	*/
	public function contact_update($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}
 
	/*
	*@method: delete_by_id
	*@params: $id{int}
	*@return: boolean
	*/
	public function delete_by_id($id)
	{
		$this->db->where('contact_id', $id);
		return $this->db->delete($this->table);
	}

	/*
	*@method: search_contact
	*@params: $search_query{String}
	*@return: array of contacts
	*/
	public function search_contact($search_query, $offset, $limit=false)
	{
		$this->db->from($this->table)
				->like('contact_name',$search_query)
				->or_like('contact_number',$search_query)
				->or_like('contact_note',$search_query)
				->or_like('created_at',date('Y-m-d', strtotime($search_query)));
				
		$this->db->order_by("contact_name", "ASC");
		if($limit)
			$this->db->limit($limit, $offset);
		
		$query = $this->db->get();
		
		return $query->result();
		
	}
 
	/*
	*@method: search_count
	*@params: $search_query{String}
	*@return: number: row count
	*/
	public function search_count($search_query)
	{
		$this->db->from($this->table)
				->like('contact_name',$search_query)
				->or_like('contact_number',$search_query)
				->or_like('contact_note',$search_query)
				->or_like('created_at',date('Y-m-d', strtotime($search_query)));
		
		$query = $this->db->get();
		
		return $query->num_rows();
		
	}
 
	
	
	
		

} // END Class: Contacts_model

