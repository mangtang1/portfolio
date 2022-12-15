<?php 	include_once($_SERVER['DOCUMENT_ROOT']."/functions.php"); ?>

<?php
 $db_conn = db_connect('user');
 $hashedPassword = hash("sha256", $_POST['password']);
 if(!isset($_POST['email'])||!isset($_POST['id'])||!isset($_POST['password'])||!isset($_POST['password-check']))
 {
	 gopage("빠진 내용이 있습니다.","/signup.php");
	 exit;
 }
 if(preg_match('/\.|\,|\(|\)|\'|\"|\ |\#/i', $_POST['id']))
 {
	gopage("잘못된 아이디입니다.", "/signup.php");
	exit;
 }
 if(preg_match('/\.|\,|\(|\)|\'|\"|\ |\#/i', $_POST['password']))
 {
	gopage("잘못된 비밀번호입니다.", "/signup.php");
	exit;
 }
 if(preg_match('/\(|\)|\'|\"|\ |\#/i', $_POST['email']))
 {
	gopage("잘못된 이메일입니다.", "/signup.php");
	exit;
 }
 if(strlen($_POST["id"])<4)
 {
	gopage("아이디는 4글자 이상이어야 합니다.", "/signup.php");
	exit;
 }
 
 if(strlen($_POST["password"])<8)
 {
	gopage("비밀번호는 8글자 이상이어야 합니다.", "/signup.php");
	exit;
 }
 if($_POST["password"]!=$_POST["password-check"])
 {	 
	gopage("비밀번호가 일치하지 않습니다.", "/signup.php");
	exit;
 }
 $userid = strtolower($_POST['id']);
 $query = "select * from users where id like ?";
 $stmt = mysqli_prepare($db_conn, $query);
 $bind = mysqli_stmt_bind_param($stmt, "s", $userid);
 $exec = mysqli_stmt_execute($stmt);
 $result = mysqli_stmt_get_result($stmt);
 $rec = mysqli_num_rows($result);
 if($rec>0)
 {
	 ?>
	 <script> 
	 alert('이미 존재하는 ID입니다.');
	 location.href = "signup.php";
	 </script>
	 <?php
	exit;
 }
 $query = "insert into users (id, pass, email) values(?,?,?);";
 $stmt = mysqli_prepare($db_conn, $query);
 $bind = mysqli_stmt_bind_param($stmt, "sss", $userid,$hashedPassword, $_POST['email']);
 $exec = mysqli_stmt_execute($stmt);
 if($exec == false) {
	gopage("회원가입에 문제가 생겼습니다.", "/signup.php");
 }
 else
 {
	gopage("회원가입이 완료되었습니다.", "/login.php");
 }
?>