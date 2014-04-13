<?php

class EditPicture extends CI_Controller {

	function index(){
		
		// not logged in
		if(!$this->session->userdata('userid')) {	
			redirect("/login");
			exit;
		}
		
		$data = array(
			'upload_path' => 'application/avatars/',
			'allowed_types' => 'jpg|jpeg',
			'max_size' => '20000',
			'max_width' => '128',
			'max_height' => '128',
			'file_name' => $this->session->userdata('userid').'.jpg',
			'overwrite' => true
		);

		$this->load->library('upload', $data);

		if (!$this->upload->do_upload('avatar')){
			build_view($this, 'uploadpicture', array('error' => $this->upload->display_errors()));
		}
		else{
			redirect("/profiles/me");
		}
	}
}