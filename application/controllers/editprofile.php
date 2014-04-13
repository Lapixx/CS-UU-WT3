<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require 'profileform.php';

class EditProfile extends ProfileForm {

	public function index()
	{
        ProfileForm::index();

        $this->form_validation->set_rules('description', 'About you', 'required');

        $profile = $this->usermodel->getProfileByID($this->session->userdata('userid'));
        $profile['brands'] = explode(',', $profile['brands']);
        foreach ($profile as $key => $value) {
            $_POST[$key] = $value;
        }

        $data = array('brands' => $this->brandmodel->getAllBrandNames(), 'title' => 'Edit profile');
        if ($this->form_validation->run()) {
            $profile = $this->buildProfile();

            if ($this->usermodel->tryUpdateProfile($this->session->userdata('email'), $profile)) {
                build_view($this, 'profiles/me');
                return;
            }
        }

        build_view($this, 'editprofile', $data);
	}
}