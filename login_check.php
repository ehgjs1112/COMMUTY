<?php session_start();?>
<?php
include_once ('./config.php');

extract($_POST);
$_SESSION['usercheck'] = $usercheck;
if ($usercheck == 1) {//일반인이 아니면
    $user_table_nm = "admin_info";
    $user_field_nm = "admin_pw";
} else {
    $user_table_nm = "worker_info";
    $user_field_nm = "worker_pw";
}
echo $user_table_nm;
echo $user_field_nm;
//
$uname = iconv("UTF-8", "EUC-KR", $uname); //이름
if (strcmp($uname, "") !== 0) {
		$con = sqlsrv_connect($serverName, $connectionInfo);
		if ($usercheck == 1) {//일반인이 아니면
			$sql = "SELECT " . $user_field_nm
					. " FROM " . $user_table_nm
					. " WHERE "
					. "phone_id"
					." = '" . $uname . "'";
		}
		else {//일반인이 아니면
		$sql = "SELECT " . $user_field_nm
				. " FROM " . $user_table_nm
				. " WHERE "
				. "admin_id"
				." = '" . $uname . "'";
		}
		echo "</br>";
		echo $sql;
		if ($con == false) {
			echo "Unable to connect.</br>";
			die(print_r(sqlsrv_errors(), true));
		}
		$result = sqlsrv_query($con, $sql);
		$row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
		echo $row['admin_pw'];
		if($usercheck != 1){
			if (strcmp($row['worker_pw'], "") != 0 && strcmp($row['worker_pw'], $pass) == 0) 
			{
				$_SESSION['uname'] = $uname;
				sqlsrv_free_stmt( $result );
				sqlsrv_close($con);
				header('location:./inout_check_page.php'); 
				echo "오키";
				exit;
			} 
			else{
				echo "아이디와 비밀번호를 확인해주세요1";
				echo $uname;
				echo "worker_pw";
				echo $row['worker_pw'];
				sqlsrv_free_stmt( $result );
				sqlsrv_close($con);
				echo "<script>alert(\"아이디와 비밀번호를 확인해주세요\"); location.href='responsive_main_login.html';</script>";
			}
		}
		else{
			if (strcmp($row['admin_pw'], "") != 0 && strcmp($row['admin_pw'], $pass) == 0){
				$_SESSION['uname'] = $uname;
				sqlsrv_free_stmt($result);
				sqlsrv_close($con);
				header('location:./responsive_dash_main.php'); 
				exit;
			} 
			else{
				echo "아이디와 비밀번호를 확인해주세요2";
				echo $uname;
				echo "admin_pw";
				echo $row['admin_pw'];
				sqlsrv_free_stmt( $result );
				sqlsrv_close($con);
				echo "<script>alert(\"아이디와 비밀번호를 확인해주세요\"); location.href='admin_responsive_main_login.html';</script>";
			}
		}
	} 
	else {
		echo "<script>alert(\"아이디를 입력해주세요\"); location.href='responsive_main_login.html';</script>";
	}
?>