<?php
	session_start();
	
	function errorMsg(){
		if(isset($_SESSION["errorMsg"])){
			$show = "<div class=\"alert alert-danger\">";
			//Don't allow html syntax to be broken
			$show .= htmlentities($_SESSION["errorMsg"]);
			$show .= "</div>";
			//Clearing the session 
			$_SESSION["errorMsg"] = NULL;
			return $show;
		}
	}

	function successMsg(){
		if(isset($_SESSION["successMsg"])){
			$show = "<div class=\"alert alert-success\">";
			$show .= htmlentities($_SESSION["successMsg"]);
			$show .= "</div>";
			$_SESSION["successMsg"] = NULL;
			return $show;
		}
	}
?>
