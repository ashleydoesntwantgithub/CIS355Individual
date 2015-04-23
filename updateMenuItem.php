<!--
Title: updateMenuItem.php
Author: Ashley Schaar
Date: 4-23-2015
For Project: CIS 355 Individual Project
-->

<?php   
    require 'database.php';
	$id = null;
	
	//Preserve menu item id
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
	
    if ( !empty($_POST)) {
        // keep track validation errors
        $nameError = null;
        $descriptionError = null;
        $priceError = null;
		 
        // keep track post values
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
         
        // validate input - No blank value
        $valid = true;
        if (empty($name)) {
            $nameError = 'Please enter Name';
            $valid = false;
        }
         // validate input - No blank value
        if (empty($description)) {
            $descriptionError = 'Please enter Description';
            $valid = false;
        }
         // validate input - No blank value
        if (empty($price)) {
			$priceError = 'Please enter Price';
            $valid = false;
        }
		// validate input - Numeric value only
		if (!is_numeric($price)) {
			$priceError = 'Not a valid Price!';
			$valid = false;
		}
         
        // insert data
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE menuItem SET name='$name',description='$description',price=$price WHERE id=".$id;
            $q = $pdo->prepare($sql);
			echo $sql;
			$q->execute();
			echo $name."<br>".$description."<br>".$price."<br>";
			
            Database::disconnect();
            header("Location: index.php");
        }
    }
	else {
		//pull pre existing data from database
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT name, description, price FROM menuItem WHERE id = ".$id;
		foreach ($pdo->query($sql) as $row) {
			$name = $row['name'];
			$description = $row['description'];
			$price = $row['price'];
		}
		Database::disconnect();
	}
?>

<!DOCTYPE html>
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
    <div class="container">
		<!--Create input boxes for Name, Description, and Price. Auto populate with current
			values pulled from menuItem Table using id-->
		<div class="span10 offset1">
			<div class="row">
				<h3>Update a Menu Item</h3>
			</div>
			<?php
				echo '<form class="form-horizontal" action="updateMenuItem.php?id='.$id.'" method="post">'
			?>
			  <div class="control-group <?php echo !empty($nameError)?'error':'';?>">
				<label class="control-label">Name</label>
				<div class="controls">
					<input name="name" type="text"  placeholder="name" value="<?php echo !empty($name)?$name:'';?>">
					<?php if (!empty($nameError)): ?>
						<span class="help-inline"><?php echo $nameError;?></span>
					<?php endif; ?>
				</div>
			  </div>
			  <div class="control-group <?php echo !empty($descriptionError)?'error':'';?>">
				<label class="control-label">Description</label>
				<div class="controls">
					<input name="description" type="text" placeholder="description" value="<?php echo !empty($description)?$description:'';?>">
					<?php if (!empty($descriptionError)): ?>
						<span class="help-inline"><?php echo $descriptionError;?></span>
					<?php endif;?>
				</div>
			  </div>
			  <div class="control-group <?php echo !empty($priceError)?'error':'';?>">
				<label class="control-label">Price</label>
				<div class="controls">
					<input name="price" type="text"  placeholder="price" value="<?php echo !empty($price)?$price:'';?>">
					<?php if (!empty($priceError)): ?>
						<span class="help-inline"><?php echo $priceError;?></span>
					<?php endif;?>
				</div>
			  </div>
			  <div class="form-actions">
				  <br>
				  <button type="submit" class="btn btn-success">Update</button>
				  <a class="btn btn-info" href="index.php">Back</a>
				</div>
			</form>
		</div>     
    </div>
  </body>
</html>