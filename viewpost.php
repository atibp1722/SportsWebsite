<?php require_once("includes/db.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/sessions.php"); ?>
<?php $searchParam = $_GET["id"]; ?>

<?php 
	if(isset($_POST["Submit"])){
		$Name = $_POST["comName"];
		$Email = $_POST["comEmail"];
		$Comment = $_POST["comment"];
		//Get current date and time
		date_default_timezone_set("Asia/Kathmandu");
		$date=time();
		$get_time=strftime("%d-%m-%Y %H:%M:%S",$date);
		
		if(empty($Name) || empty($Email) || empty($Comment)){
			//Making the error into session variaoble using super global variable
			$_SESSION["errorMsg"] = "Fields cannot be empty.";
			redirect("viewpost.php?id={$searchParam}");
			//Check for comment length
		}else if(strlen($Comment)>750){
			$_SESSION["errorMsg"] = "Comment can't be more than 750 characters.";
			redirect("viewpost.php?id={$searchParam}");
		}else{
			global $conn;
			//Inserting comment when validation is true
			$sql = "INSERT into comment(datetime, name, email, comment, postId)";
			//PDO named dummy paramerter to prevent sql injection
			$sql .= "VALUES(:dateTime, :namE, :emaiL, :commenT, :postID)";
			//PDO object notation to call prepare mathod
			$stmt = $conn->prepare($sql);
			//Bind dummy values to actual values
			$stmt->bindValue(':dateTime', $get_time);
			$stmt->bindValue(':namE', $Name);
			$stmt->bindValue(':emaiL', $Email);
			$stmt->bindValue(':commenT', $Comment);
			$stmt->bindValue(':postID', $searchParam);
			//PDO method execute called via $stmt object
			$execute=$stmt->execute();
			//Check for successfull addition to DB
			if($execute){
				$_SESSION["successMsg"] = "Comment posted successfully!";
				redirect("viewpost.php?id={$searchParam}");
			}else{
				$_SESSION["errorMsg"] = "Oops! Something went wrong, please try again.";
				redirect("viewpost.php?id={$searchParam}");
			}
		}
	}
 ?>
