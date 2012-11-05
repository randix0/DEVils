<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Users extends CI_Controller 
{

	public function profile ($login='')
	{  
		$this->load->model('m_users');
		$this->load->model('m_photos');
		$ps['_activeMenu'] = 'user';
		$user = $this->m_users->getByLogin($login);

		$ps['user']=$user;
		$ps['photos'] = $this->m_photos->getItems(0,0,'id','desc',array('users_id'=>$user['id']));
		$this->tpl->view('frontend/users/profile/', $ps);
	}
} 

?>