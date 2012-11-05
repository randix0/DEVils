<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Admin extends CI_Controller 
{
	public function index()
	{  

		$data['_activeMenu'] = 'admin';
		$this->tpl->view('backend/home/', $data);
	}
	
	public function install()
	{
		
		$data['_activeMenu'] = 'admin';
		
		$this->tpl->view('backend/install/', $data);
	}
} 

?>