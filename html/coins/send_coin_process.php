<?php 	include_once($_SERVER['DOCUMENT_ROOT']."/functions.php"); ?>
<?php
	$db_conn = db_connect('user');
	$ret_page = "/coins/send_coin.php";
	$py_path = "/home/server/py";
	
	session_start();
	if(!isset($_POST['mangtcoin'])||!isset($_SESSION['id'])||!isset($_POST['send_address'])||!isset($_POST['rec_address'])) gopage("잘못된 전송 값입니다.", $ret_page);
	if(isset($_SESSION['id'])) $id=$_SESSION['id'];
	else $id=$_POST['id'];
	$send=$_POST['send_address'];
	$rec=$_POST['rec_address'];
	$mangt=$_POST['mangtcoin'];
	if(intval($mangt)==0) gopage("잘못된 코인수량입니다.",$ret_page);
	$mangt = intval($mangt);
	if($mangt<0) gopage("잘못된 코인수량입니다.",$ret_page);
	if($_SERVER["REQUEST_METHOD"]!='POST') gopage("잘못된 전송 방식입니다.",$ret_page);
	if(chk_escape($send)) gopage("잘못된 송신자입니다.", $ret_page);
	if(chk_escape($rec)) gopage("잘못된 수신자입니다.", $ret_page);
	$query1 = "SELECT password FROM wallet_info where userid=? and address = ?;";
	$stmt1 = mysqli_prepare($db_conn, $query1);
	mysqli_stmt_bind_param($stmt1, "ss", $id, $send);
	mysqli_stmt_execute($stmt1);
	$result1 = mysqli_stmt_get_result($stmt1);
	$row1 = mysqli_fetch_assoc($result1);
	if(!isset($row1['password'])) gopage("잘못된 송신자 주소입니다", $ret_page);
	$password = $row1['password'];
	$query2 = "SELECT public_key, private_key FROM wallets where wallet_address = ? and password = ?;";
	$stmt2 = mysqli_prepare($db_conn, $query2);
	mysqli_stmt_bind_param($stmt2, "ss", $send, $password);
	mysqli_stmt_execute($stmt2);
	$result2 = mysqli_stmt_get_result($stmt2);
	$row2 = mysqli_fetch_assoc($result2);
	$send_public_key = $row2['public_key'];
	$send_private_key = $row2['private_key'];
	$query3 = "SELECT public_key FROM wallets where wallet_address = ?;";
	$stmt3 = mysqli_prepare($db_conn, $query3);
	mysqli_stmt_bind_param($stmt3, "s", $rec);
	mysqli_stmt_execute($stmt3);
	$result3 = mysqli_stmt_get_result($stmt3);
	$row3 = mysqli_fetch_assoc($result3);
	if(!isset($row3['public_key'])) gopage("잘못된 수신자 주소입니다", $ret_page);
	$rec_public_key = $row3['public_key'];
	$sh = "python3 {$py_path}/get_utxo.py {$send}";
	$ret = shell_exec($sh);
	$arr = explode('/', $ret);
	$utxo = (int)$arr[0];
	if($utxo<$mangt) gopage("잔액보다 큰 코인수량입니다.",$ret_page);
	$sh = "python3 {$py_path}/make_trans.py {$send} {$rec} {$send_public_key} {$send_private_key} {$rec_public_key} {$mangt}";
	$ret = shell_exec($sh);
	sleep(1);
	if(strpos($ret,"good")!==False)
	{
		gopage("거래 기록을 완료했습니다.", $ret_page);
	}
	else
	{
		gopage("잔액보다 큰 코인 수량입니다.", $ret_page);
	}
?>