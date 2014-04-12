<?php

echo '<img src="'.avatar_url($profile['userid']).'" /><br/>';
echo '<b>'.$profile['nickname'].'</b><br/><br/>';

echo '<b>Gender:</b> '.$profile['gender'].'<br/>';
echo '<b>Date of Birth:</b> '.$profile['dob'].'<br/>';
echo '<b>Personality:</b> '.$profile['personality'].'<br/>';
echo '<b>Brands:</b> '.implode(', ', $profile['brands']).'<br/>';
echo '<b>Description:</b> '.$profile['description'].'<br/></br>';

echo '<b>Gender preference:</b> '.$profile['gender_preference'].'<br/>';
echo '<b>Personality preference:</b> '.$profile['personality_preference'].'<br/>';
echo '<b>Age preference:</b> '.$profile['min_age'].'-'.$profile['max_age'].'<br/><br/>';
	
if(!$this->session->userdata('userid')) {	
	echo '<a href="'.base_url().'login" class="prominent">Get in touch with '.$profile['nickname'].' &rsaquo;</a>';
}
else{
	echo '<a href="'.base_url().'profiles/like/'.$profile['userid'].'" class="prominent">&#10084; Like</a>';
}