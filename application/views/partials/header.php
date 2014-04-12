<!DOCTYPE html>

<html>

<head>

<title>Yeaahh!</title>

</head>

<body>

	<a href="<?=base_url()?>home"><h1>yeaahh</h1></a>
		
	<?php if($this->session->userdata('userid')) { ?>
	
		Logged in, whoop! <a href="<?=base_url()?>logout">Sign out</a>
	
	<?php } else { ?>
	
		<a href="<?=base_url()?>login">Sign in</a> or <a href="<?=base_url()?>register">Register</a>
	
	<?php } ?>
	
	<br/><hr/><br/>