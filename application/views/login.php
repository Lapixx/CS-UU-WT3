<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Log in</title>
</head>
<body>
<?php if ($failed) { echo '<p>Invalid email or password.</p>'; } ?>
<?php echo validation_errors(); ?>
<?php echo form_open('login'); ?>

Email: <input type="text" name="email" value="" size="30" /><br />
Password: <input type="password" name="password" value="" size="30" />

<div><input type="submit" value="Log in" /></div>

</form>
</body>
</html>