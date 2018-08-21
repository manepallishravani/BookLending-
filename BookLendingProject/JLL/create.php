<?php
	require_once("core.php");
	session_start();
	if(!validate_session($conn))header("location: signin.php");
	$sql = 'SELECT * FROM users WHERE UserID = "'.$_SESSION['id'].'"';
	$result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
	global $firstName;
	global $lastName;
	while($row = mysqli_fetch_array($result))
	{
		$firstName = $row['FirstName'];
		$lastName = $row['LastName'];
	} 
	$fullName=$firstName." ".$lastName;
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Add new Book - JLL</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Add custom CSS here -->
    <link href="css/sb-admin.css" rel="stylesheet">
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
  </head>

  <body>

    <div id="wrapper">

      <!-- Sidebar -->
      <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">JLL</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
          <ul class="nav navbar-nav side-nav">
            <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
            <li class="active"><a href="create.php"><i class="fa fa-plus"></i> Add a Book</a></li>
          </ul>

          <ul class="nav navbar-nav navbar-right navbar-user">
            <li class="dropdown alerts-dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> Alerts <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a class="text-muted"><i>Empty</i></a></li>
              </ul>
            </li>
            <li class="dropdown user-dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo($fullName); ?> <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="#"><i class="fa fa-user"></i> Profile</a></li>
                <li><a href="#"><i class="fa fa-gear"></i> Settings</a></li>
                <li class="divider"></li>
                <li onclick="logout()"><a href="#"><i class="fa fa-power-off"></i> Log Out</a></li>
              </ul>
            </li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </nav>

      <div id="page-wrapper">

        <div class="row">
          <div class="col-lg-12">
            <h1>Home Page</h1>
            <ol class="breadcrumb">
              <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
              <li class="active"><i class="fa fa-plus"></i> Create</li>
            </ol>
          </div>
          
         
          <div class="col-lg-12">
          <?php if(isset($_REQUEST['error'])){
          	
          		if($_REQUEST['error']==0)
				{
					echo('<div class="alert alert-success alert-dismissable">');
				}
				else
				{
					echo('<div class="alert alert-danger alert-dismissable">');
				}
		  		echo('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>');
				if($_REQUEST['error']==1)
				{
					echo('The ISBN number you entered was invalid or wasnt found in the database. Please try using manual mode.');
				}
				elseif($_REQUEST['error']==0)
				{
					echo('The book has been succesfully added to the library.');
				}
		  }
          ?>
          	</div>
          	<div class="panel panel-primary">
          		<div class="panel-heading"><h3 class="panel-title"><i class="fa fa-plus"></i> Upload new Book</h3></div>
          		<div class="panel-body">
          			<ul class="nav nav-tabs">
          				<li class="active"><a href="#isbn" data-toggle="tab">Add Book By ISBN Number</a></li>
          				<li><a href="#manual" data-toggle="tab">Add Book Information Manually</a></li>
          			</ul>
          			<div class="tab-content">
          				<div class="tab-pane active fade in" id="isbn">
          					<form role="form" action="create_script.php" method="post">
          						<input name="mode" type="hidden" value="0" />
		          				<div class="form-group">
		          					<label>ISBN Number (10 or 13 digits)</label>
		          					<input name="isbn" type="text" class="form-control" placeholder="Do not include the dashes in the number"/>
		          					<p class="help-block">The ISBN number is usually found above or below the barcode.<br/> You can also usally find it on the page that has all the copyright info.<br/>Both the 10 digit and 13 digit ISBN codes will work.</p>
		          				</div>
		          				<input type="submit" value="Add" class="btn btn-default"/>
		          			</form>
          				</div>
          				<div class="tab-pane fade" id="manual">
          					<p>This feature is not yet available. Please use ISBN.</p>
          				</div>
          			</div>
          		</div>
          	</div>
          </div>
        </div><!-- /.row -->

      </div><!-- /#page-wrapper -->

    </div><!-- /#wrapper -->

    <!-- JavaScript -->
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.js"></script>
    <script type="text/javascript">
    	var xmlhttp;
    	
    	function logout(){
    		xmlhttp = new XMLHttpRequest();
    		xmlhttp.onreadystatechange = callback;
    		xmlhttp.open("POST", "logout.php", true);
    		xmlhttp.send();
    	}
    	
    	function callback()
    	{
    		if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
    		{
    			window.location.replace("signin.php");
    		}
    	}
    </script>
    <script src="js/tablesorter/jquery.tablesorter.js"></script>
    <script src="js/tablesorter/tables.js"></script>

  </body>
</html>
