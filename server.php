<?php
	session_start();
	$username = "";
	$email = "";
	$errors = array();
	$password_1 = null;
	$password_2 = null;
	$taskName = "";
	$syy=null;
	$smm=null;
	$sdd=null;
	$eyy=null;
	$emm=null;
	$edd=null;
	$percent = 0;

	//connect to DB
	$db = mysqli_connect('localhost','root','','club-registration') or die("Connection Failed" .mysql_connect_error());

	if(isset($_POST['register'])){ //Register button CLICK event
		$username = $_POST['username'];
		$email = $_POST['email'];
		$password_1 = $_POST['password_1'];
		$password_2 = $_POST['password_2'];
			//VALIDATION
		#$errors=null;
		if (empty($username)){
			array_push($errors,"Username is required");
		}
		if (empty($email)){
			array_push($errors,"Email is required");
		}
		if (empty($password_1)){
			array_push($errors,"Password is required");
		}
		if ($password_1 != $password_2){
			array_push($errors,"Passwords must match");
		}
		#if (strlen($password_1) < 5){
		#	array_push($errors,"Password too short, must be longer than 4 characters");
		#}
		if (count($errors) == 0) {
			$password = md5($password_1);
			$sql = "INSERT INTO users (username,email,password) VALUES ('$username', '$email', '$password')";
			$query = mysqli_query($db,$sql);
			if (false===$query) {
				printf("error: %s\n", mysqli_error($db));
			}
			$_SESSION['username'] = $username;
			header('location: index.php');

		}
	}
	
	//login time
	if(isset($_POST['login'])){
		//$errors=null;
		$username = $_POST['username'];
		$password = $_POST['password'];
		if (empty($username)){
			array_push($errors,"Username is required");
		}
	
		if (empty($password)){
			array_push($errors,"Password is required");
		}
		if(count($errors) ==0){
			$password = md5($password); //md5 encryption
			#printf($password);
			$loginQ = "SELECT * FROM users WHERE username='$username' AND password = '$password'";
			$result = mysqli_query($db, $loginQ);
			if (false===$result){
				printf("error: %s\n", mysqli_error($db));
			}
			if(mysqli_num_rows($result) == 1){
				//Login Success
				$_SESSION['username'] = $username;
				header('location: index.php');
			}else{
				array_push($errors,"Wrong Combination");
			}
		}
	}
	//logout time
	if(isset($_GET['logout'])){
		session_destroy();
		unset($_SESSION['username']);
		header('location:login.php');
	}
	if(isset($_POST['postTask'])){
		$taskName = $_POST['taskName'];
		$syy = $_POST['syy'];
		$smm = $_POST['smm'];
		$sdd = $_POST['smm'];
		$eyy = $_POST['eyy'];
		$emm = $_POST['emm'];
		$edd = $_POST['edd'];
		$percent = $_POST['percent'];
		if (empty($taskName)){
			array_push($errors,"Task name is required");
		}
		if (empty($syy)){
			array_push($errors,"Start Year is required");
		}
		if (empty($smm)){
			array_push($errors,"Start Month is required");
		}
		if (empty($sdd)){
			array_push($errors,"Start Date is required");
		}
		if (empty($eyy)){
			array_push($errors,"End Year is required");
		}
		if (empty($emm)){
			array_push($errors,"End Month is required");
		}
		if (empty($edd)){
			array_push($errors,"End Date is required");
		}
		if (empty($percent)){
			$percent = 0;
		}
		if(count($errors)==0){
			$sql = "INSERT INTO tasks (taskName,syy,smm,sdd,eyy,emm,edd,percent) VALUES ('$taskName', '$syy', '$smm', '$sdd','$eyy','$emm','$edd','$percent')";
			$query = mysqli_query($db,$sql);
			if (false===$query) {
				printf("error: %s\n", mysqli_error($db));
			}
		}
	}
?>