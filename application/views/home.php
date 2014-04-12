<h1>Home</h1>

<?php 
if(!$this->session->userdata('userid'))
	$this->load->view('partials/promo');
?>

<?php
$this->load->view('partials/profile_cards', array('profiles' => $profiles));
?>

<a href="<?=base_url()?>" class="right">Show more &rsaquo;</a><br/>