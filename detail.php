<?php 
	$errors = array();
  //  include('server.php'); 
    $username=$_REQUEST['username'];
	if(empty($username)){
	    header('location:login.php');
	}

	$db = mysqli_connect('localhost','root','','club-registration') or die("Connection Failed" .mysql_connect_error());


    
    $id=$_GET['id'];
	
	
	if(!$id){
		header('location:login.php');		
	}
	if(isset($_GET)){
		 $row=[];
		 $sql = "SELECT * FROM tasks WHERE id={$id} limit 1";
		 $result = $db->query($sql);
		 $total=$result->num_rows;
		 if ($result->num_rows > 0) {			 				
			$row = $result->fetch_assoc();				 
		}
	}
	if(isset($_POST['UpdateTask'])){	
                $id=$_POST['taskid'];	
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
					$sql = "update tasks set taskName='{$taskName}',startYear='{$startYear}',startMonth='{$startMonth}',startDate='{$startDate}',endYear='{$endYear}',endMonth='{$endMonth}',endDate='{$endDate}',percent='{$percent}' where id='{$id}'";
					$query = mysqli_query($db,$sql);
					$sql = "delete from usertask where taskID='{$id}'";
					$query = mysqli_query($db,$sql);
					foreach ($_POST['selectedPerson'] as $i){
						$sql = "INSERT INTO usertask (userid,taskid) VALUES ($i,$id)";
						$query = mysqli_query($db,$sql);
						if (false===$query) {
							printf("error: %s\n", mysqli_error($db));
						}
					}
				}
						
		 
	}
	if(isset($_POST['delTask'])){
			   $id=$_POST['taskid'];	
				$sql = "delete from  tasks where id='{$id}'";
				$query = mysqli_query($db,$sql);
				if (false===$query) {				
					printf("error: %s\n", mysqli_error($db));
					
				}else{					
					header('location:index.php');		
				}
	}
	if(isset($_POST['goIndex'])){
					header('location:index.php');		
				 
	}
	
	 
?>
<!DOCTYPE html>
<html>
<head>
	<title>ClubManagementSystem</title>
	<script src="jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="bootstrap.css">
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body class="bg-light">
	<div class="navbar navbar-light bg-white px-3">
		<div class = "container">
			<a class="navbar-brand">Task Details</a>
			<a href="index.php?logout='1'" class="btn btn-outline-danger">Log Out</a>
		</div>
	</div>
	<form method = "post" action="detail.php?id=<?php echo $id;?>&username=$_SESSION['username']">
			<?php include('errors.php'); ?>
			<div class="input-group">
				<label>ID</label>
				<input   type = "text" value="<?php echo $row['id'];?>" name="showid" disabled>
			</div>
			<input id="taskid" type = "hidden" value="<?php echo $row['id'];?>" name="taskid">
			<input  type = "hidden" value="<?php echo $_SESSION["username"];?>" name="username">
			<div class="input-group">
				<label>Please Enter Task Name</label>
				<input id="taskName" type = "text" value="<?php echo $row['taskName'];?>" name="taskName">
			</div>
			<div class="input-group-Year">
				<label>Please Enter Start Year</label>
				<input id="startYear" type = "number" value="<?php echo $row['startYear'];?>" name="startYear">
			</div>
			<div class="input-group-Month">
				<label>Please Enter Start Month</label>
				<input id="startMonth"  type = "number" value="<?php echo $row['startMonth'];?>" name="startMonth">
			</div>
			<div class="input-group-Day">
				<label>Please Enter Start Date</label>
				<input id="startDate"  type = "number"  value="<?php echo $row['startDate'];?>"name="startDate">
			</div>
			<div class="input-group-Year">
				<label>Please Enter End Year</label>
				<input id="endYear" type = "number" value="<?php echo $row['endYear'];?>" name="endYear">
			</div>
			<div class="input-group-Month">
				<label>Please Enter End Month</label>
				<input id="endMonth" type = "number"  value="<?php echo $row['endMonth'];?>"name="endMonth">
			</div>
			<div class="input-group-Day">
				<label>Please Enter End Date</label>
				<input id="endDate" type = "number"  value="<?php echo $row['endDate'];?>"name="endDate">
			</div>
			<div class="input-group-Percent">
				<label>Please Enter Completed Percentage</label>
				<input id="percent" type = "number" value="<?php echo $row['percent'];?>" name="percent">
			</div>
			<?php
			$checked = "SELECT users.*  from users,tasks,usertask where users.id = usertask.userid and tasks.id = usertask.taskid and tasks.id = {$id}";
			$findusers = "SELECT * FROM users";
			$checkedResult = $db->query($checked);
			$selected = [];
			while($row2 = $checkedResult->fetch_assoc()){
				array_push($selected,$row2["id"]);
			}
			$checkedUserID = [];
			foreach ($selected as $key => $value){
				array_push($checkedUserID,$value);
			}
			$findusersresult = $db->query($findusers);
			//print_r($checkedUserID);
			while($row = $findusersresult->fetch_assoc()){
				//echo $row["id"];
				//echo (in_array($row["id"],$checkedUserID));
				?>
				<div>
					<input type="checkbox" <?php if(in_array($row["id"],$checkedUserID)){echo 'checked ';}?>name="selectedPerson[]" value = <?php echo $row["id"]?>><?php echo $row["username"]?></input>
				</div>
			<?php
			}
			?>
			<div>
				<button    type="submit" name="UpdateTask" class="btn btn-outline-danger">UpdateTask</button><span>	
				<button    type="submit" name="delTask" class="btn btn-outline-danger">DelTask</button><span>	
				<button    type="submit" name="goIndex" class="btn btn-outline-danger">Back</button><span>	
			</div>
	      </form>	
</body>
</html>