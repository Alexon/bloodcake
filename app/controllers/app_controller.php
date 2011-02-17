<?php

class AppController extends Controller {

var $settings;
var $components = array('Cookie', 'Session');


function beforeFilter() 
{


	$this->_loadSettings();
	$this->_setLanguage();
	//��� ����� ������� ������ ������, ����� ��������� - ����� ��
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
	$this->settings['lang'] = empty($this->settings['lang']) ? 'rus' : $this->settings['lang'];
	$this->Session->write('Config.language', $this->settings['lang']);
}

function _checkAdmin()
{
//debug($this->params);
	if(isset($this->params['data']) and (isset($this->params['data']['login']) and isset($this->params['data']['login']['passwd']) and md5($this->params['data']['login']['passwd'])==$this->settings['pass']))
	{
		$this->Cookie->write('pass',md5($this->settings['pass']),true, '1 year');
	}

	$is_admin = false;
	
	if(!empty($this->settings['pass']))
	{
		$is_admin = (md5($this->settings['pass']) === $this->Cookie->read('pass'));
	}
	else
	{
		$is_admin = true;	
	}
	if($is_admin)
		define('__ADMIN', "Really admin!");
	else
		define('__ADMIN', 0);
}


}