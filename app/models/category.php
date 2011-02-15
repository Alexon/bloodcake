<?php

class Category extends AppModel
{

	var $name = 'Category';

	var $actsAs = array('Tree');

	var $hasMany = array(
		'Item' => array(
			'className' => 'Item',
			'foreignKey' => 'cat_id',
			'dependent'=> false,
		)
	);

}

?>