<?php
class User_model extends CI_model{

	public function __construct(){

		parent::__construct();
		
		$this->load->database();
		$this->table = 'user';
	}
	
	/*
	*@method: login_user
	*@params: $username{String}
	*@params: $pass{String}
	*@return: array of user | false(boolean)
	*/
	public function login_user($username,$pass){

		$this->db->select('user_id, username, fullname, user_type')
				->from($this->table)
				->where('username',$username)
				->where('password',SHA1($pass));

		if($query=$this->db->get())
		{
			return $query->row_array();
		}
		else{
			return false;
		} 
	 
	}

	/*
	*@method: getUserInfo
	*@params: $select_str{String}
	*@params: $whereCondn{Array}
	*@return: array of user
	*/
	public function getUserInfo($select_str, $whereCondn){
 
		$this->db->select($select_str)
				->from($this->table)
				->where($whereCondn);

		return $this->db->get()->row_array();
	 
	}

	/*
	*@method: saveUser
	*@params: $params{Array}
	*@return: last inserted id of user
	*/
	public function saveUser($params){
 
		$this->db->insert($this->table, $params);

		return $this->db->insert_id();
	 
	}

	/*
	*@method: updateUserInfo
	*@params: $where{array}
	*@params: $data{String}
	*@return: integer
	*/
	public function updateUserInfo($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
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
	*@method: getUserList
	*@params: $offset{Integer}
	*@params: $limit{Integer}
	*@return: array of objects
	*/
	public function getUserList($offset, $limit=false)
	{	
		$this->db->select('user_id, username, fullname, address, created_at')
			->from($this->table)
			->order_by("user_id", "DESC");
		if($limit)
			$this->db->limit($limit, $offset);
		
		$query = $this->db->get();
		
		return $query->result();
	}

	/*
	*@method: searchUser
	*@params: $search_query{String}
	*@return: array of objects
	*/
	public function searchUser($search_query, $offset, $limit=false)
	{
		$this->db->select('user_id, username, fullname, address, created_at')
			->from($this->table)
			->like('username',$search_query)
			->or_like('fullname',$search_query)
			->or_like('address',$search_query)
			->order_by("user_id", "DESC");

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
		$this->db->select('user_id, username, fullname, address, created_at')
			->from($this->table)
			->like('username',$search_query)
			->or_like('fullname',$search_query)
			->or_like('address',$search_query);
		
		$query = $this->db->get();
		return $query->num_rows();
		
	}

} // END Class: User_model