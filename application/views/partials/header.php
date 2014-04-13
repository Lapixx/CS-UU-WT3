<!DOCTYPE html>

<html>

<head>

<title>DataDate<?php if(isset($title) && $title !== '') { echo ' | '.$title; } ?></title>
<link href="<?=css_url()?>defaults.css" rel="stylesheet" type="text/css" media="all">
<script src="<?=js_url()?>jquery.js" type="text/javascript"></script>

</head>

<body>

	<nav class="sitenav">
		<ul>
			<li><b><a href="<?=base_url()?>home">DataDate</a></b></li>
			
			<?php if ($this->session->userdata('adminid')) { ?>
			
				<li class="right"><a href="<?=base_url()?>logout">Sign out</a></li>
				<li class="right">&bull;</li>
				<li class="right"><a href="<?=base_url()?>configuration">Configuration</a></li>
				
			
			<?php } else if($this->session->userdata('userid')) { ?>
			
				<li><a href="<?=base_url()?>profiles/discover">Discover</a></li>
				<li>&bull;</li>
				<li><a href="<?=base_url()?>profiles/my_likes">My Likes</a></li>
				<li>&bull;</li>
				<li><a href="<?=base_url()?>profiles/like_me">Your Likers</a></li>
				<li>&bull;</li>
				<li><a href="<?=base_url()?>profiles/connections">Connections</a></li>
									
				<li class="right"><a href="<?=base_url()?>logout">Sign out</a></li>
				<li class="right">&bull;</li>
				<li class="right"><a href="<?=base_url()?>profiles/me">My Profile (<?=$currentProfile['firstname']?>)</a></li>
			
			<?php } else { ?>
			
				<li><a href="<?=base_url()?>search">Search</a></li>
							
				<li class="right"><a href="<?=base_url()?>login">Sign in</a></li>
				<li class="right">&bull;</li>
				<li class="right"><a href="<?=base_url()?>register">Register</a></li>
			
			<?php } ?>
			
		</ul>			
	</nav>
	
	<div id="wrap">
