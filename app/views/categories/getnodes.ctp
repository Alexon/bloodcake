<?php

$data = array();

foreach ($nodes as $node){
	$data[] = array(
		"text" => $node['Category']['name'], 
		"id" => $node['Category']['id'],
		"cls" => "folder",
		"leaf" => ($node['Category']['lft'] + 1 == $node['Category']['rght'])
	);
}

echo $javascript->object($data);

?>