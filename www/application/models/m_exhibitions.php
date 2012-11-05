<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_exhibitions extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function getItems($limit=0,$offset=0)
	{
		if ($limit) $query = $this->db->get('exhibitions', $limit, $offset);
		else $query = $this->db->get('exhibitions');
		return $query->result_array();
	}

	public function getItem($id=0)
	{
		if ($id <1) return array();
		$query = $this->db->where('id',$id);
		$query = $this->db->get('exhibitions');
		return $query->row_array();
	}

	public function add($data=array())
	{
		if (!$data) return 0;
		$query = $this->db->insert('exhibitions',$data);
		return $this->db->insert_id();
	}	
	
	public function update($id,$data=array())
	{
		if ($id<1 || !$data) return false;
		$this->db->where('id',$id);
		$query = $this->db->update('exhibitions', $data);
		return true;
	}		

	public function addWork($data = array())
	{
		#exhibitions_works
		if (!$data || !isset($data['exhibitions_id']) || !isset($data['photos_id']) || !isset($data['users_id'])) return 0;
		$this->db->where('users_id',$data['users_id']);
		$this->db->where('exhibitions_id',$data['exhibitions_id']);
		$this->db->where('photos_id',$data['photos_id']);
		$count = $this->db->count_all_results('exhibitions_works');
		
		if ($count > 0) return 0;
				
		$query = $this->db->insert('exhibitions_works',$data);
		$id=$this->db->insert_id();
				
		$this->db->set('num_exhibitions', 'num_exhibitions+1', false);
		$this->db->where('id',$data['photos_id']);
		$this->db->update('photos');			
	}
	
	public function getAlreadyTookPart($photos_id=0)
	{
		if (!$photos_id) return false;

		$this->db->select('exhibitions.*, exhibitions_works.exhibitions_id');
		$this->db->from('exhibitions_works');
		$this->db->join('exhibitions', 'exhibitions.id = exhibitions_works.exhibitions_id');
		
		$this->db->where('exhibitions_works.photos_id',$photos_id);
		$query = $this->db->get();
		$already=$query->result_array();
		
		foreach($already as $a)
		{
			
		}
		return $already;
	}
	
	public function getItemsTakePart($already=array())
	{
		$notIn=array();
		if ($already)
		foreach($already as $c){
			$notIn[]=$c['exhibitions_id'];
		}
		
		$this->db->where('is_deleted',0);
		if ($notIn) $this->db->where_not_in('id', $notIn);
		
		$query = $this->db->get('exhibitions');
		return $query->result_array();		
	}

}
?>