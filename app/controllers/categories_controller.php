<?php

class CategoriesController extends AppController {



var $name = 'Categories';

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
    $this->data = $this->Category->find('all', array('fields' => array('name', 'lft', 'rght'), 'order' => 'lft ASC'));
	
	
} 



function add() {



if (!empty($this->data)) {

$this->Category->create();

if ($this->Category->save($this->data)) {

$this->Session->setFlash(__('The Category has been saved', true));

//$this->redirect(array('action'=>'index'));

} else {

$this->Session->setFlash(__('The Category could not be saved. Please, try again.', true));

}

}



$this->render(false);



}



function edit($id = null) {



if (!$id && empty($this->data)) {

$this->Session->setFlash(__('Invalid Category', true));

$this->redirect(array('action'=>'index'));

}



if (!empty($this->data)) {

if ($this->Category->save($this->data)) {

$this->Session->setFlash(__('The Category has been saved', true));

//$this->redirect(array('action'=>'index'));

} else {

$this->Session->setFlash(__('The Category could not be saved. Please, try again.', true));

}

}



if (empty($this->data)) {

$this->data = $this->Category->read(null, $id);

}



$this->render(false);



}



function delete($id = null) {



if (!$id) {

$this->Session->setFlash(__('Invalid id for Category', true));

$this->redirect(array('action'=>'index'));

}



if ($this->Category->del($id)) {

$this->Session->setFlash(__('Category deleted', true));

$this->redirect(array('action'=>'index'));

}



}


}





