<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome</title>
</head>
<body>
	<?php
		if (!empty($data)) {
			foreach ($data as $key => $data) {?>
	<p><b><?= $key ?>:</b> <?= $data ?></p>
	<?php }} else { ?>
	<p>ID not found.</p>
	<?php } ?>
</body>
</html>