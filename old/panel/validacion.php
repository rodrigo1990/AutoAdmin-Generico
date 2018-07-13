<?php
	session_start();
	if($_SESSION[login] != "ok")
	{
		header("location:login.php?error2=1");
	}
?>