<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Photos extends CI_Controller 
{

	public function index()
	{  
		$this->load->model('m_photos');
		$ps['_activeMenu'] = 'photo';
		$ps['mode']='new';
		$ps['photos'] = $this->m_photos->getItems(100,0);
		$this->tpl->view('frontend/photos/', $ps);
	}
	
	public function top($page=0)
	{  
		$this->load->model('m_photos');
		$ps['_activeMenu'] = 'photo';
		$ps['mode']='top';
		$ps['photos'] = $this->m_photos->getItems(100,0,'rating');
		$this->tpl->view('frontend/photos/', $ps);
	}
	
	public function all($page=0)
	{  
		$this->load->model('m_photos');
		$ps['_activeMenu'] = 'photo';
		$ps['mode']='new';
		$ps['photos'] = $this->m_photos->getItems(100,0);
		$this->tpl->view('frontend/photos/', $ps);
	}		
	
	public function most_commented($page=0)
	{  
		$this->load->model('m_photos');
		$ps['_activeMenu'] = 'photo';
		$ps['mode']='most_commented';
		$ps['photos'] = $this->m_photos->getItems(100,0,'num_comments');
		$this->tpl->view('frontend/photos/', $ps);
	}

	public function by_tag($tags_id=0)
	{
		$this->load->model('m_photos');
		$this->load->model('m_tags');
		$ps['_activeMenu'] = 'photo';
		$ps['mode']='by_tag';
		$ps['tag']=$this->m_tags->get($tags_id);
		$ps['photos'] = $this->m_photos->getItemsByTagID($tags_id,100,0,'id','desc');
		$this->tpl->view('frontend/photos/', $ps);
	}
	
  public function favorits($page=0)
	{  
		$this->load->model('m_photos');
		$ps['_activeMenu'] = 'photo';
		$ps['mode']='favorit';
		$ps['photos'] = $this->m_photos->getFavItems(100,0);
		$this->tpl->view('frontend/photos/', $ps);
	}
  
  
  

	public function one($id=0)
	{  
		$this->load->model('m_photos');
		$this->load->model('m_votes');
		$users_id=$this->session->userdata('users_id');
		$ps['_activeMenu'] = 'photo';
		$photo = $this->m_photos->get($id);
		$author = array();
		$comments = array();
		$tags = array();
		$contests = array();
		if ($photo){
			$this->load->model('m_users');
			$this->load->model('m_comments');
			$this->load->model('m_tags');
			$this->load->model('m_contests');
			$this->load->model('m_exhibitions');
      $this->load->model('m_favorites');
			$author = $this->m_users->get($photo['users_id']);
			$tags = $this->m_tags->itemsByObject(2,$id);
			$comments = $this->m_comments->getItems(2,$id);
			$commentsCount = count($comments);
			
			$contestsTookPart = $this->m_contests->getAlreadyTookPart($id);
			$contestsTakePart = $this->m_contests->getItemsTakePart($contestsTookPart);
			$exhibitionsTookPart = $this->m_exhibitions->getAlreadyTookPart($id);
			$exhibitionsTakePart = $this->m_exhibitions->getItemsTakePart($exhibitionsTookPart);			
		}
		$ps['photo']=$photo;
		$ps['tags']=implode(',',$tags);
		$ps['author']=$author;
		$ps['comments']=$comments;
		$ps['commentsCount']=$commentsCount;
		$ps['contestsTookPart']=$contestsTookPart;
		$ps['contestsTakePart']=$contestsTakePart;
		$ps['exhibitionsTookPart']=$exhibitionsTookPart;
		$ps['exhibitionsTakePart']=$exhibitionsTakePart;
		$ps['isVoted']=($users_id == $photo['users_id'])?1:$this->m_votes->isVoted(2,$id,$users_id);
    $ps['isFav'] = $this->m_favorites->isFav(2,$id,$users_id); 		
		$this->tpl->view('frontend/photo/', $ps);
	}
	
	public function edit($id=0)
	{
		$ps=array();
		$this->load->model('m_photos');
		$this->load->model('m_tags');
		$userdata=$this->session->all_userdata();
		$photo = $this->m_photos->get($id);
		$tags = $this->m_tags->itemsByObject(2,$id);
		
		if ($photo['users_id'] == $userdata['users_id'] || $userdata['access_level'] > 50)
		{
			$albums = $this->m_photos->getUserAlbumItems($photo['users_id']);
			$photo['tags']=implode(', ',$tags);
			$ps['photo']=$photo;
			$ps['albums']=$albums;
		}		
		$this->tpl->view('frontend/add/photo/', $ps);
	}

} 

?>