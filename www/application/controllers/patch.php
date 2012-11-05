<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Patch extends CI_Controller 
{
	
	public function index()
	{  

		$data['_activeMenu'] = 'admin';
		$this->tpl->view('backend/home/', $data);
	}
	
	public function start()
	{
		
		$data['_activeMenu'] = 'admin';
		
		ignore_user_abort(true);
		set_time_limit(0);		
		
		$offset = 0;
		$limit = 10;
		
		$this->db->where('updated',0);
		$this->db->where('is_deleted',0);
		$query = $this->db->get('photos_il', $limit, $offset);
		$photos=$query->result_array();

		while (count($photos) > 0) {
			
			foreach($photos as $p)
			{
				$img = $p['img'];
				
				$imageFile = str_replace('http://photo.ilich.in.ua/upload/', '', $img);
				
				echo '<p>'.$imageFile.'</p>';
				
				if (file_exists('./upload/'.$imageFile)) {
				
					$image = new Imagick('./upload/'.$imageFile);
					//$imageFile=time().'.'.end(explode(".", $_FILES['uploaded_image']['name']));
					
					$height=$image->getImageHeight();
					$width=$image->getImageWidth();
					
					if ($width > 800 || $height > 800){
						if ($height < $width)
							$image->scaleImage(800,0);
						else
							$image->scaleImage(0,600);
					}
					
					$image->writeImage('./storage_2/photos/b/'.$imageFile);
					$image->cropThumbnailImage(100, 100);
					$image->writeImage('./storage_2/thumbs/'.$imageFile);		
					
					$this->db->where('phid',$p['phid']);
					$this->db->update('photos_il', array('updated'=>1));
				}
				
				else {
					$this->db->where('phid',$p['phid']);
					$this->db->update('photos_il', array('is_deleted'=>1));
				}
			}

			$this->db->where('updated',0);
			$query = $this->db->get('photos_il', $limit, $offset);
			$photos=$query->result_array();
			
		}
		
		
		//$this->tpl->view('backend/install/', $data);
	}	
	
} 

?>