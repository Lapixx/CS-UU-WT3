<?php 
if(!$this->session->userdata('userid'))
	$this->load->view('partials/promo');
?>

<?php
if (!empty($profiles)) {
	echo '<div class="center">';
	foreach ($profiles as $profile) {
?>

<div class="profileCard">
	<div class="center">
		<a href="<?=base_url()?>profiles/details/<?=$profile['userid']?>"><img src="<?=avatar_url($profile['userid'])?>" /></a>
		<br/>
		<a href="<?=base_url()?>profiles/details/<?=$profile['userid']?>"><b><?=$profile['nickname']?></b></a> (<?=dob_to_age($profile['dob'])?>, <?=strtoupper($profile['gender'][0])?>)</a>
	</div>
	
	<br/>
	
	<b>Personality:</b> <?=$profile['personality']?><br/>
	<b>Brands:</b> <?=implode(', ', array_slice($profile['brands'], 0, 5))?><br/>
	
	<br/>
	
	<?=$profile['description']?>
</div>

<?php
	}
	echo '</div>';
}		
?>

<a href="<?=base_url()?>" class="right">Show more &rsaquo;</a><br/>

<?php /*
	if (!empty($dbg)) {
		foreach ($dbg as $key => $data) {?>
<p><b><?= $key ?>:</b> <?= $data ?></p>
<?php }} else { ?>
<p>ID not found.</p>
<?php } */ ?>