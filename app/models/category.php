<?php

class Category extends AppModel
{

	var $name = 'Category';
	var $actsAs = array('Tree');
	var $order = 'Category.lft ASC';
	var $hasMany = array(
		'Item' => array(
			'className' => 'Item',
			'foreignKey' => 'cat_id',
			'dependent'=> false,
		),

		'ChildCategory' => array(
			'className' => 'Category',
			'foreignKey' => 'parent_id',
			'dependent'=> false,
		)
	);
	
	
	
	var $validate = array(
		//'slag' => 'alphaNumeric',
		//'parent_id' => 'numeric',
	);
	
	
	
	function _findByIdSlag($id = null, $redirect = true)
	{
		if(!is_numeric($id))
		{
			$this->passedArgs['slag'] = $id;
		}

		if(!empty($this->passedArgs['slag']))
		{
			$data = $this->findAllBySlag($this->passedArgs['slag']);
			if(count($data)==1)
			{
				$data = $data['0'];
				$id = $data['Category']['id'];
			}
			else if($redirect)
				$this->cakeError('error404');
			else return false;
		}
		
		if(empty($id) and $redirect)
			$this->cakeError('error404');

		if(empty($data))
			$data = $this->findById($id);
			
		if(empty($data) and $redirect){
			$this->cakeError('error404');
		}
		//debug($data);
		return $data;
	}

}

?>