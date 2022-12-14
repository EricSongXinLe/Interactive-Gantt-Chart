<?php include('server.php'); 
	if(empty($_SESSION['username'])){
		header('location:login.php');
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>ClubManagementSystem</title>
	<link rel="stylesheet" type="text/css" href="bootstrap.css">
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body class="bg-light">
	<div class="navbar navbar-light bg-white px-3">
		<div class="container">
			<a class="navbar-brand">Home Page</a>
			<a href="index.php?logout='1'" class="btn btn-outline-danger">Log Out</a>
		</div>
	</div>
	<div class="container">
		<div class="row my-5">
			<div class="col-3">
				<div class="card d-flex flex-column border-0 shadow p-3">
					<div class="box-row my-1 p-2 rounded bg-primary text-white" id="select-gantt">View Gantt</div>
					<div class="box-row my-1 p-2 rounded" id="select-add">Add New Task</div>
					<div class="box-row my-1 p-2 rounded" id="select-detail">View Task Details</div>
					<div class="box-row my-1 p-2 rounded" id="select-subtask">View Subtasks</div>
				</div>
			</div>
			<div class="col-5">
				<div class="card d-flex flex-column border-0 shadow p-3">
					<label>Welcome!</label>
					<label>Check out the tasks that our Computer Science Club has!</label>
				</div>
			</div>
			<div>
				<div id="chart_div">
					<script type="text/javascript" src="loader.js"></script>
					<script type="text/javascript" src="jquery.min.js"></script>
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
									$sql = "SELECT * FROM tasks";
									$stmt = mysqli_query($db,$sql);
									while($datarows = mysqli_fetch_assoc($stmt)){
										$datarows['startMonth'] = $datarows['startMonth']-1;
										$datarows['endMonth'] = $datarows['endMonth']-1;
										echo "['" . $datarows['id']. " ','" . $datarows['taskName'] . "'," .'null'. ", new Date(" . $datarows['startYear']. "," . $datarows['startMonth']. "," . $datarows['startDate']. "),
												new Date(" . $datarows['endYear']. "," . $datarows['endMonth']. "," . $datarows['endDate']. "), ". 'null' . "," . $datarows['percent']. "," .'null'. "],";
									}

								?>
							]);

							var options = {
								height: 600,

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
							//console.log(data['Wf'][0]['c'][0]);
						}
						function getSelected() {
							
						
							var a = chart.getSelection();
							if(a.length == 0) {
								return -1;
							}
							
							
							return data['Wf'][a[0]["row"]]['c'][0]["v"];
						}
						//get details
						function getData(){
							var id=getSelected();
							if(id==-1){
								alert('Please Select a Task!');
								return;
							}
							
							window.location.href ='detail.php?id='+id+"&username=<?php echo $_SESSION['username']; ?>";
							return;
							
						}
						function goSubtask(){
							var id=getSelected();
							if(id==-1){
								alert('Please Select a Task!');
								return;
							}
							
							window.location.href ='subtask.php?id='+id+"&username=<?php echo $_SESSION['username']; ?>";
							return;
							
						}
						
						function goToPostTask(){
						window.location.href ='index.php';
						}
					</script>
					
					
					
				</div>
			</div>
		</div>
	</div>
	
	
	<form  class = "NewTask" method = "post" action="index.php" id="board">
			<?php include('errors.php'); ?>
			<input id="taskid" type = "hidden" name="taskid">
			<div class="input-group">
				<label>Task Name</label>
				<input id="taskName" type = "text" name="taskName">
			</div>
			<div class="input-group-Year">
				<label>Start Year</label> 
				<input id="startYear" type = "number" name="startYear">
			</div>
			<div class="input-group-Month">
				<label>Start Month</label>
				<input id="startMonth"  type = "number" name="startMonth">
			</div>
			<div class="input-group-Day">
				<label>Start Date</label>
				<input id="startDate"  type = "number" name="startDate">
			</div>
			<div class="input-group-Year">
				<label>End Year</label>
				<input id="endYear" type = "number" name="endYear">
			</div>
			<div class="input-group-Month">
				<label>End Month</label>
				<input id="endMonth" type = "number" name="endMonth">
			</div>
			<div class="input-group-Day">
				<label>End Date</label>
				<input id="endDate" type = "number" name="endDate">
			</div>
			<div class="input-group-Percent">
				<label>Completed Percentage</label>
				<input id="percent" type = "number" name="percent">
			</div>
			<label> Select members of the Task: </label>
			<br>
				<?php
					$findusers = "SELECT * FROM users";
					$findusersresult = $db->query($findusers);
					//echo($foundusers);
					while($row = $findusersresult->fetch_assoc()){
					?>
					<div>
						<input type="checkbox" name="selectedPerson[]" value = <?php echo $row["id"]?>> <?php echo $row["username"]?></input>
					</div>
            <?php
            	}
				?>
			
			<div class="input-group">
				<button  type="submit" name="postTask" class="btn btn-outline-danger">PostTask</button><span>	
			</div>
	      </form>
	
	
		<script type="text/javascript" src="script.js"></script>
	</body>
</html>