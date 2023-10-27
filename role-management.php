<main class="mt-5 mb-5">
	<h4 class="mb-4">All User Information</h4>
	<table class="table-bordered table table-striped text-center">
		<thead>
			<tr>
				<th>Sl</th>
				<th>Username</th>
				<th>Email</th>
				<th>Role</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
		<?php 
			if ($_SESSION['role'] != 'admin') {
				header("Location:index.php");
			}
			
			if ( isset($_GET['delete']) ) {
				$delId = (int) $_GET['delete']-1;
				deleteUser($filename,$delId);
			}
			
			
			$fileData = displayUsersInfo($filename);
			
			//echo empty(trim($fileData[2])) ? "yes" : "No";
			//print_r($fileData);
			
		$count=0;
		foreach($fileData as $data) {
			if (!empty(trim($data))) {
				list($role,$username,$email) = explode(",",rtrim($data,"\n"));
				$count++;
		?>
			<tr>
				<td><?php echo $count <= 9 ? "0".$count : $count ; ?></td>
				<td><?php echo $username ?? null ; ?></td>
				<td><?php echo $email ?? null ; ?></td>
				<td><?php echo $role ?? null; ?></td>
				<td>
					<a class="btn btn-warning" href="update.php?edit=<?php echo $count;?>">Edit</a>  ||
					<a class="btn btn-danger" href="?delete=<?php echo $count;?>">Delete</a>
				</td>
			</tr>
				<?php } } ?>
		</tbody>
	</table>
</main>