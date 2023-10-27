<?php 
session_start();
if ($_SESSION['role'] != 'admin' || !isset($_GET['edit'])) {
	header("Location:index.php");
}
include_once("functions.php");

	if (isset($_GET['edit'])) {
		$editId = (int) $_GET['edit']-1;
		$fileData = file($filename);
		if ($editId > count($fileData) || $editId < 0) {
			header("Location:index.php");
		}
		$data = trim($fileData[$editId]);
		list($role,$username,$email) = explode(",",$data);
		
		
		if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
				updateUserInfo($_POST,$filename,$errorMsg,$editId);
		}
	}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update User Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  </head>
  <body class="data-bs-theme-dark"  data-bs-theme="dark">
		<div class="container mt-5">
			<div class="row">
				<div class="col-md-3"></div>
				<div class="col-md-6 p-4 border rounded">
					<h3 class="text-center">Update User System</h3>
					<span class="text-danger"><?php echo $errorMsg; ?></span>
					
					<form action="" method="post">
					  <div class="mb-3">
						<label for="username" class="form-label">Username</label>
						<input type="text" name="username" class="form-control" id="username" value="<?php echo $username ?? ""; ?>" >
					  </div>
					  
					  <div class="mb-3">
						<label for="email" class="form-label">Email address</label>
						<input type="email" name="email" class="form-control" id="email" value="<?php echo $email ?? "";?>" >
					  </div>
					  
					  <div class="mb-3">
						<label for="pass" class="form-label">Select One Role</label>
						<select name="role" class="form-control">
							<option <?php echo $role=="admin" ? 'selected':''; ?> value="admin">Admin</option>
							<option <?php echo $role=="manager" ? 'selected':''; ?> value="manager">Manager</option>
							<option <?php echo $role=="user" ? 'selected':''; ?> value="user">User</option>
						</select>
					  </div>
					  
					  <button type="submit" class="btn btn-primary">Update</button>
					  <a href="index.php" class="btn btn-light">Back</a>
					</form>
				</div>
			</div>
			
		</div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>