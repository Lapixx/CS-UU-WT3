<?php echo form_open_multipart('editpicture'); ?>

<input type="file" size="20" name="avatar" />

<input type="submit" value="Change picture!" />

<?php echo $error; ?>

<?php echo form_close(); ?>