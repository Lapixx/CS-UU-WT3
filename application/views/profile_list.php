<h1><?=$title?></h1>

<?php 
include("partials/paging.js.php");

$this->load->view('partials/profile_cards', array('profiles' => $profiles));
?>

<a href="#" id="nav_back" onclick="back(); return false;" class="hidden">&lsaquo; Previous page</a>
<a href="#" id="nav_next" onclick="next(); return false;" class="right<?php if($pages <= 1) { echo ' hidden'; } ?>">Next page &rsaquo;</a>