<?php
if (!empty($profiles)) {
	echo '<div class="center">';
	foreach ($profiles as $i => $profile) {
?>

<div id="card_<?=$i?>" class="cardWrap">
	<div class="profileCard">
		<div class="center">
			<a href="<?=base_url()?>profiles/details/<?=$profile['userid']?>">
				<div class="avatar">
					<img src="<?=avatar_url($profile['userid'])?>/s" />
					<?php if($profile['like']){ ?><span>&#10084;</span><?php } ?>
					<?php if($profile['liked']){ ?><span class="like_me">&#10084;</span><?php } ?>
				</div>
			</a>
			<br/>
			<a href="<?=base_url()?>profiles/details/<?=$profile['userid']?>"><b><?=$profile['nickname']?></b></a> (<?=dob_to_age($profile['dob'])?>, <?=strtoupper($profile['gender'][0])?>)
		</div>
		
		<br/>
		
		<b>Personality:</b> <?=format_mbti($profile['personality'], true)?><br/>
		<b>Brands:</b> <?=implode(', ', array_slice($profile['brand_names'], 0, 5))?><br/>
		
		<br/>
		
		<?=$profile['description']?>
	</div>
</div>

<?php
	}
	echo '</div>';
} else{
?>

Nobody yet :(

<?php
}		
?>