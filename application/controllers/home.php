<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{	
		$profiles = $this->usermodel->getRandomProfiles(6);

		build_view($this, 'home', array(
			'profiles' => $profiles
		));
	}
	
	public function random()
	{
		$profiles = $this->usermodel->getRandomProfiles(6);
		build_json($this, $profiles);
	}
}