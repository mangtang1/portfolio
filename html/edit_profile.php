<?php 	include_once($_SERVER['DOCUMENT_ROOT']."/head.php"); ?>
<?php
 if(!isset($_SESSION['id'])) {
	 gopage("로그인 되어있지 않습니다.", "/login.php");
 }
 else {
	 $userid = $_SESSION['id'];
 }
?>
<head>
  <style>
    .wrap {
        align-items: center;
        flex-direction:column;
        justify-content:flex-end;
        height:100vh;
    }
  </style>
</head>
<body>
	<div style="min-height:100vh; width:100%;overflow-x:hidden; overflow-y:auto; text-align:center;">

      <form method="post" action="/edit_profile_process.php">
          	<div class="wrap">

       <input class="user-inp" type="text" name="id" id="id" placeholder="<?=$_SESSION['id']?>" disabled>

        <input class="user-inp inp" type="password" name="password-old" id="password-old" placeholder="기존 비밀번호">

        <input class="user-inp inp" type="password" name="password-new" id="password-new" placeholder="새 비밀번호">

        <input class="user-inp inp" type="password" name="password-check" id="password-check" placeholder="새 비밀번호 확인">

        <button class="user-sub sub" type="submit">계정수정</button>
  </div>
        </form>

  </div>
</body>
<?php 	include_once($_SERVER['DOCUMENT_ROOT']."/sidebar.php"); ?>
