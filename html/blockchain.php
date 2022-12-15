<?php 	include_once($_SERVER['DOCUMENT_ROOT']."/head.php"); ?>
<?php 	include($_SERVER['DOCUMENT_ROOT']."/func_list.php"); ?>

<head>
	<style>
		.navi {
			width:90%;
			max-width : 550px;
			height:40vh !important;
			padding:0;
			display:flex;
			overflow:hidden;
			flex-direction:column;
			justify-content:flex-start;
			align-items:center;
		}
		.navi .title {
			width:100%;
			height:10vh;
			font-size:4vh;
			display: flex;
			justify-content: center;
			align-items: center;
		}
		.navi .bread {
			width : 100%;
			height : 6vh;
			text-align:left;
			margin-top:1vh;
		}
		.navi .bread ul {
			text-align:left;
			padding:0;
		}
		.navi .bread li {
			display:inline-block;
			list-style : none;
			text-decoration: none;
			font-size:2.2vh;
		}
		.navi .bread li button {
			background-color:transparent;
			border:0;
		}
		.navi .bread li button:hover {
			color : var(--skyColor);
		}
		.navi .search {
			width : 50%;
			max-width:250px;
			height : 5vh;
			font-size:1rem;
			border:0;
			position:fixed;
			top:18vh;
			padding-left : 2vw;
			left:0;
			right:0;
			margin:0 auto;
			border-bottom:0.01vh solid #000000;
		}
		.navi .option {
			position:fixed;
			top:26vh;
			left:1rem;
			right:1rem;
			margin:0 auto;
			width:80%;
			max-width : 550px;
			height : 8vh;
			display:grid;
			font-size:1rem;
			text-decoration: none;
			grid-template-rows : 6vh;
			grid-template-columns : 15% 5% 15% auto 20px 20px 15px 20%;
			grid-template-areas :
				"sh . eh . check1 check2 . research";
		}
		.navi .option .sh {
			width:100% !important;
			overflow:hidden;
			grid-area : sh;
			padding-left:0.5rem;
		}
		.navi .option .eh {
			width:100% !important;
			overflow:hidden;
			grid-area : eh;
			padding-left:0.5rem;
		}
		.navi .option .research {
			border-width:1px;
			border-color:var(--greenColor);
			border-radius:3px;
			background-color:var(--whiteColor);
			color:var(--greenColor);
			grid-area : research;
			width:100%;
			height:100%;
			font-size : 1rem;
			padding:0;
		}
		.navi .option .check1 {
			grid-area : check1;
			width:100%;
			height:100%;
		}
		.navi .option .check2 {
			grid-area : check2;
			width:100%;
			height:100%;
		}
		.navi .option .check1 input[type="radio"], .navi .option .check2 input[type="radio"] {
			display:none !important;
		}
		.navi .option .check1 span, .navi .option .check2 span {
			display:inline-block;
			padding : 15px 10px;
			margin:0;
			height:100%;
			border : 0;
			color:var(--blackColor);
			padding:auto;
			cursor:pointer;
		}
		.navi .option .check1 input[type="radio"]:checked+span, .navi .option .check2 input[type="radio"]:checked+span {
			color:var(--skyColor);
		}
		.chain_list {
			height : 50vh;
			padding:0;
			position:fixed;
			top:40vh;
			left:0;
			right:0;
			margin : 0 auto;
			overflow:scroll; 
			display:flex;
			flex-direction: column;
			align-items:center;
		}
		.chain_list::-webkit-scrollbar {
			display: none;
		}
	</style>
<body>
<?php
	$level=get_dict($_GET, "level", 0);
	$block=get_dict($_GET, "block", 0);
	$address=get_dict($_GET, "address", 0);
	$inout=get_dict($_GET, "inout", 0);
	$index=get_dict($_GET, "index", 0);
	$start=get_dict($_GET, "sh", 0);
	$end=get_dict($_GET, "eh", 100);
	$sor=get_dict($_GET, "sor", "inc");
