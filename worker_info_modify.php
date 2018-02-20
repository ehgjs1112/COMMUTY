<html>
<head>
<title>임시 출근자 정보 수정 창입니다.</title>
</head>
<body>
	<?php 
		include_once ('./config.php');
		include_once ('./session_check.php');	
		extract($_POST);
		
		if($user_pass != ""){
			//if($pass_wd)
			$ID = $_SESSION['uname'];
			$con = sqlsrv_connect($serverName, $connectionInfo);
			$sql = "UPDATE worker_info set 
				worker_flag = 0, 
				update_date = '".date('Y-m-d H:i')
				."' where "
				."phone_id = '".$ID."' "
				."and "
				."worker_flag = 1";  
	
			if ($con == false) {
				echo "Unable to connect.</br>";
				die(print_r(sqlsrv_errors(), true));
			}
			echo $sql;
			sqlsrv_query($con, $sql);

			$sql_in = "insert into worker_info(
					worker_pone_number,
					woker_jumin,
					phone_id,
					worker_nm,
					worker_pw,
					worker_address,
					worker_mail,
					bank_name,
					bank_account,
					join_date,
					worker_flag,
					worker_state
				)
				values("
					."'".$worker_pone_number."',"
					."'".$woker_jumin."',"
					."'".$ID."',"
					."'".$uname = iconv("UTF-8", "CP949//TRANSLIT", $uname)."',"
					."'".$user_pass."',"
					."'".$address = iconv("UTF-8", "CP949//TRANSLIT", $address)."',"
					."'".$mail."',"
					."'".$bank = iconv("UTF-8", "CP949//TRANSLIT", $bank)."',"
					."'".$bankaccount."',"
					."'".$join_date."',"
					."'1','1')";
			echo $sql_in;
			sqlsrv_query($con, $sql_in);
			echo "<script>alert(\"회원 정보가 변경 되었습니다.\"); location.href='responsive_my_information.php';</script>";
		}
		else{
			echo "<script>alert(\"비밀번호가 입력되지 않았습니다.(비밀번호 변경시 재확인까지 입력해 주세요 !!!)\"); location.href='responsive_my_information.php';</script>";
		}
	?>
</body>
</html>