<?php require_once("includes/db.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/sessions.php"); ?>

<?php
	if(isset($_GET["id"])){
		$searchParam = $_GET["id"];
		global $conn;
		$sql = "DELETE FROM comment WHERE id='$searchParam'";
		$execute = $conn->query($sql);
			if($execute){
				$_SESSION["successMsg"] = "Comment deleted sucessfully.";
				redirect("comment.php");
			}else{
				$_SESSION["errorMsg"] = "Oops! Something went wrong.";
				redirect("comment.php");
			}
		}
 ?>