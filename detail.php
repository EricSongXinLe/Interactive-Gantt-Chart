<?php 
	$errors = array();
  //  include('server.php'); 
    $username=$_REQUEST['username'];
	if(empty($username)){
	    header('location:login.php');
	}

	$db = mysqli_connect('localhost','root','','club-registration') or die("Connection Failed" .mysql_connect_error());

    $loginQ = "SELECT * FROM users WHERE username='$username' ";
	$result = mysqli_query($db, $loginQ);
	if (false===$result){
		printf("error: %s\n", mysqli_error($db));
	}
	if(mysqli_num_rows($result) == 1){
		//Login Success
		$_SESSION['username'] = $username;
		//header('location: index.php');
	}else{
		array_push($errors,"Wrong Combination");
	}
    
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
			// 输出数据				
			$row = $result->fetch_assoc();				 
		}
	}
				
				 
				 
	 
	if(isset($_POST['UpdateTask'])){	
                $id=$_POST['taskid'];	
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
					$sql = "update tasks set taskName='{$taskName}',syy='{$syy}',smm='{$smm}',sdd='{$sdd}',eyy='{$eyy}',emm='{$emm}',edd='{$edd}',percent='{$percent}' where id='{$id}'";
					$query = mysqli_query($db,$sql);
					if (false===$query) {
						 array_push($errors,"更新失败");
						 
					}else{					
						header('location:detail.php?id='.$id.'&username='.$_SESSION["username"]);	
					}
				}
						
		 
	}
	if(isset($_POST['delTask'])){
		     
			   $id=$_POST['taskid'];	
				$sql = "delete from  tasks where id='{$id}'";
				$query = mysqli_query($db,$sql);
				if (false===$query) {				
					 array_push($errors,"删除失败");
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
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
	
	<div id="header" class="header">
		<h2>HomePage</h2>
	</div>
	<div class="content">
		<?php if (isset($_SESSION['success'])): ?>
			<div class="error success">
				<h3>
					<?php
						echo $_SESSION['success'];
						unset($_SESSION['success']);
					?>
				</h3>
		<?php endif ?>
		<?php if (isset($_SESSION["username"])): ?>
			<p>Welcome, <strong><?php echo $_SESSION['username']; ?></strong> !</p>
			<p><a href="index.php?logout='1'" style="color: red;">Logout</a></p>
		<?php endif ?>
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
			<div class="input-group">
				<label>Please Enter Start Year</label>
				<input id="syy" type = "number" value="<?php echo $row['syy'];?>" name="syy">
			</div>
			<div class="input-group">
				<label>Please Enter Start Month</label>
				<input id="smm"  type = "number" value="<?php echo $row['smm'];?>" name="smm">
			</div>
			<div class="input-group">
				<label>Please Enter Start Date</label>
				<input id="sdd"  type = "number"  value="<?php echo $row['sdd'];?>"name="sdd">
			</div>
			<div class="input-group">
				<label>Please Enter End Year</label>
				<input id="eyy" type = "number" value="<?php echo $row['eyy'];?>" name="eyy">
			</div>
			<div class="input-group">
				<label>Please Enter End Month</label>
				<input id="emm" type = "number"  value="<?php echo $row['emm'];?>"name="emm">
			</div>
			<div class="input-group">
				<label>Please Enter End Date</label>
				<input id="edd" type = "number"  value="<?php echo $row['edd'];?>"name="edd">
			</div>
			<div class="input-group">
				<label>Please Enter Completed Percentage</label>
				<input id="percent" type = "number" value="<?php echo $row['percent'];?>" name="percent">
			</div>
			<div class="input-group">
				 <button    type="submit" name="UpdateTask" class="btn">UpdateTask</button><span>	
				 <button    type="submit" name="delTask" class="btn">DelTask</button><span>	
				  <button    type="submit" name="goIndex" class="btn">GoToPostTask</button><span>	
				 
				 
			</div>
	      </form>	
	
	 
	
	 
</body>
</html>