<?php include('server.php'); 
	if(empty($_SESSION['username'])){
		header('location:login.php');
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>ClubManagementSystem</title>
	<link rel="stylesheet" type="text/css" href="style.css">
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
						$sql = "SELECT * FROM tasks";
						$stmt = mysqli_query($db,$sql);
						while($datarows = mysqli_fetch_assoc($stmt)){
							echo "['" . $datarows['id']. " ','" . $datarows['taskName'] . "'," .'null'. ", new Date(" . $datarows['syy']. "," . $datarows['smm']. "," . $datarows['sdd']. "),
									new Date(" . $datarows['eyy']. "," . $datarows['emm']. "," . $datarows['edd']. "), ". 'null' . "," . $datarows['percent']. "," .'null'. "],";
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
				//console.log(data['Wf'][0]['c'][0]);
			}
			function getSelected() {
				var a = chart.getSelection();
				if(a.length == 0) {
					return -1;
				}
				return data['Wf'][a[0]["row"]]['c'][0]["v"];
			}
			
		</script>
		
	</div>
	<form method = "post" action="index.php">
		<button type="submit" name="getDetails" class="btn">GetTaskDetails</button>
	</form>
	<form method = "post" action="index.php">
			<?php include('errors.php'); ?>
			<div class="input-group">
				<label>Please Enter Task Name</label>
				<input type = "text" name="taskName">
			</div>
			<div class="input-group">
				<label>Please Enter Start Year</label>
				<input type = "number" name="syy">
			</div>
			<div class="input-group">
				<label>Please Enter Start Month</label>
				<input type = "number" name="smm">
			</div>
			<div class="input-group">
				<label>Please Enter Start Date</label>
				<input type = "number" name="sdd">
			</div>
			<div class="input-group">
				<label>Please Enter End Year</label>
				<input type = "number" name="eyy">
			</div>
			<div class="input-group">
				<label>Please Enter End Month</label>
				<input type = "number" name="emm">
			</div>
			<div class="input-group">
				<label>Please Enter End Date</label>
				<input type = "number" name="edd">
			</div>
			<div class="input-group">
				<label>Please Enter Completed Percentage</label>
				<input type = "number" name="percent">
			</div>
			<div class="input-group">
				<button type="submit" name="postTask" class="btn">PostTask</button>
			</div>
	</form>	
</body>
</html>