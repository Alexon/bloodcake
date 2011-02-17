<?php

class AdminController extends AppController
{
	var $uses = array();
	var $components = array('Security', 'Cookie');
	var $helpers = array('Html', 'Form', 'Javascript');
	
	function beforeFilter()
	{
		
		parent::beforeFilter();
		
		if(!__ADMIN)
		//GTFO
			$this->cakeError('error404');
		
		$this->Security->requirePost('login');
	}

	function index()
	{
		if(!empty($this->params['data']))
		{
			App::import('Model', 'Setting');
			$this->Setting = new Setting();
			if($this->settings['lang']!=$this->params['data']['lang'])
			{
				//oh noes, bydlocode
				$this->Setting->query("DELETE FROM settings WHERE variable='lang'");
				$this->params['data']['lang'] = htmlspecialchars($this->params['data']['lang']);
				$this->Setting->query("INSERT INTO settings value ('lang', '".$this->params['data']['lang']."')");
				$this->settings['lang'] = $this->params['data']['lang'];
			}
			
			if(empty($this->settings['pass']) or $this->settings['pass']!=md5($this->params['data']['pass']))
			{
				//oh no, pass come into dbase!
				$this->Setting->query("DELETE FROM settings WHERE variable='pass'");
				$this->params['data']['pass'] = md5($this->params['data']['pass']);
				$this->Setting->query("INSERT INTO settings value ('pass', '".$this->params['data']['pass']."')");
				$this->settings['pass'] = $this->params['data']['pass'];
				//hanged cookie
				$this->Cookie->write('pass',md5($this->settings['pass']),true, '1 year');
			}
		}
	
	
		$locales = array();
		$localePath = ROOT.DS.'app'.DS.'locale';
		$handle = opendir($localePath);
		while (false !== ($lang = readdir($handle)))
		{
			if($lang!="." and $lang!="..")
				if($lang=='eng' or file_exists($localePath . DS . $lang . DS . 'LC_MESSAGES' . DS . 'default.po'))
				{
					$this->Session->write('Config.language', $lang);
					$locales[$lang] = $lang . ' (' . __('English',1) . ')';
				}
		}
		$this->set(compact('locales'));
		
		$this->_setLanguage();
		$current_lang = $this->settings['lang'];
		
		$this->set(compact('current_lang'));
		
	}
	
	function categories()
	{
		
	}
	
	function items()
	{
	
		$result = '';
	
		if(!empty($this->params['data']))
		{			
			App::import('Vendor', 'Spreadsheet_Excel_Reader', array('file' => 'excel_reader2.php'));
			$data = new Spreadsheet_Excel_Reader($this->params['data']['xls']['tmp_name'], true);
			$cells = $data->sheets[0]['cells'];  //NB: it read only first sheet
			//debug($cells);
			$attrs = array();
			foreach($cells[1] as $key=>$value)
			{
				if(in_array($value, array("Название", "Title", "название", "Name")))$attrs['title'] = $key;
				if(in_array($value, array("Слаг", "Slag", "Slug", "слаг")))$attrs['slag'] = $key;
				if(in_array($value, array("Категория", "Category", "категория", "category")))$attrs['category'] = $key;
				if(in_array($value, array("Описание", "Description", "описание")))$attrs['description'] = $key;
				if(in_array($value, array("Особенная", "Special", "особенная")))$attrs['special'] = $key;
				if(in_array($value, array("Цена", "Price", "цена")))$attrs['price'] = $key;
			}
			
			App::import('Model', 'Item');
			$item = new Item();
			
			//debug($cells);exit;
			
			for($i = 2; $i<=count($cells);$i++)
			{
				$row = array();
				foreach($attrs as $attr => $key)
				{
					if(!empty($cells[$i][$key]))
					{
						if($attr!="price" or is_numeric($cells[$i][$key]))
							$row[$attr] = $cells[$i][$key];
					}
				}
				
				//debug($cells[$i]);
						
				if(isset($row['title']) and $row['title']!=='')
				{
						$item->create();
						$row['Item']['title'] = $row['title'];
						$row['Item']['description'] = isset($row['description']) ? $row['description'] : '';
						$row['Item']['special'] = isset($row['special']) ? $row['special'] : '';
						$row['Item']['price'] = isset($row['price']) ? $row['price'] : '';
						$row['category'] = isset($row['category']) ? $row['category'] : '';
						$cat_id = $item->Category->findByName($row['category']);
						if(empty($cat_id) and $row['category']!=='')
						{ //category is yet not exist
							$item->Category->create();
							$cat = array('Category'=>array(
									'slag' => isset($row['slag']) ? $row['slag'] : '',
									'name' => $row['category'],
							));
							//debug($cat);
							//if(0)
								$item->Category->save($cat);
							$cat_id = $item->Category;
						}
						$row['Item']['cat_id'] = $cat_id->id;
						$row['Item']['special'] = isset($row['title']) and (in_array($row['title'], array('Да', 'да')));
						//debug($row);
						$item->save($row);
				}
			}
			$result = __('Loaded', 1);
		}
		$this->set(compact('result'));
	}
	
	function logout()
	{	
		
	}
	
	function login()
	{
		
	}



}


