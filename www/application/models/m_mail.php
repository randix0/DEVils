<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_mail extends CI_Model
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
	
	public function getLastUserGroups($users_id = 0)
	{
		if ($users_id<1) return array();
		$this->db->where('from_users_id',$users_id);
		$this->db->or_where('to_users_id',$users_id);
		$this->db->group_by(array('from_users_id','to_users_id'));
		$this->db->order_by('add_date','desc');
		$query = $this->db->get('mail',10);
		$lastUsersGroups = $query->result_array();
		
		$this->load->model('m_users');
		
		foreach($lastUsersGroups as &$u)
		{
			$u['from'] = $this->m_users->get($u['from_users_id']);
			$u['to'] = $this->m_users->get($u['to_users_id']);
		}
		
		return $lastUsersGroups;
	}
	
	public function getMessages($from_users_id = 0, $to_users_id = 0)
	{
		$this->load->model('m_users');
		
		$conversation = $this->m_mail->getConversation($from_users_id, $to_users_id);

		if ($from_users_id == $conversation['users_id_1'])
			$update_conversation = array('unread_msg_1'=>0, 'readed_msg_1'=>$conversation['readed_msg_1']+$conversation['unread_msg_1']);
		else	
			$update_conversation = array('unread_msg_2'=>0, 'readed_msg_2'=>$conversation['readed_msg_2']+$conversation['unread_msg_2']);
		$this->db->where('id',$conversation['id']);
		$this->db->update('mail_conversations', $update_conversation);

		$from = $this->m_users->get($from_users_id);
		$to = $this->m_users->get($to_users_id);
		
		$this->db->where('(from_users_id = '.$from_users_id.' AND to_users_id = '.$to_users_id.') OR (from_users_id = '.$to_users_id.' AND to_users_id = '.$from_users_id.')');

		$this->db->order_by('add_date','desc');
		$query = $this->db->get('mail',10);
		$messages = $query->result_array();
		foreach ($messages as &$m)
		{
			if ($m['from_users_id'] == $from_users_id && $m['to_users_id'] == $to_users_id)
			{
				$m['from']=$from;
				$m['to']=$to;
				$m['direction']=0;
			}
			else
			{
				$m['from']=$to;
				$m['to']=$from;
				$m['direction']=1;
			}
		}
		return $messages;
	}
	
	public function addMessage($item = array())
	{
		if (!$item || !$item['from_users_id'] || !$item['to_users_id']) return false;
		$conversation = $this->m_mail->getConversation($item['from_users_id'], $item['to_users_id']);
		
		
		$this->db->insert('mail', $item);

		$this->db->where('id',$conversation['id']);
		
		if ($item['from_users_id'] == $conversation['users_id_1'])
			$update_conversation = array('unread_msg_2'=>$conversation['unread_msg_2']+1);
		else
			$update_conversation = array('unread_msg_1'=>$conversation['unread_msg_1']+1);
		$this->db->update('mail_conversations', $update_conversation);
		
		return true;
	}

	public function getConversations($users_id = 0)
	{
		if ($users_id < 1) return array();
		$this->db->where('users_id_1',$users_id);
		$this->db->or_where('users_id_2',$users_id);
		$query = $this->db->get('mail_conversations');
		$conversations = $query->result_array();

		$this->load->model('m_users');
		
		foreach($conversations as &$m)
		{
			$m['user1'] = $this->m_users->get($m['users_id_1']);
			$m['user2'] = $this->m_users->get($m['users_id_2']);
		}
		
		return $conversations;
	}
	
	public function getConversation($users_id_1 = 0, $users_id_2 = 0)
	{
		if ($users_id_1 < 1 || $users_id_2 < 1) return false;
		$this->db->where('(users_id_1 = '.$users_id_1.' AND users_id_2 = '.$users_id_2.') OR (users_id_1 = '.$users_id_2.' AND users_id_2 = '.$users_id_1.')');
		$query = $this->db->get('mail_conversations',1);
		$conversation = $query->row_array();
		if (!$conversation){
			$conversation = array(
				'id' => $this->m_mail->createConversation($users_id_1,$users_id_2),
				'users_id_1'=>$users_id_1,
				'users_id_2'=>$users_id_2,
				'unread_msg_1'=>0,
				'unread_msg_2'=>0,
				'readed_msg_1'=>0,
				'readed_msg_2'=>0,
				'last_msg'=>0
			);
		}
		return $conversation;
	}
	
	public function createConversation($users_id_1 = 0, $users_id_2 = 0)
	{
		if ($users_id_1 < 1 || $users_id_2 < 1) return false;
		//$conversations = $this->m_mail->getConversation($users_id_1,$users_id_2);
		//if ($conversations) return $conversations['id'];
		$item=array(
			'users_id_1'=>$users_id_1,
			'users_id_2'=>$users_id_2
		);
		$this->db->insert('mail_conversations', $item);
		$conversation_id = $this->db->insert_id();
		return $conversation_id;
	}
}

?>