
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
	$project_job_code                 = $_GET['project_job_code'];
	$project_job_code                 = iconv("UTF-8", "EUC-KR", $project_job_code);
	//근무상태 1:근무중 0:휴면 
	$project_state       = $_GET['project_state'];

	$project_admin      = $_SESSION['uname'];
	$join_date = date("Y-m-d");
	
	if ($con == false) {
		echo "Unable to connect.</br>";
		die(print_r(sqlsrv_errors(), true));
	}
	
	//사용자 아이디,상태
				$param = array         (
				    $project_job_code
                     					);
	
	//가장 최근 row 가져오기
	$s_sql = "select 
			 project_name
			,project_code
			,project_job_code
			,admin_id
			,project_state
			,regi_date
			,project_flag
			,update_date
			from
			project_registration_info
			where 
			project_job_code = '".$project_job_code."'	
			";
	echo $s_sql; 
	$s_result = sqlsrv_query($con, $s_sql);
	$s_row = sqlsrv_fetch_array($s_result,SQLSRV_FETCH_ASSOC);
	 //공통으로 할일 
	 //가장 최근 row  flag 값을 0으로 업데이트 
	 $sql = "UPDATE project_registration_info set
			update_date = '".date('Y-m-d H:i')."',"
			." project_flag = '0'
			where 
			project_job_code = '".$project_job_code."'"
			." and"
			." project_flag = 1"; 
	
	sqlsrv_query($con, $sql);
	//근무중 에서 --> 휴면 으로 바꾸기
    if($project_state == 1){
	    /*
				$update_q = "
				 Update project_registration_info
                  set  project_state = 0
				  where project_job_code = ?
            				";
				echo $project_job_code;
		*/		
		$update_q = "insert into project_registration_info
			(project_name
			,project_code
			,project_job_code
			,admin_id
			,project_state
			,regi_date
			,project_flag
			,update_date
			)
			values("
				."'".$s_row['project_name']."',"
				."'".$s_row['project_code']."',"
				."'".$s_row['project_job_code']."',"
				."'".$s_row['admin_id']."',"
				."'0',"
				."'".$s_row['regi_date']->format('Y-m-d')."',"
				."'1',"
				."'".date('Y-m-d H:i')."'
			)";				
		echo $update_q;
		$result = sqlsrv_query($con, $update_q, $param);
				
	}
	//휴면 에서 --> 근무중 으로 바꾸기
	else{
		/*
		          $update_q = "
				 Update project_registration_info
                  set  project_state = 1
				  where project_job_code = ?
               				";
		*/
		
		$update_q_2 = "insert into worker_info
			(,project_name
			,project_code
			,project_job_code
			,admin_id
			,project_state
			,regi_date
			,project_flag
			,update_date
			)
			values("
				."'".$s_row['project_name']."',"
				."'".$s_row['project_code']."',"
				."'".$s_row['project_job_code']."',"
				."'".$s_row['admin_id']."',"
				."'1',"
				."'".$s_row['regi_date']."',"
				."'1',"
				."'".date('Y-m-d H:i')."'
			)";				
		
			$result = sqlsrv_query($con, $update_q_2, $param);
		
			}
				if ($result) {
					echo "Row successfully update.\n";
					sqlsrv_close($con);
				//	sqlsrv_free_stmt($result);
					echo "<script>alert(\"프로젝트 잡 코드 상태 전환 성공하였습니다.\");location.href='project_code_regestration.php';</script>";
				} else {
					echo "근무자 상태 전환 실패 하였습니다.\n";
					die(print_r(sqlsrv_errors(), true));
				}
						
			 //sqlsrv_close($con);
exit();
?> 