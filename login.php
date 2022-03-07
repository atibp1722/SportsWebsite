<?php require_once("includes/db.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/sessions.php"); ?>

<?php 

    if(isset($_POST["login_button"])){
    $UserName = $_POST["Username"];
    $Password = $_POST["Password"];

    if(empty($UserName) || empty($Password)){
        $_SESSION["errorMsg"] = "Field(s) cannot be empty.";
        redirect("login.php");
    }else{
        //function call to validate user credentials from DB    
        $fetch_login=login($UserName, $Password);
        if($fetch_login){
            //returning column data from fetch() method
            $_SESSION["Id"] = $fetch_login["id"];
            $_SESSION["Name"] = $fetch_login["username"];
            $_SESSION["successMsg"] = "Welcome " .$_SESSION["Name"];
            redirect("Dashboard.php");
         }else{
            $_SESSION["errorMsg"] = "Sorry! Incorrect login details.";
            redirect("login.php");
        }
    }
}
?>

<!DOCTYPE html>
<html>
    <head>

        <title>Sports News | Login</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSS script -->
        <link rel="stylesheet" href="css/style.css">
        <!-- Bootstrap css -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    </head>

    <body>

            <div class="container">
                <div class="row">
                    <div class="col-12 col-sm-8 col-md-6 col-lg-4 offset-sm-2 offset-md-3 offset-lg-4">
                        <header class="">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h1 class="text-center">Admin Login</h1>
                                    </div>
                                </div>
                            </div>
                        </header>
                        <?php 
                            echo errorMsg();
                            echo successMsg(); 
                        ?>
                        <form class="" action="login.php" method="post">
                            <div class="form-group">
                                <label for="username">Username:</label>
                                <input type="text" class="form-control" placeholder="" name="Username" value="" id="username">
                            </div>
                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input type="password" class="form-control" name="Password" value="" id="password">
                            </div>
                            <input type="submit" value="Login" name="login_button" class="btn btn-primary btn-block">
                            <div class="text-center">
                                <p></p>
                                <p>or...</p>
                                <p></p>
                                <a href="admin.php" class="btn btn-success btn-block">Create Account</a>
                                <p></p>
                                <p class="small"><a href="#">Forgot your account details?</a></p>
                            </div>  
                        </form>  
                    </div>
                </div>
            </div>

        <!-- Footer section begin -->
        <footer class="bg-dark text-white">
            <div class="container py-1">
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-3">
                        <h6>Quick Links</h6>
                        <ul class="list-unstyled">
                            <li><a href="#" style="color: white;">Home</a></li>
                            <li><a href="#" style="color: white;">What's New</a></li>
                            <li><a href="#" style="color: white;">Featured Opinions</a></li>
                            <li><a href="#" style="color: white;">Contact Us</a></li>
                            <li><a href="#" style="color: white;">Advertise With Us</a></li>
                        </ul>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <h6>Categories</h6>
                        <ul class="list-unstyled">
                            <li><a href="#" style="color: white;">Categories</a></li>
                            <li><a href="#" style="color: white;">Categories</a></li>
                            <li><a href="#" style="color: white;">Categories</a></li>
                            <li><a href="#" style="color: white;">Categories</a></li>
                            <li><a href="#" style="color: white;">Categories</a></li>
                        </ul>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <h6>Follow Us</h6>
                        <ul class="list-unstyled">
                            <li><a href="#" style="color: white;">Facebook</a></li>
                            <li><a href="#" style="color: white;">Instagram</a></li>
                            <li><a href="#" style="color: white;">Twitter</a></li>
                            <li><a href="#" style="color: white;">Youtube</a></li>
                            <li><a href="#" style="color: white;">Pinterest</a></li>
                        </ul>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <h6>Our Location</h6>
                        <address>
                            <strong>Kathmandu Metropolitan Complex</strong><br />
                            Wagle Chowk-35, Tripureswor<br />
                            Kathmandu, Nepal.<br />
                            <abbr title="Telephone">T:</abbr><a href="tel:+977014455678" style="color: white;"> +(977) 01-4455678</a> <abbr title="Email">E:</abbr><a href="mailto:info@gmail.com" style="color: white;"> info@gmail.com</a>
                        </address>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-9">
                        <ul class="list-inline">
                            <li class="list-inline-item">&copy; <span id="year"></span> XYZ Designs, Ltd.</li>
                            <li class="list-inline-item">All Rights Reserved</li>
                            <li class="list-inline-item"><a href="#" style="color: white;">Terms, Conditions and Privacy Policy</a>.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
        <!-- Footer section end -->

        <!-- JS, JQuery bootstrap links -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <!--Font awesome -->
        <script src="https://kit.fontawesome.com/8521a00be3.js" crossorigin="anonymous"></script>
        <!-- Custom JS to get current year -->
        <script>
            $('#year').text(new Date().getFullYear());
        </script>


    </body>
</html>
