<?php require_once("includes/db.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/sessions.php"); ?>
<?php //login_confirm(); ?>

<?php 
	if(isset($_POST["Submit"])){
		$categoryName = $_POST["CategoryName"];
		$Admin = $_SESSION["Name"];
		//Get current date and time
		date_default_timezone_set("Asia/Kathmandu");
		$date=time();
		$get_time=strftime("%d-%m-%Y %H:%M:%S",$date);
		
		if(empty($categoryName)){
			//Making the error into session variaoble using super global variable
			$_SESSION["errorMsg"] = "Field(s) cannot be empty.";
			redirect("Categories.php");
			//Check for category length
		}else if(strlen($categoryName)<4){
			$_SESSION["errorMsg"] = "Category must be atleast 2 characters long.";
			redirect("Categories.php");
		}else{
			//Inserting title when validation is true
			$sql = "INSERT into category(name, author, datetime)";
			//PDO named dummy paramerter to prevent sql injection
			$sql .= "VALUES(:nameCategory, :authorName, :dateTime)";
			//PDO object notation to call prepare mathod
			$stmt = $conn->prepare($sql);
			//Bind dummy values to actual values
			$stmt->bindValue(':nameCategory', $categoryName); 
			$stmt->bindValue(':authorName', $Admin);
			$stmt->bindValue(':dateTime', $get_time);
			//PDO ,ethod execute called via $stmt object
			$execute=$stmt->execute();
			//Check for successfull addition to DB
			if($execute){
				$_SESSION["successMsg"] = "Category added successfully!";
				redirect("Categories.php");
			}else{
				$_SESSION["errorMsg"] = "Oops! Something went wrong, please try again.";
				redirect("Categories.php");
			}
		}
	}
 ?>

<!DOCTYPE html>
<html>
	<head>

		<title>Sports News | Category</title>
		<meta charset="utf-8">
  		<meta name="viewport" content="width=device-width, initial-scale=1">

  		<!-- CSS script -->
  		<link rel="stylesheet" href="css/style.css">
  		<link rel="stylesheet" href="css/bootstrap.min.css">
		<!-- Bootstrap css -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

	</head>

	<body>

		<!--Navigation section begin-->
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
			<div class="container">
					<a href="#" class="navbar-brand">sportsnepal.com</a>
					<!-- Toggle effect on menu -->
					<button class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapseCms">
						<span class="navbar-toggler-icon"></span>
					</button>
					<div class="collapse navbar-collapse" id="navbarCollapseCms">
						<!-- Navigation menu items -->
						<ul class="navbar-nav">
							<li class="nav-item">
								<a href="MyProfile.php" class="nav-link" style="color: white;">Profile</a>
							</li>
							<li class="nav-item">
								<a href="Dashboard.php" class="nav-link" style="color: white;">Dashboard</a>
							</li>
							<li class="nav-item">
								<a href="Posts.php" class="nav-link" style="color: white;">Posts</a>
							</li>
							<li class="nav-item">
								<a href="Categories.php" class="nav-link" style="color: white;">Categories</a>
							</li>
							<li class="nav-item">
								<a href="comment.php" class="nav-link" style="color: white;">Manage Comments</a>
							</li>
						</ul>
					<ul class="navbar-nav ml-auto">
						<li class="nav-item"><a href="Logout.php" class="nav-link" style="color: white;"><i class="fas fa-sign-out-alt text-danger"></i>Logout</a></li>
					</ul>
				</div>
			</div>
		</nav>
		<!--Navigation bar end  -->

		<!-- Header section begin -->
		<header class="py-2">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<h1 class="text-center">Category Management Suite</h1>
					</div>
				</div>
			</div>
		</header>
		<!-- Header section end -->

		<!-- Categories page begin  -->
		<section class="container py-2 mb-2">
			<div class="row">
				<div class="offset-lg-1 col-lg-10">
					<!-- Calling error and success message functions -->
					<?php 
						echo errorMsg();
						echo successMsg(); 
					?>
					<!-- Form for adding category -->
					<form class="" action="Categories.php" method="post">
						<div class="card bg-light text-dark">
							<div class="card-header">
								<h3>Add Category</h3>
							</div>
							<div class="card-body bg-light text-dark">
								<div class="form-group">
									<label for="title"><span class="fieldInfo">Category Name: </span></label>
									<input class="form-control" type="text" name="CategoryName" id="title" placeholder="Insert category name here.">
								</div>
								<!-- Button to take back to dashboard -->
								<div class="row">
									<div class="col-lg-6 mb-2">
										<a href="Dashboard.php" class="btn btn-danger btn-block"><i class="fas fa-arrow-alt-circle-left"></i> Back to Dashboard</a>
									</div>
									<div class="col-lg-6">
										<button type="submit" value="Save" name="Submit" class="btn btn-success btn-block">Save To Database <i class="fas fa-save"></i></button>
									</div>
								</div>
							</div>
						</div>
					</form>
					<h1 class="text-center">Available Categories</h1>
					<table class="table table-bordered table-hover">
						<thead>
							<tr class="table-head table-primary">
								<th>S.No.</th>
								<th class="text-center">Date & Time</th>
								<th class="text-center">Name</th>
								<th class="text-center">Ceated By</th>
								<th class="text-center">Option</th>
							</tr>
						</thead>
					<?php
						global $conn;
						$sql = "SELECT * FROM category ORDER BY id DESC";
						$execute=$conn->query($sql);
						$com=0;
						while($data_rows=$execute->fetch()){
							$catId = $data_rows["id"];
							$catDate = $data_rows["datetime"];
							$catName = $data_rows["name"];
							$catAuthor = $data_rows["author"];
							$com++;
					?>
					<tbody>
						<tr>
							<td class="text-center"><?php echo $com; ?></td>
							<td class="text-center"><?php echo $catDate; ?></td>
							<td class="text-center"><?php echo $catName; ?></td>
							<td class="text-center"><?php echo $catAuthor; ?></td>
							<td class="text-center"><a href="deletecategory.php?id=<?php echo $catId; ?>" class="btn btn-danger">Delete</a></td>
						</tr>
					</tbody>
				<?php } ?>
				</table>
				</div>
			</div>
		</section>
		<!-- Categories page end -->


		<!-- Footer section begin -->
		<footer class="bg-dark text-light">
            <div class="container py-3">
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-3">
                        <h6>Quick Links</h6>
                        <ul class="list-unstyled">
                            <li><a href="#" style="color: white;">Home</a></li>
                            <li><a href="#" style="color: white;">Write For Us</a></li>
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