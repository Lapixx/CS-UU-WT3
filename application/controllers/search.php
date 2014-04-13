<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require 'profileform.php';

class Search extends ProfileForm {

	public function index()
	{
        ProfileForm::index();

        $data = array('brands' => $this->brandmodel->getAllBrandNames());
        if ($this->form_validation->run()) {
//            $email = $this->input->post('email');
//            $password = $this->input->post('password');
//            $profile = $this->buildProfile();
//
//            if ($this->usermodel->tryRegister($email, $password) && $this->usermodel->tryUpdateProfile($email, $profile)) {
//                $this->load->view('registersuccess');
//                return;
//            }

			// build anon search profile
			// approximate personality = (1-preferences)
			$anon = array(
				'userid' => -1,
				'name' => 'not registered'
			);
			$profiles = array();
			//$profiles = $this->usermodel->getSortedMatches($anon);
			build_view($this, 'profile_list', array('profiles' => $profiles, 'title' => 'Search results'));
        }

        build_view($this, 'search', $data);
	}
}