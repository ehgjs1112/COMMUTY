
<?php
       include_once ('./session_check.php');	    
?>

<?php
	include_once ('./config.php');
	$con = sqlsrv_connect($serverName, $connectionInfo);
	if ($con == false) {
		echo "Unable to connect.</br>";
		die(print_r(sqlsrv_errors(), true));
	}
	//extract($_POST);
	//아이디
	$phone_id            = $_GET['phone_id'];
	//근무상태 1:근무중 0:휴면 
	$worker_state       = $_GET['worker_state'];

	$project_admin      = $_SESSION['uname'];
	$join_date = date("Y-m-d");
	echo $phone_id;
	if ($con == false) {
		echo "Unable to connect.</br>";
		die(print_r(sqlsrv_errors(), true));
	}
	
	//사용자 아이디,상태
				$param = array         (
				    $phone_id
                     					);
	
	//가장 최근 row 가져오기
	$s_sql = "select 
			worker_pone_number
			,worker_nm
			,worker_pw
			,woker_jumin
			,worker_address
			,bank_account
			,bank_name
			,worker_type
			,worker_mail
			,join_date
			,worker_wage
			,ad_approval
			from
			worker_info
			where 
			phone_id = '".$phone_id."'
			 and 
			worker_flag = 1";
	
	    $s_result = sqlsrv_query($con, $s_sql);
		$s_row = sqlsrv_fetch_array($s_result,SQLSRV_FETCH_ASSOC);
	 
	 //공통으로 할일 
	 //가장 최근 row  flag 값을 0으로 업데이트 
	 $sql = "UPDATE worker_info set
			update_date = '".date('Y-m-d H:i')."',"
			." worker_flag = '0'
			where 
			phone_id = '".$phone_id."'"
			." and"
			." worker_flag = 1"; 
	
	sqlsrv_query($con, $sql);
	
	//근무중 에서 --> 휴면 으로 바꾸기
    if($worker_state == 1){
	   /*
			$update_q = "
		    Update worker_info
            set  worker_state = 0
			where phone_id= ?
            				";
		*/		
	//상태를 0으로 바꾸면서 flag 1 row 를 넣는다
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
			,update_date
			,worker_flag
			)
			values("
				."'".$s_row['worker_pone_number']."',"
				."'".$phone_id."',"
				."'".$s_row['worker_pw']."',"
				."'".$s_row['worker_nm']."',"
				."'0',"
				."'".$s_row['woker_jumin']."',"
				."'".$s_row['worker_address']."',"
				."'".$s_row['worker_type']."',"
				."'".$s_row['worker_mail']."',"
				."'".$s_row['ad_approval']."',"
				."'".$s_row['bank_name']."',"
				."'".$s_row['bank_account']."',"
				."'".$s_row['join_date']."',"
				."'".$s_row['worker_wage']."',"
				."'".date('Y-m-d H:i')."',"
				."'1'
			)";				
				
		$result	=	sqlsrv_query($con, $sql_in);	
				
				
	}
	//휴면 에서 --> 근무중 으로 바꾸기
	else{
		/*
		          $update_q = "
				 Update worker_info
                  set  worker_state = 1
				  where phone_id = ?
               				";
		*/		
		$sql_in_2 = "insert into worker_info
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
			,update_date
			,worker_flag
			)
			values("
				."'".$s_row['worker_pone_number']."',"
				."'".$phone_id."',"
				."'".$s_row['worker_pw']."',"
				."'".$s_row['worker_nm']."',"
				."'1',"
				."'".$s_row['woker_jumin']."',"
				."'".$s_row['worker_address']."',"
				."'".$s_row['worker_type']."',"
				."'".$s_row['worker_mail']."',"
				."'".$s_row['ad_approval']."',"
				."'".$s_row['bank_name']."',"
				."'".$s_row['bank_account']."',"
				."'".$s_row['join_date']."',"
				."'".$s_row['worker_wage']."',"
				."'".date('Y-m-d H:i')."',"
				."'1'
			)";				
			$result	= sqlsrv_query($con, $sql_in_2);
		
		}
				if ($result) {
					echo "Row successfully update.\n";
					sqlsrv_close($con);
				//	sqlsrv_free_stmt($result);
					echo "<script>alert(\"근무자 상태 전환 성공하였습니다.\");location.href='all_mamber_dashBoard.php';</script>";
				} else {
					echo "근무자 상태 전환 실패 하였습니다.\n";
					die(print_r(sqlsrv_errors(), true));
				}
			
			
			sqlsrv_close($con);
		
	 
	
exit();
?> 