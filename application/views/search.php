<?php
	echo form_open('search');
	$this->load->view('formview');

	//	$mbti_types = array('IE','NS','TF','PJ')
	// Extrovert (E) versus Introvert (I).
	// Intuitive (N) versus Sensing (S).
	// Thinking (T) versus Feeling (F).
	// Judging (J) versus Perceiving (P).

	echo form_fieldset('Personality preferences'); 

	echo form_label('Introvert (I)', 'personality_i'); 
	echo '<input type="range" name="personality_i" min="0" max="100" value="'.set_value('personality_i').'">';
	echo form_label('Extrovert (E)', 'personality_i'); 
	echo form_error('personality_i') . '<br />';
	
	echo form_label('Intuitive (N)', 'personality_n'); 
	echo '<input type="range" name="personality_n" min="0" max="100" value="'.set_value('personality_n').'">';
	echo form_label('Sensing (S)', 'personality_n');
	echo form_error('personality_n') . '<br />';
	
	echo form_label('Thinking (T)', 'personality_t'); 
	echo '<input type="range" name="personality_t" min="0" max="100" value="'.set_value('personality_t').'">';
	echo form_label('Feeling (F)', 'personality_t');  
	echo form_error('personality_t') . '<br />';
	
	echo form_label('Perceiving (P)', 'personality_p'); 
	echo '<input type="range" name="personality_p" min="0" max="100" value="'.set_value('personality_p').'">';
	echo form_label('Judging (J)', 'personality_p'); 
	echo form_error('personality_p') . '<br />';

	echo form_fieldset_close(); 
	
	echo form_submit('search', 'Search');
	echo form_close();