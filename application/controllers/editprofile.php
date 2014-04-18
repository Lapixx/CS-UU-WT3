<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require 'profileform.php';

class EditProfile extends ProfileForm {

	public function index()
	{
        if(!$this->session->userdata('userid')) {
            redirect("/home");
        }

        ProfileForm::index();

        $profile = $this->usermodel->getProfileByID($this->session->userdata('userid'));
        $defaults = array();
        $defaults['gender'] = $profile['gender'];
        $defaults['dob'] = $profile['dob'];
        $defaults['gender_pref'] = $profile['gender_preference'];
        $defaults['min_age'] = $profile['min_age'];
        $defaults['max_age'] = $profile['max_age'];
        $defaults['brands'] = explode(',', $profile['brands']);
        $defaults['description'] = $profile['description'];
        $defaults['nickname'] = $profile['nickname'];
        $defaults['first_name'] = $profile['firstname'];
        $defaults['last_name'] = $profile['lastname'];

        $this->form_validation->set_rules('first_name', 'First name', 'required|alpha');
        $this->form_validation->set_rules('last_name', 'Last name', 'required|alpha');
        if ($this->input->post('nickname') != $profile['nickname']) {
            $this->form_validation->set_rules('nickname', 'Nickname', 'required|is_unique[profiles.nickname]|alpha_dash');
        }
        else {
            $this->form_validation->set_rules('nickname', 'Nickname', 'required|alpha_dash');
        }
        $this->form_validation->set_rules('description', 'About you', 'required');

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