<?php

mysql_connect('localhost', 'root', 'mysql') or die(mysql_error());
mysql_select_db('test') or die(mysql_error());


class hint {

	function validateUser() {
		// query mysql to authenticate user
		return false;
	}
	
}


if ($_POST) {
	$hint = new hint($_POST['user'], $_POST['password']);
	if ($hint->validateUser()) {
		print 'Your Secret Hint is: ' . $hint;
	} else {
		print 'Bad Credentials';
	}
}

?>
