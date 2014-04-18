<?php
	$this->form_validation->set_error_delimiters('<div class="error">', '</div>');

	echo form_open('editprofile');

	$table = $this->table->make_columns(array(
			form_label('First name', 'first_name'),
			form_input(array('name' => 'first_name', 'id' => 'first_name', 'value' => set_value('first_name'))),
			form_error('first_name'),

			form_label('Last name', 'last_name'),
			form_input(array('name' => 'last_name', 'id' => 'last_name', 'value' => set_value('last_name'))),
			form_error('last_name'),

			form_label('Nickname', 'nickname'),
			form_input(array('name' => 'nickname', 'id' => 'nickname', 'value' => set_value('nickname'))),
			form_error('nickname'),

			form_label('About you', 'description'),
			form_textarea(array('name' => 'description', 'id' => 'description', 'value' => set_value('description'), 'cols' => '50', 'rows' => '10', 'maxlength' => '500')),
			form_error('description')
		),
	3);

	echo form_fieldset('Personal info');
	echo $this->table->generate($table);
	echo form_fieldset_close();

	$this->load->view('formview', array(
		'brands' => $brands,
		'defaults' => $defaults
	));

	echo form_submit('update', 'Update');
	echo form_close();