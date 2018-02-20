<?php
	include_once ('./config.php');
	$con = sqlsrv_connect($serverName, $connectionInfo);
	if ($con == false) {
		echo "Unable to connect.</br>";
		die(print_r(sqlsrv_errors(), true));
	}
	extract($_POST);
	$user_table_nm = "worker_info";
	$user_field_nm = "worker_pone_number";
	$join_date = date("Y-m-d");
	

	$worker_pone_number = $_POST['user_id'];
	$ID = trim(substr($worker_pone_number,4,4).substr($worker_pone_number,9,4));
	$worker_pw = $_POST['user_pass'];
	$worker_nm = $_POST['uname'];
	$worker_address = $_POST['address'];
	$worker_mail = $_POST['mail'];
	$bank_name = $_POST['bank'];
	$bank_account = $_POST['bankaccount'];
	
	$cost_center = $_POST['cost_center'];
	$department  = $_POST['department'];
	
	$sql = "select count(case when phone_id in ('".$ID."') then 1 end) as num from worker_info";
	$result = sqlsrv_query($con, $sql);
	$row = sqlsrv_fetch_array($result,SQLSRV_FETCH_ASSOC);
	if ($row['num'] === 0) {
		if(strcmp($user_pass,"")!=0 and strcmp($user_pass2,"")!=0){
			echo "맞네";
			if (strcmp($user_pass, $user_pass2) == 0){
				$insert_q = "INSERT INTO dbo.worker_info(
					phone_id,
					worker_nm, 
					worker_pone_number,
					worker_pw,
					worker_address, 
					worker_mail, 
					bank_name, 
					bank_account,
					join_date,
					worker_state,
					cost_center,
					department,
					worker_flag) 
					values"."
					(?,?,?,?,?,?,?,?,?,?,?,?,?)";
				echo $insert_q;
				$worker_nm = iconv("UTF-8", "EUC-KR",$worker_nm);
				$worker_address = iconv("UTF-8", "EUC-KR",$worker_address);
				$bank_name = iconv("UTF-8", "EUC-KR",$bank_name);
				
				//전화번호, 비밀번호, 이름, 주소, 메일주소, 은행, 계좌, 가입일
				$param = array(
				    $ID,
					$worker_nm, 
					$worker_pone_number,
					$worker_pw,
					$worker_address, 
					$worker_mail, 
					$bank_name, 
					$bank_account,
					$join_date,
					"1",
					$cost_center,
					$department,
					"1"
					
				);
				$result = sqlsrv_query($con, $insert_q, $param);
				if ($result) {
					echo "Row successfully inserted.\n";
					sqlsrv_close($con);
					sqlsrv_free_stmt($result);
					echo "<script>alert(\"회원가입을 성공하였습니다.\");location.href='responsive_main_login.php';</script>";
				} else {
					echo "Row insertion failed.\n";
					die(print_r(sqlsrv_errors(), true));
				}
			}
		} 
		else if (strcmp($user_pass, $user_pass2) != 0){
			sqlsrv_close($con);
			sqlsrv_free_stmt($result);
			//echo "<script>alert(\"비밀번호가 입력되지 않았습니다.\");</script>";
			echo "<script>alert(\"비밀번호가 일치하지 않습니다.\"); location.href='responsive_main_login.php';</script>";
		}
		else {
			sqlsrv_free_stmt($result);
			sqlsrv_close($con);
			echo "<script>alert(\"비밀번호가 입력되지 않았습니다.\");location.href='responsive_main_login.php';</script>";
		}
	} 
	else {
		sqlsrv_close($con);
		//echo "<script>alert(\"이미 등록된 휴대폰 번호 입니다.\")</script>";
		echo "<script>alert(\"이미 등록된 휴대폰 번호 입니다.\"); location.href='responsive_main_login.php';</script>";
	}
exit();
?> 