<!DOCTYPE html>
<!--
Title: index.php
Author: Ashley Schaar
Date: 4-23-2015
For Project: CIS 355 Individual Project
-->
<html lang="en">
<head>
    <meta charset="utf-8">
	<!--Using Bootstrap elements-->
    <link   href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	<?php
		session_start();
	?>
</head>
 
<body>
    <div class="container">
		<!--Header for Landing Page-->
        <div class="row">
            <h3>"The Fix" Bakery Menu<img src="http://uptownbaycity.com/wp-content/uploads/2014/12/The-Fix-Logo.jpg" align="right" width=100px></h3>
        </div>
        <div class="row">
            <p>
			<?php
				if ($_SESSION["id"] == "loggedin") {
					// Create Logout button
					echo '<a href="logout.php" class="btn btn-danger">Logout</a>';
					echo '<a href="createMenuItem.php" class="btn btn-success">Create Menu Item</a>';
				}
					else {
					// Create Login button
					echo '<a href="login.php" class="btn btn-success">Login</a>';
					echo ' ';
				}
			?>	
            </p>
            <!--Table of items on Menu-->
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Menu Item</th>
                        <th>Price</th>
                        <th></th> <!--This column will hold buttons, no title needed-->
                    </tr>
                </thead>
                <tbody>
                    <?php
						include 'database.php';
						$pdo = Database::connect();
						$sql = 'SELECT * FROM menuItem ORDER BY id DESC';
						//For each record in menuItem table, show name and price, and create View button
						foreach ($pdo->query($sql) as $row) {
                            echo '<tr>';
                            echo '<td>'. $row['name'] . '</td>';
                            echo '<td>'. $row['price'] . '</td>';
                            echo '<td width=400>';
							echo '<a class="btn btn-default" href="view.php?id='.$row['id'].'">View</a>';
							//If logged in, create Edit Recipe, Update, and Delete buttons for each record as well
							if ($_SESSION["id"] == "loggedin") {
								echo ' ';
								echo '<a class="btn btn-info" href="updateRecipe.php?id='.$row['id'].'">Edit Recipe</a>';
								echo '<a class="btn btn-success" href="updateMenuItem.php?id='.$row['id'].'">Update Details</a>';
								echo '<a class="btn btn-danger" href="deleteMenuItem.php?id='.$row['id'].'">Delete</a>';
								echo '</td>';
								echo '</tr>';
							}
                       }
                       Database::disconnect();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
  </body>
</html>