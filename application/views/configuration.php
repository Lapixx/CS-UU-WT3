<?php
	echo form_open('configuration');
	echo form_label('X-Factor', 'x');
	echo '0<input type="range" name="x" min="0" max="1" step="0.01" value="' . $x . '" />1<br />';

	echo form_label('Learning factor', 'alpha');
	echo '0<input type="range" name="alpha" min="0" max="1" step="0.01" value="' . $alpha . '" />1<br />';

	echo form_radio(array('name' => 'distance_measure', 'value' => 'dice', 'id' => 'dice', 'checked' = $distance_measure == 'dice' ? 'checked' : ''));
	echo form_label('Dice', 'dice') . '<br />';
	echo form_radio(array('name' => 'distance_measure', 'value' => 'jaccard', 'id' => 'jaccard', 'checked' = $distance_measure == 'jaccard' ? 'checked' : ''));
	echo form_label('Jaccard', 'jaccard') . '<br />';
	echo form_radio(array('name' => 'distance_measure', 'value' => 'cosine', 'id' => 'cosine', 'checked' = $distance_measure == 'cosine' ? 'checked' : ''));
	echo form_label('Cosine', 'cosine') . '<br />';
	echo form_radio(array('name' => 'distance_measure', 'value' => 'overlap', 'id' => 'overlap', 'checked' = $distance_measure == 'overlap' ? 'checked' : ''));
	echo form_label('Overlap', 'overlap') . '<br />';

	echo form_submit('set', 'Change settings');
	echo form_close();