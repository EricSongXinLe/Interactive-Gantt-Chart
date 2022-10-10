<?php include('server.php'); 
	if(empty($_SESSION['username'])){
		header('location:login.php');
	}
	$id=$_GET['id'];
?>
<!DOCTYPE html>
<html>
<head>
	<title>TaskManagementSystem</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	
	<div id="header" class="header">
		<h2>SubTasks</h2>
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
	<div id="chart_div" align = 'center'>
		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
			<script type="text/javascript">
			google.charts.load('current', {'packages':['gantt']});
			google.charts.setOnLoadCallback(drawChart);
			var chart;
		    var data;
			function drawChart() {
				data = new google.visualization.DataTable();
				data.addColumn('string', 'Task ID');
				data.addColumn('string', 'Task Name');
				data.addColumn('string', 'Resource');
				data.addColumn('date', 'Start Date');
				data.addColumn('date', 'End Date');
				data.addColumn('number', 'Duration');
				data.addColumn('number', 'Percent Complete');
				data.addColumn('string', 'Dependencies');
				data.addRows([
					<?php 
						global $db;
						$sql = "SELECT * FROM subtasks";
						$stmt = mysqli_query($db,$sql);
						while($datarows = mysqli_fetch_assoc($stmt)){
							echo "['" . $datarows['id']. " ','" . $datarows['subTaskName'] . "'," .'null'. ", new Date(" . $datarows['startYear']. "," . $datarows['startMonth']. "," . $datarows['startDate']. "),
									new Date(" . $datarows['endYear']. "," . $datarows['endMonth']. "," . $datarows['endDate']. "), ". 'null' . "," . $datarows['percent']. "," .'null'. "],";
						}

					?>
				]);

				var options = {
					height: 400,
					width: 1200,
					gantt: {
						criticalPathEnabled: false,
						labelStyle:{
							fontName: "comic sans ms",
							fontSize: 15
						},
						trackHeight: 80,
						backgroundColor: '#faead3'
					}

				};
				chart = new google.visualization.Gantt(document.getElementById('chart_div'));
				chart.draw(data, options);
			}
			function getSelected() {
				var a = chart.getSelection();
				if(a.length == 0) {
					return -1;
				}
				
				
				return data['Wf'][a[0]["row"]]['c'][0]["v"];
			}
			function getData(){
				var id=getSelected();
				if(id==-1){
					alert('Please Select a Project!');
					return;
				}
				window.location.href ='subdetail.php?id='+id+"&username=<?php echo $_SESSION['username']; ?>";
				return;
				
			}
			function goToPostTask(){
			   window.location.href ='index.php';
			}
		</script>
		
		
		
	</div>
	<form method = "post" action="index.php">
		<button type="button" name="getDetails" class="btn" onclick="getData()">GetSubTaskDetails</button>

	</form>
	
	<form method = "post" action="subtask.php">
			<?php include('errors.php'); ?>
			<input id="taskid" type = "hidden" name="taskid" value=<?php echo $id ?>>
			<div class="input-group">
				<label>Please Enter Task Name</label>
				<input id="subTaskName" type = "text" name="subTaskName">
			</div>
			<div class="input-group">
				<label>Please Enter Start Year</label>
				<input id="startYear" type = "number" name="startYear">
			</div>
			<div class="input-group">
				<label>Please Enter Start Month</label>
				<input id="startMonth"  type = "number" name="startMonth">
			</div>
			<div class="input-group">
				<label>Please Enter Start Date</label>
				<input id="startDate"  type = "number" name="startDate">
			</div>
			<div class="input-group">
				<label>Please Enter End Year</label>
				<input id="endYear" type = "number" name="endYear">
			</div>
			<div class="input-group">
				<label>Please Enter End Month</label>
				<input id="endMonth" type = "number" name="endMonth">
			</div>
			<div class="input-group">
				<label>Please Enter End Date</label>
				<input id="endDate" type = "number" name="endDate">
			</div>
			<div class="input-group">
				<label>Please Enter Completed Percentage</label>
				<input id="percent" type = "number" name="percent">
			</div>
			<div class="input-group">
				 <button  id="addbtn" type="submit" name="postSubTask" class="btn">PostSubTask</button><span>	
			</div>
	      </form>	
	
	 
	
	 
</body>
</html>