<?php echo form_open_multipart('editpicture'); ?>

<?php echo $error; ?>

<input type="file" size="20" name="avatar" />

<input type="submit" value="Change picture!" />

<?php echo form_close(); ?>