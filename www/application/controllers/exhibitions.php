<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Exhibitions extends CI_Controller 
{

	function __construct()
	{
		parent::__construct();
		
	}
	
	public function index()
	{  
		$this->load->model('m_exhibitions');
		$ps=array();
		$ps['exhibitions']=$this->m_exhibitions->getItems();
		$this->tpl->view('frontend/exhibitions/items/', $ps);
	}

	public function one($id)
	{  
		$this->load->model('m_exhibitions');
		$this->load->model('m_photos');
		$ps=array();
		$ps['exhibition']=$this->m_exhibitions->getItem($id);
		if ($ps['exhibition']) $ps['photos']=$this->m_photos->getExhibitionsItems($id,20,0);
		$this->tpl->view('frontend/exhibitions/one/', $ps);
	}	
	
	public function add($id=0)
	{
		$user=$this->session->all_userdata();
		if ($user['access_level'] < 50) header('location: /');
		$this->load->model('m_exhibitions');
		$ps=array();
		if ($id>0) $ps['exhibition']=$this->m_exhibitions->getItem($id);
		$this->tpl->view('frontend/add/exhibition/', $ps);
	}

	public function edit($id=0)
	{
		$this->load->model('m_exhibitions');
		$ps=array();
		if ($id>0) $ps['exhibition']=$this->m_exhibitions->getItem($id);
		$this->tpl->view('frontend/add/exhibition/', $ps);
	}

} 

?>