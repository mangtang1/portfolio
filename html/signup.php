<?php 	include_once($_SERVER['DOCUMENT_ROOT']."/head.php"); ?>
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
  
      <form method="post" action="/signup_process.php">
      	<div class="wrap">

            <input class="user-inp inp" type="text" name="email" id="email" placeholder="이메일">

            <input class="user-inp inp" type="text" name="id" id="id" placeholder="아이디">

            <input class="user-inp inp" type="password" name="password" id="password" placeholder="비밀번호">

            <input class="user-inp inp" type="password" name="password-check" id="password-check" placeholder="비밀번호 확인">

          <button class="user-sub sub" type="user-submit">회원가입</button>
      
  </div>
  </form>
  </div>
</body>
<?php 	include_once($_SERVER['DOCUMENT_ROOT']."/sidebar.php"); ?>
