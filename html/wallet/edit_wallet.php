<!DOCTYPE html>

<?php 	include($_SERVER['DOCUMENT_ROOT']."/functions.php"); ?>

<?php
	$redir = "/wallet/manage_wallet.php";
    if($_SERVER["REQUEST_METHOD"]!='POST') gopage("잘못된 전송 방식입니다.",$redir);
	session_start();
	if(!isset($_SESSION['id']))
	{
		gopage("아이디가 설정되어 있지 않습니다.", "/wallet/manage_wallet.php");
		exit;
	}
	if(!isset($_POST['password'])||trim($_POST['password'])=="") gopage("잘못된 패스워드 입니다.", $redir);
	
	$id = $_SESSION['id'];
	$address = $_POST['address'];
	$comment = $_POST['comment'];
	$password_hash = hash("sha256", $_POST['password']);

	$db_conn = db_connect('user');

	$query = "select * from wallet_info where userid=? and password=? and address=?;";
	$stmt = mysqli_prepare($db_conn, $query);
	$bind = mysqli_stmt_bind_param($stmt, "sss", $id, $password_hash, $address);
	$exec = mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	if(mysqli_num_rows($result)==0) gopage("잘못된 패스워드 입니다.", $redir);

	$query = "UPDATE wallet_info SET comment = ? where userid = ? and password = ? and address=?;";
	$stmt = mysqli_prepare($db_conn,$query);
	$bind = mysqli_stmt_bind_param($stmt, "ssss", $comment, $id, $password_hash, $address);
	$exec = mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	gopage("지갑 정보를 수정하였습니다!", $redir);
?> 