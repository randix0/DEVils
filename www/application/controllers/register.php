<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Register extends CI_Controller 
{
	
	public function index()
	{  
		$ps=array();
		$ps['status']='error';
		$ps['error_msg']='';
		if (isset($_POST['signup']) && $_POST['signup'])
		{
			$reg=$_POST['signup'];
			if (!isset($reg['login']) || !$reg['login']) $ps['error_msg']='no login';
			elseif (!isset($reg['password']) || !$reg['password']) $ps['error_msg']='no password';
			elseif (!isset($reg['password_repeat']) || !$reg['password_repeat']) $ps['error_msg']='no password_repeat';
			elseif (!isset($reg['email']) || !$reg['email']) $ps['error_msg']='no email';
			elseif ($reg['password'] != $reg['password_repeat']) $ps['error_msg']='no passwords don`t matches';
			
			unset($reg['password_repeat']);
			
			$this->load->model('m_users');
			if (!$ps['error_msg']) {
				$user=$this->m_users->getByLogin($reg['login']);
				if ($user) $ps['error_msg']='user already exist';
				else $this->m_users->register($reg);
				$ps['status']='success';
			}
		}
		
		$this->tpl->view('frontend/register/', $ps);
	}
} 

?>