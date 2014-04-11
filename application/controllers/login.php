<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index()
	{
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');

        $data = array('failed' => false);
        if ($this->form_validation->run()) {
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            if ($this->usermodel->tryLogin($email, $password)) {
                //$this->load->view('loginsuccess');
                redirect("/welcome");
                return;
            }

            $data['failed'] = true;
        }

        $this->load->view('login', $data);
	}
}