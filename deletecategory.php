<?php require_once("includes/db.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/sessions.php"); ?>

<?php
	if(isset($_GET["id"])){
		$searchParam = $_GET["id"];
		global $conn;
		$sql = "DELETE FROM category WHERE id='$searchParam'";
		$execute = $conn->query($sql);
			if($execute){
				$_SESSION["successMsg"] = "Category deleted sucessfully.";
				redirect("Categories.php");
			}else{
				$_SESSION["errorMsg"] = "Oops! Something went wrong.";
				redirect("Categories.php");
			}
		}
 ?>