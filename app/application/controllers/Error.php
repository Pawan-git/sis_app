<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Error extends CI_Controller 
{
 public function __construct() 
 {
    parent::__construct(); 
 } 

 public function index($error_code=404) 
 { 
	$this->output->set_status_header('404');
	$data['error_code'] =  404;
	$data['error_message'] =  'Oops! Page not found.';
   
	$this->load->view('errors/error_view', $data);
 } 
 
 
} 