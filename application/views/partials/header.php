<!DOCTYPE html>

<html>

<head>

<title>DataDate<?php if(isset($title) && $title !== '') { echo ' | '.$title; } ?></title>
<link href="<?=css_url()?>defaults.css" rel="stylesheet" type="text/css" media="all">

</head>

<body>

	<nav class="sitenav">
		<ul>
			<li><b><a href="<?=base_url()?>home">DataDate</a></b></li>
			
			<?php if($this->session->userdata('userid')) { ?>
			
				<li><a href="<?=base_url()?>profiles/my_likes">My Likes</a></li>
				<li>&bull;</li>
				<li><a href="<?=base_url()?>profiles/like_me">Your Likers</a></li>
				<li>&bull;</li>
				<li><a href="<?=base_url()?>profiles/connections">Connections</a></li>
									
				<li class="right"><a href="<?=base_url()?>logout">Sign out (<?=$currentProfile['firstname']?>)</a></li>
				<li class="right">&bull;</li>
				<li class="right"><a href="<?=base_url()?>home">My Profile</a></li>
			
			<?php } else { ?>
			
				<li><a href="<?=base_url()?>home">Search</a></li>
							
				<li class="right"><a href="<?=base_url()?>login">Sign in</a></li>
				<li class="right">&bull;</li>
				<li class="right"><a href="<?=base_url()?>register">Register</a></li>
			
			<?php } ?>
			
		</ul>			
	</nav>
	
	<div id="wrap">
