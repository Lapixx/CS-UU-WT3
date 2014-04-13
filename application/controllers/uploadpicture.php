<?php

class UploadPicture extends CI_Controller {

	function index(){
		
		// not logged in
		if(!$this->session->userdata('userid')) {	
			redirect("/login");
			exit;
		}
		
		$data = array(
			'upload_path' => '../avatars/',
			'allowed_types' => 'jpg',
			'max_size' => '20',
			'max_width' => '128',
			'max_height' => '128',
			'file_name' => $this->session->userdata('userid').'.jpg',
			'overwrite' => true
		);

		$this->load->library('upload', $data);

		if (!$this->upload->do_upload()){
			build_view($this, 'uploadpicture', array('error' => $this->upload->display_errors()));
		}
		else{
			build_view($this, 'upload_success', array('upload_data' => $this->upload->data()));
		}
	}
}