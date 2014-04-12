<?php
	echo form_fieldset('Gender', array('id' => 'gender')); 
	echo form_label('Male', 'gender_male'); 
	echo form_radio(array('name' => 'gender', 'id' => 'gender_male', 'value' => 'male', 'checked' => (set_radio('gender', 'male', true) == '' ? '' : 'checked'))); 
	echo form_label('Female', 'gender_female'); 
	echo form_radio(array('name' => 'gender', 'id' => 'gender_female', 'value' => 'female', 'checked' => (set_radio('gender', 'female') == '' ? '' : 'checked'))); 
	echo form_fieldset_close(); 
	echo form_error('gender') . '<br />';

	echo form_label('Date of birth', 'dob'); 
	echo form_input(array('name' => 'dob', 'id' => 'dob', 'placeholder' => 'dd-mm-yyyy', 'value' => set_value('dob'))); 
	echo form_error('dob') . '<br />';

	echo form_fieldset('Gender preference'); 
	echo form_label('Men', 'gender_pref_men'); 
	echo form_radio(array('name' => 'gender_pref', 'id' => 'gender_pref_men', 'value' => 'men', 'checked' => (set_radio('gender_pref', 'men', true) == '' ? '' : 'checked'))); 
	echo form_label('Women', 'gender_pref_women'); 
	echo form_radio(array('name' => 'gender_pref', 'id' => 'gender_pref_women', 'value' => 'women', 'checked' => (set_radio('gender_pref', 'women') == '' ? '' : 'checked'))); 
	echo form_label('Both', 'gender_pref_both'); 
	echo form_radio(array('name' => 'gender_pref', 'id' => 'gender_pref_both', 'value' => 'both', 'checked' => (set_radio('gender_pref', 'both') == '' ? '' : 'checked'))) . '<br />';
	echo form_fieldset_close(); 
	echo form_error('gender_pref') . '<br />';

	echo form_label('Minimum preferred age', 'min_age'); 
	echo form_input(array('name' => 'min_age', 'id' => 'min_age', 'value' => set_value('min_age'))); 
	echo form_error('min_age') . '<br />';

	echo form_label('Maximum preferred age', 'max_age'); 
	echo form_input(array('name' => 'max_age', 'id' => 'max_age', 'value' => set_value('max_age'))); 
	echo form_error('max_age') . '<br />';

	echo form_fieldset('Brands you like'); 

	foreach ($brands as $id => $brand) {
		echo form_checkbox(array('name' => 'brands[]', 'value' => $id, 'checked' => set_checkbox('brands[]', $id))) . $brand;
	}

	echo form_fieldset_close(); 
	echo form_error('brands') . '<br />';