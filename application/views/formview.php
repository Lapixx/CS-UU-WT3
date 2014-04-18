<?php
	if (!isset($defaults))
	{
		$defaults = array();
		$defaults['gender'] = 'male';
		$defaults['dob'] = '';
		$defaults['gender_pref'] = 'men';
		$defaults['min_age'] = '';
		$defaults['max_age'] = '';
		$defaults['brands'] = array();
	}

	$this->form_validation->set_error_delimiters('<div class="error">', '</div>');

	$male = $defaults['gender'] == 'male';
	echo form_fieldset('Gender', array('id' => 'gender'));
	echo form_label('Male', 'gender_male');
	echo form_radio(array('name' => 'gender', 'id' => 'gender_male', 'value' => 'male', 'checked' => (set_radio('gender', 'male', $male) == '' ? '' : 'checked')));
	echo form_label('Female', 'gender_female');
	echo form_radio(array('name' => 'gender', 'id' => 'gender_female', 'value' => 'female', 'checked' => (set_radio('gender', 'female', !$male) == '' ? '' : 'checked')));
	echo form_fieldset_close();
	echo form_error('gender');

	echo form_fieldset('Date of birth');
	echo form_label('Date of birth', 'dob');
	echo form_input(array('name' => 'dob', 'id' => 'dob', 'placeholder' => 'dd-mm-yyyy', 'value' => set_value('dob', $defaults['dob'])));
	echo form_error('dob');
	echo form_fieldset_close();

	$men = $defaults['gender_pref'] == 'men'; $women = $defaults['gender_pref'] == 'women';
	echo form_fieldset("I'm interested in");
	echo form_label('Men', 'gender_pref_men');
	echo form_radio(array('name' => 'gender_pref', 'id' => 'gender_pref_men', 'value' => 'men', 'checked' => (set_radio('gender_pref', 'men', $men) == '' ? '' : 'checked')));
	echo form_label('Women', 'gender_pref_women');
	echo form_radio(array('name' => 'gender_pref', 'id' => 'gender_pref_women', 'value' => 'women', 'checked' => (set_radio('gender_pref', 'women', $women) == '' ? '' : 'checked')));
	echo form_label('Both', 'gender_pref_both');
	echo form_radio(array('name' => 'gender_pref', 'id' => 'gender_pref_both', 'value' => 'both', 'checked' => (set_radio('gender_pref', 'both', !($men || $women)) == '' ? '' : 'checked')));
	echo form_error('gender_pref') . '<br />';

	echo form_label('Minimum preferred age', 'min_age');
	echo form_input(array('name' => 'min_age', 'id' => 'min_age', 'value' => set_value('min_age', $defaults['min_age'])));
	echo form_error('min_age') . '<br />';

	echo form_label('Maximum preferred age', 'max_age');
	echo form_input(array('name' => 'max_age', 'id' => 'max_age', 'value' => set_value('max_age', $defaults['max_age'])));
	echo form_error('max_age');
	echo form_fieldset_close();

	echo form_error('brands');
	echo form_fieldset('Brands you like');

	echo '<div class="brands_col">';
	$n = 0; $l = ceil(count($brands)/3);
	foreach ($brands as $id => $brand) {
		echo form_checkbox(array('name' => 'brands[]', 'value' => $id, 'checked' => set_checkbox('brands[]', $id, in_array($id, $defaults['brands']))));
		echo form_label($brand, 'brands[]');
		echo '<br/>';
		if(++$n % $l == 0) {
			echo '</div><div class="brands_col">';
		}
	}
	echo '</div>';

	echo form_fieldset_close();