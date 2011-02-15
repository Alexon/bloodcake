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

}

?>