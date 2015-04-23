<!DOCTYPE html>
<!--
Title: view.php
Author: Ashley Schaar
Date: 4-23-2015
For Project: CIS 355 Individual Project
-->
<?php
    require 'database.php';
	
	//Preserve id passed from index.php
    $id = null;
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
		//Pull item from menuItem table with Primary Key that matches ID
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM menuItem where id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        Database::disconnect();
?>
 
<html lang="en">
<head>
    <meta charset="utf-8">
	<!--Using Bootstrap Elements-->
    <link   href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	<?php
		session_start();
	?>
</head>
 
<body>
    <div class="container">
     <!--Display name, price, and description of menuItem-->
        <div class="span10 offset1">
            <div class="row">
                <h3>Menu Details</h3>
            </div>
            <div class="form-horizontal" >
                <div class="control-group">
                    <label class="control-label">Name</label>
                    <div class="controls">
                        <?php echo $data['name'];?>
                    </div>
                </div>
				<br>
                <div class="control-group">
                    <label class="control-label">Description</label>
                    <div class="controls">
                        <?php echo $data['description'];?>
                    </div>
                </div>
				<br>
                <div class="control-group">
                    <label class="control-label">Price</label>
                    <div class="controls">
                        <?php echo $data['price'];?>
                    </div>
                </div>
				<br>
				<!--Create back button to send to index.php-->
                <div class="form-actions">
                    <a class="btn btn-info" href="index.php">Back</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>