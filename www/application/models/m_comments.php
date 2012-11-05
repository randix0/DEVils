<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_comments extends CI_Model
{

/*
object_type
1 - posts
2 - photos

20 - user
 */

	public function __construct()
	{
		parent::__construct();
	}
	
	public function add($comment)
	{
		$comment['add_date']=time();
		$this->db->insert('comments', $comment);
		$comments_id = $this->db->insert_id();
		if ($comment['object_type'] == 2){
			$this->db->set('num_comments', 'num_comments+1', false);
			$this->db->where('id',$comment['object_id']);
			$this->db->update('photos');			
		}	
		return $comments_id;		
	}
	
	public function getItems($object_type=0,$object_id=0)
	{
		if ($object_type<1 || $object_id <1) return array();
		$query = $this->db->where('object_type',$object_type);
		$query = $this->db->where('object_id',$object_id);
		$query = $this->db->get('comments');
		$comments = $query->result_array();
		
		$this->load->model('m_users');
		
		foreach($comments as &$comment)
		{
			$comment['author'] = $this->m_users->get($comment['users_id']);
		}
		
		return $comments;
	}
	
	public function get($id=0)
	{
		if ($id<1) return array();
		$this->db->where('id',$id);
		$query = $this->db->get('comments',1);
		$comment = $query->row_array();
		$this->load->model('m_users');
		$comment['author'] = $this->m_users->get($comment['users_id']);
		return $comment;
	}	
}
?>