<h2><?php __('excel item loading') ?></h2>

<?= $result ?><hr style="margin:1em;" />
<?= $form->create(null, array('enctype'=>"multipart/form-data")) ?>
<? __('Your Excel table') ?>: <?= $form->file('xls'); ?>
<?= $form->submit(__('Import',1)) ?>
<?= $form->end() ?>