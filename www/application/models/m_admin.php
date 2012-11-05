<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_page extends CI_Model
{
	
	private $_table = 'pages';
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function installDB()
	{
		#$query = $this->db->query('');
		$cr_auth="create table phil2_users
		(id int unsigned not null auto_increment primary key,
		login char(20) not null,
		password text not null,
		access_level char(20) not null,
		mail char(50) not null,
		fname char(255) not null,
		lname char(255) not null,
		rating int not null,
		add_date int not null,
		apr tinyint not null)";	
		
			
	}
	
}
?>