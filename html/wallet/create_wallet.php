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

	$password_hash = hash("sha256", $_POST['password']);
	$db_conn = db_connect('user');
	$query = "select * from wallet_info where userid=? and password=?;";
	$stmt = mysqli_prepare($db_conn, $query);
	$bind = mysqli_stmt_bind_param($stmt, "ss", $id, $password_hash);
	$exec = mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	if(mysqli_num_rows($result)>0) gopage("이미 있는 패스워드 입니다.", $redir);
	$ret = shell_exec("python3 {$py_path}/wallet.py $password_hash");
	$ret = trim($ret);
	$comment = $_POST['comment'];
	$query = "insert into wallet_info (userid, address, password, comment) values(?,?,?,?)";
	$stmt = mysqli_prepare($db_conn,$query);
	$bind = mysqli_stmt_bind_param($stmt, "ssss", $id, $ret, $password_hash, $comment);
	$exec = mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	gopage("새 지갑을 생성하였습니다!", $redir);
?> 