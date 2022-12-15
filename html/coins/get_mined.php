<?php
	$minor_address=$_GET["minor_address"];
	$minor_public_key=$_GET["minor_public_key"];
	$minor_private_key=$_GET["minor_private_key"];
	$nonce=$_GET["nonce"];
	$ret = shell_exec("python3 /home/server/py/check_correct_mine.py {$minor_address} {$minor_public_key} {$minor_private_key} {$nonce}");
	echo $ret;
	if(strpos($ret,"good")!==False)
	{
		$ret = shell_exec("python3 /home/server/py/mine_block.py {$minor_address} {$minor_public_key} {$minor_private_key} {$nonce}");
		$ret = shell_exec("python3 /home/server/py/upload_block.py");
		$ret = shell_exec("cp /home/server/jsons/chain_block.json /var/www/html/temp/chain_block.json");
		$ret = shell_exec("cp /home/server/jsons/show_block.json /var/www/html/temp/show_block.json");
		

		echo "채굴 완료!";
	}
	else
	{
		echo "채굴 실패!";
	}
?>