<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_logs extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function add($log)
	{
		$log['add_date']=time();
		$this->db->insert('logs', $log);
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
			$query = $this->db->get('logs', $limit, $offset);
		else
			$query = $this->db->get('logs');
		
		$logs=$query->result_array();
		
		$this->load->model('m_users');
		$this->load->model('m_photos');
		$this->load->model('m_comments');
		
		foreach($logs as &$log)
		{
			$log['author'] = $this->m_users->get($log['users_id']);
			$log['object'] = array();
			if ($log['object_type'] == 1)
				$log['object'] = array();
			elseif($log['object_type'] == 2)
				$log['object'] = $this->m_photos->get($log['object_id']);
			elseif($log['object_type'] == 6)
				$log['object'] = $this->m_comments->get($log['object_id']);
		}
		
		return $logs;
	}
	
}
?>