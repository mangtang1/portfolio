<?php 
	function getkey($arr, $name, $val) {
		if(array_key_exists($name, $arr)) return $arr[$name];
		else return $val;
	}
	function get_wallets($arr)
	{
	$db_conn = mysqli_connect("localhost", "userman", "bigbrother", "service");
		$userid=getkey($arr,"userid", "%");
		$head=getkey($arr,"head","<div class=\"libo\"><label style=\"width:100%;\">");
		$foot=getkey($arr,"foot","</label></div>");
		$event=getkey($arr,"event","");
		$show_utxo=getkey($arr,"show_utxo",1);
		$show_userid=getkey($arr,"show_userid",0);
		$show_address=getkey($arr,"show_address",1);
		$show_comment=getkey($arr,"show_comment",1);
		$icon=getkey($arr,"icon","fa-regular fa-hand-pointer");
		$ret = "";

		$query = "SELECT * FROM wallet_info where userid like ?;";

		$stmt = mysqli_prepare($db_conn,$query);
		$bind = mysqli_stmt_bind_param($stmt, "s", $userid);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);					
		while($row = mysqli_fetch_assoc($result)) {
			$query2 = "SELECT * FROM utxo where address = ?;";
			$stmt2 = mysqli_prepare($db_conn,$query2);
			$bind = mysqli_stmt_bind_param($stmt2, "s", $row['address']);
			mysqli_stmt_execute($stmt2);
			$result2 = mysqli_stmt_get_result($stmt2);	
			$utxo=0;
			while($row2 = mysqli_fetch_assoc($result2)) {
				$utxo+=$row2['mangtcoin'];
			}
			$ret.= $head;
			if($show_address==1)
			{
				$temp=substr($row['address'],20);
				$ret.= "<h5>{$temp}</h5>";
			}
			if($show_userid==1) $ret.= "<h6>{$row['userid']}</h6>";
			if($show_utxo==1) $ret.= "<h6>UTXO : {$utxo}</h6>";
			if($show_comment==1) $ret.= "<h6>{$row['comment']}</h6>";
			$ret.= sprintf("<button class=\"icon\" onclick=\"{$event}\"><i class=\"{$icon}\" style=\"font-size:1.5rem;\"></i></button>",$row['address']) ;
			$ret.= $foot;
		}
		mysqli_free_result($result);
		return $ret;
	}
	function block_form($arr)
	{
		$key=getkey($arr,"key",1);
		$val=(string)getkey($arr,"value",1);
		$event=getkey($arr,"event",1);
		$icon=getkey($arr,"icon",1);
		if($icon=="") $but="";
		else $but='<button type="submit"  class="icon" onclick="'.$event.'"><i class="'.$icon.'"style="font-size:1.5rem;"></i></button>';
		return '<div class="libo"><label  style="width:100%"><h5>'.$key.'</h5><h6>'.$val.'</h6>'.$but.'</label></div>';
	}
?>
