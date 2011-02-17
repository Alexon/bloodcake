<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<title><?php echo h($title_for_layout) ?></title>
	
<?php echo $html->css('/js/ext-2.0.1/resources/css/ext-custom.css'); ?>
<?php echo $javascript->link('/js/ext-2.0.1/ext-custom.js'); ?>

</head>
<body>

<div style="margin:40px;">

	<?php echo $content_for_layout ?>

</div>

</body>
</html>