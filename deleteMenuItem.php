<!DOCTYPE html>
<!--
Title: deleteMenuItem.php
Author: Ashley Schaar
Date: 4-23-2015
For Project: CIS 355 Individual Project
-->

<?php
    require 'database.php';
    $id = null;
	
	// Preserve id passed from index.php
    if ( !empty($_GET['id'])) {
        $id = $_GET['id'];
    }
	
    if ( !empty($_POST)) {
        // keep track post values
        $id = $_GET['id'];
	
        // delete data
		$pdo = Database::connect();
		echo "DB connected";
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		echo "Attribute Set";
        $sql = 	"DELETE FROM recipe WHERE menuItem_id = ".$id."; DELETE FROM menuItem WHERE id = ".$id;
		echo "SQL written";
		$stm = $pdo->prepare($sql);
		echo "SQL Prepared";
		$stm->execute();
		echo "SQL executed";
        
        Database::disconnect();
        header("Location: index.php");
    }
?>
<html lang="en">
<head>
    <meta charset="utf-8">
	<!--Using Bootstrap Elements-->
    <link   href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	<?php
		session_start();
		if ($_SESSION["id"] != "loggedin") {
			header("Location: index.php");
		}		
	?>
</head>
<body>				
	<!--Give option to confirm or cancel record deletion-->
    <div class="container">
		<div class="span10 offset1">
			<div class="row">
				<h3>Delete a Menu Item</h3>
			</div>
			 <?php
				echo '<form class="form-horizontal" action="deleteMenuItem.php?id='.$id.'" method="post">';
			?>
				<input type="hidden" name="Can't find me" value="Can't touch dis">
			  <p class="alert alert-error">Are you sure to delete ?</p>
			  <div class="form-actions">
				 <br>
					<button type="submit" class="btn btn-danger">Yes</button>
					<a href="index.php" class="btn btn-info">No</a>
				</div>
			</form>
		</div>
                 
    </div> 
  </body>
</html>