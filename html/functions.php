<?php
	$py_path = "/home/server/py";
	function chk_escape($val)
	{
		return preg_match('/\.|\,|\(|\)|\'|\"|\ |\#/i', $val);
	}
	function get_dict($arr, $key, $val)
	{
		if(isset($arr[$key])&&$arr[$key]) return $arr[$key];
		return $val;
	}
	function redir_page($redir_url, $redir_value)
	{
		$redir_values = explode("&",$redir_value);
		$redir_values_count=count($redir_values);
		$redir_values_num=0;
		
		$ret = "<form name='redir_form' action='$redir_url' method='post'>";
		
		while($redir_values_num < $redir_values_count){
			$redir_var = explode("=",$redir_values[$redir_values_num]);
			$ret .= "<input type='hidden' name='{$redir_var[0]}' value='{$redir_var[1]}'>";
			
			$redir_values_num=$redir_values_num+1;
		}
		
		$ret .= "</form><script language='javascript'> document.redir_form.submit();</script>";
		return $ret;
	}
	function gopage($mes, $url)
	{
		if($mes!="")
		{
			echo "
			<script>
				alert('{$mes}');
			</script>";
		}
		echo " <script>
		location.href = '{$url}';
		</script>";
		exit;
	}
	function get_block_setting($tar = "all")
	{
		$path = "/home/server/jsons/setting_block.json";
		$json_string = file_get_contents($path);
		$arr = json_decode($json_string, true);
		if($tar=='all') return $arr;
		else return $arr[$tar];
	}
	function get_secret()
	{
		$keys = func_get_args();
		$cnt = func_num_args();
		$path = "/home/server/keys/key.json";
		$json_string = file_get_contents($path);
		$arr = json_decode($json_string, true);
		for($i=0;$i<$cnt;$i++)
		{
			$arr = $arr[$keys[$i]];
		}
		return $arr;
	}
	function db_connect($name)
	{
	  $arr=get_secret($name);
	  $db_conn = mysqli_connect($arr['host'], $arr['user'], $arr['password'], $arr['db']);
	  return $db_conn;
	}
?>