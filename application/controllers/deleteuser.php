<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DeleteUser extends CI_Controller {

	public function index()
	{
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_message('required', 'This field is required.');

        if ($this->form_validation->run()) {
            if ($this->usermodel->deleteUser($this->input->post('password'))) {
                build_view($this, 'deleted', array('title' => 'Account deleted'))
            }
        }

        build_view($this, 'deleteconfirm', array('failed' => true, 'title' => 'Delete account'));
	}
}