<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require 'profileform.php';

class EditProfile extends ProfileForm {

	public function index()
	{
        ProfileForm::index();

        $this->form_validation->set_rules('description', 'About you', 'required');

        $profile = $this->usermodel->getProfileByID($this->session->userdata('userid'));
        $defaults = array();
        $defaults['gender'] = $profile['gender'];
        $defaults['dob'] = $profile['dob'];
        $defaults['gender_pref'] = $profile['gender_preference'];
        $defaults['min_age'] = $profile['min_age'];
        $defaults['max_age'] = $profile['max_age'];
        $defaults['brands'] = explode(',', $profile['brands']);
        $defaults['description'] = $profile['description'];

        $data = array('brands' => $this->brandmodel->getAllBrandNames(), 'title' => 'Edit profile', 'defaults' => $defaults);
        if ($this->form_validation->run()) {
            $profile = $this->buildProfile(true);

            if ($this->usermodel->tryUpdateProfile($this->session->userdata('email'), $profile)) {
            	redirect('profiles/me');
                return;
            }
        }

        build_view($this, 'editprofile', $data);
	}
}