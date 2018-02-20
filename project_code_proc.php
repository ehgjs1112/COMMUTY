
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
	extract($_POST);
	
	$project_job_code   = iconv("UTF-8", "EUC-KR", $project_job_code);
	$project_code       = iconv("UTF-8", "EUC-KR", $project_code);
	$project_name       = iconv("UTF-8", "EUC-KR", $project_name);
	$project_admin      = $_SESSION['uname'];
	$join_date = date("Y-m-d");
	
  //$stmt = sqlsrv_query($con, $sql, $params);
	
	if ($con == false) {
		echo "Unable to connect.</br>";
		die(print_r(sqlsrv_errors(), true));
	}
	
	//$row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC);
     			
				$insert_q = "INSERT INTO dbo.project_registration_info(
					project_job_code,
					project_code,
					project_name,
					admin_id,
                    project_state,					
					regi_date) 
					values
					(?,
					 ?,
					 ?,
					 ?,
					 1,
					 ?)";
					 
				//전화번호, 비밀번호, 이름, 주소, 메일주소, 은행, 계좌, 가입일
				$param = array(
				    $project_job_code,
					$project_code,
					$project_name,
					$project_admin,
					$join_date);
				
				
				$result = sqlsrv_query($con, $insert_q, $param);
				
				if ($result) {
					echo "Row successfully inserted.\n";
					sqlsrv_close($con);
					//sqlsrv_free_stmt($result);
					echo "<script>alert(\"프로젝트 코드 등록을 성공하였습니다.\");location.href='project_code_regestration.php';</script>";
				} else {
					echo "Row insertion failed.\n";
					die(print_r(sqlsrv_errors(), true));
				}
			
			sqlsrv_free_stmt($result);
			sqlsrv_close($con);
		
	 
	
exit();
?> 