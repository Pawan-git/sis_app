<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

	public function __construct(){

		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('EmpExpense_model', 'emp_expense_model');
		
		$this->data = [];
	}
	
	/*
	*@method: index
	*@return: render view--list monthly expense
	*/
	public function index()
	{
		if (!$this->is_logged_in())
        {
            // User is not logged in
			redirect('user/login');
        }

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
				'user_ref'=>$this->session->userdata('user_data')['user_id'],
				'DATE_FORMAT(expense_date, "%Y-%m") >= ' => date( 'Y-m', strtotime($this->input->get('from_year').'-'.$this->input->get('from_month')) ),
				'DATE_FORMAT(expense_date, "%Y-%m") <= ' => date( 'Y-m', strtotime($this->input->get('to_year').'-'.$this->input->get('to_month')) )
			];
			$this->data['expenses'] = $this->emp_expense_model->searchExpensesMonthwise($where, $this->data['offset'], $this->limit);
			
			$total_rows = $this->emp_expense_model->searchCountMonthwise($where);

		}else{

			$this->data['expenses'] = $this->emp_expense_model->getExpensesMonthwise( $this->data['offset'], $this->limit, $this->session->userdata('user_data')['user_id'] );
			$total_rows = $this->emp_expense_model->countMonthwise();
		}
		
		self::_paginate($baseurl=site_url('user'), $total_rows);
		
		$parser['content']  =   $this->load->view('user/expenses-monthwise',$this->data,TRUE);
		$this->parser->parse('template', $parser);
		
	}

	/*
	*@method: expense_detail
	*@return: render view--list month-wise expense detail
	*/
	public function expense_detail($timestr=false)
	{
		if(!$timestr){
			redirect('404');
		}
		if (!$this->is_logged_in())
        {
            // User is not logged in
			redirect('user/login');
        }

		$this->data['title'] = 'Monthly Expense ::  Detail';
		$this->data['timestr'] = $timestr;

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
			$this->data['expenses'] = $this->emp_expense_model->getExpensesWhere($query, $this->data['offset'], $this->limit, $this->session->userdata('user_data')['user_id']);
			$this->data['query'] = $query;
			$total_rows = $this->emp_expense_model->searchCountMonthwise($query);

		}else{
			$where = [
				'user_ref'=>$this->session->userdata('user_data')['user_id'],
				'DATE_FORMAT(expense_date, "%Y-%m") = ' => date("Y-m", $timestr)
			];
			$this->data['expenses'] = $this->emp_expense_model->getExpensesWhere( $this->data['offset'], $this->limit, $where );
			$total_rows = $this->emp_expense_model->countExpensesWhere($where);
		}
		
		self::_paginate($baseurl=site_url('user'), $total_rows);
		
		$parser['content']  =   $this->load->view('user/expenses-detail-monthly',$this->data,TRUE);
		$this->parser->parse('template', $parser);
		
	}
	
	/*
	* @method: login
	*/
	public function login(){

		$this->data['title'] = 'Login';

		$this->load->helper(array('form'));
		
		$this->load->helper('security');

        $this->load->library('form_validation');
		
		$this->form_validation->set_rules('user_password', 'Password', 'trim|required',
				array('required' => 'You must provide a %s.')
		);
		$this->form_validation->set_rules('username', 'Username', 'trim|required');

		if ($this->form_validation->run() == FALSE)
		{	
			$this->load->view("login", $this->data);
		}
		else
		{
			/* $data = $this->security->xss_clean($data); */
			$username = $this->input->post('username', TRUE); // TRUE enables the xss filtering
			$password = $this->input->post('user_password', TRUE); // TRUE enables the xss filtering

			if( $userdata = $this->user_model->login_user($username,$password) ){
				$this->session->set_userdata(array('user_data'=>$userdata));

				if( 'ADMIN' == $userdata['user_type'] ) {
					redirect('admin');
				}else{
					redirect('user');
				}
				
			}else{
				
				$this->session->set_flashdata('error_msg','Please enter valid Username or Password.');
				$this->load->view("login", $this->data);
			}
			
		}
		
	}
	
	/*
	* @method: logout
	*/
	public function logout(){
		$user_data = $this->session->all_userdata();
        foreach ($user_data as $key => $value) {
            if ($key != 'session_id' && $key != 'ip_address' && $key != 'user_agent' && $key != 'last_activity') {
                $this->session->unset_userdata($key);
            }
        }
		
		#$this->session->sess_destroy();
	
		redirect('user/login');
		
	}

	/*
	* @method: signup
	*/
	public function signup(){

	}

	/*
	* @method: change-password
	*/
	public function change_password(){

		$this->data['title'] = 'Change Password';

		if( $this->input->post() ):
		
			$this->load->helper(array('form'));
			
			$this->load->helper('security');

	        $this->load->library('form_validation');
			
			$config = array(
					array(
							'field' => 'old_password',
							'label' => 'Old Password',
							'rules' => 'trim|required'
					),array(
							'field' => 'new_password',
							'label' => 'New Password',
							'rules' => 'trim|required'
					),array(
							'field' => 'confirm_password',
							'label' => 'Confirm Password',
							'rules' => 'trim|required|matches[new_password]'
					)
			);
			
			$this->form_validation->set_rules($config);

			if ($this->form_validation->run() == FALSE)
			{
				$this->session->set_flashdata('error_msg', validation_errors());
			}
			else
			{ 
				$old_password = $this->input->post('old_password', TRUE);
				$new_password = $this->input->post('new_password', TRUE); // TRUE enables the xss filtering
			
				if( $this->user_model->login_user($username=$this->session->userdata('user_data')['username'], $old_password) ){
					$this->user_model->updateUserInfo(array('user_id' => $this->session->userdata('user_data')['user_id']), ['password' => SHA1($new_password)]);
					$this->session->set_flashdata('success_msg', 'Updated successfully!');
				}else{
					$this->session->set_flashdata('error_msg', "Old Password didn't match.");
				}
			}

		endif;	

		$parser['content']  =   $this->load->view('user/change-password',$this->data,TRUE);
		$this->parser->parse('template', $parser);
	}

} // END: class User