<?php			
    $db_conn = db_connect('user');
    if($_SERVER["REQUEST_METHOD"]!='GET') gopage("잘못된 전송 방식입니다.","/index.php");
    if(!isset($_GET["userid"])||!isset($_GET["userpw"])||!isset($_GET["walletpw"]))
    {
        echo "wrong";
        exit;
    }
    $id = $_GET["userid"];
    $userpw = hash("sha256", $_GET['userpw']);
    $walletpw = hash("sha256", $_GET['walletpw']);
    $query = "SELECT * from users where id = ? and pass = ?";
    $stmt = mysqli_prepare($db_conn,$query);
    mysqli_stmt_bind_param($stmt, "ss", $id, $userpw);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);	
    if(mysqli_num_rows($result)==0)
    {
        echo "wrong id and user password";
        exit;
    }
    
    $query = "SELECT address from wallet_info where userid = ? and password = ?;";
    $stmt = mysqli_prepare($db_conn,$query);
    mysqli_stmt_bind_param($stmt, "ss", $id, $walletpw);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);					
    if(mysqli_num_rows($result)==0)
    {
        echo "wrong id or wallet password";
        exit;
    }
    
    $row = mysqli_fetch_assoc($result);
    $address = $row["address"];
    $query = "SELECT public_key, private_key FROM wallets where wallet_address = ? and password = ?;";

    $stmt = mysqli_prepare($db_conn,$query);
    mysqli_stmt_bind_param($stmt, "ss", $address, $walletpw);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);					
    $row = mysqli_fetch_assoc($result);
    
    echo "{$address} {$row["public_key"]} {$row["private_key"]}";
    
    mysqli_free_result($result);
    mysqli_stmt_close($stmt);
    mysqli_close($db_conn);
?>