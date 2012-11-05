<?php 

class M_page extends CI_Model
{
	
	private $_table = 'pages';
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function getAll($is_del = false)
	{
		if(!$is_del) $this->db->where('is_del', 0); 
		$query = $this->db->get($this->_table);
		$res = array();
		foreach($query->result_array() as $row) 
		{
			$res[] = $row;
		} 
		return $res;
	}
	
	public function get($link = '', $lang = 'english')
	{
		$this->db->where('link', $link);
		$this->db->where('lang', $lang);
		$this->db->where('is_del', 0);
		$query = $this->db->get($this->_table);
		$res = array(); 
		foreach($query->result_array() as $row) 
		{
			$res[$row['iname']] = $row['idesc'];
		} 
		return $res;
	}
	
	public function getById($id = 0)
	{
		$id = (int) $id;
		if($id == 0) return false; 
		$this->db->where('id', $id);
		$query = $this->db->get($this->_table);
		$row = $query->result_array();
		return $row[0];
	}
	
	public function add($data)
	{
		if(empty($data)) return 0;
		$this->db->set($data);
		$this->db->insert($this->_table);
		return $this->db->insert_id();
	}
	
	public function update($id, $data)
	{
		if(empty($data)) return 0;
		$this->db->where('id', $id);
		$this->db->set($data);
		$this->db->update($this->_table);
		return $id;
	}
	
	public function delete($id)
	{
		$data = array('is_del' => '1');
		return $this->update($id, $data);
	}
	
}

?>