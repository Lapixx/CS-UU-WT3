<?php
	$this->form_validation->set_error_delimiters('<div class="error">', '</div>');

	echo form_open('register');

	$table = $this->table->make_columns(array(
			form_label('Email', 'email'),
			form_input(array('name' => 'email', 'id' => 'email', 'value' => set_value('email'))),
			form_error('email'),

			form_label('Password', 'password'),
			form_password(array('name' => 'password', 'id' => 'password', 'value' => set_value('password'))),
			form_error('password'),

			form_label('Confirm password', 'pass_conf'),
			form_password(array('name' => 'pass_conf', 'id' => 'pass_conf', 'value' => set_value('pass_conf'))),
			form_error('pass_conf'),

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

	$this->load->view('formview');

	echo form_error('questions');
	echo form_fieldset('Please answer the following questions');
	// herping a derp because CI fails with radio buttons
	foreach ($questions as $i => $q) {
		$quest = $this->input->post('questions');
		$check = false;
		if (!empty($quest) && array_key_exists($i, $quest)) {
			$check = $quest[$i];
		}

		echo 'Question ' . ($i + 1) . '<br />';
		echo form_radio(array('name' => "questions[$i]", 'id' => "question{$i}a", 'value' => 'a', 'checked' => isset($check) && $check === 'a' ? 'checked' : ''));
		echo form_label($q[0], "question{$i}a") . '<br />';
		echo form_radio(array('name' => "questions[$i]", 'id' => "question{$i}b", 'value' => 'b', 'checked' => isset($check) && $check === 'b' ? 'checked' : ''));
		echo form_label($q[1], "question{$i}b") . '<br />';
		echo form_radio(array('name' => "questions[$i]", 'id' => "question{$i}c", 'value' => 'c', 'checked' => isset($check) && $check === 'c' ? 'checked' : ''));
		echo form_label($q[2], "question{$i}c") . '<br />';
		echo '<br />';
	}
	echo form_fieldset_close();

	echo form_submit('register', 'Register');
	echo form_close();