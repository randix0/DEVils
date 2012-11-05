<?php
require_once('./application/libraries/smarty/libs_3.1.5/Smarty.class.php');
 
	class Templates extends Smarty 
	{
		
		private $CI; 
		private $_debug = true;
		
		private $_mainTpl = 'main.tpl';
		private $_structTplsDir = 'std/tpl/';
		
		public $_lang = 'en';
		public $_languages = array('en' => 'English', 'ru' => 'Russian', 'ua' => 'Ukrainian' );
		
		private $_pageText = array();
		
 
		
		function __construct()
		{
			parent::__construct(); 
			$this->CI =& get_instance();
			$this->CI->load->helper('file');
			
			$this->template_dir = './application/views/';
			$this->compile_dir = './application/cache/smarty/'; 
			$this->cache_dir = './application/cache/smarty/';
			$this->assign('_title', ''); 
			
			$this->registerPlugin('block', 'l', array($this, 'smartyBlockTranslate'));
			$this->registerPlugin('block', 't', array($this, 'smartyBlockTextView'));
			
			$this->assign('__LANGUAGES', $this->_languages); 
			//$this->selectLang();
			//$this->setPageText();
			
			$this->assign('_url', $this->CI->config->item('base_url').'/'.$this->_lang); 
			
		}
		
		/*
		 * 
		 */
		
		public function setPageText()
		{
			$link = $this->CI->router->fetch_directory().$this->CI->router->fetch_class();
			$this->CI->load->model('m_page');
			$res = $this->CI->m_page->get($link, $this->_lang);
			$this->_pageText = $res;
		}
		
		/*
		 * 
		 */
		
		public function smartyBlockTextView($params, $content, &$smarty, &$repeat)
		{ 
			if(isset($this->_pageText[$content]))
			{
				$result = $this->_pageText[$content];
				return $result;
			}
			if($this->_debug) return '<span style="color: #f00; font-weight: 800;">'.$content.'</span>';
			return $content;
		}
		
		/*
		 * 
		 */
		
		public function smartyBlockTranslate($params, $content, &$smarty, &$repeat) 
		{
			if(isset($this->CI->lang)) 
			{
			   	$result = &$this->CI->lang->line($content);
			   	if($result) return $result;
			}
			return $content;
	 	}
	 	
	 	
		/*
		 * 
		 */
	 	
		public function selectLang()
		{
			$lang = $this->CI->uri->segment(1);  
			if(isset($this->_languages[$lang]))
			{
				$this->CI->session->set_userdata('lang', $lang);
				$thisURL = $this->CI->uri->uri_string();
				$thisURL = explode("/", $thisURL);
				unset($thisURL[0]);
				$thisURL = implode("/", $thisURL); 
			}
			else
			{
				$thisURL = $this->CI->uri->uri_string();
			}
			
			if($this->CI->session->userdata('lang'))
			{
				$this->_lang = $this->CI->session->userdata('lang');
				
			} 
			else
			{
				$this->CI->session->set_userdata('lang', $this->_lang);
			}
			
			$this->CI->lang->load('main', $this->_lang); 
			
			$this->assign('__choiseLANG', $this->_lang);
			$this->assign('__thisURL', $thisURL);
		}
	 	
		/*
		 * 
		 */
	 	
	 	
	 	public function view($tplDir = '', $data = array(), $tplFile = false, $attach = true, $fetch = false)
	 	{	  
			//$data['_partners'] = '';
	 		//if($this->CI->uri->segment(1) == 'partners' or (isset($this->_languages[$this->CI->uri->segment(1)]) and $this->CI->uri->segment(2) == 'partners')) $data['_partners'] = 'std/partners/';
	 		//if($this->CI->uri->segment(1) == 'admin' or (isset($this->_languages[$this->CI->uri->segment(1)]) and $this->CI->uri->segment(2) == 'admin')) $this->_structTplsDir = 'std/admin/';

	 		if($tplDir != '')
	 		{
				if(!$tplFile) $tplFile = 'index.tpl';
				$files = get_filenames($this->template_dir.'/'.$tplDir);
				
				if(!empty($files))
				{
			 		foreach($files as $file)
			 		{
			 			switch($file)
			 			{
			 				case $tplFile : $tpl['content'] = $tplDir.'/'.$file; break;
			 				case 'title.tpl' : $tpl['title'] = $tplDir.'/'.$file; break;
			 				case 'headdata.tpl' : $tpl['headdata'] = $tplDir.'/'.$file; break;
			 				case 'leftColumn.tpl' : $tpl['leftColumn'] = $tplDir.'/'.$file; break;
			 				case 'rightColumn.tpl' : $tpl['rightColumn'] = $tplDir.'/'.$file; break;
							case 'subNav.tpl' : $tpl['subNav'] = $tplDir.'/'.$file; break;
			 				default: $tpl[$file] = $tplDir.'/'.$file;
			 			}
			 		}
				}

				$files = get_filenames($this->template_dir.'/'.$tplDir.'/../std');
			 	if(!empty($files))
				{ 
				 	foreach($files as $file)
				 	{
				 		switch($file)
				 		{
				 			case 'meta.tpl' : $tpl['meta'] = $tplDir.'/../std/'.$file; break;
				 			default: $tpl[$file] = $tplDir.'/../std'.'/'.$file;
				 		}
				 	}
				} 

	 		}

			
	 		$tpl['header'] = $this->_structTplsDir.'header.tpl';
			$tpl['pageTop'] = $this->_structTplsDir.'pageTop.tpl';
			$tpl['pageBottom'] = $this->_structTplsDir.'pageBottom.tpl';
	 		$tpl['pageNav'] = $this->_structTplsDir.'pageNav.tpl';
	 		$tpl['footer'] = $this->_structTplsDir.'footer.tpl';
			$this->assign('_tpl', $tpl); 
			
	 		if(!empty($data))  
			{
				foreach($data as $key => $val)
					$this->assign($key, $val);
			}

			if($attach && !$fetch) {
				$this->display($this->_structTplsDir.$this->_mainTpl);
			}

			elseif(!$attach && !$fetch)
				$this->display($tplDir.'/'.$tplFile);
			elseif($attach && $fetch)
				return $this->fetch($this->_structTplsDir.$this->_mainTpl);
			elseif(!$attach && $fetch)
				return $this->fetch($tplDir.'/'.$tplFile);
			else die('wtf?');
			

			//$this->display($tplDir.'/'.$tplFile);			
	 	}
	}
?>