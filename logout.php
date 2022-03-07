<?php require_once("includes/db.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/sessions.php"); ?>

<?php
	//making all user credential to null before logging out
	 $_SESSION["Id"] = NULL;
     $_SESSION["Name"] = NULL;
     $_SESSION["successMsg"] = NULL;
	 session_destroy();
	 redirect("login.php");
 ?>