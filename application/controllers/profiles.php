<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profiles extends CI_Controller {
	
	public function details($id)
	{	
		$profile = $this->usermodel->getProfileByID($id);
		$this->load->view('profile_details', array('profile' => $profile));
	}
}