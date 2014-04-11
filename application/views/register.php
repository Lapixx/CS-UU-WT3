<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Register</title>
</head>
<body>

<?php echo form_open('register'); ?>

<?php echo form_label('Email', 'email'); ?>
<?php echo form_input(array('name' => 'email', 'id' => 'email', 'value' => set_value('email'))); ?>
<?php echo form_error('email'); ?><br />

<?php echo form_label('Password', 'password'); ?>
<?php echo form_password(array('name' => 'password', 'id' => 'password', 'value' => set_value('password'))); ?>
<?php echo form_error('password'); ?><br />

<?php echo form_label('Confirm password', 'pass_conf'); ?>
<?php echo form_password(array('name' => 'pass_conf', 'id' => 'pass_conf', 'value' => set_value('pass_conf'))); ?>
<?php echo form_error('pass_conf'); ?><br />

<?php echo form_label('First name', 'first_name'); ?>
<?php echo form_input(array('name' => 'first_name', 'id' => 'first_name', 'value' => set_value('first_name'))); ?>
<?php echo form_error('first_name'); ?><br />

<?php echo form_label('Last name', 'last_name'); ?>
<?php echo form_input(array('name' => 'last_name', 'id' => 'last_name', 'value' => set_value('last_name'))); ?>
<?php echo form_error('last_name'); ?><br />

<?php echo form_label('Nickname', 'nickname'); ?>
<?php echo form_input(array('name' => 'nickname', 'id' => 'nickname', 'value' => set_value('nickname'))); ?>
<?php echo form_error('nickname'); ?><br />

<?php echo form_fieldset('Gender', array('id' => 'gender')); ?>
<?php echo form_label('Male', 'gender_male'); ?>
<?php echo form_radio(array('name' => 'gender', 'id' => 'gender_male', 'value' => 'male', 'checked' => (set_radio('gender', 'male', true) == '' ? '' : 'checked'))); ?>
<?php echo form_label('Female', 'gender_female'); ?>
<?php echo form_radio(array('name' => 'gender', 'id' => 'gender_female', 'value' => 'female', 'checked' => (set_radio('gender', 'female') == '' ? '' : 'checked'))); ?>
<?php echo form_fieldset_close(); ?>
<?php echo form_error('gender'); ?><br />

<?php echo form_label('Date of birth', 'dob'); ?>
<?php echo form_input(array('name' => 'dob', 'id' => 'dob', 'value' => set_value('dob', 'dd-mm-yyyy'))); ?>
<?php echo form_error('dob'); ?><br />

<?php echo form_label('About you', 'description'); ?>
<?php echo form_textarea(array('name' => 'description', 'id' => 'description', 'value' => set_value('description'), 'cols' => '50', 'rows' => '10', 'maxlength' => '500')); ?>
<?php echo form_error('description'); ?><br />

<?php echo form_fieldset('Gender preference'); ?>
<?php echo form_label('Men', 'gender_pref_men'); ?>
<?php echo form_radio(array('name' => 'gender_pref', 'id' => 'gender_pref_men', 'value' => 'men', 'checked' => (set_radio('gender_pref', 'men', true) == '' ? '' : 'checked'))); ?>
<?php echo form_label('Women', 'gender_pref_women'); ?>
<?php echo form_radio(array('name' => 'gender_pref', 'id' => 'gender_pref_women', 'value' => 'women', 'checked' => (set_radio('gender_pref', 'women') == '' ? '' : 'checked'))); ?>
<?php echo form_label('Both', 'gender_pref_both'); ?>
<?php echo form_radio(array('name' => 'gender_pref', 'id' => 'gender_pref_both', 'value' => 'both', 'checked' => (set_radio('gender_pref', 'both') == '' ? '' : 'checked'))); ?><br />
<?php echo form_fieldset_close(); ?>
<?php echo form_error('gender_pref'); ?><br />

<?php echo form_label('Minimum preferred age', 'min_age'); ?>
<?php echo form_input(array('name' => 'min_age', 'id' => 'min_age', 'value' => set_value('min_age'))); ?>
<?php echo form_error('min_age'); ?><br />

<?php echo form_label('Maximum preferred age', 'max_age'); ?>
<?php echo form_input(array('name' => 'max_age', 'id' => 'max_age', 'value' => set_value('max_age'))); ?>
<?php echo form_error('max_age'); ?><br />

<?php echo form_fieldset('Brands you like'); ?>
<?php
	foreach ($brands as $id => $brand) {
		echo form_checkbox(array('name' => 'brands[]', 'value' => $id, 'checked' => set_checkbox('brands[]', $id))) . $brand;
	}
?>
<?php echo form_fieldset_close(); ?>
<?php echo form_error('brands[]'); ?><br />

<?php echo form_fieldset('Please answer the following questions'); ?>
<?php
	foreach ($questions as $i => $q) {
		echo 'Question ' . ($i + 1) . '<br />';
		echo form_radio(array('name' => "question[$q[0]]", 'id' => "question{$i}a", 'value' => 'a', 'checked' => (set_radio("question[$q[0]]", 'a', true))));
		echo form_label($q[1], "question{$i}a") . '<br />';
		echo form_radio(array('name' => "question[$q[0]]", 'id' => "question{$i}b", 'value' => 'b', 'checked' => (set_radio("question[$q[0]]", 'b'))));
		echo form_label($q[2], "question{$i}b") . '<br />';
		echo form_radio(array('name' => "question[$q[0]]", 'id' => "question{$i}c", 'value' => 'c', 'checked' => (set_radio("question[$q[0]]", 'c'))));
		echo form_label($q[3], "question{$i}c") . '<br />';
		echo '<br />';
	}
?>
<?php echo form_fieldset_close(); ?>

<?php echo form_submit('register', 'Register'); ?>

</form>
</body>
</html>