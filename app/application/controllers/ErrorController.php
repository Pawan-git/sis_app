<?php

class ErrorController extends CI_Controller
{
	function __construct() {
		parent::__construct();
	}

	public function error_404()
	{
		$this->output->set_status_header('404'); 

	    $data["heading"] = "404 Page Not Found";
	    $data["message"] = "The page you requested was not found ";

	    $parser['content']	=	$this->load->view('errors/page_404',$data,TRUE);
        $this->parser->parse('template', $parser);

	   # $this->load->view('errors/page_404',$data);
	}
}