<h1>Home</h1>

<?php 
if(!$this->session->userdata('userid'))
	$this->load->view('partials/promo');

$pages = 1;
$page = "home/random";
include("partials/paging.js.php");

$this->load->view('partials/profile_cards', array('profiles' => $profiles));
?>

<a href="#" onclick="refreshPage(); return false;" class="right">Show more &rsaquo;</a>