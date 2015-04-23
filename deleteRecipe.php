<?php
    require 'database.php';
    $id = null;
	 
    if ( !empty($_GET['id'])) {
        $id = $_GET['id'];
    }
	
	if ( !empty($_GET['menuID'])) {
		$menuID = $_GET['menuID'];
	}
	
    if ( !empty($_POST)) {
        // keep track post values
        $id = $_GET['id'];
        $menuID = $_GET['menuID']; 		
        // delete data
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "DELETE FROM recipe WHERE id = ".$id;        		
		$stm = $pdo->prepare($sql);		
		$stm->execute();		
        
        Database::disconnect();
        header("Location: updateRecipe.php?id=".$menuID);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
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
     
                <div class="span10 offset1">
                    <div class="row">
                        <h3>Delete an Ingredient</h3>
                    </div>
                     <?php
						echo '<form class="form-horizontal" action="deleteRecipe.php?id='.$id.'&menuID='.$menuID.'" method="post">';
					?>
					<input type="hidden" id="doDelete" name="doDelete" value="yes">
                      <p class="alert alert-error">Are you sure to delete ?</p>
                      <div class="form-actions">
					      <br>
                          <button type="submit" class="btn btn-danger">Yes</button>
                          <?php
							echo '<a href="updateRecipe.php?id='.$menuID.'" class="btn btn-info">No</a>';
						  ?>
                        </div>
                    </form>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>