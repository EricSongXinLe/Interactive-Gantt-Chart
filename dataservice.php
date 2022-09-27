<?php
	//connect to DB
	$db = mysqli_connect('localhost','root','root','club-registration') or die("Connection Failed" .mysql_connect_error());


	$option='';
	if(isset($_POST['option'])){
		$option=$_POST['option'];
	}
	if($option){
		switch($option){
			case 'getdata':
				$id=$_POST['id'];
				if(!$id){
					echo json_encode(array('code'=>1,'msg'=>'参数不能为空','data'=>''));
					exit;
				}
				 $row=[];
				 $sql = "SELECT * FROM tasks WHERE id={$id} limit 1";
				 $result = $db->query($sql);
				 $total=$result->num_rows;
				if ($result->num_rows > 0) {			 
					// 输出数据				
					$row = $result->fetch_assoc();				 
				} 
				
				echo json_encode(['code'=>0,'msg'=>'ok','data'=> $row,'total'=>$total]);
				$db->close();
				exit;
			break;
			case 'updatedata':
				$id=$_POST['id'];
				$taskName = $_POST['taskName'];
				$syy = $_POST['syy'];
				$smm = $_POST['smm'];
				$sdd = $_POST['smm'];
				$eyy = $_POST['eyy'];
				$emm = $_POST['emm'];
				$edd = $_POST['edd'];
				$percent = $_POST['percent'];
				if (empty($taskName)){
					echo json_encode(array('code'=>1,'msg'=>'Task name is required','data'=>''));
					exit;
				}
				if (empty($syy)){
					echo json_encode(array('code'=>1,'msg'=>'Start Year is required','data'=>''));
					exit;
				}
				if (empty($smm)){
					echo json_encode(array('code'=>1,'msg'=>'Start Month is required','data'=>''));
					exit;
				}
				if (empty($sdd)){
					echo json_encode(array('code'=>1,'msg'=>'Start Date is required','data'=>''));
					exit;
				}
				if (empty($eyy)){
					echo json_encode(array('code'=>1,'msg'=>'End Year is required','data'=>''));
					exit;
				}
				if (empty($emm)){
					echo json_encode(array('code'=>1,'msg'=>'End Month is required','data'=>''));
					exit;
				}
				if (empty($edd)){
					echo json_encode(array('code'=>1,'msg'=>'End Date is required','data'=>''));
					exit;
				}
				if (empty($percent)){
					$percent = 0;
				}
			
				$sql = "update tasks set taskName='{$taskName}',syy='{$syy}',smm='{$smm}',sdd='{$sdd}',eyy='{$eyy}',emm='{$emm}',edd='{$edd}',percent='{$percent}' where id='{$id}'";
				$query = mysqli_query($db,$sql);
				if (false===$query) {
					
					echo json_encode(array('code'=>1,'msg'=>'update faild','data'=>''));
					$db->close();
					exit;
				}else{					
					 echo json_encode(['code'=>0,'msg'=>'ok','data'=> $row,'total'=>$total]);		
				}
					
			
				$db->close();
			break;
			case 'deldata':
			    $id = $_POST['id'];
				 
				if(!$id){
					echo json_encode(array('code'=>1,'msg'=>'参数不能为空','data'=>''));
					exit;
				}
			
				$sql = "delete from  tasks where id='{$id}'";
				$query = mysqli_query($db,$sql);
				if (false===$query) {				
					echo json_encode(array('code'=>1,'msg'=>'update faild','data'=>''));
					$db->close();
					exit;
				}else{					
					 echo json_encode(['code'=>0,'msg'=>'ok','data'=> $row,'total'=>$total]);		
				}
							
				$db->close();
			break;
			
			
		}
	}
	
	
?>