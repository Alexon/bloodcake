<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo h($title_for_layout) ?></title>
	<link href="/favicon.ico" type="image/x-icon" rel="icon" />
	<link href="/favicon.ico" type="image/x-icon" rel="shortcut icon" />
	<link rel="stylesheet" type="text/css" href="/css/cake.generic.css" />
	<link rel="stylesheet" type="text/css" href="/css/newstyle.css" />
</head>
<body>
<div id="container">

<div id="header">
<a href="/"><?= $html->image('sviborg.png', array('onclick'=>'alert("'.__('Dont tach me!',1).'");return false;')); ?></a>
</div>

<div id="navigation">
	<div><a href="">Link</a></div>
	<div><a href="">Link</a></div>
	<? if(__ADMIN){?><div><?= $html->link(__('Admin area',1), '/admin/') ?></div><?}?>
</div>
<div id="content">

	<?php echo $content_for_layout ?>

</div>

<div id="footer">
</div>

</div>
</body>
</html>