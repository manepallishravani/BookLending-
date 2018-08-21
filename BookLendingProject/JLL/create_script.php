<?php
	require_once("core.php");
	session_start();
	if($_REQUEST['mode'] == 0)
	{
		$bookisbn = $_REQUEST['isbn'];
		if(strlen($bookisbn)==10)
		{
			$sql = "SELECT * FROM `books` WHERE `ISBN10` = ".$bookisbn;
		}
		elseif(strlen($bookisbn)==13)
		{
			$sql = "SELECT * FROM `books` WHERE `ISBN13` = ".$bookisbn;
		}
		else
		{
			die("An unexpected error has ocurred, go back to <a href='index.php'>homepage</a>.");			
		}
		$result = mysqli_query($conn,$sql) or die(mysqli_error($conn));
		$row = mysqli_fetch_array($result);
		if(isset($row))
		{
				$sql = 'INSERT INTO `library` VALUES(
													"",
													"'.$row['ID'].'",'.
													'"'.$_SESSION['id'].'",
													"'.$_SESSION['id'].'",""
													)';
				mysqli_query($conn, $sql);
				header("location:index.php?error=0");
		}
		else
		{
			$json = file_get_contents("http://isbndb.com/api/v2/json/33BNPPTM/book/".$bookisbn);
			$info = json_decode($json,true);
			var_dump($info['data']);
			if(!isset($info['error']))
			{
				if(isset($info['data'][0]['title']))
				{
					$title = $info['data'][0]['title'];
					if(isset($info['data'][0]['author_data'][0]['name'])){$author = $info['data'][0]['author_data'][0]['name'];}else{$author="";}
					if(isset($info['data'][0]['publisher_text'])){$publisher = $info['data'][0]['publisher_text'];}else{$publisher="";};
					$isbn10 = $info['data'][0]['isbn10'];
					$isbn13 = $info['data'][0]['isbn13'];
					$sql = 'INSERT INTO `books` VALUES ("","'.$title.'","'.$author.'","'.$publisher.'","'.$isbn10.'","'.$isbn13.'","")';
					mysqli_query($conn, $sql) or die($conn);
					if(strlen($bookisbn)==10)
					{
						echo("test1");
						$sql = "SELECT * FROM `books` WHERE `ISBN10` = ".$bookisbn;
					}
					elseif(strlen($bookisbn)==13)
					{
						echo("test2");
						$sql = "SELECT * FROM `books` WHERE `ISBN13` = ".$bookisbn;
					}
					else
					{
						die("An unexpected error has ocurred, go back to <a href='index.php'>homepage</a>.");			
					}
					$result = mysqli_query($conn,$sql) or die(mysqli_error($conn));
					$row = mysqli_fetch_array($result);
					if(isset($row))
					{
						$sql = 'INSERT INTO `library` VALUES(
															"",
															"'.$row['ID'].'",'.
															'"'.$_SESSION['id'].'",
															"'.$_SESSION['id'].'",""
															)';
						mysqli_query($conn, $sql) or die(mysqli_error($conn));
						header("location:create.php?error=0");
					}
					else {
						die("An unexpected error has ocurred, go back to <a href='index.php'>homepage</a>.");
					}
				}
				else
				{
					header("location:create.php?error=1&suberror=2");
				}
				
			}
			else
			{
				header("location:create.php?error=1&suberror=3");
			}
		}
	}
	else 
	{
		
	}
?>