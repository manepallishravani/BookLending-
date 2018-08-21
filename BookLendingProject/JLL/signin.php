<?php
	require_once("core.php");
	session_start();
	$fillun = "";
	$fillps = "";
	$fillchecked = "false";
	if(isset($_REQUEST['un']) and isset($_REQUEST['ps']))
	{
		$un = $_REQUEST['un'];
		$ps = $_REQUEST['ps'];
		if(session_login($un, $ps, $conn, FALSE, TRUE))
		{
			if(isset($_REQUEST['remember']))
			{
				setcookie("un", $un, strtotime('+1Year'));
				setcookie("ps", $ps, strtotime('+1Year'));
			}
			else {
				setcookie("un", $un, strtotime('-1Year'));
				setcookie("ps", $ps, strtotime('-1Year'));
			}
			header("location:index.php");
		}
	}
	elseif (isset($_SESSION['un']) and isset($_SESSION['ps'])) {
		$un = $_SESSION['un'];
		$ps = $_SESSION['ps'];
		if(session_login($un, $ps, $conn, TRUE, TRUE))
		{
			header("location:index.php");
		}
	}
	
	elseif(isset($_COOKIE['un']) and isset($_COOKIE['ps']))
	{
		$fillun = $_COOKIE['un'];
		$fillps = $_COOKIE['ps'];
		$fillchecked = "true";
	}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Signin to JLL</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/signin.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">

      <form class="form-signin" role="form" method="post" action="signin.php">
        <h2 class="form-signin-heading">Please sign in</h2>
        <input name="un" type="text" class="form-control topbox" placeholder="Username" required autofocus value="<?php echo $fillun; ?>">
        <input name="ps" type="password" class="form-control bottombox" placeholder="Password" required value="<?php echo $fillps; ?>">
        <label class="checkbox">
          <input type="checkbox" name="remember" checked="<?php echo $fillchecked; ?>"> Remember me (Requires cookies and expires after 1 year)
        </label>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
        <a href="signup.php" class="btn btn-primary help-block btn-block" role="button">Sign Up</a>
      </form>
    </div> <!-- /container -->


  </body>
</html>
