<h2><?php __('Category tree') ?></h2><?php echo $tree->generate($this->data, array('type' => 'ol'));  ?> <? if(__ADMIN){ echo '<br />'.$html->link(__('create category',1), '/categories/create/'); } ?>