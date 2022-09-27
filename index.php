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
			//获取任务
			function getData(){
				var id=getSelected();
				if(id==-1){
					alert('Please Select a Project!');
					return;
				}
				//ajax无法使用就直接跳到详情页面
				window.location.href ='detail.php?id='+id+"&username=<?php echo $_SESSION['username']; ?>";
				return;
				
				/* var json = {
				   id: id,
				   option: 'getdata'				    
				 };
				 //原生ajax
				 json = (function(obj){ // 转成post需要的字符串.
				   var str = "";
				   for(var prop in obj){
					 str += prop + "=" + obj[prop] + "&"
				   }
				   return str;
				 })(json);
				 var xhr = new XMLHttpRequest();
				 xhr.open("POST", "dataservice.php", true);
				 xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
				 xhr.onreadystatechange = function(){
				   var XMLHttpReq = xhr;
				   if (XMLHttpReq.readyState == 4) {
					 if (XMLHttpReq.status == 200) {					   
					   //JSON.parse(this.responseText);
					   var jsonObj = eval( '(' + this.responseText + ')' );  // eval();方法
						if(jsonObj.code>0){
							alert(jsonObj.msg );
						}else{
							if(jsonObj.total){
								$('#taskid').val(jsonObj.data.id);
								$('#taskName').val(jsonObj.data.taskName);
								$('#syy').val(jsonObj.data.syy);
								$('#smm').val(jsonObj.data.smm);
								$('#sdd').val(jsonObj.data.sdd);
								$('#eyy').val(jsonObj.data.eyy);
								$('#emm').val(jsonObj.data.emm);
								$('#edd').val(jsonObj.data.edd);
								$('#percent').val(jsonObj.data.percent);
								$("#addbtn").hide();
								$("#upbtn").show();
								$("#delbtn").show();	
								$("#gottask").show();
								
							}else{
								alert('数据获取失败');
							}
							
						}
					 }
				   }
				 }
				 xhr.send(json);*/
			}
			 //更新
			 function updateTask(){				 
				/*var id=$('#taskid').val();
				if(!id){
					alert('请选择一条数据');
					return;
				}			
				var json = {
				        id:id,
						taskName:$('#taskName').val(),
						syy:$('#syy').val(),
						smm:$('#smm').val(),
						sdd:$('#sdd').val(),
						eyy:$('#eyy').val(),
						emm:$('#emm').val(),
						edd:$('#edd').val(),
						percent:$('#percent').val(),
					    option:'updatedata'				    
				 };
				 //原生ajax
				 json = (function(obj){ // 转成post需要的字符串.
				   var str = "";
				   for(var prop in obj){
					 str += prop + "=" + obj[prop] + "&"
				   }
				   return str;
				 })(json);
				 var xhr = new XMLHttpRequest();
				 xhr.open("POST", "dataservice.php", true);
				 xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
				 xhr.onreadystatechange = function(){
				   var XMLHttpReq = xhr;
				   if (XMLHttpReq.readyState == 4) {
					 if (XMLHttpReq.status == 200) {					   
					   //JSON.parse(this.responseText);
					   var jsonObj = eval( '(' + this.responseText + ')' );  // eval();方法
					   if(jsonObj.code>0){
						   alert(jsonObj.msg );
						}else{					
							alert('更新成功');
							window.location.href ='index.php';
							
						}
					 }
				   }
				 }
				 xhr.send(json);
				 */
				
			}
			 
			
		     //删除
			 function delTask(){
				 		 
				/*if (confirm("你确定要执行删除操作码？")) {
					var id=$('#taskid').val();
					if(!id){
						alert('请选择一条数据');
						return;
					}	
					var json = {
				        id:id,					
						option:'deldata'		    
				    };
					 //原生ajax
					json = (function(obj){ // 转成post需要的字符串.
					   var str = "";
					   for(var prop in obj){
						 str += prop + "=" + obj[prop] + "&"
					   }
					   return str;
					 })(json);
					 var xhr = new XMLHttpRequest();
					 xhr.open("POST", "dataservice.php", true);
					 xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
					 xhr.onreadystatechange = function(){
					   var XMLHttpReq = xhr;
					   if (XMLHttpReq.readyState == 4) {
						 if (XMLHttpReq.status == 200) {					   
						   //JSON.parse(this.responseText);
						   var jsonObj = eval( '(' + this.responseText + ')' );  // eval();方法
						   if(jsonObj.code>0){
								alert(jsonObj.msg );
							}else{					
								alert('删除成功');
								window.location.href ='index.php';
								
							}
						 }
					   }
					 }e
					xhr.send(json);					
				}
				else {
					return;
				}			*/	
			}
			//返回添加页面
			function goToPostTask(){
			   window.location.href ='index.php';
			}
		</script>
		
		
		
	</div>
	<form method = "post" action="index.php">
		<!--<button type="submit" name="getDetails" class="btn">GetTaskDetails</button>-->
		<button type="button" name="getDetails" class="btn" onclick="getData()">GetTaskDetails</button>

	</form>
	
	<form method = "post" action="index.php">
			<?php include('errors.php'); ?>
			<input id="taskid" type = "hidden" name="taskid">
			<div class="input-group">
				<label>Please Enter Task Name</label>
				<input id="taskName" type = "text" name="taskName">
			</div>
			<div class="input-group">
				<label>Please Enter Start Year</label>
				<input id="syy" type = "number" name="syy">
			</div>
			<div class="input-group">
				<label>Please Enter Start Month</label>
				<input id="smm"  type = "number" name="smm">
			</div>
			<div class="input-group">
				<label>Please Enter Start Date</label>
				<input id="sdd"  type = "number" name="sdd">
			</div>
			<div class="input-group">
				<label>Please Enter End Year</label>
				<input id="eyy" type = "number" name="eyy">
			</div>
			<div class="input-group">
				<label>Please Enter End Month</label>
				<input id="emm" type = "number" name="emm">
			</div>
			<div class="input-group">
				<label>Please Enter End Date</label>
				<input id="edd" type = "number" name="edd">
			</div>
			<div class="input-group">
				<label>Please Enter Completed Percentage</label>
				<input id="percent" type = "number" name="percent">
			</div>
			<div class="input-group">
				 <button  id="addbtn" type="submit" name="postTask" class="btn">PostTask</button><span>	
				 <br/>
			     <span  id="upbtn"    class="btn" onclick="updateTask()" style="display:none;pargin-top:10px;cursor:pointer;">UpdateTask</span>
				 <span  id="delbtn"   class="btn" onclick="delTask()"    style="display:none;pargin-top:10px;cursor:pointer;">DelTask</span>
				 <span  id="gottask"  class="btn" onclick="goToPostTask()"    style="display:none;pargin-top:10px;cursor:pointer;">GoToPostTask</span>
			</div>
	      </form>	
	
	 
	
	 
</body>
</html>