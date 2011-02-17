<h2><?php __('Admin area') ?></h2>

<?= $form->create() ?>
<? __('Protect admin area by password') ?>:<br /><?= $form->password('pass') ?><br /><br />
<? __('Choose site language') ?>:<br/><?= $form->select('lang', $locales, $current_lang) ?>
<?= $form->submit(__('Save',1)) ?>
<?= $form->end() ?>


<h2><?php __('See also')?></h2> 
	<ul><li><?= $html->link(__('editable category tree',1), '/admin/categories/') ?></li>
	<li><?= $html->link(__('excel item loading',1), '/admin/items/') ?></li>
	</ul>
