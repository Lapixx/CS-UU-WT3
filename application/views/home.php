<?php
if (!empty($profiles)) {
	echo '<div class="center">';
	foreach ($profiles as $profile) {
?>

<div class="profileCard">
	<div class="center">
		<a href="<?=base_url()?>profiles/details/<?=$profile['userid']?>">
			<img src="<?=avatar_url($profile['userid'])?>" />
		</a>
	</div>
	
	<br/>
	
	<a href="<?=base_url()?>profiles/details/<?=$profile['userid']?>"><b><?=$profile['nickname']?></b></a> (<?=dob_to_age($profile['dob'])?>, <?=strtoupper($profile['gender'][0])?>)
	
	<br/>
	
	Personality: <?=$profile['personality']?><br/>
	Brands: <?=implode(', ', array_slice($profile['brands'], 0, 3))?><br/>
	<?=$profile['description']?>
</div>

<?php
	}
	echo '</div>';
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