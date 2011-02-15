<?php


class Item extends AppModel
{

	var $name = 'Item';

	var $belongsTo = array(
		'Category' => array(
			'className' => 'Category',
			'foreignKey' => 'cat_id'
		)
	); 
	
	var $hasMany = array(
		'Image' => array(
			'className' => 'Image',
			'foreignKey' => 'good_id',
			'dependent'=> true,
		)
	);
	
	var $hasOne = array(
		'MainImage' => array(
			'className' => 'Image',
			'foreignKey' => 'good_id',
			'conditions' => array('Item.main_pic_id=MainImage.id' => '1'),
		)
	);
}

