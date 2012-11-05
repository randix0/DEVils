<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_tags extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function get($id=0)
	{
		if ($id<1) return array();
		$this->db->where('id',$id);
		$query = $this->db->get('tags',1);
		return $query->row_array();
	}	
	
	public function setTags($tags_text='', $object_type=0, $object_id=0)
	{
		if (!$tags_text) return false;
		$tags_text=mb_strtolower($tags_text);
		$tags=explode(',',$tags_text);
		$tags_links=array();
		
		$this->db->delete('tags_links', array('object_type' => $object_type, 'object_id'=>$object_id)); 
			
		foreach($tags as &$tag)
		{
			trim($tag);
			$this->db->where('tag',$tag);
			$query = $this->db->get('tags');
			$tag_row = $query->row_array();
			if (isset($tag_row['id']) && $tag_row['id'])
				$tags_id=$tag_row['id'];
			else
			{
				$this->db->insert('tags',array('tag'=>$tag));
				$tags_id=$this->db->insert_id();
			}
			$tags_links[]=array(
				'object_type'=>$object_type,
				'object_id'=>$object_id,
				'tags_id'=>$tags_id
			);
		}
		$this->db->insert_batch('tags_links',$tags_links);
		
	}
	
	public function itemsByObject($object_type=0, $object_id=0)
	{
		$this->db->select('tag');
		$this->db->from('tags');
		$this->db->where('object_type',$object_type);
		$this->db->where('object_id',$object_id);
		$this->db->join('tags_links', 'tags.id = tags_links.tags_id');
		
		$query = $this->db->get();
		$result=$query->result_array();
		$tags=array();
		foreach ($result as $r)
		{
			$tags[]=$r['tag'];
		}
		return $tags;
	}	
	
	public function getItems()
	{
		$this->db->select('tags.*');
		$this->db->select('COUNT(ph_tags.id) AS count', FALSE);
		$this->db->from('tags');

		$this->db->join('tags_links', 'tags.id = tags_links.tags_id');
		$this->db->group_by('tags.id');
		$this->db->order_by('count','desc');
		$query = $this->db->get();
		$result=$query->result_array();
		return $result;
	}
}
?>