?>

	<div class="wrap">
		<div class="navi">
			<div class="title">
				<p id="title" style="margin:0">
				</p>
			</div>
			<div class="bread">
				<ul>
					<li><button onclick='goup(0);'>체인</button></li>
					<?php
						if($level>=1) echo " > <li><button onclick='goup(1);'>블록</button></li>";
						if($level>=2) echo " > <li><button onclick='goup(2);'>거래</button></li>";
						if($level>=3) echo " > <li><button onclick='goup(3);'>계좌</button></li>";
						if($level>=4)
						{
							if($_GET['inout']=="inputs")
							{
								echo " > <li><button onclick='goup(4);'>입력</button></li>";
							}
							else echo " > <li><button onclick='goup(4);'>출력</button></li>";
						}
						if($level>=5) echo " > <li><button onclick='goup(5);'>번호</button></li>";
					?>
				</ul>
			</div>
			<input class="search" onkeyup="filter_list('chain_input', 'chain_list')" id="chain_input" type="text" placeholder="검색">
			<div class="option">
				<input class="sh" type="number" name="sh" id="sh" placeholder="시작">
				<input class="eh" type="number" name="eh" id="eh" placeholder="끝">
				<div class="check1">
				<label>
					<input type="radio" id="inc" name="sor" value="inc"></input>
					<span class="fa-solid fa-up-long"></span>
					</label>
				</div>

				<div class="check2">
				<label>
					<input type="radio" id="dec" name="sor" value="dec"></input>
					<span class="fa-solid fa-down-long"></span>
					</label>
				</div>
				<button class="research" id="research" onclick="refresh();" type="button">재탐색</button>
			</div>
		</div>
	</div>
	<div style="width:100%;margin-top:3rem;">
		<ul class="chain_list" id="chain_list">
		<?php
		//echo "{$level} {$start} {$end} {$block}";
		$query = "python3 /home/server/py/get_block.py {$sor} {$start} {$end}";
		if($level>=1) $query .=" {$block}";
		if($level>=2) $query .=" trans_list";
		if($level>=3) $query .=" {$address}";
		if($level>=4) $query .=" {$inout}";
		if($level>=5) $query .=" {$index}";
		$ret = shell_exec($query);
		$arr = json_decode($ret, 'true');
			foreach($arr as $key => $value)
			{
				$icon="";
				$event="";
				$nel=0;
				if(gettype($value)=="array")
				{
					if($level==0)
					{
						$value=$value['hash_cnt'];
						$key_name="block";
					}
					if($level==1)
					{
						$value="";
						$key_name="";
					}
					if($level==2)
					{
						$value=$value['public_key'];
						$key_name="address";
					}
					if($level==3)
					{
						$value="";
						$key_name="inout";
					}
					if($level==4)
					{
						$value=$value['mangtcoin'];	
						$key_name="index";
					}
					$nel = $level+1;
					$icon="fa-solid fa-magnifying-glass";
					$event="godown({$nel}, '{$key_name}', '{$key}');";
				}
			
				$key = substr($key, 0, 15);
				$value = substr((string)$value, 0, 15);
				$arr = array("key"=>$key,"value"=>$value,"icon"=>$icon,"event"=>$event);
				echo block_form($arr);
			}
		?>
		</ul>
	</div>
	<script>
	function get_query(){
		var url = document.location.href;
		var qs = url.substring(url.indexOf('?') + 1).split('&');
		for(var i = 0, result = {}; i < qs.length; i++){
			qs[i] = qs[i].split('=');
			result[qs[i][0]] = decodeURIComponent(qs[i][1]);
		}
		return result;
	}
	function get_value(arr, key, val) {
		if(arr.hasOwnProperty(key)&&arr[key]) return arr[key];
		return val;
	}
	
	function goup(level)
	{
		let param = get_query();
		let block = get_value(param, 'block', 1);
		let address = get_value(param, 'address', 1);
		let inout = get_value(param, 'inout', 1);
		let index = get_value(param, 'index', 1);
		let sh = get_value(param, 'sh', 0);
		let eh = get_value(param, 'eh', 100);
		if(level==-1) level=get_value(param, 'level', 0); 
		adr = "?level="+level+"&sh="+sh+"&eh="+eh;
		let sor = get_value(param, 'sor', 'inc');
		adr = adr+"&sor="+sor;
		if(level>=1) adr = adr+"&block="+block;
		if(level>=3) adr = adr+"&address="+address;
		if(level>=4) adr = adr+"&inout="+inout;
		if(level>=5) adr = adr+"&index="+index;
		location.href=adr;
	}
	function godown(level, key, value)
	{
		let param = get_query();
		if(key!="") param[key]=value;
		let block = get_value(param, 'block', 1);
		let address = get_value(param, 'address', 1);
		let inout = get_value(param, 'inout', 'inputs');
		let index = get_value(param, 'index', 0);
		let sh = get_value(param, 'sh', 0);
		let eh = get_value(param, 'eh', 100);
		if(level==-1) level=get_value(param, 'level', 0); 
		adr = "?level="+level+"&sh="+sh+"&eh="+eh;
		let sor = get_value(param, 'sor', 'inc');
		adr = adr+"&sor="+sor;
		if(level>=1) adr = adr+"&block="+block;
		if(level>=3) adr = adr+"&address="+address;
		if(level>=4) adr = adr+"&inout="+inout;
		if(level>=5) adr = adr+"&index="+index;
		location.href=adr;
	}
	function refresh()
	{
		let param=get_query();
		param['sh']=document.getElementById('sh').value;
		param['eh']=document.getElementById('eh').value;
		let sorli = document.getElementsByName('sor');
		sorli.forEach((node)=>{
			if(node.checked) {
				param['sor']=node.value;
			}
		});
		let block = get_value(param, 'block', 1);
		let address = get_value(param, 'address', 1);
		let inout = get_value(param, 'inout', 'inputs');
		let index = get_value(param, 'index', 0);
		let sh = get_value(param, 'sh', 0);
		let eh = get_value(param, 'eh', 100);
		let level=get_value(param, 'level', 0); 
		adr = "?level="+level+"&sh="+sh+"&eh="+eh;
		let sor = get_value(param, 'sor', 'inc');
		adr = adr+"&sor="+sor;
		if(level>=1) adr = adr+"&block="+block;
		if(level>=3) adr = adr+"&address="+address;
		if(level>=4) adr = adr+"&inout="+inout;
		if(level>=5) adr = adr+"&index="+index;
		location.href=adr;
	}
	window.addEventListener("load",function(){
		console.log("hi");
		let title = document.getElementById("title");
		let param=get_query();
		let level=get_value(param, 'level', 0);
		let sor=get_value(param, 'sor', 'inc');
		let sh=get_value(param, 'sh', 0);
		let eh=get_value(param, 'eh', 100);
		let val = "";
		if(level==0) val = "체인";
		else if(level==1) val = get_value(param, "block", "블록");
		else if(level==2) val = get_value(param, "block", "블록");
		else if(level==3) val = get_value(param, "address", "거래목록");
		else if(level==4) val = get_value(param, "inout", "입력");
		else if(level==5) val = get_value(param, "index", "거래");
		title.innerText=val.substr(0,10);
		document.getElementById('sh').placeholder=sh;
		document.getElementById('eh').placeholder=eh;
		console.log(document.querySelector('input[type=radio][value=inc]'));
		if(sor=="inc")
		{
			document.querySelector('input[type=radio][value=inc]').checked = true;
			document.querySelector('input[type=radio][value=dec]').checked = false;
		}
		else
		{
			document.querySelector('input[type=radio][value=dec]').checked = true;
			document.querySelector('input[type=radio][value=inc]').checked = false;
		}
	});
</script>
</body>
<?php 	include_once($_SERVER['DOCUMENT_ROOT']."/sidebar.php"); ?>
