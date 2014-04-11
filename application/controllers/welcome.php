<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		$data = array('data' => array_merge($this->usermodel->getUserByID(3), $this->usermodel->getProfileByID(3)));
		$this->load->view('welcome_message', $data);
	}
}