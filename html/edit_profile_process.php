<?php 	include_once($_SERVER['DOCUMENT_ROOT']."/functions.php"); ?>

<?php
 session_start();
 $redir = "/edit_profile.php";
 $db_conn = db_connect('user');
 $hashed_old_Password = hash("sha256", $_POST['password-old']);
 $hashed_new_Password = hash("sha256", $_POST['password-new']);
 $userid = $_SESSION['id'];
 if(isset($_POST['password-new'])&&strlen($_POST['password-new'])>0)
 {
	 if(!isset($_POST['password-check'])||strlen($_POST['password-check'])==0) gopage("비밀번호 확인을 입력해주세요.",$redir);
 }
 else gopage("정보 수정이 완료되었습니다.", $redir);
 $query = "select * from users where id = ? and pass = ?";
 $stmt = mysqli_prepare($db_conn, $query);
 $bind = mysqli_stmt_bind_param($stmt, "ss", $userid, $hashed_old_Password);
 $exec = mysqli_stmt_execute($stmt);
 $result = mysqli_stmt_get_result($stmt);
 $rec = mysqli_num_rows($result);
 if($rec==0) gopage("잘못된 기존 비밀번호 입니다.", $redir);
 if(chk_escape($_POST['password'])gopage("잘못된 비밀번호입니다.", $redir);
 if(strlen($_POST["password-new"])<8) gopage("비밀번호는 8글자 이상이어야 합니다.", $redir);
 if($_POST["password-new"]!=$_POST["password-check"]) gopage("비밀번호가 일치하지 않습니다.", $redir); 
 
 $query = "UPDATE users set pass = ? where id = ?";
 $stmt = mysqli_prepare($db_conn, $query);
 $bind = mysqli_stmt_bind_param($stmt, "ss", $hashed_new_Password, $userid);
 $exec = mysqli_stmt_execute($stmt);
 if($exec == false) gopage("정보 수정에 문제가 생겼습니다.", $redir);
 else gopage("정보 수정이 완료되었습니다.", $redir);
?>