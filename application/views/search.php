<?php
	echo form_open('search');
	$this->load->view('formview');
	echo form_submit('search', 'Search');
	echo form_close();
?>