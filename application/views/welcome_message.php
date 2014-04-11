<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome</title>
</head>
<body>

	<h1>yeaahh</h1>
	
	<img src="<?=img_url()?>yeaahh.jpg" /><br/>
	
	<a href="<?=base_url()?>login">Sign in</a> or <a href="<?=base_url()?>register">Register</a><br/><br/>
	
	<hr/>

	<?php
		if (!empty($data)) {
			foreach ($data as $key => $data) {?>
	<p><b><?= $key ?>:</b> <?= $data ?></p>
	<?php }} else { ?>
	<p>ID not found.</p>
	<?php } ?>
</body>
</html>