<?php
	session_start();
	$username = "";
	$email = "";
	$errors = array();
	$password_1 = null;
	$password_2 = null;
	$taskName = "";
	$startYear=null;
	$startMonth=null;
	$startDate=null;
	$endYear=null;
	$endMonth=null;
	$endDate=null;
	$percent = 0;

	//connect to DB
	$db = mysqli_connect('localhost','root','','club-registration');

	if(isset($_POST['register'])){ //Register button CLICK event
		$username = $_POST['username'];
		$email = $_POST['email'];
		$password_1 = $_POST['password_1'];
		$password_2 = $_POST['password_2'];
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
		$startYear = $_POST['startYear'];
		$startMonth = $_POST['startMonth'];
		$startDate = $_POST['startDate'];
		$endYear = $_POST['endYear'];
		$endMonth = $_POST['endMonth'];
		$endDate = $_POST['endDate'];
		$percent = $_POST['percent'];
		if (empty($taskName)){
			array_push($errors,"Task name is required");
		}
		if (empty($startYear)){
			array_push($errors,"Start Year is required");
		}
		if (empty($startMonth)){
			array_push($errors,"Start Month is required");
		}
		if (empty($startDate) or $startDate <0 or $startDate > 31){
			array_push($errors,"Start Date is not valid/or empty");
		}
		if (empty($endYear)){
			array_push($errors,"End Year is required");
		}
		if (empty($endMonth)){
			array_push($errors,"End Month is required");
		}
		if (empty($endDate)){
			array_push($errors,"End Date is required");
		}
		if (empty($percent)){
			$percent = 0;
		}
		if(count($errors)==0){
			$sql = "INSERT INTO tasks (taskName,startYear,startMonth,startDate,endYear,endMonth,endDate,percent) VALUES ('$taskName', '$startYear', '$startMonth', '$startDate','$endYear','$endMonth','$endDate','$percent')";
			$query = mysqli_query($db,$sql);
			if (false===$query) {
				printf("error: %s\n", mysqli_error($db));
			}
			$getTaskID = "SELECT max(id) as taskID FROM tasks";
			$query = $db->query($getTaskID);
			$row = $query->fetch_assoc();
			$currentID = $row["taskID"];
			foreach ($_POST['selectedPerson'] as $i){
				$sql = "INSERT INTO usertask (userid,taskid) VALUES ($i,$currentID)";
				$query = mysqli_query($db,$sql);
				if (false===$query) {
					printf("error: %s\n", mysqli_error($db));
				}
			}
		}
	}
	if(isset($_POST['postSubTask'])){
		$subTaskName = $_POST['subTaskName'];
		$startYear = $_POST['startYear'];
		$startMonth = $_POST['startMonth'];
		$startDate = $_POST['startDate'];
		$endYear = $_POST['endYear'];
		$endMonth = $_POST['endMonth'];
		$endDate = $_POST['endDate'];
		$percent = $_POST['percent'];
		$id = $_POST['taskid'];
		if (empty($subTaskName)){
			array_push($errors,"Subtask name is required");
		}
		if (empty($startYear)){
			array_push($errors,"Start Year is required");
		}
		if (empty($startMonth)){
			array_push($errors,"Start Month is required");
		}
		if (empty($startDate)){
			array_push($errors,"Start Date is required");
		}
		if (empty($endYear)){
			array_push($errors,"End Year is required");
		}
		if (empty($endMonth)){
			array_push($errors,"End Month is required");
		}
		if (empty($endDate)){
			array_push($errors,"End Date is required");
		}
		if (empty($percent)){
			$percent = 0;
		}
		if(count($errors)==0){
			$sql = "INSERT INTO subtasks (subTaskName,startYear,startMonth,startDate,endYear,endMonth,endDate,taskid,percent) VALUES ('$subTaskName', $startYear, $startMonth, $startDate,$endYear,$endMonth,$endDate,$id, $percent)";
			$query = mysqli_query($db,$sql);
			if (false===$query) {
				printf("error: %s\n", mysqli_error($db));
			}
		}
	}
?>