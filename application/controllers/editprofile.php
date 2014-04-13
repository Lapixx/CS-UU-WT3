<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require 'profileform.php';

class Register extends ProfileForm {

	public function index()
	{
        ProfileForm::index();

        $this->form_validation->set_rules('description', 'About you', 'required');

        $data = array('brands' => $this->brandmodel->getAllBrandNames(), 'title' => 'Edit profile');
        if ($this->form_validation->run()) {
            $profile = $this->buildProfile();

            if ($this->usermodel->tryUpdateProfile($this->session->userdata('email'), $profile)) {
            	$this->load->view('partials/header');
                $this->load->view('profiles/me');
                $this->load->view('partials/footer');
                return;
            }
        }

        $this->load->view('partials/header');
        $this->load->view('editprofile', $data);
        $this->load->view('partials/footer');
	}
}