<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->limit = 10;
    }

    public function is_logged_in()
    {
        $user = $this->session->userdata('user_data');
        return isset($user);
    }

    public function is_admin()
    {
        $user = $this->session->userdata('user_data');
        return (isset($user) && 'ADMIN' == $user['user_type']);
    }
	
	public function get_csrf_token(){
		
		$token_name = $this->security->get_csrf_token_name();
		$token_hash = $this->security->get_csrf_hash();
		
		return array('token_name'=>$token_name, 'token_hash'=>$token_hash);
		
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
	
}