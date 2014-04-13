<h2>Really delete account?</h2>

<?php

if ($failed)
	echo 'Invalid password.<br />';

echo form_open('deleteuser');
echo form_label('Password', 'password');
echo form_password(array('name' => 'password', 'id' => 'password'));
echo form_error('password') . '<br />';
echo form_submit('delete', 'Delete');
echo form_close();