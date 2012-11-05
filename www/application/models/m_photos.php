<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_photos extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}
	
	public function get($id=0)
	{
		if ($id<1) return array();
		$this->db->where('id',$id);
		$query = $this->db->get('photos',1);
		return $query->row_array();
	}
	
	public function getItems($limit=0,$offset=0,$order='id',$by='desc',$where = array())
	{
		$this->db->where('is_deleted',0);
		if ($where){
			foreach($where as $w=>$v)
			{
				$this->db->where($w,$v);
			}
		}
		if ($order && $by)
			$this->db->order_by($order, $by);
		if ($limit > 0)
			$query = $this->db->get('photos', $limit, $offset);
		else
			$query = $this->db->get('photos');
		$photos=$query->result_array();
		$this->load->model('m_users');
		foreach ($photos as &$photo) {
			$photo['author'] = $this->m_users->get($photo['users_id']);
		}
		return $photos;
	}
  
  	public function getFavItems($limit=0,$offset=0,$order='id',$by='desc',$where = array())
	{
		
    
    
    $this->db->where('is_deleted',0);
		if ($where){
			foreach($where as $w=>$v)
			{
				$this->db->where($w,$v);
			}
		}
		if ($order && $by)
      
			
    
      $this->db->order_by($order, $by);
      //$this->db->join('photos_favorites','photos.id=photos_favorites.photo_id');
      
      if ($this->session->userdata('users_id')=='')
      {
          $_user_id=0 ;
      }
      else
      {
          $_user_id=$this->session->userdata('users_id');
      }
      $where="id in (Select photo_id from ph_photos_favorites p where p.user_id=".$_user_id."  and p.is_delete=1 )";
      
      $this->db->where($where);
    
      
    if ($limit > 0)
			$query = $this->db->get('photos', $limit, $offset);
		else
			$query = $this->db->get('photos');
		
    
    
    
    
    $photos=$query->result_array();
		$this->load->model('m_users');
		foreach ($photos as &$photo) {
			$photo['author'] = $this->m_users->get($photo['users_id']);
		}
		return $photos;
	}
  
  
  
	public function getItemsByTagID($tags_id=0,$limit=0,$offset=0)
	{
		$this->db->select('photos.*');
		$this->db->from('tags_links');
		$this->db->join('photos', 'photos.id = tags_links.object_id');
				
		$this->db->where('photos.is_deleted',0);
		$this->db->where('tags_links.tags_id',$tags_id);
		$this->db->where('tags_links.object_type',2);
		if ($limit > 0)
			$this->db->limit($limit, $offset);
		
		$query = $this->db->get();
		$photos = $query->result_array();
		$this->load->model('m_users');
		foreach ($photos as &$photo) {
			$photo['author'] = $this->m_users->get($photo['users_id']);
		}		
		return $photos;
	}
  
  
  
  

	public function getAlbumItems($limit=0,$offset=0,$order='id',$by='desc')
	{
		$this->db->where('is_deleted',0);
		if ($order && $by)
			$this->db->order_by($order, $by);
		if ($limit > 0)
			$query = $this->db->get('photos_albums', $limit, $offset);
		else
			$query = $this->db->get('photos_albums');
		$photos=$query->result_array();
		$this->load->model('m_users');
		foreach ($photos as &$photo) {
			$photo['author'] = $this->m_users->get($photo['users_id']);
		}
		return $photos;
	}
	
	public function getUserAlbumItems($users_id=0,$limit=0,$offset=0,$order='id',$by='desc')
	{
		$this->db->where('is_deleted',0);
		$this->db->where('users_id',$users_id);
		if ($order && $by)
			$this->db->order_by($order, $by);
		if ($limit > 0)
			$query = $this->db->get('photos_albums', $limit, $offset);
		else
			$query = $this->db->get('photos_albums');
		$albums=$query->result_array();

		return $albums;
	}	
	
	public function getContestsItems($id=0, $limit=0, $offset=0)
	{

		$this->db->select('photos.*');
		$this->db->from('contests_works');
		$this->db->join('photos', 'photos.id = contests_works.photos_id');
				
		$this->db->where('photos.is_deleted',0);
		$this->db->where('contests_works.contests_id',$id);
		if ($limit > 0)
			$this->db->limit($limit, $offset);
		
		$query = $this->db->get();
		$photos = $query->result_array();
		return $photos;
	}

	public function getExhibitionsItems($id=0, $limit=0, $offset=0)
	{
		$this->db->select('photos.*');
		$this->db->from('exhibitions_works');
		$this->db->join('photos', 'photos.id = exhibitions_works.photos_id');
				
		$this->db->where('photos.is_deleted',0);
		$this->db->where('exhibitions_works.exhibitions_id',$id);
		if ($limit > 0)
			$this->db->limit($limit, $offset);
		
		$query = $this->db->get();
		$photos = $query->result_array();
		return $photos;
	}

	public function getLast()
	{
		$this->db->where('is_deleted',0);
		$this->db->order_by("id", "desc");
		$query = $this->db->get('photos', 1);
		$photo = $query->row_array();
		$this->load->model('m_users');
		$photo['author'] = $this->m_users->get($photo['users_id']);
		return $photo;
	}

	public function delete($id)
	{
		$this->db->where('id',$id);
		$this->db->set('is_deleted', 1);
		$query = $this->db->update('photos');
		return true;
	}	
	
	public function update($id,$array=array())
	{
		$this->db->where('id',$id);
		$query = $this->db->update('photos', $array);
		return true;
	}	

	public function updateAlbum($id,$array=array())
	{
		$this->db->where('id',$id);
		$query = $this->db->update('photos_albums', $array);
		return true;
	}	
	
	public function getDailyItems($limit=0,$loadUserData = false)
	{
		$this->db->select('photos.*');
		$this->db->select('photos_daily.date_from');
		$this->db->from('photos_daily');
		$this->db->where('photos_daily.date_from >',time()-86400);
		$this->db->join('photos', 'photos.id = photos_daily.photos_id');
		$this->db->order_by('photos_daily.date_from');
		if ($limit) $this->db->limit($limit);
		$query = $this->db->get();
		$result=$query->result_array();
		
		if ($loadUserData)
		{
			foreach($result as &$p)
			{
				$p['author'] = $this->m_users->get($p['users_id']);
			}
		}
		
		return $result;
	}

	public function getDailyItem()
	{
		$this->db->select('photos.*');
		$this->db->select('photos_daily.date_from');
		$this->db->from('photos_daily');
		$this->db->where('photos_daily.date_from <',time());
		$this->db->join('photos', 'photos.id = photos_daily.photos_id');
		$this->db->order_by('photos_daily.date_from');
		$this->db->limit(1);
		$query = $this->db->get();
		$result=$query->row_array();
		
		$result['author'] = $this->m_users->get($result['users_id']);
		
		
		return $result;
	}
	
	public function setDailyItems($data)
	{
		if (!isset($data['photos_id']) || !$data['photos_id']) return false;
		$this->db->where('photos_id',$data['photos_id']);
		$query = $this->db->get('photos_daily',1);
		$photo = $query->row_array();
		
		if ($photo) return false;
		
		$this->db->insert('photos_daily',$data);
		
		$this->db->set('rating_daily', 'rating_daily+1', false);
		$this->db->where('id',$data['photos_id']);
		$this->db->update('photos');	
		return true;
	}	

	public function createAlbum($data)
	{
		$query = $this->db->insert('photos_albums',$data);
		return $this->db->insert_id();		
	}
	
		
	
}
?>