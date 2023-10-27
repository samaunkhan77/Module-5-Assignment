<?php 
	session_start();
	
	if (!isset($_SESSION['login']) && $_SESSION['login']!=true) {
		header("Location:login.php");
	}
	
	include_once("functions.php");
	
	/* Logout System */
	if ( isset($_GET['logout']) && $_GET['logout']==true ) {
		session_destroy();
		header("Location:login.php");
	}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  </head>
  <body data-bs-theme="dark">
    
		<div class="container mt-4">
			<nav class="navbar navbar-expand-lg bg-body-tertiary">
			  <div class="container-fluid">
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
				  <span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarTogglerDemo01">
				  <a class="navbar-brand" href="index.php"><?php echo ucfirst($_SESSION['role']); ?> Dashboard</a>
				</div>
				
				<div class="d-flex float-end" >
						<ul class="navbar-nav  mb-2 mb-lg-0">
						<?php if ( $_SESSION['role'] == 'admin' ) {?>
							<li class="nav-item">
							  <a class="nav-link active" href="adduser.php">Add New</a>
							</li>
						<?php } ?>
							<li>&nbsp;&nbsp;&nbsp;&nbsp;</li>
							<li class="nav-item">
							  <a class="nav-link active" href="#">Welcome <em class="text-muted"> <?php echo $_SESSION['username'] ?? "";?></em> </a>
							</li>
							<li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
							<li class="nav-item">
							  <a class="nav-link active btn btn-dark " href="?logout=true">Logout</a>
							</li>
						</ul>
					</div>
			  </div>
			</nav>
			<p><span class="text-success">
			<?php 
				if ($_SESSION['success'] == true) {
					echo "Logined Successsfully";
				}
				$_SESSION['success']=false;
			?>
			</span></p>
				
			<?php include_once("displayInfo.php");?>
			

			<?php 
			if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin' ) {
				include_once("role-management.php"); 
			}
			?>
			
			
		</div>
	
	
	
	
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>