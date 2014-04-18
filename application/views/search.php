<?php
	echo form_open('search');
	$this->load->view('formview');

	//	$mbti_types = array('IE','NS','TF','PJ')
	// Extrovert (E) versus Introvert (I).
	// Intuitive (N) versus Sensing (S).
	// Thinking (T) versus Feeling (F).
	// Judging (J) versus Perceiving (P).

	echo form_fieldset('Personality preferences');

	$table = $this->table->make_columns(array(
			form_label('Introvert (I)', 'personality_i'),
			'<input type="range" name="personality_i" min="0" max="100" value="'.set_value('personality_i').'">',
			form_label('Extrovert (E)', 'personality_i'),
			form_error('personality_i'),

			form_label('Intuitive (N)', 'personality_n'),
			'<input type="range" name="personality_n" min="0" max="100" value="'.set_value('personality_n').'">',
			form_label('Sensing (S)', 'personality_n'),
			form_error('personality_n'),

			form_label('Thinking (T)', 'personality_t'),
			'<input type="range" name="personality_t" min="0" max="100" value="'.set_value('personality_t').'">',
			form_label('Feeling (F)', 'personality_t'),
			form_error('personality_t'),

			form_label('Perceiving (P)', 'personality_p'),
			'<input type="range" name="personality_p" min="0" max="100" value="'.set_value('personality_p').'">',
			form_label('Judging (J)', 'personality_p'),
			form_error('personality_p')
		),
	4);

	echo $this->table->generate($table);

	echo form_fieldset_close();

	echo form_submit('search', 'Search');
	echo form_close();