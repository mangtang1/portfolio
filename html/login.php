<?php 	include_once($_SERVER['DOCUMENT_ROOT']."/head.php"); ?>
<head>
  <style>
    .wrap {
        height:100vh;
    }
    .pick {
        width:15vh;
        height:15vh;
        display:block;
        margin-bottom : -3vh;
        transition: all 0.8s cubic-bezier(0.810, -0.330, 0.345, 1.375);
        transition-delay: 0.2s;
        animation : motion_mining 1.5s linear 0.3s infinite alternate;
    }
    .mined_coin {
        width:15vh;
        height:15vh;
        margin-bottom:10vh;
        display:block;
        background-size : 15vh 15vh;
        animation-name : cracked;
        animation-duration : 3s;
        animation-timing-function : linear;
        animation-delay : 0.2s;
        animation-direction : normal;
        animation-iteration-count : infinite;
    }
    @keyframes motion_mining {
        0% { transform: rotate(20deg) translate(2px, 2px); }
        50% { transform: rotate(35deg) translate(2px, 2px); }
        90% { transform: rotate(70deg) translate(2px, 2px); }
    }
    @keyframes cracked {
        0% { background-image: url(/imgs/logo.png); }
        70% { background-image: url(/imgs/crack1.png); }
        100% { background-image: url(/imgs/logo.png); }
    }
  </style>

</head>
<body>
	<div style="min-height:100vh; width:100%;overflow-x:hidden; overflow-y:auto; text-align:center;">
        <form method="post" action="/login_process.php">

  	<div class="wrap">
		<img src="/imgs/pick.png" class="pick">
   		<div class="mined_coin">
        </div>

            <input class="user-inp inp" type="text" name="id" id="id" placeholder="아이디">

            <input class="user-inp inp" type="password" name="password" id="password" placeholder="비밀번호">

          <button class="user-sub sub" type="submit" disabled>로그인</button>
  </div>
      </form>
  </div>
</body>
<?php 	include_once($_SERVER['DOCUMENT_ROOT']."/sidebar.php"); ?>
