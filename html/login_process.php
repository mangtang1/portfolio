<!DOCTYPE html>
<?php 	include_once($_SERVER['DOCUMENT_ROOT']."/functions.php"); ?>

<html>
<head>
 <meta charset="utf-8">
 <title></title>
</head>
<body>
 <?php
 session_start();
 if(chk_escape(POST['id']))
 {
	gopage("잘못된 아이디 입니다.","/index.php");
	exit;
 }
 if(chk_escape($_POST['password']))
 {
	gopage("잘못된 패스워드 입니다.","/index.php");
	exit;
 }
 $db_conn = db_connect('user');
 $userid = strtolower($_POST['id']);
 $userpass = hash("sha256", $_POST['password']);
 
 $query = "SELECT * FROM users WHERE id = ? AND pass = ?";
 $stmt = mysqli_prepare($db_conn, $query);
 $bind = mysqli_stmt_bind_param($stmt, "ss", $userid, $userpass);
 $exec = mysqli_stmt_execute($stmt);
 $result = mysqli_stmt_get_result($stmt);
 $row = mysqli_fetch_assoc($result);
 
 if($row != null) {
	 $_SESSION['id'] = $row['id'];
	 gopage("", "/index.php");
	 exit;
 }
 else
 {
	 gopage("잘못된 아이디나 패스워드입니다.", "/login.php");
	 exit;
 }
 ?>
</body>
