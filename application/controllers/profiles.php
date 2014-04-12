<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profiles extends CI_Controller {
	
	public function details($id)
	{	
		$profile = $this->usermodel->getProfileByID($id);
		$this->load->view('profile_details', array('profile' => $profile));
	}
	
	public function avatar($id){

		$profile = $this->usermodel->getProfileByID($id);

		// profile not found - return 404
		if(!array_key_exists('userid', $profile)){
			show_404('avatar/'.$id);
		}
		
		$profile_avatar = 'application/avatars/'.$profile['userid'].'.jpg';

		// not logged in/no avatar set - return default avatar (m/f)
		if(!$this->session->userdata('userid') || !file_exists($profile_avatar)) {
			header('Content-Type: image/jpeg');
			readfile('assets/img/default_'.$profile['gender'][0].'.jpg');
			exit;
		}

		// logged in and avatar set - return avatar
		header('Content-Type: image/jpeg');
		readfile($profile_avatar);
		exit;
	}
}