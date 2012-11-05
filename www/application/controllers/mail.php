<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Mail extends CI_Controller 
{

	public function index()
	{  
		$ps=array();
		$users_id=$this->session->userdata('users_id');
		$this->load->model('m_mail');
		$ps['mailUsers'] = $this->m_mail->getConversations($users_id);
		/*
		$ps['_activeMenu'] = 'photo';
		$ps['mode']='new';
		$ps['photos'] = $this->m_photos->getItems(100,0);
		*/
		$this->tpl->view('frontend/mail/', $ps);
	}
	
	public function to($to_users_id = 0)
	{
		$ps=array();
		if ($to_users_id < 1) return false;
		$users_id=$this->session->userdata('users_id');
		$this->load->model('m_mail');
		$ps['mailMessages'] = $this->m_mail->getMessages($users_id, $to_users_id);
		$ps['mailUsers'] = $this->m_mail->getConversations($users_id);
		$ps['to_users_id'] = $to_users_id;
		/*
		$ps['mode']='new';
		$ps['photos'] = $this->m_photos->getItems(100,0);
		*/
		$this->tpl->view('frontend/mail/', $ps);
	}
	
}

?>