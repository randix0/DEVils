<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Login extends CI_Controller 
{
	
	public function index()
	{  
		if (isset($_POST['signin']) && isset($_POST['signin']['login']) && isset($_POST['signin']['password']))
		{
			$signin=$_POST['signin'];
			echo $signin['login'].':'.$signin['password'];
			$this->load->model('m_users');
			$this->load->model('m_avatars');
			$user=$this->m_users->sign_in($signin['login'],$signin['password']);
			
			$user['users_id']=$user['id'];
			
			$this->session->set_userdata($user);
			
			header('location: '.$_SERVER['HTTP_REFERER']);
		}
	}
} 

?>