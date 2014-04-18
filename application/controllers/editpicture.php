<?php

class EditPicture extends CI_Controller {

	function index(){

		// not logged in
		if(!$this->session->userdata('userid')) {
			redirect("/login");
			exit;
		}

		// load libs
		$this->load->library('upload');
		$this->load->library('image_lib');

		//upload image
		$img = $this->upload->data();
		$data = array(
			'upload_path' => 'application/avatars/',
			'allowed_types' => 'jpg|jpeg',
			'max_size' => '20000',
			'file_name' => $this->session->userdata('userid').'.jpg',
			'overwrite' => true
		);

		$this->upload->initialize($data);
		if (!$this->upload->do_upload('avatar')){
			build_view($this, 'uploadpicture', array('error' => $this->upload->display_errors()));
			return;
		}

		$portrait = intval($img["image_width"]) < intval($img["image_height"]);

		// scale picure down to approx fit in 128x128 square
		$data = array(
			"source_image" => $data['upload_path'].$data['file_name'],
			"maintain_ratio" => true,
			"width" => 128,
			"height" => 128,
			"master_dim" => $portrait ? "width" : "height"
		);
		$this->image_lib->initialize($data);
		if(!$this->image_lib->resize()){
			build_view($this, 'uploadpicture', array('error' => $this->image_lib->display_errors()));
			return;
		}

 		// crop picure in 128x128 square for exact fit
		$data = array(
			"source_image" => $data['upload_path'].$data['file_name'],
			"maintain_ratio" => false,
			"width" => 128,
			"height" => 128,
			"x_axis" => '0',
			"y_axis" => '0'
		);

		//$this->image_lib->clear()
		$this->image_lib->initialize($data);
		if (!$this->image_lib->crop()){
	    	build_view($this, 'uploadpicture', array('error' => $this->image_lib->display_errors()));
	    	return;
	    }

		redirect("/profiles/me");

	}
}