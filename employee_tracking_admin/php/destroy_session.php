<?php
	session_start();
	if(isset($_SESSION)){
		$_SESSION['user'] = null;
		session_destroy();
	}
	die("1");
?>