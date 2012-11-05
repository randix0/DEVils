<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class My extends CI_Controller 
{

	function __construct()
	{
		parent::__construct();
		
	}
	
	public function index()
	{  
		$this->load->model('m_users');
		$ps=array();
		$this->tpl->view('frontend/my/index/', $ps);
	}
	
	public function profile()
	{  
		$this->load->model('m_users');
		$ps=array();
		$this->tpl->view('frontend/my/profile/', $ps);
	}	
	
	public function settings()
	{  
		$this->load->model('m_users');
		$ps=array();
		$this->tpl->view('frontend/my/settings/', $ps);
	}	

} 

?>