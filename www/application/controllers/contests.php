<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contests extends CI_Controller 
{

	function __construct()
	{
		parent::__construct();
		
	}
	
	public function index()
	{  
		$this->load->model('m_contests');
		$ps=array();
		$ps['contests']=$this->m_contests->getItems();
		$this->tpl->view('frontend/contests/items/', $ps);
	}

	public function one($id)
	{  
		$this->load->model('m_contests');
		$this->load->model('m_photos');
		$ps=array();
		$ps['contest']=$this->m_contests->getItem($id);
		if ($ps['contest']) $ps['photos']=$this->m_photos->getContestsItems($id,20,0);
		$this->tpl->view('frontend/contests/one/', $ps);
	}	
	
	public function add($id=0)
	{
		$user=$this->session->all_userdata();
		if ($user['access_level'] < 50) header('location: /');
		$this->load->model('m_contests');
		$ps=array();
		if ($id>0) $ps['contest']=$this->m_contests->getItem($id);
		$this->tpl->view('frontend/add/contest/', $ps);
	}

	public function edit($id=0)
	{
		$this->load->model('m_contests');
		$ps=array();
		if ($id>0) $ps['contest']=$this->m_contests->getItem($id);
		$this->tpl->view('frontend/add/contest/', $ps);
	}

} 

?>