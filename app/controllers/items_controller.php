<?php

require_once "_commoncontroller.php";

class ItemsController extends CommonController 
{

	var $name = 'Items';
	var $helpers = array('Html', 'Form', 'Tree', 'Ajax');
	var $components = array('Cookie');

	function index()
	{
		$this->paginate = array(
			'limit' => 10,
			'fields' => array('Item.title', 'Item.price', 'Category.name', 'Item.special', 'Item.id', 'Category.id', 'MainImage.url'),
		);
		$data = $this->paginate('Item');
		$this->set(compact('data'));
		
	}
	
	function view($id=null)
	{
		if(!is_numeric($id))
			$this->redirect('/items/');
		
		$data = $this->Item->findById($id);
		
		if(empty($data))
		{
			$this->cakeError('error404');
		}
				
		$this->set(compact('data'));


		$exc_id = $data['MainImage']['id'] ? $data['MainImage']['id'] : "0";
		
		$this->paginate = array(
			'limit' => 10,
			'conditions' => array('Image.good_id='.$id, 'Image.id!='.$exc_id),
			'fields' => array('Image.id', 'Image.good_id', 'Image.url'),
		);
		$images = $this->paginate('Image');
		$this->set(compact('images'));
		
	}
	
	
	
	function edit($id)
	{
		if(!__ADMIN)
			$this->redirect('/items/');
	
		$data = $this->Item->findById($id);
		if(empty($data))
			$this->cakeError('error404');
		
		if(!empty($this->params['data']))
		{
			$this->Item->save($this->params['data']);
			
			//debug($this->params['data']);exit;
			foreach($this->params['data']['delete'] as $image=>$checked)
			{
				if($checked)$this->Item->Image->delete($image);
			}
			//exit;
			
			$root = ROOT . '/app/webroot/img/';
			foreach($this->params['data']['Item'] as $key => $file)
			{
				if(is_array($file) and isset($file['name']) and isset($file['tmp_name']) and !$file['error'])
				{
					if(in_array(strtolower($file['type']), array('image/jpeg', 'image/png', 'image/gif')))
					{
						$file['name'] = basename( $file['name']);
						$target_path = $root . $file['name'];
						if(file_exists($target_path))
						{
							$file['name'] = time() . $file['name'];
							$target_path = $root . $file['name'];
						}
						if(!move_uploaded_file($file['tmp_name'], $target_path))
							$this->cakeError('cannotWriteFile', array('file'=>$file['name']));
						
						$this->Item->Image->create();
						$this->Item->Image->save(array('Image'=>array('url'=>$file['name'], 'good_id'=>$this->Item->id)));
					}
				}
			}
			
			$this->redirect('/items/view/'.$this->Item->id);
		}
			
		$this->set(compact('data'));
		$this->data = $data;	
		$categories = $this->Item->Category->find('list', array('fields' => array('id', 'name')));
		$this->set(compact('categories'));
		
		$images = $this->Item->Image->find('list', array('fields' => array('id', 'url'), 'conditions'=>array('Image.good_id'=>$id)));
		$this->set(compact('images'));
	}
	
	
	function create($cat_id = null)
	{
		if(!__ADMIN)
			$this->redirect('/items/');
			
		if(!empty($this->params['data']))
		{
			$this->Item->create();
			$this->Item->save($this->params['data']);
			
			$root = ROOT . '/app/webroot/img/';
			foreach($this->params['data']['Item'] as $key => $file)
			{
				if(is_array($file) and isset($file['name']) and isset($file['tmp_name']) and !$file['error'])
				{
					if(in_array(strtolower($file['type']), array('image/jpeg', 'image/png', 'image/gif')))
					{
						$file['name'] = basename( $file['name']);
						$target_path = $root . $file['name'];
						if(file_exists($target_path))
						{
							$file['name'] = time() . $file['name'];
							$target_path = $root . $file['name'];
						}
						if(!move_uploaded_file($file['tmp_name'], $target_path))
							$this->cakeError('cannotWriteFile', array('file'=>$file['name']));
						
						$this->Item->Image->create();
						$this->Item->Image->save(array('Image'=>array('url'=>$file['name'], 'good_id'=>$this->Item->id)));
					}
				}
			}
			
			$this->redirect('/items/view/'.$this->Item->id);
		}
			
		$this->loadModel('Category');
		$this->Category = new Category();
		$this->data['cat'] = $this->Category->_findByIdSlag($cat_id, false);
		$cat_id = $this->data['cat'] ? $this->data['cat']['Category']['id'] : null;
		$this->set(compact('cat_id'));
		
		$categories = $this->Category->find('list', array('fields' => array('id', 'name')));
		$this->set(compact('categories'));
	}
	
	function delete($id = null)
	{
		if(!__ADMIN)
			$this->redirect('/items/');
			
		$this->Item->delete($id);
		
		$this->Flash(__('Deleted!', 1) ,'/items/');
	}

}





