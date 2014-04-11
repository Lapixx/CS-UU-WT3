<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profiles extends CI_Controller {
	
	public function details($id)
	{	
		if(!$this->session->userdata('userid')) {
			redirect("/login");
		}
		
		echo 'details of '.$id;	
		$dbg = array_merge($this->usermodel->getUserByID(2), $this->usermodel->getProfileByID(2));
	}
}