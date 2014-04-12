<?php

echo '<div class="avatar">';
echo '<img src="'.avatar_url($profile['userid']).'" />';
if($profile['like']){ echo '<span>&#10084;</span>'; }
if($profile['liked']){ echo '<span class="like_me">&#10084;</span>'; }
echo '</div>';
echo '<b>'.$profile['nickname'].'</b><br/><br/>';

// connection
if($profile['like'] && $profile['liked']) {
	echo '<b>Name:</b> '.$profile['firstname'].' '.$profile['lastname'].'<br/>';
	echo '<b>E-mail:</b> <a href="mailto:'.$profile['email'].'">'.$profile['email'].'</a><br/><br/>';
}

echo '<b>Gender:</b> '.ucfirst($profile['gender']).'<br/>';
echo '<b>Date of Birth:</b> '.$profile['dob'].'<br/>';
echo '<b>Personality:</b> '.$profile['personality'].'<br/>';
echo '<b>Brands:</b> '.implode(', ', $profile['brands']).'<br/>';
echo '<b>Description:</b> '.$profile['description'].'<br/></br>';

echo '<b>Gender preference:</b> '.ucfirst($profile['gender_preference']).'<br/>';
echo '<b>Personality preference:</b> '.$profile['personality_preference'].'<br/>';
echo '<b>Age preference:</b> '.$profile['min_age'].'-'.$profile['max_age'].'<br/><br/>';
	
if(!$this->session->userdata('userid')) {	
	echo '<a href="'.base_url().'login" class="prominent">Get in touch with '.$profile['nickname'].' &rsaquo;</a>';
}
else{

	if (!$profile['like'] && $profile['userid'] !== $this->session->userdata('userid'))
		echo '<a href="'.base_url().'profiles/like/'.$profile['userid'].'" class="prominent">&#10084; &#9825; &#9829; Like</a><br/';
	echo 'You like this user!<br/>';
	
	if ($profile['liked'])
		echo 'This user likes you!';
}