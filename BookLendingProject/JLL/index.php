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

    <title>Home Page - JLL</title>

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
            <li class="active"><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
            <li><a href="create.php"><i class="fa fa-plus"></i> Add a Book</a></li>
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
              <li class="active"><i class="fa fa-home"></i> Home</li>
            </ol>
          </div>
          
          <div class="col-lg-12">
          	<div class="panel panel-primary">
          		<div class="panel-heading"><h3 class="panel-title"><i class="fa fa-book"></i> Book Library</h3></div>
          		<div class="panel-body">
          			<div id="all-books">
          				<img src="images/ajax-loader.gif" alt="Loading..."/>
          			</div>
          		</div>
          	</div>
          </div>
          
          <div class="col-lg-12">
          	<div class="panel panel-primary">
          		<div class="panel-heading"><h3 class="panel-title"><i class="fa fa-book"></i> Your Books</h3></div>
          		<div class="panel-body">
          			<div id="my-books">
          				<img src="images/ajax-loader.gif" alt="Loading..."/>
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
    	
    	$.ajaxSetup({
    		cache: false
    	});
    	
    	$(document).ready(function(){
    		$('#all-books').load("loadbooks.php", {mode: "allbooks"});
    		$('#my-books').load("loadbooks.php", {mode: "mybooks"});
    	});
    </script>
    <script src="js/tablesorter/jquery.tablesorter.js"></script>
    <script src="js/tablesorter/tables.js"></script>
	
	
	<!-- Editing Modal -->
	<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h4 class="modal-title" id="editModalLabel">Edit row</h4>
	      </div>
	      <div class="modal-body">
	        
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	<script type="text/javascript">
		var editedrow = 0;
		$('#editModal').on('shown.bs.modal', function (e) {
			$.post("loadbooks.php", {mode: "editform",editedid: editedrow}, function(data){
				console.log(data);
				$(".modal-body").html(data);
			});
		});
	</script>
  </body>
</html>
