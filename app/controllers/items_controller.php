<?php

class ItemsController extends AppController {



var $name = 'Items';

var $helpers = array('Html', 'Form', 'Tree');

var $components = array('Cookie');

function beforeFilter() 
{
	$this->_setLanguage();
}

function _setLanguage()
{
	if ($this->Cookie->read('lang') && !$this->Session->check('Config.language')) 
	{
		$this->Session->write('Config.language', $this->Cookie->read('lang'));
	}
	elseif (isset($this->params['language']) && ($this->params['language'] != $this->Session->read('Config.language')))
	{
		$this->Session->write('Config.language', $this->params['language']);
		$this->Cookie->write('lang', $this->params['language'], null, '20 days');
	}
}


function index()
{
Configure::write('App.encoding', 'UTF-8');
    $this->data = $this->Item->find('all');
	print_r($this->data);
	
} 

}





