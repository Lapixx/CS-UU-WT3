	<?php
		if (!empty($profiles)) {
			foreach ($profiles as $profile) {
				echo '<div>';
				echo '<a href="'.base_url().'profiles/details/'.$profile['userid'].'">';
				echo '<img src="'.avatar_url($profile['userid']).'" />';
				echo '</a><br/>';
				echo '<a href="'.base_url().'profiles/details/'.$profile['userid'].'">';
				echo '<b>'.$profile['nickname'].'</b>';
				echo '</a> ('.dob_to_age($profile['dob']).', '.strtoupper($profile['gender'][0]).')<br/>';
				echo 'Personality: '.$profile['personality'].'<br/>';
				echo 'Brands: '.implode(', ', array_slice(explode(',', $profile['brands']), 0, 3)).'<br/>';
				echo $profile['description'].'<br/>';
				echo '</div>';
			}
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