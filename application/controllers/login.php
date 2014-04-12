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
                redirect("/home");
                return;
            }

            $data['failed'] = true;
        }

		$this->load->view('partials/header');
        $this->load->view('login', $data);
        $this->load->view('partials/footer');
	}
}