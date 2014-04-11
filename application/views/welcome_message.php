<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome</title>
</head>
<body>

	<h1>yeaahh</h1>
	
	<img src="<?=img_url()?>yeaahh.jpg" /><br/>
	
	<a href="<?=base_url()?>login">Sign in</a> or <a href="<?=base_url()?>register">Register</a>
	
	<br/><br/><hr/><br/><br/>
	
	<?php
		if (!empty($profiles)) {
			foreach ($profiles as $profile) {
				echo '---<br/>';
				echo $profile['nickname'].'<br/>';
				echo $profile['gender'][0].'<br/>';
				echo $profile['dob'].'<br/>';
				echo $profile['description'].'<br/>';
				echo $profile['personality'].'<br/>';
				echo implode(', ', array_slice(explode(',', $profile['brands']), 0, 3)).'<br/>';
				echo '---';
			}
		}		
	?>
	
	<a href="<?=base_url()?>">MEEEEER!!!!</a>

	<?php /*
		if (!empty($dbg)) {
			foreach ($dbg as $key => $data) {?>
	<p><b><?= $key ?>:</b> <?= $data ?></p>
	<?php }} else { ?>
	<p>ID not found.</p>
	<?php } */ ?>
</body>
</html>