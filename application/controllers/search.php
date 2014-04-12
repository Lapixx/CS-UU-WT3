<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require 'profileform.php';

class Search extends ProfileForm {

	public function index()
	{
        ProfileForm::index();

        $data = array('brands' => $this->brandmodel->getBrandNames());
        if ($this->form_validation->run()) {
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $profile = $this->buildProfile();

            if ($this->usermodel->tryRegister($email, $password) && $this->usermodel->tryUpdateProfile($email, $profile)) {
                $this->load->view('registersuccess');
                return;
            }
        }

        $this->load->view('partials/header');
        $this->load->view('search', $data);
        $this->load->view('partials/footer');
	}
}