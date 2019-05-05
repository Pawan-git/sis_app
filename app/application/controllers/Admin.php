<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller {

	public function __construct(){

		parent::__construct();
		
		if (!$this->is_logged_in())
        {
            // User is not logged in
			redirect('user/login');
        }

        if (!$this->is_admin())
        {
            // User is not logged in
			redirect('404');
        }
		
		$this->load->model('User_model', 'user_model');
		$this->load->model('EmpExpense_model', 'emp_expense_model');
		
		$this->data = [];

	}
	
	/*
	*@method: index
	*@return: render view--list all expenses
	*/
	public function index()
	{	
		$this->data['title'] = 'Expenses';

        $limit = $this->input->get('show', TRUE);
		$page_num = $this->input->get('page', TRUE);
		
		if($limit){
			$total_rows = $this->data['limit'] = $this->limit = $limit;
		}
		
		$this->data['offset'] = 0;
		if($page_num){
			$this->data['offset'] = $this->limit*((int)$page_num-1);
		}
		
		$query = $this->input->get('query', TRUE);
		if(!empty($query))
		{
			$this->data['expenses'] = $this->emp_expense_model->searchExpenses($query, $this->data['offset'], $this->limit);
			$this->data['query'] = $query;
			$total_rows = $this->emp_expense_model->search_count($query);

		}else{

			$this->data['expenses'] = $this->emp_expense_model->getExpenses( $this->data['offset'], $this->limit );
			$total_rows = $this->emp_expense_model->count_all();
		}
	
		self::_paginate($baseurl=site_url('admin'), $total_rows);
		
		$parser['content']  =   $this->load->view('admin/user-expenses',$this->data,TRUE);
		$this->parser->parse('template', $parser);
	}

	/*
	*@method: monthwise_expense
	*@return: render view--list all month-wise total expense
	*/
	public function monthwise_expense()
	{	
		$this->data['title'] = 'Monthly Expenses';

        $limit = $this->input->get('show', TRUE);
		$page_num = $this->input->get('page', TRUE);
		
		if($limit){
			$total_rows = $this->data['limit'] = $this->limit = $limit;
		}
		
		$this->data['offset'] = 0;
		if($page_num){
			$this->data['offset'] = $this->limit*((int)$page_num-1);
		}
		
		if( $this->input->get('from_month') && $this->input->get('from_year') && $this->input->get('to_month') && $this->input->get('to_month') )
		{
			$where = [
				'DATE_FORMAT(expense_date, "%Y-%m") >= ' => date( 'Y-m', strtotime($this->input->get('from_year').'-'.$this->input->get('from_month')) ),
				'DATE_FORMAT(expense_date, "%Y-%m") <= ' => date( 'Y-m', strtotime($this->input->get('to_year').'-'.$this->input->get('to_month')) )
			];
			$this->data['expenses'] = $this->emp_expense_model->searchExpensesMonthwise($where, $this->data['offset'], $this->limit);
			
			$total_rows = $this->emp_expense_model->searchCountMonthwise($where);

		}else{

			$this->data['expenses'] = $this->emp_expense_model->getExpensesMonthwise( $this->data['offset'], $this->limit );
			$total_rows = $this->emp_expense_model->countMonthwise();
		}
		
		self::_paginate($baseurl=site_url('admin'), $total_rows);
		
		$parser['content']  =   $this->load->view('admin/expenses-monthwise',$this->data,TRUE);
		$this->parser->parse('template', $parser);
	}
	
	/*
	*@method: upload_expense_file
	* function will add the expenses records into DB from uploaded file
	*@return: json
	*/
	public function upload_expense_file()
	{
		if (empty($_FILES) ){
			redirect('admin');
		}

		$allowed =  array('psv');
		$filename = $_FILES['expense_file']['name'];
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		if(!in_array($ext,$allowed) ) {
			$this->session->set_flashdata('error_msg','Please choose a valid file.');
		    redirect('admin');
		}

        $file = $_FILES['expense_file']['tmp_name'];
        $h = fopen($file, "rt");
		$exepense_array = [];
		while (!feof($h)) { 
		    $exepense_array[] = explode('|', rtrim(fgets($h), "\n"));

		} 
		fclose($h); 
		
		unset($exepense_array[0]);

		$expense_data = [];
		$created_at = date('Y-m-d H:i:s');
		foreach ($exepense_array as $row) :
			# code...
			$address_parts = preg_split('/\s+/', $row[3]);
			$username = strtolower(preg_replace('/\s+/', '_', $row[2])) .$address_parts[0].end($address_parts);

			$userInfo = $this->user_model->getUserInfo($select_str='user_id', $whereCondn=['username'=>$username]);
			if( empty($userInfo) ){
				$user_data = [
					'username' => $username,
					'fullname' => $row[2],
					'password' => sha1($username),
					'address' => $row[3],
					'user_type' => 'EMP',
					'created_at' => $created_at
				];

				$user_id = $this->user_model->saveUser($user_data);
			}else{
				$user_id = $userInfo['user_id'];
			}
			
			$expense_data[] = [
				'expense_category' => $row[1],
				'expense_description' => $row[4],
				'pre_tax_amount' => $row[5],
				'tax_amount' => $row[6],
				'expense_date' => date('Y-m-d', strtotime($row[0])),
				'user_ref' => $user_id,
				'created_at' => $created_at
			];

		endforeach;
		
		if( !empty($expense_data) ){
			$this->emp_expense_model->saveBatch($expense_data);
		}

		redirect('admin');

	}
	
	/*
	*@method: user_list:- function will list users
	*@return: renser view
	*/
	public function user_list()
	{
		$this->data['title'] = 'Users';

        $limit = $this->input->get('show', TRUE);
		$page_num = $this->input->get('page', TRUE);
		
		if($limit){
			$total_rows = $this->data['limit'] = $this->limit = $limit;
		}
		
		$this->data['offset'] = 0;
		if($page_num){
			$this->data['offset'] = $this->limit*((int)$page_num-1);
		}
		
		$query = $this->input->get('query', TRUE);
		if(!empty($query))
		{
			$this->data['user_list'] = $this->user_model->searchUser($query, $this->data['offset'], $this->limit);
			$this->data['query'] = $query;
			$total_rows = $this->user_model->search_count($query);

		}else{

			$this->data['user_list'] = $this->user_model->getUserList( $this->data['offset'], $this->limit );
			$total_rows = $this->user_model->count_all();
		}
		
		self::_paginate($baseurl=site_url('admin/user-list'), $total_rows);
		
		$parser['content']  =   $this->load->view('admin/user-list',$this->data,TRUE);
		$this->parser->parse('template', $parser);
	}
	
		
} // END: class Phonebook