<?php
	echo form_open('editprofile');

	echo form_label('About you', 'description');
	echo form_textarea(array('name' => 'description', 'id' => 'description', 'value' => set_value('description', $defaults['description']), 'cols' => '50', 'rows' => '10', 'maxlength' => '500'));
	echo form_error('description') . '<br />';

	$this->load->view('formview', array(
		'brands' => $brands,
		'defaults' => $defaults		
	));

	echo form_submit('update', 'Update');
	echo form_close();