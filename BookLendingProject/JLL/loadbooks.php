<?php
	require_once("core.php");
	session_start();
	if($_REQUEST['mode']=="allbooks")
	{
		$sql="SELECT `BookID`, `LibraryID`, `OwnerID`, books.`Title`, books.`Author`, books.`Publisher`, books.`Genre`, users_a.`FirstName` AS `FirstNameA`, users_a.`LastName` AS `LastNameA`, users_a.`City` AS `CityA`, users_b.`FirstName` AS `FirstNameB`, users_b.`LastName` AS `LastNameB`, `LendedTo` FROM `library` INNER JOIN books ON `books`.`ID`=library.`BookID` INNER JOIN users AS users_a ON users_a.`UserID`=library.`OwnerID` INNER JOIN users AS users_b ON users_b.`UserID`=library.`LendedTo` LIMIT 30";
		$info = mysqli_query($conn, $sql) or die(mysqli_error($conn));
		echo('<table class="table table-bordered table-hover table-striped tablesorter"><thead><tr>');
		if($deco_json['debug_mode'] == "TRUE")echo('<th class="header">ID<i class="fa fa-sort" style="float: right"></i></th>');
		echo('<th class="header">Title<i class="fa fa-sort" style="float: right"></i></th>
		<th class="header">Author<i class="fa fa-sort" style="float: right"></i></th>
		<th class="header">Publisher<i class="fa fa-sort" style="float: right"></i></th>
		<th class="header">Genre<i class="fa fa-sort" style="float: right"></i></th>
		<th class="header">Owner Name<i class="fa fa-sort" style="float: right"></i></th>
		<th class="header">Owner City<i class="fa fa-sort" style="float: right"></i></th>
		<th class="header">Lended To<i class="fa fa-sort" style="float: right"></i></th></tr></thead><tbody>');
		while($row = mysqli_fetch_array($info))
		{
			echo("<tr>");
				if($deco_json['debug_mode'] == "TRUE")echo("<td>".$row['LibraryID']);
				echo("<td>".$row['Title']."</td>
				<td>".$row['Author']."</td>
				<td>".$row['Publisher']."</td>
				<td>".$row['Genre']."</td>
				<td>".$row['FirstNameA']." ".$row['LastNameA']."</td>
				<td>".$row['CityA']."</td>");
				if($row['LendedTo']!=$row['OwnerID'])echo("<td>".$row['FirstNameB']." ".$row['LastNameB']."</td>");else echo("<td></td>");
				echo("</tr>");
		}
		echo("</tbody></table>");
	}
	elseif ($_REQUEST['mode']=="mybooks") {
		$sql="SELECT `BookID`, `LibraryID`, `OwnerID`, books.`Title`, books.`Author`, books.`Publisher`, books.`Genre`, users_a.`FirstName` AS `FirstNameA`, users_a.`LastName` AS `LastNameA`, users_a.`City` AS `CityA`, users_b.`FirstName` AS `FirstNameB`, users_b.`LastName` AS `LastNameB`, `LendedTo` FROM `library` INNER JOIN books ON `books`.`ID`=library.`BookID` INNER JOIN users AS users_a ON users_a.`UserID`=library.`OwnerID` INNER JOIN users AS users_b ON users_b.`UserID`=library.`LendedTo` WHERE `OwnerID` = '".$_SESSION['id']."' LIMIT 30";
		$info = mysqli_query($conn, $sql) or die(mysqli_error($conn));
		echo('<table class="table table-bordered table-hover table-striped tablesorter"><thead><tr>');
		if($deco_json['debug_mode'] == "TRUE")echo('<th class="header">ID<i class="fa fa-sort" style="float: right"></i></th>');
		echo('<th class="header">Title<i class="fa fa-sort" style="float: right"></i></th>
		<th class="header">Author<i class="fa fa-sort" style="float: right"></i></th>
		<th class="header">Publisher<i class="fa fa-sort" style="float: right"></i></th>
		<th class="header">Genre<i class="fa fa-sort" style="float: right"></i></th>
		<th class="header">Lended To<i class="fa fa-sort" style="float: right"></i></th>
		<th>Options</th></tr></thead><tbody>');
		while($row = mysqli_fetch_array($info))
		{
			echo("<tr>");
				if($deco_json['debug_mode'] == "TRUE")echo("<td>".$row['LibraryID']);
				echo("<td>".$row['Title']."</td>
				<td>".$row['Author']."</td>
				<td>".$row['Publisher']."</td>
				<td>".$row['Genre']."</td>");
				if($row['LendedTo']!=$row['OwnerID'])echo("<td>".$row['FirstNameB']." ".$row['LastNameB']."</td>");else echo("<td></td>");
				echo("<td><button onclick='editedrow=".$row['LibraryID']."' class='btn btn-primary' data-toggle='modal' data-target='#editModal'><i class='fa fa-pencil-square-o'></i></button></td></tr>");
		}
		echo("</tbody></table>");
	}
	elseif ($_REQUEST['mode']=="editform") {
		$sql="SELECT `BookID`, books.`ISBN13`, `LibraryID`, `OwnerID`, books.`Title`, books.`Author`, books.`Publisher`, books.`Genre`, users_a.`FirstName` AS `FirstNameA`, users_a.`LastName` AS `LastNameA`, users_a.`City` AS `CityA`, users_b.`FirstName` AS `FirstNameB`, users_b.`LastName` AS `LastNameB`, `LendedTo` FROM `library` INNER JOIN books ON `books`.`ID`=library.`BookID` INNER JOIN users AS users_a ON users_a.`UserID`=library.`OwnerID` INNER JOIN users AS users_b ON users_b.`UserID`=library.`LendedTo` WHERE `LibraryID` = '".$_REQUEST['editedid']."' LIMIT 30";
		$info = mysqli_query($conn, $sql) or die(mysqli_error($conn));
		while($row = mysqli_fetch_array($info))
		{
			echo('
				<form role="form" action="edit_script.php" method="post">
				<div class="form-group">
					<label>Enter new isbn: (10 or 13 digits)</label>
					<input name="isbn" type="text" class="form-control" placeholder="Do not include the dashes in the number" value='.$row['ISBN13'].'>
					<p class="help-block">The ISBN number is usually found above or below the barcode.<br> You can also usally find it on the page that has all the copyright info.<br>Both the 10 digit and 13 digit ISBN codes will work.</p>
				</div>
				<input type="submit" class="btn btn-primary" value="Save changes"></input>
				</form>
			');
		}
	}
?>