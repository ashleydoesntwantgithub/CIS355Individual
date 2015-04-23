<!--
Title: logout.php
Author: Ashley Schaar
Date: 4-23-2015
For Project: CIS 355 Individual Project
-->

<?php	
	session_start();

        $_SESSION["id"] = "";
		session_destroy();
		header('Location: index.php');

?>