<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_votes extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}
	
	public function isVoted($object_type=0,$object_id=0,$users_id=0)
	{
		if (!$users_id || !$object_type || !$object_id) return 1;
		$query = $this->db->query('select count(*) as cnt from ph_votes where `object_type`='.$object_type.' AND `object_id`='.$object_id.' AND `users_id`='.$users_id);
		$row=$query->row_array();
		return $row['cnt'];
	}
	
	public function vote($object_type=0,$object_id=0,$users_id=0)
	{
		if (!$users_id || !$object_type || !$object_id) return array();
		$data['object_type']=$object_type;
		$data['object_id']=$object_id;
		$data['users_id']=$users_id;
		$data['add_date']=time();
		$this->db->insert('votes', $data); 

		if ($object_type == 2){
			$this->db->set('rating', 'rating+1', false);
			$this->db->where('id',$object_id);
			$this->db->update('photos');			
		}		
		
		return true;
	}	
	
}
?>