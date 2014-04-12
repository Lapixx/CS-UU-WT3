<?php
	echo form_open('register');

	echo form_label('Email', 'email');
	echo form_input(array('name' => 'email', 'id' => 'email', 'value' => set_value('email')));
	echo form_error('email') . '<br />';

	echo form_label('Password', 'password');
	echo form_password(array('name' => 'password', 'id' => 'password', 'value' => set_value('password')));
	echo form_error('password') . '<br />';

	echo form_label('Confirm password', 'pass_conf');
	echo form_password(array('name' => 'pass_conf', 'id' => 'pass_conf', 'value' => set_value('pass_conf')));
	echo form_error('pass_conf') . '<br />';

	echo form_label('First name', 'first_name');
	echo form_input(array('name' => 'first_name', 'id' => 'first_name', 'value' => set_value('first_name')));
	echo form_error('first_name') . '<br />';

	echo form_label('Last name', 'last_name');
	echo form_input(array('name' => 'last_name', 'id' => 'last_name', 'value' => set_value('last_name')));
	echo form_error('last_name') . '<br />';

	echo form_label('Nickname', 'nickname');
	echo form_input(array('name' => 'nickname', 'id' => 'nickname', 'value' => set_value('nickname')));
	echo form_error('nickname') . '<br />';

	echo form_label('About you', 'description');
	echo form_textarea(array('name' => 'description', 'id' => 'description', 'value' => set_value('description'), 'cols' => '50', 'rows' => '10', 'maxlength' => '500'));
	echo form_error('description') . '<br />';

	$this->load->view('formview');

	echo form_fieldset('Please answer the following questions');
	// herping a derp because CI fails with 
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
	echo form_error('questions') . '<br />';

	echo form_submit('register', 'Register');
	echo form_close();