<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends ProfileForm {

	public function index()
	{
        ProfileForm::index();

        $data = array('brands' => $this->brandmodel->getBrandNames(), 'questions' => $this->questions);
        if ($this->form_validation->run()) {
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $profile = $this->buildProfile();

            if ($this->usermodel->tryRegister($email, $password) && $this->usermodel->tryUpdateProfile($email, $profile)) {
            	$this->load->view('partials/header');
                $this->load->view('registersuccess');
                $this->load->view('partials/footer');
                return;
            }
        }

		$this->load->view('partials/header');
        $this->load->view('register', $data);
        $this->load->view('partials/footer');
	}
}