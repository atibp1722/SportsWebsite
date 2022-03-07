<?php require_once("includes/db.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/sessions.php"); ?>

<!DOCTYPE html>
<html>
	<head>

		<title>Sports News | Comments</title>
		<meta charset="utf-8">
  		<meta name="viewport" content="width=device-width, initial-scale=1">

  		<!-- CSS script -->
  		<link rel="stylesheet" href="css/style.css">
		<!-- Bootstrap css -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

	</head>

	<body>

		<!--Navigation section begin-->
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
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
								<a href="MyProfile.php" class="nav-link" style="color: white;">Profile</a>
							</li>
							<li class="nav-item">
								<a href="Dashboard.php" class="nav-link" style="color: white;">Dashboard</a>
							</li>
							<li class="nav-item">
								<a href="posts.php" class="nav-link" style="color: white;">Posts</a>
							</li>
							<li class="nav-item">
								<a href="Categories.php" class="nav-link" style="color: white;">Categories</a>
							</li>
							<li class="nav-item">
								<a href="comments.php" class="nav-link" style="color: white;">Manage Comments</a>
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
						<h1 class="text-center">Manage Comment</h1>
					</div>
				</div>
			</div>
		</header>
		<!-- Header section end -->

	<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<table class="table table-bordered table-hover">
						<thead>
							<tr class="table-head table-primary">
								<th>S.No.</th>
								<th>Comment Time & Date</th>
								<th>Name</th>
								<th>Email</th>
								<th>Comment</th>
								<th>Option</th>
							</tr>
						</thead>
					<?php
						global $conn;
						$sql = "SELECT * FROM comment ORDER BY id DESC";
						$execute=$conn->query($sql);
						$com=0;
						while($data_rows=$execute->fetch()){
							$comID = $data_rows["id"];
							$comDate = $data_rows["datetime"];
							$comName = $data_rows["name"];
							$comEmail = $data_rows["email"];
							$comContent = $data_rows["comment"];
							$postID = $data_rows["postId"];
							$com++;
					?>
					<tbody>
						<tr>
							<td><?php echo $com; ?></td>
							<td><?php echo $comDate; ?></td>
							<td><?php echo $comName; ?></td>
							<td><?php echo $comEmail; ?></td>
							<td><?php echo $comContent; ?></td>
							<td><a href="deletecomment.php?id=<?php echo $comID; ?>" class="btn btn-danger">Delete</a></td>
						</tr>
					</tbody>
				<?php } ?>
				</table>
			</div>
		</div>
	</div>

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