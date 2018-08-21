<?php

	$json = file_get_contents("settings.json");
	$deco_json = json_decode($json, true);
    $db_name = $deco_json['db_name'];
    $un = $deco_json['un'];
    $pw = $deco_json['ps'];
    $host = $deco_json['host'];
    
    $conn = mysqli_connect($host, $un, $pw) or die (mysqli_error($conn));
    
    mysqli_select_db($conn, $db_name) or die(mysqli_error($conn));

	function session_login($un, $ps, $conn, $hashed = false, $dontStart = FALSE)
	{
		if(!$dontStart)session_start();
		if($hashed){
			$sql = 'SELECT * FROM Users WHERE Username ="' . $un .'" and Password = "'. $ps . '"';
		}else{
			$sql = 'SELECT * FROM Users WHERE Username ="' . $un .'" and Password = "'. hash("sha256", $ps) . '"';			
		}
		$info = mysqli_query($conn, $sql) or die(mysqli_error($conn));
		global $rowUn;
		global $rowPs;
		global $id;
		while($row = mysqli_fetch_array($info))
		{
			$rowUn = $row['Username'];
			$rowPs = $row['Password'];
			$id = $row['UserID'];
		}
		if(isset($rowUn) and isset($rowPs))
		{
			if($rowUn!="" and $rowPs!="")
			{
				$_SESSION['un'] = $rowUn;
				$_SESSION['ps'] = $rowPs;
				$_SESSION['token'] = session_id();
				$_SESSION['id'] = $id;
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
		else {
			return FALSE;
		}
		
	}
	
	function validate_session($conn)
	{
		if(isset($_SESSION['un']) and isset($_SESSION['ps']))
		{
			$user = $_SESSION['un'];
			$pswd = $_SESSION['ps'];
			if(session_login($user, $pswd, $conn, TRUE, TRUE))
			{
				return TRUE;
			}
			else {
				return FALSE;
			}
		}
		else {
			return FALSE;
		}
	}
	
?>