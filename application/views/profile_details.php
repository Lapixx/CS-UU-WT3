<?php
//print_r($profile);exit;
echo '<b>'.$profile['nickname'].':</b><br/>';
echo $profile['gender'].'<br/>';
echo $profile['dob'].'<br/>';
echo $profile['description'].'<br/>';
echo $profile['personality'].'<br/>';
echo implode(', ', array_slice(explode(',', $profile['brands']), 0, 3)).'<br/><br/>';

echo '<b>Preferences:</b><br/>';
echo $profile['gender_preference'].'<br/>';
echo $profile['personality_preference'].'<br/>';
echo $profile['min_age'].'-'.$profile['max_age'].'<br/><br/>';
	
echo '<a href="'.base_url().'login">Get in touch with '.$profile['nickname'].'</a>';
if(!$this->session->userdata('userid')) {
//	redirect("/login");
}