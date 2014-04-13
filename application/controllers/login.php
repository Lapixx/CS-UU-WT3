<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index()
	{
		if($this->session->userdata('userid')) {
			redirect("/home");
		}
		
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');

        $data = array('failed' => false);
        if ($this->form_validation->run()) {
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            if ($this->usermodel->tryLogin($email, $password)) {
            	
            	if ($this->session->userdata('adminid'))
            		redirect("/configuration");
            	else
            		redirect("/home");
                return;
            }

            $data['failed'] = true;
        }
        
        $data['title'] = 'Sign in';

        build_view($this, 'login', $data);
	}
}