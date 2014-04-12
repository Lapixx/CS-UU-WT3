<h1><?=$title?></h1>

<?php 
$this->load->view('partials/profile_cards', array('profiles' => $profiles));
?>