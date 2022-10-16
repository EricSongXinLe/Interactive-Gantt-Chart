<?php include('server.php'); 
	if(empty($_SESSION['username'])){
		header('location:login.php');
	}
	$id=$_GET['id'];
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
	<div class = "container">
		<div class="row my-5">
			<div class = "col-3">
				<div class="card d-flex flex-column border-0 shadow p-3">
						<div class="box-row my-1 p-2 rounded bg-primary text-white" id="select-gantt">View Gantt</div>
						<div class="box-row my-1 p-2 rounded" id="select-add">Add New Subtask</div>
						<div class="box-row my-1 p-2 rounded" id="select-detail">View Subtask Details</div>
						<div class="box-row my-1 p-2 rounded" id="select-home">Homepage</div>
				</div>
			</div>
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
								$sql = "SELECT * FROM subtasks WHERE taskid = $id";
								$stmt = mysqli_query($db,$sql);
								while($datarows = mysqli_fetch_assoc($stmt)){
									$datarows['startMonth'] = $datarows['startMonth']-1;
									$datarows['endMonth'] = $datarows['endMonth']-1;
									echo "['" . $datarows['id']. " ','" . $datarows['subTaskName'] . "'," .'null'. ", new Date(" . $datarows['startYear']. "," . $datarows['startMonth']. "," . $datarows['startDate']. "),
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
								trackHeight: 40,
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
						
						
						return data['Wf'][a[0]["row"]]['c'][0]["v"]; //special code that reveals the id of the subtask, lol
					}
					function getData(){
						var id=getSelected();
						if(id==-1){
							alert('Please Select a Subtask!');
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
		</div>
	</div>
	<form class = "NewTask" method = "post" action="subtask.php" id = "board">
			<?php include('errors.php'); ?>
			<input id="taskid" type = "hidden" name="taskid" value=<?php echo $id ?>>
			<div class="input-group">
				<label>Please Enter Task Name</label>
				<input id="subTaskName" type = "text" name="subTaskName">
			</div>
			<div class="input-group-Year">
				<label>Please Enter Start Year</label>
				<input id="startYear" type = "number" name="startYear">
			</div>
			<div class="input-group-Month">
				<label>Please Enter Start Month</label>
				<input id="startMonth"  type = "number" name="startMonth">
			</div>
			<div class="input-group-Day">
				<label>Please Enter Start Date</label>
				<input id="startDate"  type = "number" name="startDate">
			</div>
			<div class="input-group-Year">
				<label>Please Enter End Year</label>
				<input id="endYear" type = "number" name="endYear">
			</div>
			<div class="input-group-Month">
				<label>Please Enter End Month</label>
				<input id="endMonth" type = "number" name="endMonth">
			</div>
			<div class="input-group-Day">
				<label>Please Enter End Date</label>
				<input id="endDate" type = "number" name="endDate">
			</div>
			<div class="input-group-Percent">
				<label>Please Enter Completed Percentage</label>
				<input id="percent" type = "number" name="percent">
			</div>
			<button  id="addbtn" type="submit" name="postSubTask" class="btn btn-outline-danger">PostSubTask</button><span>
	      </form>	
	<script type="text/javascript" src="script.js"></script>
</body>
</html>