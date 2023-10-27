<?php 

$filename = "./data/users.txt";

$errorMsg = "";

/*************** Default User Set Start  ****************/
function defaultAdminSet($filename) {
	$adminInfo = [
		"role" 			 => "admin",
		"username" => "Alamin Miah",
		"email" 		 => "alamin@gmail.com",
		"password"  => "12345"
	];
	$fileData = file($filename);
		
	if ( empty($fileData) ) {
		$fp = fopen($filename,"w");
		$data = sprintf("%s,%s,%s,%s\n",$adminInfo['role'],$adminInfo['username'],$adminInfo['email'],$adminInfo['password']);
		fwrite($fp,$data);
		fclose($fp);
	}
}

defaultAdminSet($filename);

/*************** Default User Set end  ****************/

/*************** Registration Process Start  ****************/
function getUserRegistrationInfo($input,$filename, &$errorMsg) {
	$username = $input['username'];
	$email  	   = $input['email'];
	$password = $input['password'];

	if ( $username=="" || $email=="" || $password=="" ) {
		$errorMsg = "Field Must Not be Empty!";
	}else {
	
		if ( !file_exists($filename) ) {
			$errorMsg = "{$filename} is not exist!";
			exit;
		}
	
		$fileData = file($filename);
		$existEmail = false;
		foreach($fileData as $data) {
			list($newRole,$newUsername,$newEmail,$newPassword) = explode(",",trim($data));
			if ( $newEmail == $email ) {
				$existEmail = true;
			}
		}
	
		if ( $existEmail ) {
			$errorMsg = "Already email registered. Please provide another email!";
		}else {
			$fp = fopen($filename,"a");
			$data = sprintf("%s,%s,%s,%s\n","user",$username,$email,$password);
			fwrite($fp,$data);
			header("Location:login.php");
			fclose($fp);
		}
	}
}

/***************  Registration Process End  ****************/


/***************  Login Process Start  ****************/
function userLoginProcess($input,$filename, &$errorMsg) {
	$email 	   = $input['email'];
	$password = $input['password'];
	
	if ($email=="" || $password=="") {
		$errorMsg = "Field Must Not be Empty!";
	}else {
		$fileData = file($filename);
		
		$isLogined = false;
		$loginRole = "";
		$loginUsername = "";
		$loginEmail = "";
		
		foreach($fileData as $data) {
			list($existRole,$existUsername,$existEmail,$existPassword) = explode(",",trim($data));
			if ( $existEmail == $email && $existPassword == $password ) {
				$isLogined = true;
				$loginRole = $existRole;
				$loginUsername = $existUsername;
				$loginEmail = $existEmail;
			}
		}
		
		if ( $isLogined ) {
			session_start();
			$_SESSION['login'] = true;
			$_SESSION['role'] = $loginRole;
			$_SESSION['username'] = $loginUsername;
			$_SESSION['email'] = $loginEmail;
			$_SESSION['success'] = true;
			header("Location:index.php");
		}else {
			$errorMsg = "Invalid Username or Password";
		}
	}
}
/***************  Login Process End  ****************/


/***************  Display Users Info Start  ****************/
function displayUsersInfo($filename) {
	return  file($filename);
}
/***************  Display Users Info End  ****************/

/***************  Delete User Start  ****************/
function deleteUser($filename,$delId) {
	$data = file($filename);
	if ($delId > count($data)) {
		header("Location:index.php");
	}
	
	unset($data[$delId]);

	$fp = fopen($filename,"w");
	foreach($data as $line) {
		$newLine = trim($line);
		fwrite($fp,"$newLine\n");
		header("Location:login.php");
	}
	fclose($fp);
}
/***************  Delete User End  ****************/

/*************** Update Process Start  ****************/
function updateUserInfo($input,$filename, &$errorMsg,$editId) {
	$username = $input['username'];
	$email  	   = $input['email'];
	$role           = $input['role'] ?? "";
	
	if ( $username=="" || $email=="" || $role=="" ) {
		$errorMsg = "Field Must Not be Empty!";
	}else {
		if ( !file_exists($filename) ) {
			$errorMsg = "{$filename} is not exist!";
			exit;
		}
	
		$fileData = file($filename);
		$existEmail = false;
		$emails = [];
		$oldPass = "";
		foreach($fileData as $data) {
			list($newRole,$newUsername,$newEmail,$newPassword) = explode(",",trim($data));
			$oldPass = $newPassword;
			if ( $newEmail == $email ) {
				array_push($emails,$newEmail);
				$existEmail = true;
			}
		}
	
		$totalEmail = count($emails);

		if ( $existEmail && $totalEmail > 1 ) {
			$errorMsg = "Already email registered. Please provide another email!";
		}else {
			unset($fileData[$editId]);
			
			$fp = fopen($filename,"w");
			foreach($fileData as $data) {
				fwrite($fp,$data);
			}
			fclose($fp);
			
			$fp = fopen($filename,"a");
			$data = sprintf("%s,%s,%s,%s\n",$role,$username,$email,$oldPass);
			fwrite($fp,$data);
			header("Location:login.php");
			fclose($fp);
		}
	}
}
/***************  Update Process End  ****************/

/***************  Add New Process Start  ****************/
function addNewUser($filename,$input,&$errorMsg) {
	$username = $input['username'];
	$email 	   = $input['email'];
	$role  		   = $input['role'] ?? "";
	$password = $input['password'];

	if ($username=="" || $email=="" || $role=="" || $password=="" ) {
		$errorMsg = "Field must not be empty!";
	}else {
		$fileData = file($filename);
		$foundEmail = false;
		foreach($fileData as $data) {
			list($existRole,$existUsername,$existEmail) = explode(",",$data);
			if ($existEmail == $email) {
				$foundEmail = true;
			}
		}
		
		if ($foundEmail) {
		$errorMsg = "Already email exists. Provide another email";
		}else {
			$fp = fopen($filename,"a");
			fwrite($fp,"$role,$username,$email,$password");
			header("Location:index.php");
			fclose($fp);
		}
	}
}

/***************  Add New Process End  ****************/