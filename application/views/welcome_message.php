<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome</title>
</head>
<body>

	<h1>yeaahh</h1>
	
	<img src="<?=img_url()?>yeaahh.jpg" /><br/>
	
	<?php if($this->session->userdata('userid')) { ?>
	
		Logged in, whoop! <a href="<?=base_url()?>logout">Sign out</a>
	
	<?php } else { ?>
	
		<a href="<?=base_url()?>login">Sign in</a> or <a href="<?=base_url()?>register">Register</a>

	<?php } ?>
	
	
	<br/><br/><hr/><br/><br/>
	
	<?php
		if (!empty($profiles)) {
			foreach ($profiles as $profile) {
				echo '---<br/>';
				echo '<a href="'.base_url().'profiles/details/'.$profile['userid'].'">';
				echo $profile['nickname'].'</a><br/>';
				echo $profile['gender'][0].'<br/>';
				echo $profile['dob'].'<br/>';
				echo $profile['description'].'<br/>';
				echo $profile['personality'].'<br/>';
				echo implode(', ', array_slice(explode(',', $profile['brands']), 0, 3)).'<br/>';
				echo '---';
			}
		}		
	?>
	
	<a href="<?=base_url()?>">MEEEEER!!!!</a><br/>

	<?php /*
		if (!empty($dbg)) {
			foreach ($dbg as $key => $data) {?>
	<p><b><?= $key ?>:</b> <?= $data ?></p>
	<?php }} else { ?>
	<p>ID not found.</p>
	<?php } */ ?>
</body>
</html>