<?php
	echo form_open('configuration');
	echo form_label('X-Factor', 'x');
	echo 'Match on:<br/>';
	echo 'Brands only <input type="range" name="x" min="0" max="1" step="0.01" value="' . $mix_weight . '" /> Personality only<br />';

	echo form_label('Learning factor', 'alpha');
	echo 'No learning <input type="range" name="alpha" min="0" max="1" step="0.01" value="' . $alpha . '" /> Instant learning<br />';

	echo form_fieldset('Distance measure'); 
	echo form_radio(array('name' => 'distance_measure', 'value' => 'dice', 'id' => 'dice', 'checked' => $match_type == 'dice' ? 'checked' : ''));
	echo form_label('Dice', 'dice') . '<br />';
	echo form_radio(array('name' => 'distance_measure', 'value' => 'jaccard', 'id' => 'jaccard', 'checked' => $match_type == 'jaccard' ? 'checked' : ''));
	echo form_label('Jaccard', 'jaccard') . '<br />';
	echo form_radio(array('name' => 'distance_measure', 'value' => 'cosine', 'id' => 'cosine', 'checked' => $match_type == 'cosine' ? 'checked' : ''));
	echo form_label('Cosine', 'cosine') . '<br />';
	echo form_radio(array('name' => 'distance_measure', 'value' => 'overlap', 'id' => 'overlap', 'checked' => $match_type == 'overlap' ? 'checked' : ''));
	echo form_label('Overlap', 'overlap') . '<br />';
	echo form_fieldset_close();

	echo form_submit('set', 'Change settings');
	echo form_close();