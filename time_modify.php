<html>
<head>
</head>
<body>
	<?php 
		include_once ('./config.php');
		$con = sqlsrv_connect($serverName, $connectionInfo);
		$ID = $_GET['ID'];
		$mode = $_GET['mode'];
		$date = $_GET['date'];
		extract($_POST);
		echo $hour;
		echo $min;
		if($mode === '1') $modi_sql =  "worker_attend_time";
		if($mode === '2') $modi_sql =  "worker_finish_time";
		if($mode === '3') $modi_sql =  "worker_attend_ot_time";
		if($mode === '4') $modi_sql =  "worker_finish_ot_time";
		if ($con == false) {
			echo "Unable to connect.</br>";
			die(print_r(sqlsrv_errors(), true));
		}
		
		$sql = "select
		worker_attend_time, 
		worker_finish_time, 
		worker_attend_ot_time, 
		worker_finish_ot_time
		from Attendance_info 
		where phone_id =".$ID."and worker_attend_day = '".$date."'and update_check = 1";
		$result = sqlsrv_query($con, $sql);
		$row = sqlsrv_fetch_array($result,SQLSRV_FETCH_ASSOC);
		
		if($mode === '1'){ 
			$worker_attend_time = $hour.":".$min;
			if(isset($row['worker_finish_time']) == TRUE) 	 $worker_finish_time = $row['worker_finish_time'] -> format('H:i'); else  $worker_finish_time = NULL;
			if(isset($row['worker_attend_ot_time']) == TRUE) $worker_attend_ot_time = $row['worker_attend_ot_time'] -> format('H:i'); else  $worker_attend_ot_time = NULL; 
			if(isset($row['worker_finish_ot_time']) == TRUE) $worker_finish_ot_time = $row['worker_finish_ot_time'] -> format('H:i'); else  $worker_finish_ot_time = NULL;
		}
		if($mode === '2'){ 
			$worker_finish_time =  $hour.":".$min;   
			if(isset($row['worker_attend_time']) == TRUE) 	 $worker_attend_time = $row['worker_attend_time'] -> format('H:i');	else  $worker_attend_time = NULL;
			if(isset($row['worker_attend_ot_time']) == TRUE) $worker_attend_ot_time = $row['worker_attend_ot_time'] -> format('H:i'); else  $worker_attend_ot_time = NULL;
			if(isset($row['worker_finish_ot_time']) == TRUE) $worker_finish_ot_time = $row['worker_finish_ot_time'] -> format('H:i'); else  $worker_finish_ot_time = NULL;
		}
		if($mode === '3'){
			$worker_attend_ot_time =  $hour.":".$min;
			if(isset($row['worker_attend_time']) == TRUE) 	 $worker_attend_time = $row['worker_attend_time'] -> format('H:i'); else  $worker_attend_time = NULL;
			if(isset($row['worker_finish_time']) == TRUE)	 $worker_finish_time = $row['worker_finish_time'] -> format('H:i'); else  $worker_finish_time = NULL;
			if(isset($row['worker_finish_ot_time']) == TRUE) $worker_finish_ot_time = $row['worker_finish_ot_time'] -> format('H:i'); else  $worker_finish_ot_time = NULL;
		}
		if($mode === '4'){
			$worker_finish_ot_time =  $hour.":".$min;
			if(isset($row['worker_attend_time']) == TRUE) 	 $worker_attend_time = $row['worker_attend_time'] -> format('H:i'); else  $worker_attend_time = NULL;
			if(isset($row['worker_finish_time']) == TRUE)	 $worker_finish_time = $row['worker_finish_time'] -> format('H:i'); else  $worker_finish_time = NULL;
			if(isset($row['worker_attend_ot_time']) == TRUE) $worker_attend_ot_time = $row['worker_attend_ot_time'] -> format('H:i'); else  $worker_attend_ot_time = NULL;
		}
		
		$sql = "UPDATE Attendance_info set update_check = 0 
			where phone_id = '".$ID. "' and worker_attend_day = '".$date."'";  
		sqlsrv_query($con, $sql);
		if($worker_attend_ot_time != NULL){
			$sql = "insert into Attendance_info(
				phone_id,
				worker_attend_time,
				worker_finish_time,
				worker_attend_ot_time,
				worker_finish_ot_time,
				worker_attend_day,
				update_check
			)
			values("
				."'".$ID."',"
				."'".$worker_attend_time."',"
				."'".$worker_finish_time."',"
				."'".$worker_attend_ot_time."',"
				."'".$worker_finish_ot_time."',"
				."'".$date."',"
				."'1')";
		}
		else{ 
			$sql = "insert into Attendance_info(
				phone_id,
				worker_attend_time,
				worker_finish_time,
				worker_attend_day,
				update_check
			)
			values("
				."'".$ID."',"
				."'".$worker_attend_time."',"
				."'".$worker_finish_time."',"
				."'".$date."',"
				."'1')";
		}
		echo $sql;
		sqlsrv_query($con, $sql);
		if($mode === '1') echo "<script>alert(\"출근시간이 수정 되였습니다.\"); location.href='responsive_dash_main.php';</script>";
		if($mode === '2') echo "<script>alert(\"퇴근시간이 수정 되였습니다.\"); location.href='responsive_dash_main.php';</script>";
		if($mode === '3') echo "<script>alert(\"OT출근시간이 수정 되였습니다.\"); location.href='responsive_dash_main.php';</script>";
		if($mode === '4') echo "<script>alert(\"OT퇴근시간이 수정 되였습니다.\"); location.href='responsive_dash_main.php';</script>";
	?>
</body>
</html>