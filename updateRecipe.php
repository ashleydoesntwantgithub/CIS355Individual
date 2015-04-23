<!DOCTYPE html>
<!--
Title: updateRecipe.php
Author: Ashley Schaar
Date: 4-23-2015
For Project: CIS 355 Individual Project
-->

<?php
    require 'database.php';
	$id = null;
	//Preserve menu item id from index.php
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
	$itemID = $id;
	//Insert a new ingredient in relation to the recipe of the Menu Item
	if ( !empty($_POST)) {
		$ingredientID = $_POST["ingredientID"];
		$pdo = Database::connect();
		$sqlInsert = 'INSERT INTO recipe (menuItem_id,ingredient_id) VALUES (?,?)';
		$q = $pdo->prepare($sqlInsert);
		$q->execute(array($itemID, $ingredientID));
		Database::disconnect();
	}
	//Pull the Menu Item name from the database
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
		<!--Create list of ingredients linked to menu item through Recipe table
			and create delete button for each respective recipe record-->
        <div class="span10 offset1">
			<div class="row">
				<h3>Item Recipe
				<a class="btn btn-info" href="index.php">Back</a>
				</h3>
			</div>        
			<div class="form-horizontal" >
				<div class="control-group">
					<label class="control-label">Name</label>
					<div class="controls">
						<?php echo $data['name'];?>
					</div>
				</div>
				<br>
				<table>
					<?php
						$pdo = Database::connect();
						$sql = "SELECT recipe.id, ingredient.name FROM recipe 
						INNER JOIN ingredient ON recipe.ingredient_id = ingredient.id WHERE menuItem_id = ".$id;
						echo '<thead><th>Ingredient List</th></thead>';							
						foreach ($pdo->query($sql) as $row) {
							echo '<tr>';
							echo '<td>'. $row['name'] . '</td>';
							echo '<td width=250><a class="btn btn-danger" href="deleteRecipe.php?id='.$row['id'].'&menuID='.$itemID.'">Delete</a></td>';
							echo "</tr>";
						}
						Database::disconnect();
					?>
				</table>
				<br>
				<label class="control-label">Add Ingredient</label>
				<div class="controls">
					<?php
						echo "<form action='updateRecipe.php?id=".$itemID."' method='post'>";
					?>
					<!--Create DropDown Box of possible ingredients pulled from database-->
					<select name="ingredientID">
					<?php
						$pdo2 = Database::connect();
						$pdo2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						$sqlIngredientList = "SELECT * FROM ingredient";
						foreach($pdo2->query($sqlIngredientList) as $row) {
							$ingredientID = $row[0];
							echo "<option value=".$ingredientID." >$row[1]</option>"; 
						}
					?>
					</select>
					<!--Create button to add selected ingredient to recipe for menuItem-->
					<button type="submit" class="btn btn-success">Add</button>
					</form>
				</div>
			<br>
		</div>
	</div>
</body>
</html>