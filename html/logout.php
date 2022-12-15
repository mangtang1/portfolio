<?php 	include_once($_SERVER['DOCUMENT_ROOT']."/functions.php"); ?>
<?php
	session_start();
	session_destroy();
	gopage("", "/index.php");
?>