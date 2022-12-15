<?php 	include_once($_SERVER['DOCUMENT_ROOT']."/head.php"); ?>
<?php 	include_once($_SERVER['DOCUMENT_ROOT']."/func_list.php"); ?>

<head>
	<style>
		.adr_box {
			width : 90vw;
			height : 60vh;
			max-width : 600px;
			margin-top:10vh;
		}
		.adr_list {
			height : 45vh;
			padding:0;
			overflow:scroll; 
		}
		.adr_list::-webkit-scrollbar {
			display: none;
		}
		#cont.open .modal{
			pointer-events : auto;
			top : 50vh !important;
		}
		.btn-floating {
			color: var(--cyanColor);
			padding: 0;
			width: 55.5px; height: 55.5px;
			margin:auto;
			outline: 0;
			border: none;
			text-decoration: none;
			background-color: #FFFFFF;
			border-radius: 50%;
			box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
		}
		.btn-floating:hover {
			background: #FFFFF;
		}
		.btn-floating div {
			font-size: 1.8em;
			padding: 0;
			margin:0;
		}
		.shadow {
			box-shadow : 2px;
		}
		.title {
			margin-top:8vh;
			margin-bottom:0vh;
		}
		.info {
			margin-top:3vh;
			width : 80%;
		}
		.info input{
			margin-top:1vh;
			padding-left:1rem;
		}
		#address_edit.hide {
			display : none !important;
			z-index : -1 !important;
			
		}
		.new {
			border : 1px dashed #000000 !important;
			justify-content:center;
			align-items:center;
			text-align:center;
			display:flex;
		}	
		#sendbut {
			position:absolute;
			top:40vh;
			width : 80%;
			height:5vh;
			max-width:800px;
			border-width:0;
			background-color : var(--baseColor);
		}
		#sendbut.active {
			background-color : var(--yellowColor) !important;
		}
	</style>
</head>
<?php
 if(!isset($_SESSION['id'])) {
	 gopage("로그인 되어있지 않습니다.", "/login.php");
 }
 else {
	 $userid = $_SESSION['id'];
 }
?>
<?php
	$arr = array("userid"=>$userid,"icon"=>"fa-solid fa-magnifying-glass","event"=>"wallet_mode('title', '%s', 'sendbut', 2);");
	$edit_my_wallets = get_wallets($arr);
?>
<body>
	
  	<div class="wrap" style="justify-content:flex-start;height:100vh;">

		<div id="search_address" class="adr_box" style="margin-top:10vh;">
		  <input class="form-control" onkeyup="filter_list('address_input', 'address_list')" id="address_input" type="text" placeholder="내 계좌"></input>

		  <br>
			<div class="adr_list" style="height:70vh !important;">
				<ul class="list-group" id="address_list">
					<label>
					<div class="new">
						<button onclick="wallet_mode('title', '지갑 생성', 'sendbut', 1);" class="btn-floating"><div><span class="fa fa-plus"></span></div></button>
					</div>
					</label>
					<?=$edit_my_wallets?>
				</ul>  
			</div>
		</div>
	</div>
	<div id="cont">
		<div class="modal">
			<button onclick="close_modal();" class="btn-floating" style="position:absolute; top:1vh;"><div><span class="fa-solid fa-xmark"></span></div></button>

			<div class="title"><h3 id="title"></h3></div>
			<div class="info"> 
				<input class="form-control pass" id="password_input" type="password" placeholder="계좌 비밀번호"></input>
				<input class="form-control text" id="comment_input" type="text" placeholder="계좌 설명"></input>
			</div>
			
			<button id="sendbut" type="submit" onclick="create_wal();" disabled></button>
		</div>
	</div>
	<script>
		let passForm = document.getElementById("password_input");
		let commentForm = document.getElementById("comment_input");
		let sendButton = document.getElementById("sendbut");
		
		function activeEvent() 
		{
			switch(!(passForm.value && commentForm.value))
			{
				case true : sendButton.classList.remove('active'); sendButton.disabled = true; break;
				case false : sendButton.classList.add('active'); sendButton.disabled = false; break;
			}
		}
		passForm.addEventListener('keyup', activeEvent);
		commentForm.addEventListener('keyup', activeEvent);
		
		let sw=0;
		function create_wal() {
			let password=document.getElementById('password_input').value;
			let comment=document.getElementById('comment_input').value;
			post_to_url('/wallet/create_wallet.php', {'password':password, 'comment':comment});
		}
		function edit_wal(address) {
			let password=document.getElementById('password_input').value;
			let comment=document.getElementById('comment_input').value;
			post_to_url('/wallet/edit_wallet.php', {'address':address, 'password':password, 'comment':comment});
		}
		function wallet_mode(title, val, but, mode) {
			let small = document.getElementById(title);
			let button = document.getElementById(but);
			if(mode==sw||mode==0)
			{
				sw=0;
				close_modal();
				return 0;
			}
			else if(mode==1)
			{
				small.innerText=val;
				button.innerText="계좌 생성하기";
				button.setAttribute("onclick","create_wal()");
				sw=1;
			}
			else if(mode==2)
			{
				small.innerText=val.substr(0,20);
				button.innerText="계좌 변경하기";
				button.setAttribute("onclick","edit_wal('"+val+"')");

				sw=2;
			}
			open_modal();

		}
	</script>
</body>

<?php 	include_once($_SERVER['DOCUMENT_ROOT']."/sidebar.php"); ?>

					