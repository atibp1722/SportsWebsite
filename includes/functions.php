<?php require_once("includes/db.php"); ?>
<?php
	// Function to redirect the user to same page if field is empty
	function redirect($Location){
		header("Location: $Location");
		exit;
	}

	function login($UserName,$Password){
	//Check for valid username and password from DB
        global $conn;
        $sql = "SELECT username,password FROM admin
        WHERE username=:userName AND password=:passWord";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':userName' ,$UserName);
        $stmt->bindValue(':passWord' ,$Password);
        $stmt->execute();
        //Counting each row which hold sql query result
        $show = $stmt->rowcount();
        if($show==1){
            //fetch result storedin fetch_login variable
            return $fetch_login = $stmt->fetch();
        }else{
            return null;
        }
	}

    function login_confirm(){
        //password protecting backend pages from accessing after logging out
        if(isset($_SESSION["Id"])){
            return true;
        }else{
            $_SESSION["errorMsg"] = "Please enter your login details";
            redirect("login.php");
        }
    }

?>