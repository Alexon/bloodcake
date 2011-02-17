<?php

class CommonController extends AppController {

var $settings;

function beforeFilter() 
{
	$this->_loadSettings();
	$this->_setLanguage();
	//ещё нужно считать пароль админа, чтобы проверять - админ ли
	$this->_checkAdmin();
}

function _loadSettings()
{
	App::import('Model', 'Setting');
	$this->settings = new Setting();
	$this->settings = $this->settings->find('list', array('fields' => array('Setting.variable', 'Setting.value')));
	//debug($this->settings);
}

function _setLanguage()
{
	$lang = empty($this->settings['lang']) ? 'rus' : $this->settings['lang'];
	$this->Session->write('Config.language', $lang);
}

function _checkAdmin()
{
	$is_admin = false;
	
	if(!empty($this->settings['pass']))
	{
		$is_admin = (md5($this->settings['pass']) === $this->Cookie->read('pass'));
	}
$is_admin = true;	
	if($is_admin)
		define('__ADMIN', 1);
	else
		define('__ADMIN', 0);
}


}