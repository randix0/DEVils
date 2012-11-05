<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_avatars extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}
	
	public function set($data)
	{
		$query = $this->db->insert('avatars',$data);
		return $this->db->insert_id();
	}
	
	public function get($id,$user=array())
	{
			$this->db->where('id', $id);
			$query1 = $this->db->get('avatars', 1);
			$avatar = $query1->row_array();
			if (isset($avatar['path']) && isset($avatar['file']) && $avatar['path'] && $avatar['file'])
			{
				$user['avatar_b']=$avatar['path'].'b/'.$avatar['file'];	
				$user['avatar_m']=$avatar['path'].'m/'.$avatar['file'];	
				$user['avatar_s']=$avatar['path'].'s/'.$avatar['file'];
			}		
			else
			{
				$user['avatar_b']='/resources/images/misc/no_avatar_b.png';	
				$user['avatar_m']='/resources/images/misc/no_avatar_m.png';	
				$user['avatar_s']='/resources/images/misc/no_avatar_s.png';
			}
		return $user;
	}	
	
}
?>