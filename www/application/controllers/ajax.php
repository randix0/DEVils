<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Ajax extends CI_Controller 
{
	
	public function setOnline()
	{
		$json = array('status'=>'error');
		$user=$this->session->all_userdata();
		if (isset($user['users_id']) && $user['users_id'] > 0 && $user['online_till'] < time())
		{
			$this->load->model('m_users');
			$isVoted=$this->m_users->setOnline($user['users_id'],300);
			$onlineTill = time()+300;
			$this->session->set_userdata('online_till',$onlineTill);
			$json['status'] = 'success';
			$json['details'] = 'complete';
		}
		elseif (isset($user['users_id']) && $user['users_id'] > 0 && $user['online_till'] > time())
		{
			$json['status'] = 'success';
			$json['details'] = 'still_online';
		}
		elseif (!isset($user['users_id']))
		{
			$json['details'] = 'not_logged';
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}

	public function addComment()
	{  
		$json = array('status'=>'error');
		if (isset($_POST['comment']) && $_POST['comment'])
		{
			$comment=$_POST['comment'];
			$user=$this->session->all_userdata();
			$comment['users_id']=$user['users_id'];
			$this->load->model('m_comments');
			$comments_id=$this->m_comments->add($comment);
			$this->load->model('m_logs');
			$this->m_logs->add(array(
				'users_id'=>$user['users_id'],
				'action'=>1,
				'object_type'=>6,
				'object_id'=>$comments_id
			));	
			$json['status']='success';
			$json['item']=$comment;
			$json['item']['author']=$user;
			$json['item']['add_date']=date('d-m-y H:i:s');
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}

	public function like($object_type=0,$object_id=0)
	{  
		$json = array('status'=>'error');
		$user=$this->session->all_userdata();
		if (isset($user['users_id']) && $user['users_id']>0)
		{
			$this->load->model('m_votes');
			$isVoted=$this->m_votes->isVoted($object_type,$object_id,$user['users_id']);
			if (!$isVoted)
			{
				$this->m_votes->vote($object_type,$object_id,$user['users_id']);
				$json['status']='success';
			}
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}	

	public function delete($object_type=0,$object_id=0)
	{  
		$json = array('status'=>'error');
		$user=$this->session->all_userdata();
		if ($object_type == 2) {
			$this->load->model('m_photos');
			$photo=$this->m_photos->get($object_id);
			if ($photo['users_id'] == $user['users_id'] || $user['access_level'] > 80)
			$this->m_photos->delete($object_id);
			$json['status']='success';
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}	
	
	public function savePhoto()
	{
		$json = array('status'=>'error');
		$item=$_POST['item'];
		$id=$_POST['id'];
		$item_add=$_POST['additional'];
		$user=$this->session->all_userdata();
		if (isset($user['users_id']) && $user['users_id']) {
			$this->load->model('m_photos');
			$this->load->model('m_tags');
			$photo=$this->m_photos->get($id);
			if ($photo['users_id'] == $user['users_id'] || $user['access_level'] > 80)		
				{
					if (!isset($item['allow_comments'])) $item['allow_comments']=0;
					if ($item['album_id'] == -1 && isset($item_add['album_iname']) && $item_add['album_iname']){
						$item['album_id'] = $this->m_photos->createAlbum(array('users_id'=>$user['users_id'],'iname'=>$item_add['album_iname']));
					}
					
					if (isset($item_add['album_cover']) && $item_add['album_cover'] && $item['album_id']>0) {
						$album['cover']=$photo['id'];
						$this->m_photos->updateAlbum($item['album_id'],$album);
					}
					
					
					$this->m_photos->update($id,$item);
					$this->m_tags->setTags($item_add['tags'],2,$id);
					$json['status']='success';
				}
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}

    public function savePost()
    {
        $json = array('status'=>'error');
        $item=$_POST['item'];
        $id=(int)$_POST['id'];
        //$item_add=$_POST['additional'];
        $user=$this->session->all_userdata();
        if (isset($user['users_id']) && $user['users_id']) {
            $this->load->model('m_posts');
            //$this->load->model('m_tags');
            if ($id) {
                $post=$this->m_post->get($id);
                if ($post['users_id'] == $user['users_id'] || $user['access_level'] > 80)
                {
                    $this->m_post->update($id,$item);
                    $json['status']='success';
                }
            } else {
                $item['users_id'] = $user['users_id'];
                $id = $this->m_post->create($item);
                $json['status']='success';
                $json['id'] = $id;
            }
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }
	
	public function uploadAvatar()
	{
		$json=array('status'=>'error');
		$user=$this->session->all_userdata();
		if( isset($_POST['submit']) && isset($user) && isset($user['users_id']) && isset($_FILES['avatar_image']['tmp_name'])) {
			$imageFile=time().'.'.end(explode(".", $_FILES['avatar_image']['name']));
			$image = new Imagick($_FILES['avatar_image']['tmp_name']);
			
			$height=$image->getImageHeight();
			$width=$image->getImageWidth();
			
			if ($height < $width)
				$image->scaleImage(300,0);
			else
				$image->scaleImage(0,300);
			
			$image->writeImage('./storage/avatars/b/'.$imageFile);
			$image->cropThumbnailImage(100, 100);
			$image->writeImage('./storage/avatars/m/'.$imageFile);
			$image->cropThumbnailImage(40, 40);
			$image->writeImage('./storage/avatars/s/'.$imageFile);			
			
			$data = array(
			   'path' => '/storage/avatars/',
			   'file' => $imageFile,
			   'add_date' => time(),
			   'users_id' => $user['users_id']
			);
			
			$this->load->model('m_avatars');
			$this->load->model('m_users');
			$avatars_id=$this->m_avatars->set($data);
			if ($avatars_id > 0)
			{
				$this->m_users->update(array('avatars_id'=>$avatars_id),$user['users_id']);
				$this->session->set_userdata('avatars_id',$avatars_id);
			}
			$json['status']='success';
			$json['src']=$data['path'].'b/'.$data['file'];
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}
	
	public function sendMail()
	{
		$json = array('status'=>'error');
		$user=$this->session->all_userdata();
		if(isset($_POST['item']) && isset($user) && isset($user['users_id']) && isset($_POST['item']['to_users_id']) && $_POST['item']['to_users_id'] > 0 && isset($_POST['item']['idesc'])) {
			$item=$_POST['item'];
			$item['from_users_id']=$user['users_id'];
			$item['add_date']=time();
			$this->load->model('m_mail');
			$this->m_mail->addMessage($item);
			$json['status']='success';
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}
} 

?>