<?php require_once("includes/db.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/sessions.php"); ?>

<!DOCTYPE html>
<html>
	<head>

		<title>Sports News | Home Page</title>
		<meta charset="utf-8">
  		<meta name="viewport" content="width=device-width, initial-scale=1">

  		<!-- CSS script -->
  		<link rel="stylesheet" href="css/style.css">
  		<link rel="stylesheet" href="css/bootstrap.min.css">
		<!-- Bootstrap css -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

		<style>
			.categorySide{
				color: black;
				font-family: "Times New Roman", Times, serif;
				font-style: italic;
				font-weight:bold;
			}
		</style>
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
							<?php
								global $conn;
								$sql = "SELECT * FROM category
								ORDER BY name ASC";
								$stmt = $conn->query($sql);
								while($data_rows = $stmt->fetch()){
									$catID = $data_rows["id"];
									$catName = $data_rows["name"];
								?>
								<li class="nav-item">
									<a href="home.php?category=<?php echo $catName; ?>" style="color:white;
									margin-left: 25px;"><span><?php echo $catName; ?></span></a>
								</li>
							<?php } ?>
						</ul>
					<ul class="navbar-nav ml-auto">
						<!-- Search Bar -->
							<form class="form-inline" action="home.php" method="get">
								<div class="form-group">
									<input class="form-control mr-sm-1" type="text" name="search" 
									placeholder="Search News" value="">
									<button name="searchButton" class="btn btn-success my-2 my-sm-0">Go</button>
								</div>
							</form>
					</ul>
				</div>
			</div>
		</nav>
		<!--Navigation bar end  -->

		<div class="cotainer offset-sm-1 py-2">
				<img src="img/advert.jpg">
		</div>

		<!-- Header section begin -->
		<div class="container">
			<div class="row mt-4 mb-4">
				<!-- Main content display area-->
				<div class="col-sm-8">
					<?php echo errorMsg(); ?>
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

					//Get post accorfing to category chosen	
					}elseif (isset($_GET["category"])){
						$CATEGORY = $_GET["category"];
						$sql = "SELECT * FROM posts
						WHERE category = '$CATEGORY' ORDER BY id ASC";
						$stmt = $conn->prepare($sql);
						$stmt->bindValue(':CATEGORY',$CATEGORY);
						$stmt->execute();
					}
					else{
						//Query to get post content
						$sql = "SELECT * from posts ORDER BY id desc";
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
							<a href="viewpost.php?id=<?php echo $postId ?>"><h4 class="card-title"><?php echo $postName; ?></h4></a>
							<small>Posted by: <?php echo $postAuthor; ?> Category:  <?php echo $postCategory; ?> Date: <?php echo $postDateTime; ?></small>
							<hr>
							<!-- Limiting content on display to only 100 words -->
							<p>
								<?php if(strlen($postContent)>150){
									$postContent = substr($postContent,0,100);
								} echo $postContent; ?>	</a>	
							</p>
						</div>
					</div>
				<?php } ?>
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
		<!-- Side display area end -->
	</div></div>
	
		<!-- Footer section begin -->
		<footer class="bg-primary text-white">
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