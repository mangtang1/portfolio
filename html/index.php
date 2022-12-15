<?php 	include_once($_SERVER['DOCUMENT_ROOT']."/head.php"); ?>
<?php
 session_start();
?>
<head>

	<style>
	@font-face {
		font-family: 'KOTRA_BOLD-Bold';
		src: url('https://cdn.jsdelivr.net/gh/projectnoonnu/noonfonts_20-10-21@1.1/KOTRA_BOLD-Bold.woff') format('woff');
		font-weight: normal;
		font-style: normal;
	}
		.wrap * {
			font-family:'BMJUA';
		}
		.wrap {
			
			width:100%;
			overflow-x:hidden;
			overflow-y:auto;
			position:relative;
		}
		.tab {
			width:100%;
			display:flex;
			flex-direction : column;
			justify-content:flex-start;
			align-items:center;
			position:relative;
			text-align:center;
		}
		.t-1 {
			height:100vh;
			padding-top:30vh;
			background-image: linear-gradient(to top, #e9fdfd, #effdff, #f6fdff, #fcfeff, #ffffff);
		}
		
		.t-2 {
			height:100vh;
			padding-top:10vh;
			background-color : #FFFFFF;
		}
		
		.t-3 {
			height:100vh;
			padding-top:10vh;
			background-color : #EEEEEE;
		}
		
		.t-4 {
			height:100vh;
			padding-top:10vh;
			background-color:#FFFFFF;
		}
		
		.t-5 {
			height:100vh;
			padding-top:10vh;
			background-color:#EAEAEA;
		}
		.title {
			width:70%;
			max-width:1200px;
			height:5rem;
			background-color:transparent;
			border:0;
			font-size:2rem;
			text-align:left;
			color : #000000;
			margin-top : 10vh;
			display:block;
		}
		.detail {
			width:70%;
			max-width:1200px;
			height:10rem;
			background-color:transparent;
			border:0;
			line-height:1.5rem;
			font-size:1rem;
			text-align:left;
			color : #888888;
			margin-top:1rem;
			margin-bottom:1rem;
			display:block;
		}
		.downpage {
			animation : motion1 0.3s linear 0s infinite alternate; margin-bottom:0;
		}
		.uppage {
			animation : motion2 0.3s linear 0s infinite alternate; margin-bottom:0;
		}
		.logo {
			width:20vh;
			height:20vh;
			display:block;
			animation : motion3 1.5s linear 0s infinite alternate; margin-bottom:0;
		}

		@keyframes motion1 {
			0% {margin-bottom: 0x;}
			100% {margin-bottom: 15px;}
		}
		@keyframes motion2 {
			0% {margin-top: 0x;}
			100% {margin-top: 15px;}
		}
		@keyframes motion3 {
			50% {opacity:0.8;}
		}
		.btn-floating {
		    font-family: 'Font Awesome 6 Free' !important;
			color: #555555;
			padding: 0;
			font-size:4vh;
			width: 100vw;
			outline: 0;
			border: none;
			display:block;
			text-decoration: none;
			background-color: transparent;
			text-align: center;
			align-items : center;
			position:absolute;
		}
		.btn-floating * {
		    font-family: 'Font Awesome 6 Free' !important;
		}
	</style>
</head>
<body>
	<div style="min-height:100vh; width:100%;overflow-x:hidden; overflow-y:auto">
		<div class="wrap">
			<div class="t-1 tab" id="tab1">
				<img src="/imgs/logo.png" class="logo">
				<span style="font-size:3rem;margin-top:1rem;text-align:center;">맹트코인</span>
				<span style="font-size:1.5rem;color:#444444;margin-top:0.5rem;text-align:center;">블록체인의 원리를 알 수 있는<br>교육용 암호화폐</span>
			</div>
			<a href="#tab2" class="btn-floating" style=" bottom:10vh;">	<span class="fa-solid fa-angles-down downpage"></span></a>
		</div>
		
		<div class="wrap">
			<div class="t-2 tab" id="tab2">
				<span class="title">맹트코인이란?</span>
				<span class="detail"> &nbsp실제 거래를 위한 것이 아닌 대중들이 암호화폐의 원리와 가치를 이해할 수 있도록 만든 교육용 코인입니다.</span>
			</div>
			<a href="#tab1" class="btn-floating" style="top:10vh;">	<span class="fa-solid fa-angles-up uppage"></span>	</a>
			<a href="#tab3" class="btn-floating" style="bottom:10vh;">	<span class="fa-solid fa-angles-down downpage"></span>	</a>
		</div>
		
		<div class="wrap">
			<div class="t-3 tab" id="tab3">
				<span class="title">체험 방법</span>
				<span class="detail">아이디 : testtest<br>비밀번호 : testtest 로 접속해서 체험해 보세요</span>
				
			</div>
			<a href="#tab2" class="btn-floating" style="top:10vh;">	<span class="fa-solid fa-angles-up uppage"></span>	</a>
			<a href="#tab4" class="btn-floating" style="bottom:10vh;">	<span class="fa-solid fa-angles-down downpage"></span>	</a>
		</div>
		
		<div class="wrap">
			<div class="t-4 tab" id="tab4">
				<span class="title">계정</span>
				<span class="detail">계좌들을 관리할 계정을 다룹니다. 이때 맹트코인 계좌는 계정에 속하는 것이 아닌 계좌에 접근할 수 있는 비밀번호를 계정이 가지게 됩니다.</span>
				
				<span class="title">거래</span>
				<span class="detail">내 계좌에서 다른 계좌로 맹트코인을 송금합니다. 나의 계좌를 관리 할 수 있습니다.</span>
			</div>
			<a href="#tab3" class="btn-floating" style="top:10vh;">	<span class="fa-solid fa-angles-up uppage"></span>	</a>
			<a href="#tab5" class="btn-floating" style="bottom:10vh;">	<span class="fa-solid fa-angles-down downpage"></span>	</a>
		</div>
		
		<div class="wrap">
			<div class="t-5 tab" id="tab5">
				<span class="title">체인</span>
				<span class="detail">서버에 기록되어 있는 맹트코인의 블록체인과 그 상세값들을 확인 할 수 있습니다.</span>
				
				<span class="title">채굴</span>
				<span class="detail">맹트코인을 채굴할 수 있는 소스코드를 다운로드 받을 수 있습니다.</span>
			</div>
			<a href="#tab4" class="btn-floating" style="top:10vh;">	<span class="fa-solid fa-angles-up uppage"></span>	</a>
			<a href="#tab6" class="btn-floating" style="bottom:10vh;">	<span class="fa-solid fa-angles-down downpage"></span>	</a>
		</div>		
			
		</div>
	</div>
</body>
<?php 	include_once($_SERVER['DOCUMENT_ROOT']."/sidebar.php"); ?>
