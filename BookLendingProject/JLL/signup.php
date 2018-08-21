<?php
	require_once("core.php");
	if(isset($_REQUEST['un']) and isset($_REQUEST['ps']))
	{
		$un = $_REQUEST['un'];
		$ps = $_REQUEST['ps'];
		$fn = $_REQUEST['fn'];
		$ln = $_REQUEST['ln'];
		$em = $_REQUEST['em'];
		$ci = $_REQUEST['ci'];
		$st = $_REQUEST['st'];
		$hn = $_REQUEST['hn'];
		$sql = 'INSERT INTO Users VALUES (
										 "",
										 "'.$un.'",
										 "'.hash("sha256",$ps).'",
										 "'.$fn.'",
										 "'.$ln.'",
										 "'.$em.'",
										 "'.$ci.'",
										 "'.$st.'",
										 "'.$hn.'",
										 "",
										 "",
										 "",
										 ""
										 
										  )';
		if(mysqli_query($conn, $sql))
		{
			session_login($un, $ps, $conn);
			header("location: index.php");
		}
		else {
			header("location: signup.php?error=1");
		}
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

    <title>Signin Template for Bootstrap</title>

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
		<div class="alert alert-success alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			An unexpected error has ocurred. <?php mysqli_error($conn) ?>
		</div>
      <form class="form-signin" role="form" method="post" action="signup.php">
        <h2 class="form-signin-heading">Please sign up</h2>
        <input name="un" type="text" maxlength="20" class="form-control topbox" placeholder="Username(Up to 20 characters)" required autofocus>
        <input name="ps" type="password" class="form-control middlebox" placeholder="Password" required>
        <input name="fn" type="text" class="form-control middlebox" placeholder="First Name" required>
        <input name="ln" type="text" class="form-control middlebox" placeholder="Last Name" required>
        <input name="em" type="email" class="form-control middlebox" placeholder="Email" required>
        <input name="ci" type="text" class="form-control middlebox" placeholder="City" required>
        <input name="st" type="text" class="form-control middlebox" placeholder="Street" required>
        <input name="hn" type="text" class="form-control bottombox" placeholder="House Number" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign Up!</button>
        <a href="signin.php" class="btn btn-primary help-block btn-block" role="button">Sign In</a>
      </form>
    </div> <!-- /container -->


  </body>
</html>