<!DOCTYPE html>
<html>
	<head>

		<title>Sports News</title>
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
		<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
			<div class="container">
					<a href="home.php" class="navbar-brand">sportsnepal.com</a>
					<!-- Toggle effect on menu -->
					<button class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapseCms">
						<span class="navbar-toggler-icon"></span>
					</button>
					<div class="collapse navbar-collapse" id="navbarCollapseCms">
						<!-- Navigation menu items -->
						<ul class="navbar-nav">
							<li class="nav-item">
								<a href="Dashboard.php" class="nav-link" style="color: white;">Category 1</a>
							</li>
							<li class="nav-item">
								<a href="Posts.php" class="nav-link" style="color: white;">Category 2</a>
							</li>
							<li class="nav-item">
								<a href="Categories.php" class="nav-link" style="color: white;">Category 3</a>
							</li>
							<li class="nav-item">
								<a href="Categories.php" class="nav-link" style="color: white;">Category 4</a>
							</li>
							<li class="nav-item">
								<a href="Categories.php" class="nav-link" style="color: white;">Category 5</a>
							</li>
							<li class="nav-item">
								<a href="Categories.php" class="nav-link" style="color: white;">Category 6</a>
							</li>
						</ul>
					<ul class="navbar-nav ml-auto">
						<!-- Search Bar -->
							<form class="form-inline" action="home.php" method="get">
								<div class="form-group">
									<input class="form-control" type="text" name="search" 
									placeholder="Search News" value="">
									<button name="searchButton" class="btn btn-success my-2 my-sm-0">Go</button>
								</div>
							</form>
					</ul>
				</div>
			</div>
		</nav>
		<!--Navigation bar end  -->

		<!-- Header section begin -->
		<div class="container">
			<div class="row my-2">
				<!-- Main content display area-->
				<div class="col-sm-8">
					<?php 
						echo errorMsg();
						echo successMsg(); 
					?>
					<!--Extracting content from DB -->
					<?php
					//Using the search bar function
					if(isset($_GET["searchButton"])){
						$Search = $_GET["search"];
						//Query to return search result
						$sql = "SELECT * from posts
						WHERE name LIKE :search
						OR category LIKE :search
						OR content LIKE :search";
						$stmt = $conn->prepare($sql);
						$stmt -> bindValue(':search', '%'.$Search.'%');
						$stmt->execute();
					}
					else{
						//Getting id from url to display content in full page
						$urlId = $_GET["id"];
						if(!isset($urlId)){
							$_SESSION["errorMsg"] = "Sorry, no such result found.";
							redirect("home.php");
						}
						//Query to get post content
						$sql = "SELECT * from posts
						WHERE id = '$urlId'";
						$stmt = $conn->query($sql);
					}
						while($data_rows = $stmt->fetch()){
							$postId = $data_rows["id"];
							$postDateTime = $data_rows["datetime"];
							$postName = $data_rows["name"];
							$postCategory = $data_rows["category"];
							$postAuthor = $data_rows["author"];
							$postImage = $data_rows["image"];
							$postContent = $data_rows["content"];
					 ?>
					<div class="card mt-2">
						<img src="upload/<?php echo $postImage; ?>" class="img-fluid"/>
						<div class="card-body">
							<h4 class="card-title"><?php echo $postName; ?></h4>
							<small>Posted by: <?php echo $postAuthor; ?> category:  <?php echo $postCategory; ?> on: <?php echo $postDateTime; ?></small>
							<span style="float:right;">Comments</span>
							<hr>
							<p>
								<?php echo $postContent; ?>
							</p>
						</div>
					</div>
				<?php } ?>
				<br>
				<div class="">

					<!-- Fetching the user comments -->
					<span class="fieldInfo">Viewer Comments</span>
					<br><br>
					<?php
						//global $conn;
						$sql = "SELECT * FROM comment
						WHERE postId = '$searchParam'";
						$stmt = $conn->query($sql);
						while($data_rows = $stmt->fetch()){
							$commentDate = $data_rows['datetime'];
							$commentName = $data_rows['name'];
							$commentPost = $data_rows['comment'];
					 ?>
					 <div>
					 		<div class="media-body">
					 			<h6 class="strong"><?php echo $commentName; ?></h6>
					 			<p class="small"><?php echo $commentDate; ?></p>
					 			<p><em><?php echo $commentPost; ?></em></p>
					 		</div>
					 </div>
					 <hr>
					<?php } ?>

					<!--Commnet area -->
					<form class="" action="viewpost.php?id=<?php echo $searchParam; ?>" method="post">
						<div class="card mb-2">
							<div class="card-header">
								<h5 class="commentArea">Leave a Comment</h5>
							</div>
							<div class="card-body">
								<div class="form-group">
									<div class="input-group">
										<label>Name: </label>
										<input type="text" class="form-control" name="comName" 
										placeholder="Leave your name" value="">
									</div>
								</div>
								<div class="form-group">
									<div class="input-group">
										<label>Email: </label>
										<input type="text" class="form-control" name="comEmail" 
										placeholder="Leave your email" value="">
									</div>
								</div>
								<div class="form-group">
									<label>Comment: </label>
									<textarea class="form-control" 
									rows="5" cols="50" name="comment"></textarea>
								</div>
								<div>
									<button name="Submit" type="submit" class="btn btn-info">Post</button>
								</div>
							</div>
						</div>
				</div>
				</div>

				<!-- Side content dispaly area -->
				<div class="col-sm-4 py-2">

					<!-- Displaying categories on side bar -->
					<div class="card">
						<div class="card-body">
							<div class="card-headder text-dark">
								<h2 class="lead font-weight-bold">Categories</h2>
								<hr>
								<div class="card-body py-1">
									<?php
										global $conn;
										$sql = "SELECT * FROM category
										ORDER BY name ASC";
										$stmt = $conn->query($sql);
										while($data_rows = $stmt->fetch()){
											$catID = $data_rows["id"];
											$catName = $data_rows["name"];
									 ?>
									 <a href="home.php?category=<?php echo $catName; ?>"><span class="categorySide"><?php echo $catName; ?></span></a><br>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
					<hr>

					<div class="card py-2">
						<div class="card-body">
							<img src="img/ads.png" alt="advertise here" class="d-block img-fluid">
						</div>
					</div>
					<hr>

					<div class="card">
						<div class="card-body">
							<div class="card-headder text-dark">
								<h2 class="lead font-weight-bold">Recenlty Added</h2>
								<hr>
								<div class="card-body py-1">
									<?php
										global $conn;
										$sql = "SELECT * FROM posts
										ORDER BY datetime ASC LIMIT 5";
										$stmt = $conn->query($sql);
										while($data_rows = $stmt->fetch()){
											$ID = $data_rows["id"];
											$Name = $data_rows["name"];
									 ?>
									 <a href="viewpost.php?id=<?php echo $ID; ?>" target="_blank"><span><?php echo $Name; ?></a></span><br><br>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
					<hr>

					<div class="card mt-2">
						<div class="card-body">
							<img src="img/ads.png" alt="advertise here" class="d-block img-fluid">
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Side content dispaly area end-->

			</div>
		</div>
		<!-- Header section end -->

		<!-- Footer section begin -->
		<footer class="bg-dark text-white">
            <div class="container py-3">
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