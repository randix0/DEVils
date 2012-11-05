<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_users extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}
	
	public function sign_in($login='', $password='')
	{
		$this->db->where('login', $login);
		$this->db->where('password', md5($login.$password.'ilich'));
		$query = $this->db->get('users', 1);
		$user = $query->row_array();
		
		$this->load->model('m_avatars');
		$user=$this->m_avatars->get($user['avatars_id'],$user);	
		
		$this->m_users->setOnline($user['id']);	
		
		return $user;
	}
	
	public function setOnline($users_id = 0, $timeDiff = 300)
	{
		if ($users_id < 1) return false;
		$onlineTill = time()+$timeDiff;
		$this->db->where('id', $users_id);
		$this->db->update('users', array('online_till'=>$onlineTill));
	}

	public function get($users_id=0)
	{
		$this->db->where('id', $users_id);
		$query = $this->db->get('users', 1);
		$user=$query->row_array();
		$this->load->model('m_avatars');
		if ($user) $user=$this->m_avatars->get($user['avatars_id'],$user);		
		
		return $user;
	}	
	
	public function getByLogin($login=0)
	{
		$this->db->where('login', $login);
		$query = $this->db->get('users', 1);
		$user=$query->row_array();
		$this->load->model('m_avatars');
		if ($user) $user=$this->m_avatars->get($user['avatars_id'],$user);		
		
		return $user;
	}	

	public function register($user=array())
	{
		if (!$user) return false;
		$user['password']=md5($user['login'].$user['password'].'ilich');
		$user['add_date']=time();
		$this->db->insert('users', $user); 
		return true;
	}	
	
	public function getItems($limit=0,$offset=0,$order='id',$by='desc', $whereArr = array())
	{
		if ($whereArr)
		{
			foreach($whereArr as $key=>$value)
			{
				$this->db->where($key, $value);
			}
		}
		if ($order && $by)
			$this->db->order_by($order, $by);
		if ($limit > 0)
			$query = $this->db->get('users', $limit, $offset);
		else
			$query = $this->db->get('users');
		
		$users=$query->result_array();
		
		$this->load->model('m_avatars');
		
		foreach($users as &$user)
		{
			$user=$this->m_avatars->get($user['avatars_id'],$user);
		}		
			
		return $users;
	}	

	public function update($data,$id)
	{
		if (!$data || !$id) return false;
		$this->db->update('users', $data, array('id'=>$id));
		foreach($data as $key=>$value){
			$this->session->set_userdata($key, $value);
		}
		return true;
	}	
}
?>