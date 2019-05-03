<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

	public function __construct(){

		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('EmpExpense_model', 'emp_expense_model');
		
		$this->data = [];
	}
	
	public function index()
	{
		if (!$this->is_logged_in())
        {
            // User is not logged in
			redirect('user/login');
        }

        $this->data['title'] = 'User :: Expenses';

        $limit = $this->input->get('show', TRUE);
		$page_num = $this->input->get('page', TRUE);
		
		if($limit){
			$total_rows = $this->data['limit'] = $this->limit = $limit;
		}
		
		$offset = 0;
		if($page_num){
			$offset = $this->limit*((int)$page_num-1);
		}
		
		$query = $this->input->get('query', TRUE);
		if(!empty($query))
		{
			$this->data['contacts'] = $this->contacts_model->search_contact($query, $offset, $this->limit);
			$this->data['query'] = $query;
			$total_rows = $this->contacts_model->search_count($query);
		}else{
			$this->data['expenses'] = $this->emp_expense_model->getExpenseByUser($this->session->userdata('user_data')['user_id'], $offset, $this->limit);
			$total_rows = $this->emp_expense_model->count_all();
		}
		
		echo '<pre>'; print_r($this->data); die;
		self::_paginate($baseurl=site_url('user'), $total_rows);
		

		$this->load->view('contacts_view', $this->data);
		
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

} // END: class User