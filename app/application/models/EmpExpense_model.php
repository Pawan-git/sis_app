<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EmpExpense_model extends CI_model{

	var $table = 'emp_expense';

	public function __construct(){

		parent::__construct();
		
		$this->load->database();

	}
	
	/*
	*@method: saveBatch: Insert batch
	*@return: boolean
	*/
	public function saveBatch($expense_data)
	{
		$this->db->insert_batch($this->table, $expense_data);
		return true;
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
	*@method: getExpensesWhere
	*@params: $offset{Integer}
	*@params: $limit{Integer}
	*@params: $where{Array}
	*@return: array of expenses
	*/
	public function getExpensesWhere($offset, $limit=false, $where=false)
	{
		$this->db->select('expense_id, expense_category, expense_description, pre_tax_amount, tax_amount, expense_date')
				->from($this->table)
				->order_by("expense_date", "DESC");
		if($where){
			$this->db->where($where);
		}
		if($limit)
			$this->db->limit($limit, $offset);
		
		$query = $this->db->get();
		/*echo $this->db->last_query(); die;*/
		return $query->result();
	}

	/*
	*@method: countExpensesWhere
	*@params: $where{Array}
	*@return: array of expenses
	*/
	public function countExpensesWhere($where=false)
	{
		$this->db->select('expense_id, expense_category, expense_description, pre_tax_amount, tax_amount, expense_date')
			->from($this->table);
		if($where){
			$this->db->where($where);
		}
		
		$query = $this->db->get();
		
		return $query->num_rows();
	}
	
	/*
	*@method: getExpenses
	*@params: $offset{Integer}
	*@params: $limit{Integer}
	*@return: array of expenses
	*/
	public function getExpenses($offset, $limit=false)
	{	
		$this->db->select('expense_id, expense_category, expense_description, pre_tax_amount, tax_amount, expense_date, user.fullname as emp_name, user.address as emp_address')
			->from($this->table)
			->join('user','user_ref = user_id','LEFT')
			->order_by("expense_date", "DESC");
		if($limit)
			$this->db->limit($limit, $offset);
		
		$query = $this->db->get();
		
		return $query->result();
	}

	/*
	*@method: searchExpenses
	*@params: $search_query{String}
	*@return: array of objects
	*/
	public function searchExpenses($search_query, $offset, $limit=false)
	{
		$this->db->select('expense_id, expense_category, expense_description, pre_tax_amount, tax_amount, expense_date, user.fullname as emp_name, user.address as emp_address')
			->from($this->table)
			->join('user','user_ref = user_id','LEFT')
			->like('expense_category',$search_query)
			->or_like('expense_description',$search_query)
			->or_like('fullname',$search_query)
			/*->or_like('created_at',date('Y-m-d', strtotime($search_query)))*/
			->order_by("expense_date", "DESC");

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
				->join('user','user_ref = user_id','LEFT')
				->like('expense_category',$search_query)
				->or_like('expense_description',$search_query)
				->or_like('fullname',$search_query);
				/*->or_like('created_at',date('Y-m-d', strtotime($search_query)));*/
		
		$query = $this->db->get();
		return $query->num_rows();
		
	}
 
	/*
	*@method: getExpensesMonthwise
	*@params: $offset{Integer}
	*@params: $limit{Integer}
	*@return: array of expenses
	*/
	public function getExpensesMonthwise($offset, $limit=false, $user_id=false)
	{	
		$this->db->select('sum(pre_tax_amount) as pre_tax_amount, sum(tax_amount) as tax_amount, DATE_FORMAT(expense_date, "%Y-%m") as expense_year_month')
			->from($this->table)
			->group_by('expense_year_month')
			->order_by("expense_year_month", "DESC");

		if($user_id)
			$this->db->where(['user_ref'=>$user_id]);
			
		if($limit)
			$this->db->limit($limit, $offset);
		
		$query = $this->db->get();
		return $query->result();
	}

	/*
	*@method: countMonthwise: count monthly records
	*@return: number
	*/
	public function countMonthwise($user_id=false)
	{	
		$this->db->select('DATE_FORMAT(expense_date, "%Y-%m") as expense_year_month')
			->from($this->table)
			->group_by('expense_year_month');

		if($user_id)
			$this->db->where(['user_ref'=>$user_id]);

		$query = $this->db->get();
		
		return $query->num_rows();
	}

	/*
	*@method: searchExpensesMonthwise
	*@params: $whereCondn{Array}
	*@return: array of objects
	*/
	public function searchExpensesMonthwise($whereCondn, $offset, $limit=false)
	{
		$this->db->select('sum(pre_tax_amount) as pre_tax_amount, sum(tax_amount) as tax_amount, DATE_FORMAT(expense_date, "%Y-%m") as expense_year_month')
			->from($this->table)
			->where($whereCondn)
			->group_by('expense_year_month')
			->order_by("expense_year_month", "DESC");

		if($limit)
			$this->db->limit($limit, $offset);
		
		$query = $this->db->get();
		#echo $this->db->last_query(); die;
		return $query->result();
		
	}
 
	/*
	*@method: searchCountMonthwise
	*@params: $$whereCondn{Array}
	*@return: number: row count
	*/
	public function searchCountMonthwise($whereCondn)
	{
		$this->db->select('sum(pre_tax_amount) as pre_tax_amount, sum(tax_amount) as tax_amount, DATE_FORMAT(expense_date, "%Y-%m") as expense_year_month')
			->from($this->table)
			->where($whereCondn)
			->group_by('expense_year_month');
		
		$query = $this->db->get();
		return $query->num_rows();
		
	}
 	
} // END Class: EmpExpense_model

