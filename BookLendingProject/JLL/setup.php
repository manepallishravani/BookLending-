<?php
	if(isset($_REQUEST['un']))
	{
		//Put info into settings file for core.php to use
		$info = array('db_name' => $_REQUEST['db_name'],
							'un' => $_REQUEST['un'],
							'ps' => $_REQUEST['ps'],
							'host' => $_REQUEST['host'],
							'debug_mode' => "FALSE"
							 );
		$json = json_encode($info);
		file_put_contents('settings.json', $json);
		
		//Connect to MySQL and create database
		$conn = mysqli_connect($_REQUEST['host'], $_REQUEST['un'], $_REQUEST['ps']) or die (mysqli_error($conn));
		mysqli_query($conn,"CREATE DATABASE IF NOT EXISTS " . $_REQUEST['db_name']) or die(mysqli_error($conn));
		mysqli_select_db($conn,$_REQUEST['db_name']) or die(mysqli_error($conn));
		$sql = "			
				DROP TABLE IF EXISTS `Users`;
						
				CREATE TABLE `Users` (
				  `UserID` INT NOT NULL AUTO_INCREMENT DEFAULT NULL,
				  `Username` MEDIUMTEXT NULL DEFAULT NULL,
				  `Password` MEDIUMTEXT NULL DEFAULT NULL,
				  `FirstName` MEDIUMTEXT NULL DEFAULT NULL,
				  `LastName` MEDIUMTEXT NULL DEFAULT NULL,
				  `Email` MEDIUMTEXT NULL DEFAULT NULL,
				  `City` MEDIUMTEXT NULL DEFAULT NULL,
				  `Street` MEDIUMTEXT NULL DEFAULT NULL,
				  `AddressNum` TINYINT NULL DEFAULT NULL,
				  `UploadedBooks` INT NULL DEFAULT NULL,
				  `BorrowedBooks` INT NULL DEFAULT NULL,
				  `LendingStars` INT NULL DEFAULT NULL,
				  `BorrowingStars` INT NULL DEFAULT NULL,
				  PRIMARY KEY (`UserID`)
				);
				
				DROP TABLE IF EXISTS `Library`;
						
				CREATE TABLE `Library` (
				  `LibraryID` INT NULL AUTO_INCREMENT DEFAULT NULL,
				  `BookID` INT NULL DEFAULT NULL,
				  `OwnerID` INT NULL DEFAULT NULL,
				  `LendedTo` INT NULL DEFAULT NULL,
				  `LendedTime` TIMESTAMP NULL DEFAULT NULL,
				  PRIMARY KEY (`LibraryID`)
				);
				
				DROP TABLE IF EXISTS `Books`;
						
				CREATE TABLE `Books` (
				  `ID` INT NULL AUTO_INCREMENT DEFAULT NULL,
				  `Title` MEDIUMTEXT NULL DEFAULT NULL,
				  `Author` MEDIUMTEXT NULL DEFAULT NULL,
				  `Publisher` MEDIUMTEXT NULL DEFAULT NULL,
				  `ISBN10` MEDIUMTEXT NULL DEFAULT NULL,
				  `ISBN13` MEDIUMTEXT NULL DEFAULT NULL,
				  `Genre` MEDIUMTEXT NULL DEFAULT NULL,
				  PRIMARY KEY (`ID`)
				);
				
				DROP TABLE IF EXISTS `Requests`;
						
				CREATE TABLE `Requests` (
				  `RequestID` INT NULL AUTO_INCREMENT DEFAULT NULL,
				  `ReqLibraryID` INT NULL DEFAULT NULL,
				  `RequesterID` INT NULL DEFAULT NULL,
				  `ReqBookOwnerID` INT NULL DEFAULT NULL,
				  `Time` TIMESTAMP NULL DEFAULT NULL,
				  `QueueIndex` INT NULL DEFAULT NULL,
				  `Status` INT NULL DEFAULT NULL COMMENT '0:Requsted 1:Approved 2:Currently Borrowed 3:Returned',
				  PRIMARY KEY (`RequestID`)
				);
				
				ALTER TABLE `Library` ADD FOREIGN KEY (BookID) REFERENCES `Books` (`ID`);
				ALTER TABLE `Library` ADD FOREIGN KEY (OwnerID) REFERENCES `Users` (`UserID`);
				ALTER TABLE `Requests` ADD FOREIGN KEY (ReqLibraryID) REFERENCES `Library` (`LibraryID`);
				ALTER TABLE `Requests` ADD FOREIGN KEY (RequesterID) REFERENCES `Users` (`UserID`);
				ALTER TABLE `Requests` ADD FOREIGN KEY (ReqBookOwnerID) REFERENCES `Users` (`UserID`)
				
				";
				//echo $sql;
				mysqli_multi_query($conn,$sql) or die(mysqli_error("An error has ocurred while installing the database:<br>".$conn));
				mysqli_close($conn);
				$success = true;
	}
?>
<html>
	<header></header>
	<body>
		<?php
		if (isset($success))
		{
			echo "Database installed!";
		}
		else
		{
			echo '<form method="post" action="setup.php">
			  	<table border="0">
			  	<tr>
			  		<td>Databse Name: </td>
			  		<td><input type="text" name="db_name" /></td></tr>
			  	<tr>
			  		<td>MySQL Username: </td>
			  		<td><input type="text" name="un" /></td>
			  	</tr>
			  	<tr>
			  		<td>MySQL Password: </td>
			  		<td><input type="password" name="ps" /></td>
			  	</tr>
			  	<tr>
			  		<td>MySQL Host: </td>
			  		<td><input type="text" name="host" /></td>
			  	</tr>
			  	<tr><td colspan="2"><input type="submit" value="Install!"/></td></tr>
			  	</table>
			  </form>';
		  }
	  	?>
	  
	</body>
</html>