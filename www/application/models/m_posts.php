<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_posts extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function get($id=0)
    {
        if ($id<1) return array();
        $this->db->where('id',$id);
        $query = $this->db->get('posts',1);
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
            $query = $this->db->get('posts', $limit, $offset);
        else
            $query = $this->db->get('posts');
        $photos=$query->result_array();
        $this->load->model('m_users');
        foreach ($photos as &$photo) {
            $photo['author'] = $this->m_users->get($photo['users_id']);
        }
        return $photos;
    }

    public function getItemsByTagID($tags_id=0,$limit=0,$offset=0)
    {
        $this->db->select('posts.*');
        $this->db->from('tags_links');
        $this->db->join('posts', 'posts.id = tags_links.object_id');

        $this->db->where('posts.is_deleted',0);
        $this->db->where('tags_links.tags_id',$tags_id);
        $this->db->where('tags_links.object_type',1);
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

    public function getLast()
    {
        $this->db->where('is_deleted',0);
        $this->db->order_by("id", "desc");
        $query = $this->db->get('posts', 1);
        $photo = $query->row_array();
        $this->load->model('m_users');
        $photo['author'] = $this->m_users->get($photo['users_id']);
        return $photo;
    }

    public function delete($id)
    {
        $this->db->where('id',$id);
        $this->db->set('is_deleted', 1);
        $query = $this->db->update('posts');
        return true;
    }

    public function update($id,$array=array())
    {
        $this->db->where('id',$id);
        $query = $this->db->update('posts', $array);
        return true;
    }

}
?>