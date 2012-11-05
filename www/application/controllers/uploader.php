<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Uploader extends CI_Controller 
{
	
	public function index()
	{  
		$ps=array();
		$user=$this->session->all_userdata();
		if( isset($_POST['submit']) && isset($user) && isset($user['users_id']) && isset($_FILES['uploaded_image']['tmp_name'])) {
			$imageFile=time().'.'.end(explode(".", $_FILES['uploaded_image']['name']));
			$photoData=$_POST['photo'];
			$image = new Imagick($_FILES['uploaded_image']['tmp_name']);
			
			$height=$image->getImageHeight();
			$width=$image->getImageWidth();
			
			if ($width > 800 || $height > 800){
				if ($height < $width)
					$image->scaleImage(800,0);
				else
					$image->scaleImage(0,600);
			}
			
						
			
			$image->writeImage('./storage/photos/b/'.$imageFile);
			$image->cropThumbnailImage(100, 100);
			$image->writeImage('./storage/thumbs/'.$imageFile);
			
			$ps['photo_b']='/storage/photos/b/'.$imageFile;
			$ps['thumb']='/storage/thumbs/'.$imageFile;
			
			$data = array(
			   'iname' => ($photoData['iname']?$photoData['iname']:'noname'),
			   'idesc' => ($photoData['idesc']?$photoData['idesc']:''),
			   'path' => '/storage/photos/',
			   'file' => $imageFile,
			   'thumb' => $ps['thumb'],
			   'add_date' => time(),
			   'allow_comments' => (isset($photoData['allow_comments'])?1:0),
			   'users_id' => $user['users_id']
			);
			
			$this->db->insert('photos', $data);
			$photos_id = $this->db->insert_id();
			$this->load->model('m_users');
			$this->load->model('m_logs');
			$this->m_users->update(array('num_photos'=>$user['num_photos']+1),$user['users_id']);
			$this->m_logs->add(array(
				'users_id'=>$user['users_id'],
				'action'=>1,
				'object_type'=>2,
				'object_id'=>$photos_id
			));
		}
		$ps['_activeMenu'] = 'upload';
		$this->tpl->view('frontend/upload/', $ps);
	}
} 

?>