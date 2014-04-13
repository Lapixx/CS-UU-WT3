<?php
	echo form_open('editprofile');

	echo form_label('First name', 'first_name');
	echo form_input(array('name' => 'first_name', 'id' => 'first_name', 'value' => set_value('first_name', $defaults['first_name'])));
	echo form_error('first_name') . '<br />';

	echo form_label('Last name', 'last_name');
	echo form_input(array('name' => 'last_name', 'id' => 'last_name', 'value' => set_value('last_name', $defaults['last_name'])));
	echo form_error('last_name') . '<br />';

	echo form_label('Nickname', 'nickname');
	echo form_input(array('name' => 'nickname', 'id' => 'nickname', 'value' => set_value('nickname', $defaults['nickname'])));
	echo form_error('nickname') . '<br />';

	echo form_label('About you', 'description');
	echo form_textarea(array('name' => 'description', 'id' => 'description', 'value' => set_value('description', $defaults['description']), 'cols' => '50', 'rows' => '10', 'maxlength' => '500'));
	echo form_error('description') . '<br />';

	$this->load->view('formview', array(
		'brands' => $brands,
		'defaults' => $defaults		
	));

	echo form_submit('update', 'Update');
	echo form_close();