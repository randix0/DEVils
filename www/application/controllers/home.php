<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Home extends CI_Controller 
{
	
	public function index()
	{  

        $this->load->model('m_users');
		$this->load->model('m_photos');
		$this->load->model('m_tags');
		$this->load->model('m_logs');
		$ps['_activeMenu'] = 'home';
/*
		$ps['photoOfDay'] = $this->m_photos->getDailyItem(true);
		$ps['photos_new'] = $this->m_photos->getItems(12);
		$ps['photos_top'] = $this->m_photos->getItems(12,0,'rating');
        $ps['photos_fav'] = $this->m_photos->getFavItems(12,0,'photos.id');
		$ps['photos_most_commented'] = $this->m_photos->getItems(12,0,'num_comments');
		$ps['tags_top'] = $this->m_tags->getItems();
		$ps['last_updates'] = $this->m_logs->getItems(10,0,'id','desc');
		$ps['users_online'] = $this->m_users->getItems(20,0,'online_till','desc',array('online_till >=' => time()));
		$ps['users_top_rated'] = $this->m_users->getItems(20,0,'rating');
		$ps['users_top_uploaders'] = $this->m_users->getItems(20,0,'num_photos');
*/
		$this->tpl->view('frontend/home/', $ps);
	}
	public function error404()
	{
		echo '404';
	}
	
} 

?>