<?php 	include_once($_SERVER['DOCUMENT_ROOT']."/head.php"); ?>
<?php 	include_once($_SERVER['DOCUMENT_ROOT']."/func_list.php"); ?>

<?php
 if(!isset($_SESSION['id'])) {
	 gopage("로그인 되어있지 않습니다.", "/login.php");
 }
 else {
	 $userid = $_SESSION['id'];
 }
?>
<?php
	$arr = array("userid"=>$userid, "event"=> "fill_address('%s', 'send_fill');", "show_userid"=>0);
	$my_wallets = get_wallets($arr);
	$arr = array("userid"=>"%", "event"=> "fill_address('%s', 'rec_fill');", "show_userid"=>1, "show_utxo"=>0);
	
	$all_wallets = get_wallets($arr);
	$tax_rate = get_block_setting("tax_rate");

?>
<head>
	<style>
	.btn-floating {
		color: var(--cyanColor);
		padding: 0;
		width: 55.5px; height: 55.5px;
		margin:0 auto;
		outline: 0;
		left:0;
		right:0;
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
	  .recs {
		  overflow:scroll; 
		  height:70vh !important;
	  }
	  .recs::-webkit-scrollbar {
		  display: none;
    }
	.wrap {
		min-height:100vh;
		width:100vw;
		overflow-x:hidden;
		overflow-y:auto;
		background-color:#FFFFFF;
		text-align:center;
	}
	.money {
		width:12rem;
		background:transparent;
		border:0;
		border-bottom:1px solid #888888;
		margin-top:2rem;
		margin-bottom:1rem;
		font-size:2.5rem;
	}
	.tax {
		width:16rem;
		background:transparent;
		border:0;
		margin-top:0.5rem;
		margin-bottom:1rem;
		font-size:1.5rem;
		color:#AAAAAA;
	}
	#cont.open .modal{
	    pointer-events : auto;
		top : 20vh !important;
	}
	
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
	#sendbut {
		width : 100%;
		height : 10vh;
		font-size : 2rem;
		border-width:0;
		position : absolute;
		bottom : 0;
		max-width : 800px;
		background-color : var(--baseColor);
	}
	#sendbut.active {
		background-color : var(--yellowColor) !important;
	}
  </style>
</head>

<body>
	<div class="wrap">
		<div style="position:absolute;top:5vh;overflow:hidden;">
			<label style="width:100%; margin-top:1.5rem;">
				<p style="font-size:1.5rem;"> 내 계좌 <i class="fa-solid fa-hand-pointer"></i> </p>
				<p id="send_fill" style="font-size:1rem;"></p>
				<button style="display:none" onclick="address_mode('address_list', 'address_input', '내 계좌', 1);"> </button>
			</label>
		</div>
		<div style="position:absolute;top:30vh;overflow:hidden;">
			<input class="money" type="number" pattern="\d*" style="text-align:center;" id="ori_money" onkeyup="cal_tax('ori_money', 'tax');" placeholder="코인 수량"\>
			<p class="tax" id="tax">수수료포함(0.1%)</p>
		</div>
		<div style="position:absolute;top:70vh;overflow:hidden;">
			<label style="width:100%; margin-top:1.5rem;">
				<p style="font-size:1.5rem;"> 받을 계좌  <i class="fa-solid fa-hand-pointer"></i>  </p>
				<p style="font-size:1rem;" id="rec_fill"></p>
				<button style="display:none" onclick="address_mode('address_list', 'address_input', '받을 계좌', 2);"> </button>
			</label>
		</div>			
		<button type="submit" id="sendbut" onclick="send_coin()" disabled>송금하기</button>
	</div>
	<div id="cont">
		<div class="modal">
			<button onclick="close_modal();" class="btn-floating" style="position:absolute; top:1vh;"><div><span class="fa-solid fa-xmark"></span></div></button>

			<div class="adr_box">
			<input class="form-control" onkeyup="filter_list('address_input', 'address_list')" id="address_input" type="text" placeholder="내 계좌"></input>

			<br>
			<div class="adr_list">
				<ul class="list-group" id="address_list">

				</ul>  
			</div>
			</div>
		</div>
	</div>
	
<script>
	let sendForm = document.getElementById('send_fill');
	let recForm = document.getElementById("rec_fill");
	let moneyForm = document.getElementById("ori_money");
	let sendButton = document.getElementById("sendbut");
	
	function activeEvent() 
	{
		switch(!(sendForm.innerText && recForm.innerText && moneyForm.value))
		{
			case true : sendButton.classList.remove('active'); sendButton.disabled = true; break;
			case false : sendButton.classList.add('active'); sendButton.disabled = false; break;
		}
	}
	moneyForm.addEventListener('keyup', activeEvent);
	
	
	
	let send_address, rec_address, sw=0;
	
	function address_mode(tar_list, inputs, plahold, mode) {
		
		let small = document.getElementById(tar_list);
		let input = document.getElementById(inputs);

		if(mode==sw || mode==0)
		{
			sw=0;
			close_modal();
			return 0;
		}
		else if(mode==1)
		{
			small.innerHTML=`<?=$my_wallets?>`;
			sw=1;
		}
		else if(mode==2)
		{
			small.innerHTML=`<?=$all_wallets?>`;
			sw=2;
		}
		open_modal();
		input.placeholder=plahold;
	}
	function fill_address(address, target) {
		let search_address = document.getElementById("search_address");
		let target_fill = document.getElementById(target);
		target_fill.innerHTML = address;
		activeEvent();
		close_modal();
	}
	function cal_tax(val1, val2) {
		let source=document.getElementById(val1);
		let dest=document.getElementById(val2);
		let money=Number(source.value)+parseInt(Number(source.value)*<?=$tax_rate?>);
		if(Number(source.value)==0)
		{
			dest.innerText="수수료포함(0.1%)";
		}
		else
		{
			dest.innerText=money;
		}
	}
	function send_coin() {
		let send_address=document.getElementById('send_fill').innerText;
		let rec_address=document.getElementById('rec_fill').innerText;
		let mangtcoin=document.getElementById('ori_money').value;
		post_to_url('/coins/send_coin_process.php', {'send_address':send_address, 'rec_address':rec_address, 'mangtcoin':mangtcoin});
	}
</script>
</body>

<?php 	include_once($_SERVER['DOCUMENT_ROOT']."/sidebar.php"); ?>

					