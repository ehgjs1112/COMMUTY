<html>
<head>
<title>임시 출근 수정 창입니다.</title>
</head>
<body>
	<?php 
		include_once ('./config.php');
		extract($_POST);
		$ID = $_GET['ID'];
		$con = sqlsrv_connect($serverName, $connectionInfo);
		$actual_adress = iconv("UTF-8", "CP949//TRANSLIT", $actual_adress);
		$bank_name = iconv("UTF-8", "CP949//TRANSLIT", $bank_name);
		
		$s_sql = "select 
			worker_pone_number
			,worker_pw
			,woker_jumin
			,worker_type
			,worker_mail
			,join_date
			,worker_wage
			,ad_approval
			from
			worker_info
			where 
			phone_id = '".$ID."'
			 and 
			worker_flag = 1";
			
		$s_result = sqlsrv_query($con, $s_sql);
		$s_row = sqlsrv_fetch_array($s_result,SQLSRV_FETCH_ASSOC);
								
		$sql = "UPDATE worker_info set
			update_date = '".date('Y-m-d H:i')."',"
			." worker_flag = '0'
			where 
			phone_id = '".$ID."'"
			." and"
			." worker_flag = 1";  
		echo $sql;
		if ($con == false) {
			echo "Unable to connect.</br>";
			die(print_r(sqlsrv_errors(), true));
		}
		
		sqlsrv_query($con, $sql);
		echo $sql;
		$sql_in = "insert into worker_info
			(worker_pone_number
			,phone_id
			,worker_pw
			,worker_nm
			,worker_state
			,woker_jumin
			,worker_address
			,worker_type
			,worker_mail
			,ad_approval
			,bank_name
			,bank_account
			,join_date
			,worker_wage
			,worker_flag
			)
			values("
				."'".$s_row['worker_pone_number']."',"
				."'".$ID."',"
				."'".$s_row['worker_pw']."',"
				."'".$uname = iconv("UTF-8", "CP949//TRANSLIT", $uname)."',"
				."'1',"
				."'".$woker_jumin."',"
				."'".$actual_adress."',"
				."'".$s_row['worker_type']."',"
				."'".$s_row['worker_mail']."',"
				."'".$s_row['ad_approval']."',"
				."'".$bank_name."',"
				."'".$bankaccount."',"
				."'".$s_row['join_date']."',"
				."'".$s_row['worker_wage']."',"
				."'1'
			)";
		echo $sql_in;
		sqlsrv_query($con, $sql_in);
		echo "<script>alert(\"회원 정보가 변경 되었습니다.\"); location.href='responsive_dash_main.php';</script>";
		
	?>
</body>
</html>