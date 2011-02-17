<?php

class Image extends AppModel
{

	var $name = 'Image';

	var $belongsTo = array(
		'Item' => array(
			'className' => 'Item',
			'foreignKey' => 'good_id',
		)
	);
	
	function beforeDelete()
	{
		$data = $this->findById($this->id);
		$root = ROOT . '/app/webroot/img/';
		unlink($root . $data['Image']['url']);
		
		return true;
	}

}

?>