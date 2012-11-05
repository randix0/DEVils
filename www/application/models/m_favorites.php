<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_favorites extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}
	
	public function isFav($object_type=0,$object_id=0,$users_id=0)
	{
		$res=0;
    if (!$users_id || !$object_type || !$object_id) return 1;
		$query = $this->db->query('select count(*) as cnt from ph_photos_favorites where `object_type`='.$object_type.' AND `photo_id`='.$object_id.' AND `user_id`='.$users_id);
		$row=$query->row_array();
		if ($row['cnt']!=0)
    {
        $res=1;    
    }    
    return $res;
	}
	
	public function AddToFavorites($object_type=0,$object_id=0,$users_id=0)
	{
		if (!$users_id || !$object_type || !$object_id) return array();
		
    
    if (M_favorites::isFav($object_type,$object_id,$users_id)==0)
    {
        $data['object_type']=$object_type;
		    $data['photo_id']=$object_id;
		    $data['user_id']=$users_id;
        $data['is_delete']=1;
		    $data['add_date']=time();
		    $this->db->insert('photos_favorites', $data); 		
		}
    else
    {
        	$where=array('photo_id'=>$object_id,'user_id'=>$users_id,'object_type'=>$object_type);
      
          $this->db->set('is_delete', 1);			
          $this->db->where($where);
			    $this->db->update('photos_favorites');			
		
    }
    
    return true;
	}
  
  public function DeleteFromFavorites($object_type=0,$object_id=0,$users_id=0)
	{
		if (!$users_id || !$object_type || !$object_id) return array();
		 
			$where=array('photo_id'=>$object_id,'user_id'=>$users_id,'object_type'=>$object_type);
      
      $this->db->set('is_delete', 0);			
      $this->db->where($where);
			$this->db->update('photos_favorites');			
		
		
		return true;
	}
  
  
  
  
  
  
  
  	
	
}


?>