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
				echo '<div>';
				echo '<a href="'.base_url().'profiles/details/'.$profile['userid'].'">';
				echo '<img src="<?=img_url()?>yeaahh.jpg" />';
				echo '</a><br/>';
				echo '<a href="'.base_url().'profiles/details/'.$profile['userid'].'">';
				echo '<b>'.$profile['nickname'].'</b>';
				echo '</a> ('.dob_to_age($profile['dob']).', '.strtoupper($profile['gender'][0]).')<br/>';
				echo 'Personality: '.$profile['personality'].'<br/>';
				echo 'Brands: '.implode(', ', array_slice(explode(',', $profile['brands']), 0, 3)).'<br/>';
				echo $profile['description'].'<br/>';
				echo '</div>';
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