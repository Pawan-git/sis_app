<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contacts extends MY_Controller {

	public function __construct(){

		parent::__construct();
		
		if (!$this->is_logged_in())
        {
            // User is not logged in
			
			redirect('user/login');
        }
		
		$this->load->model('contacts_model');
		
		$this->limit = 10;

	}
	
	/*
	*@method: index
	*@return: render view--list all contacts
	*/
	public function index()
	{

		$limit = $this->input->get('show', TRUE);
		$page_num = $this->input->get('page', TRUE);
		
		if($limit){
			$total_rows = $data['limit'] = $this->limit = $limit;
		}
		
		$offset = 0;
		if($page_num){
			$offset = $this->limit*((int)$page_num-1);
		}
		
		$query = $this->input->get('query', TRUE);
		if(!empty($query))
		{
			$data['contacts'] = $this->contacts_model->search_contact($query, $offset, $this->limit);
			$data['query'] = $query;
			$total_rows = $this->contacts_model->search_count($query);
		}else{
			$data['contacts'] = $this->contacts_model->get_all_contact($offset, $this->limit);
			$total_rows = $this->contacts_model->count_all();
		}
		
		
		self::_paginate($baseurl=site_url('contacts'), $total_rows);
		

		$this->load->view('contacts_view',$data);
	}
	
	/*
	*@method: add
	* function will add a contact
	*@return: json
	*/
	public function add()
	{
		$response = array();
		
		$this->load->helper(array('form'));
		
		$this->load->helper('security');

        $this->load->library('form_validation');
		
		$config = array(
				array(
						'field' => 'contact_name',
						'label' => 'Name',
						'rules' => 'trim|required'

				),
				array(
						'field' => 'contact_number',
						'label' => 'Phone Number',
						'rules'=>'trim|required|regex_match[/^[0-9]{10}$/]',
						'errors' => array(
								'regex_match' => 'Not a valid 10 digit number.',
						),
				),
				array(
						'field' => 'contact_note',
						'label' => 'Additional Note', 
						'rules' => 'trim'
				)
		);
		
		$this->form_validation->set_rules($config);

		if ($this->form_validation->run() == FALSE)
		{
			$errors = validation_errors();
			$response['status'] = 'FALSE';
			$response['data'] = array('error_message'=>$errors, 'csrf'=>$this->get_csrf_token());
			
		}
		else
		{
			$contact_name = $this->input->post('contact_name', TRUE); // TRUE enables the xss filtering
			$contact_number = $this->input->post('contact_number', TRUE);
			$contact_note = $this->input->post('contact_note', TRUE);

			$data = array(
				'contact_name' => $contact_name,
				'contact_number' => $contact_number,
				'contact_note' => $contact_note,
				'created_at' => date('Y-m-d h:i:s'),
			);
			
			$insert = $this->contacts_model->contact_add($data);
			
			$response['status'] = 'TRUE';
			$response['data'] = array('message'=>'Saved successfully!');
	
		}
		
		echo json_encode($response);
		
	}
	
	/*
	*@method: edit:- function will edit a contact
	*@params: $id{integer}
	*@return: json
	*/
	public function edit($id)
	{
		$data = $this->contacts_model->get_by_id($id);
		$response['status'] = 'TRUE';
		$response['data'] = $data;
		
		echo json_encode($response);
	}
	
	/*
	*@method: update:- function will update a contact
	*@params: $id{integer}
	*@return: json
	*/
	public function update()
	{
		$response = array();
		
		$this->load->helper(array('form'));
		
		$this->load->helper('security');

        $this->load->library('form_validation');
		
		$config = array(
				array(
						'field' => 'contact_name',
						'label' => 'Contact Name',
						'rules' => 'trim|required'
				),
				array(
						'field' => 'contact_number',
						'label' => 'Contact Number',
						'rules'=>'required|regex_match[/^[0-9]{10}$/]',
						/*'rules' => 'trim|required',
						 'errors' => array(
								'required' => 'You must provide a %s.',
						), */
				),
				array(
						'field' => 'contact_note',
						'label' => 'Additional Note',
						'rules' => 'trim'
				)
		);
		
		$this->form_validation->set_rules($config);

		if ($this->form_validation->run() == FALSE)
		{
			$errors = validation_errors();
			$response['status'] = 'FALSE';
			$response['data'] = array('error_message'=>$errors, 'csrf'=>$this->get_csrf_token());
			//redirect('contacts');
		}
		else
		{
			$contact_name = $this->input->post('contact_name', TRUE); // TRUE enables the xss filtering
			$contact_number = $this->input->post('contact_number', TRUE);
			$contact_note = $this->input->post('contact_note', TRUE);
			$contact_id = $this->input->post('contact_id', TRUE);

			$data = array(
				'contact_name' => $contact_name,
				'contact_number' => $contact_number,
				'contact_note' => $contact_note
			);
			
			$insert = $this->contacts_model->contact_update(array('contact_id' => $contact_id), $data);
			
			$response['status'] = 'TRUE';
			$response['data'] = array('message'=>'Updated successfully!');
	
		}
		
		echo json_encode($response);
		
	}
	
	/*
	*@method: edit
	* function will delete a contact
	*@return: json
	*/
	public function delete_contact()
	{
		$contact_id = $this->input->post('contact_id', TRUE);
		$this->contacts_model->delete_by_id($contact_id);
		
		echo json_encode(
		array("status" => 'TRUE', 
				'data'=>array('csrf'=>$this->get_csrf_token())
			));
	}
	
	protected function _paginate($baseurl, $total_rows){
		
		$this->load->library('pagination');

		$config['base_url'] = $baseurl;
		$config['total_rows'] = $total_rows;
		$config['page_query_string'] = TRUE;
		$config['per_page'] = $this->limit;
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		
		$config['use_page_numbers'] = TRUE;
		$config['query_string_segment'] = 'page';
		
		$config['reuse_query_string'] = true;

		$this->pagination->initialize($config);
	}
	
	
} // END: class Phonebook