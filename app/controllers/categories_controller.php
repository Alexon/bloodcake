<?php

require_once "_commoncontroller.php";

class CategoriesController extends CommonController
{

	var $name = 'Categories';
	var $components = array('RequestHandler','Security', 'Cookie');
	var $helpers = array('Html', 'Form', 'Tree', 'Javascript');
	
	function beforeFilter() {
		
		parent::beforeFilter();
		
		// ensure our ajax methods are posted
		$this->Security->requirePost('getnodes', 'reorder', 'reparent');
		
	}

	function index()
	{
		$this->data = $this->Category->find('all', array('fields' => array('name', 'lft', 'rght', 'id'), 'order' => 'lft ASC'));
		
		//$this->jsTree->initialize($this);
		
	}
	
	function create($parent_id = null)
	{	
		if(!__ADMIN)
			$this->redirect('/categories/');
			
		if(!empty($this->params['data']))
		{
			$this->Category->create();
			$this->Category->save($this->params['data']);
			$this->redirect('/categories/view/'.$this->Category->id);
		}
		
		$parent = $this->Category->findById($parent_id);
		if(empty($parent))$parent_id = null;
		
		$this->set(compact('parent_id'));
		
		$this->data = $this->Category->find('list', array('fields' => array('id', 'name')));
	}
	
	function delete($id)
	{
		if(!__ADMIN)
			$this->redirect('/categories/');

		$this->Category->delete($id);
		$this->Flash(__('Deleted!', 1), '/categories/');
	}
	
	function edit($id = null)
	{
		if(!__ADMIN)
			$this->redirect('/categories/view/'.$id);
			
		if(!empty($this->params['data']))
		{
			$this->Category->save($this->params['data']);
			$this->redirect('/categories/view/'.$this->Category->id);
		}
			
		$this->data = $this->Category->_findByIdSlag($id);
		
		
		$this->data['categories'] = $this->Category->find('list', array('fields' => array('id', 'name')));
	}
	
	

	

	function view($id = null)
	{
		$data = $this->Category->_findByIdSlag($id);
		
		$this->paginate = array(
			'limit' => 10,
			'conditions' => array('Item.cat_id='.$data['Category']['id']),
			'fields' => array('Item.title', 'Item.price', 'Category.name', 'Item.special', 'Item.id', 'Category.id'),
		);
		$items = $this->paginate('Item');
		$this->set(compact('items'));
		
		$data['ParentCategory'] = $this->Category->findById($data['Category']['parent_id']);
		$data['ParentCategory'] = $data['ParentCategory']['Category'];
		
		$this->set(compact('data'));
	}
	





	function getnodes() {
		
		// retrieve the node id that Ext JS posts via ajax
		$parent = intval($this->params['form']['node']);
		
		// find all the nodes underneath the parent node defined above
		// the second parameter (true) means we only want direct children
		$nodes = $this->Category->children($parent, true);
		
		// send the nodes to our view
		$this->set(compact('nodes'));
		
	}
	
	function reorder() {
		
		// retrieve the node instructions from javascript
		// delta is the difference in position (1 = next node, -1 = previous node)
		
		$node = intval($this->params['form']['node']);
		$delta = intval($this->params['form']['delta']);
		
		if ($delta > 0) {
			$this->Category->movedown($node, abs($delta));
		} elseif ($delta < 0) {
			$this->Category->moveup($node, abs($delta));
		}
		
		// send success response
		exit('1');
		
	}
	
	function reparent(){
		
		$node = intval($this->params['form']['node']);
		$parent = intval($this->params['form']['parent']);
		$position = intval($this->params['form']['position']);
		
		// save the employee node with the new parent id
		// this will move the employee node to the bottom of the parent list
		
		$this->Category->id = $node;
		$this->Category->saveField('parent_id', $parent);
		
		// If position == 0, then we move it straight to the top
		// otherwise we calculate the distance to move ($delta).
		// We have to check if $delta > 0 before moving due to a bug
		// in the tree behaviour (https://trac.cakephp.org/ticket/4037)
		
		if ($position == 0) {
			$this->Category->moveup($node, true);
		} else {
			$count = $this->Category->childcount($parent, true);
			$delta = $count-$position-1;
			if ($delta > 0) {
				$this->Category->moveup($node, $delta);
			}
		}
		
		// send success response
		exit('1');
		
	} 


}


