<!DOCTYPE html>

<html>

<head>

<title>Yeaahh!</title>
<link href="<?=css_url()?>defaults.css" rel="stylesheet" type="text/css" media="all">

</head>

<body>

	<nav class="sitenav">
		<ul>
			<li><b><a href="<?=base_url()?>home">Yeaahh!</a></b></li>
			
			<?php if($this->session->userdata('userid')) { ?>
									
				<li class="right"><a href="<?=base_url()?>logout">Sign out (<?=$currentProfile['firstname']?>)</a></li>
				<li class="right">&bull;</li>
				<li class="right"><a href="<?=base_url()?>home">Profile settings</a></li>
			
			<?php } else { ?>
			
				<li class="right"><a href="<?=base_url()?>login">Sign in</a></li>
				<li class="right">&bull;</li>
				<li class="right"><a href="<?=base_url()?>register">Register</a></li>
			
			<?php } ?>
			
		</ul>			
	</nav>
	
	<div id="wrap">
