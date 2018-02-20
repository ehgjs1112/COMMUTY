
<?php
$ot_start_hour = 18;
$ot_start_min = 30;
$start_worker_time = 9;
error_reporting(E_ALL);

ini_set("display_errors", 1);


session_start();
include_once ('./config.php');

// ************공통영역 *********************************
//분기 구분자 받기 
$mode = $_GET["mode"];

$con = sqlsrv_connect($serverName, $connectionInfo);
// ************공통영역 *********************************


//매개변수로 구분 짓기.
//성공하면 출퇴근 페이지로 이동 함.  
if ($mode == "login_check") {
//시작 **********
extract($_POST);
$_SESSION['usercheck'] = $usercheck;
if ($usercheck == 1) {//일반인이 아니면
    $user_table_nm = "admin_info";
} else {
    $user_table_nm = "worker_info";
}
echo $user_table_nm;
echo $user_field_nm;
//
$uname = iconv("UTF-8", "EUC-KR", $uname); //이름
if (strcmp($uname, "") !== 0) {
		if ($usercheck == 1) {//일반인이 아니면
			$sql = "SELECT admin_pw, admin_maill, admin_nm" 
					." FROM " . $user_table_nm
					." WHERE "
					."admin_id"
					." = '" . $uname . "'";
		}
		else {//일반인이 아니면
		$sql = "SELECT worker_pw, worker_mail, worker_nm"
				. " FROM " . $user_table_nm
				. " WHERE "
				. "phone_id"
				." = '" . $uname . "'"
				." and "
				."worker_flag = 1";
		}
		echo "</br>";
		echo $sql;
		if ($con == false) {
			echo "Unable to connect.</br>";
			die(print_r(sqlsrv_errors(), true));
		}
		$result = sqlsrv_query($con, $sql);
		$row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
		
		if($usercheck != 1){
			if (strcmp($row['worker_pw'], "") != 0 && strcmp($row['worker_pw'], $pass) == 0) 
			{
				$_SESSION['uname'] = $uname;
				sqlsrv_free_stmt( $result );
				sqlsrv_close($con);
				$show_name = iconv("CP949", "UTF-8//TRANSLIT", $row['worker_nm']);
				$show_email = $row['worker_mail'];
				$_SESSION['show_name'] = $show_name;
				$_SESSION['show_email'] = $show_email;
				
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
				echo "<script>alert(\"아이디와 비밀번호를 확인해주세요\"); location.href='responsive_main_login.php';</script>";
			}
		}
		else{
			if (strcmp($row['admin_pw'], "") != 0 && strcmp($row['admin_pw'], $pass) == 0){
				$_SESSION['uname'] = $uname;
				$show_name = iconv("CP949", "UTF-8//TRANSLIT", $row['admin_nm']);
				$show_email = $row['admin_maill'];
				$_SESSION['show_name'] = $show_name;
				$_SESSION['show_email'] = $show_email;
				echo $show_name;
				echo $show_email;
				
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
		echo "<script>alert(\"아이디를 입력해주세요\"); location.href='responsive_main_login.php';</script>";
	}

//종료 **********

} 
//

else if ($mode == "in") {
 	$uname = $_SESSION["uname"];
    $time = date('H:i');
    $date = date('Y-m-d');
	$attend_hour = (int)substr($time,0,2);
	$finish_in = 0;
	//worker_stat 필드가 0일 경우 출근 1일 경우 퇴근
	//finish_in 해당 날짜 퇴근 정보가 있는지 확인 0일 경우 없음 1일 경우 있음
	echo "<br>".$attend_hour."<br>";
	if($attend_hour > 7 and $attend_hour < 16){
		$sql = "select count(case when phone_id = '".$uname."' and worker_attend_day = '".$date."' and worker_stat = 1 and finish_check = 1 then 1 end) from time_history";
		$stmt = sqlsrv_query($con, $sql);
		$row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC);//퇴근 기록확인
		echo "row[0]".$row[0]."<br>";
		if($row[0] > 0) $finish_in = 1;
		$in_sql = "INSERT INTO time_history(
			phone_id, 
			worker_time, 
			worker_attend_day, 
			worker_stat,
			finish_check) 
			values("."'".$uname."',"
			."'".$time."',"
			."'".$date."',
			'0',".$finish_in.")";
		echo $in_sql;
		sqlsrv_query($con, $in_sql);
		
		//김희수 수정 st ***
		//그날 최초 일때만 인서트를 해줌
		$sql_count = "select count(*) from 
										Attendance_info 
										where
                                        phone_id =	'".$uname."'   and worker_attend_day = '".$date."' ";   
	    											
		//총 개수를 구하려고 함
		$sql_count_number = sqlsrv_query($con,$sql_count);
		$row_num = sqlsrv_fetch_array( $sql_count_number , SQLSRV_FETCH_NUMERIC);
								$number = (int) implode('',$row_num);
		// 개수가 0 일때만 최초 출근 인서트를 어탠던스 테이블에 한다.
		if($number == 0 ){
		 
		$in_sql_2 = "insert into Attendance_info(
			 phone_id
			,worker_attend_time
			,worker_attend_day
		)
		values("
			."'".$uname."',"
			."'".$time."',"
			."'".$date."'"."
						)";
		echo $in_sql_2;
		sqlsrv_query($con, $in_sql_2);
		}				
		//김희수 수정 ed ***
		sqlsrv_close($con);
		if($finish_in == 1) echo "<script>alert(\"퇴근이 처리되어 있습니다. 관리자에게 문의 하세요.\"); location.href='inout_check_page.php';</script>";
		else echo "<script>alert(\"출근 처리 되었습니다.\"); location.href='inout_check_page.php';</script>";
	}
	else echo "<script>alert(\"지금은 출근 시간이 아닙니다(출근가능시간 08:00 ~ 15:00).\"); location.href='inout_check_page.php';</script>";
}
else if ($mode == "out") {
 	$uname = $_SESSION["uname"];
    $time = date('H:i');
	$htime = date('H:i');
    $date = date('Y-m-d');
	$only_ot_total = NULL;
	$worker_attend_ot_time = NULL;
	$worker_finish_ot_time = NULL;

	$times = explode(':',$time);
	$finish_hour = (int)$times[0];
	$finish_min = (int)$times[1];
	
	echo "finish_hour".$finish_hour."<br>";
	echo "finish_hour".$finish_min."<br>";
	
	if($finish_hour <= 6){ 
		$date = date('Y-m-d',strtotime("-1 day"));
		echo "통과";
		echo $date;
	}
		
	if((int)$finish_min < 30) $finish_min = 0;
	else $finish_min = 30;

	
	$time = $finish_hour.":".$finish_min;
	$formCount   =	$_POST["formCount"];
	echo  "formCount".$formCount;
	$project_job_code = array();
	$project_code = array();
	$project_name = array();
	$project_time = array();
	$division    =  array();
	$phone_id     = array();
	$query_parts = array();
	$poject_check_sum = 0;
	for($i=0;$i<$formCount;$i++){
		$project_job_code[$i]	=		$_POST["project_job_code"][$i];
		$project_code[$i]		=		$_POST["project_code"][$i];
		$project_name[$i]		=		$_POST["project_name"][$i];
		$project_time[$i]		=		$_POST["project_time"][$i];
		$division[$i]		    =		$_POST["division"][$i];
		$time_S 				= 		str_replace("시간",":",$project_time[$i]);
		$project_time[$i] 		= 		trim(str_replace("분","",$time_S));
		
		$time_S 				= 		explode(':', $project_time[$i]);
		if((int)$time_S[0] === 30){
			$time_S[0]=0; 
			$time_S[1]=30;
		}
		$project_time[$i] 		= 		(int)$time_S[0]*60+$time_S[1];	
		$poject_check_sum 		=		$poject_check_sum + $project_time[$i];
		$phone_id[$i]			=		$_SESSION["uname"];
	}
	if(strcmp($project_name[0],"")==0){
			echo "<script>alert(\"프로젝트가 선택되지 않았습니다. 프로젝트를 선택해주세요!!!\"); location.href='inout_check_page.php';</script>";
			$in_sql = "INSERT INTO time_history(
				phone_id, 
				worker_time, 
				worker_attend_day, 
				worker_stat,
				finish_check) 
				values("."'".$uname."',"
				."'".$htime."',"
				."'".$date."',
				1,0)";
			sqlsrv_query($con, $in_sql);//퇴근 history 저장	
	}
	else{
		$in_sql = "INSERT INTO time_history(
		phone_id, 
		worker_time, 
		worker_attend_day, 
		worker_stat,
		finish_check) 
		values("."'".$uname."',"
		."'".$htime."',"
		."'".$date."',
		1,1)";
	}
	//프로젝트 등록
	//$p_sql = "select sum(project_time)as time
	//	from project_time_info 
	//	where 
	//	project_time_flag = '1' 
	//	and 
	//	phone_id = '"
	//	.$uname."'".
	//	" and ".
	//	"regi_date = '"
	//	.$date."'";
	//$result_p = sqlsrv_query($con, $p_sql);
	//$p_row = sqlsrv_fetch_array($result_p,SQLSRV_FETCH_ASSOC);
	//if(isset($p_row['time'])== FALSE){
	//	$p_time = 0;
	//}
	//else $p_time = $p_row['time'];
	//프로젝트 시간 산출
	sqlsrv_query($con, $in_sql);//퇴근 history 저장
	echo "row[0]".$row[0]."<br>";
	
	$sql = "select count(case when phone_id = '".$uname."' and worker_attend_day = '".$date."' and worker_stat = 0 and finish_check = 0 then 1 end) from time_history";
	$stmt = sqlsrv_query($con, $sql);
	$row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC);
	//worker_stat 필드가 0일 경우 출근 1일 경우 퇴근
	//finish_in 해당 날짜 퇴근 정보가 있는지 확인 0일 경우 없음 1일 경우 있음	
	
	if($finish_hour <= 6){ 
		$finish_hour = $finish_hour + 24;
	}
	
	if($row[0] > 0){	
		echo $in_sql;
			
		//넘지 않았으면 ot 시간은 null 일반 근무 총시간을 계산 하여 attendence time에 기록 
		$finish_min_total = (int)$finish_hour*60 + $finish_min;//퇴근 시간을 분으로 변경
		echo "<br>".$finish_min_total."<br>";
		//시간 분 분리
		$ot_start_ch_min = $ot_start_hour * 60 + $ot_start_min;
		if($finish_min_total >= $ot_start_ch_min){//OT근무
			$ot_work_time_min = $finish_min_total;//18:00~24:00 -> 시간 + 새벽근무시간
			$in_sql = "select worker_time from time_history where worker_stat = 0 and phone_id = '".$uname."' and worker_attend_day = '".$date."' ORDER BY idx DESC";
			echo $in_sql;
			$stmt = sqlsrv_query($con, $in_sql);
			$row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_NUMERIC);
			$work_attend_time = $row[0] -> format('H:i');//출근시간 가져오기
			$attend_hour = substr($work_attend_time,0,2);
			$attend_min = substr($work_attend_time,3,2);
			
			if($attend_hour < $start_worker_time){
				$attend_hour = 9;
				$attend_min = 0;
			}
			elseif((int)$attend_min > 30) {
				$attend_hour = $attend_hour + 1;
				$attend_min = 0;
			}
			elseif((int)$attend_min < 30 and (int)$attend_min > 0) $attend_min = 30;	//출근시간 30분단위로 

			$work_attend_time = $attend_hour.":".$attend_min;
			$attend_total = (int)$attend_hour*60 + (int)$attend_min;
			
			if($attend_total >= 720 and $attend_total < 780){ //12시 ~ 12시 59분
				$today_min_total = $ot_work_time_min - $attend_total - ($attend_total - 780);//총근무시간 - 출근시간 - (1~59)
				$only_ba_total = 1080 - $attend_total;//기본근무시간 = 18:00 - 출근시간
			}
			else if($attend_total < 720){
				$today_min_total = $ot_work_time_min - $attend_total - 60;//총근무시간 = ot퇴근시간 - 출근시간 -60 
				$only_ba_total = 1080 - $attend_total - 60;//기본근무시간 = 18:00 - 출근시간 - 점심시간
			}
			else{ 
				$today_min_total = $ot_work_time_min - $attend_total;//총근무시간 = ot퇴근시간 - 출근시간 
				$only_ba_total = 1080 - $attend_total;//기본근무시간 = 18:00 - 출근시간
			}
			echo "ot<br>";
			//DB 총시간 근무
			$only_ot_total = $ot_work_time_min - 1080;//ot총 근무시간 = ot퇴근시간 - 18:00
			
			$only_ba_total = timeformat($only_ba_total);
			$only_ot_total = timeformat($only_ot_total);
			$worker_finish_time = "18:00";
			$worker_attend_ot_time = "'18:00'";
			$worker_finish_ot_time = "'".$time."'";
		}
		else{//
			echo "보통근무";
			$in_sql = "select worker_time from time_history where worker_stat = 0 and phone_id = '".$uname."' and worker_attend_day = '".$date."' ORDER BY idx DESC";
			echo $in_sql;
			$stmt = sqlsrv_query($con, $in_sql);
			$row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC);
			$work_attend_time = $row[0] -> format('H:i');//출근시간 가져오기	
			$attend_hour = substr($work_attend_time,0,2);
			$attend_min = substr($work_attend_time,3,2);
			
			if($attend_hour < $start_worker_time){
				$attend_hour = 9;
				$attend_min = 0;
			}
			elseif((int)$attend_min > 30) {
				$attend_hour = $attend_hour + 1;
				$attend_min = 0;
			}
			elseif((int)$attend_min < 30 and (int)$attend_min > 0) $attend_min = 30;	//출근시간 30분단위로 

			
			$work_attend_time = $attend_hour.":".$attend_min;
			$attend_total = (int)$attend_hour*60 + (int)$attend_min;
			if($attend_total >= 720 and $attend_total < 780){ //12시 ~ 12시 59분
				echo "점심 출근";
				if((int)$finish_min_total > 780) $only_ba_total = $finish_min_total - $attend_total - ($attend_total - 780);
				$attend_total1 = $attend_total - 720;
				echo "1only_ba_total:".$only_ba_total."<br>";
				echo "2finish_min_total:".$finish_min_total."<br>";
				echo "3attend_total:".$attend_total."<br>";
				echo "4attend_total-720:".$attend_total1."<br>";
			}
			else if((int)$attend_total < 720){
				echo "점심 전 출근";
				if((int)$finish_min_total > 780) $only_ba_total = $finish_min_total - $attend_total - 60;
				else $only_ba_total = $finish_min_total - $attend_total;
			}
			else {
				echo "점심 후퇴근";
				$only_ba_total = $finish_min_total - $attend_total;
			}
			
			$worker_finish_time = $time;
			$worker_attend_ot_time = "NULL";
			$worker_finish_ot_time = "NULL";
			$only_ot_total = "NULL";
			$only_ba_total = timeformat($only_ba_total);
		}

		if($poject_check_sum <= ((int)time_to_min($only_ba_total)+(int)time_to_min($only_ot_total))){//프로젝트지정시간이 실제 근무시간보다 작은가? 
			$u_pquery = 
			"UPDATE project_time_info 
			SET 
			project_time_flag = '0', 
			update_project_time = '".$date."'"." 
			FROM 
			project_time_info 
			where 
			regi_date = '".$date."'"." 
			and project_time_flag = 1 
			and phone_id = '".$uname."'"; 
				
			sqlsrv_query($con, $u_pquery);
			$query = 'INSERT INTO project_time_info (
				project_job_code,
				phone_id,
				project_time,
				division,
				regi_date,
				project_time_flag) 
				VALUES ';
			for($x=0; $x<count($project_job_code); $x++){
				$query_parts[] = "('" 
				. $project_job_code[$x] 
				. "','" 
				. $phone_id[$x] 
				. "','" 
				. (int)$project_time[$x]
				. "','" 
				. (int)$division[$x]				
				. "',getdate(),1)";
			}
			echo $query .= implode(',', $query_parts);
			if ($con == false) {
				echo "Unable to connect.</br>";
				die(print_r(sqlsrv_errors(), true));
			}
			sqlsrv_query($con, $query);
			echo "<script>alert(\"프로젝트별 시간배분 등록이 완료되었습니다.\");location.href='inout_check_page.php'</script>";
		}
		else {
			echo "<script>alert(\"수고 하셨습니다.11\");location.href='inout_check_page.php';</script>";
		}
		$sql = "select count(case when phone_id in (?) and worker_attend_day in(?) then 1 end) from Attendance_info";
		$params = array($uname,$date);
		$stmt = sqlsrv_query($con, $sql, $params);
		$row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC);
		echo "row[0]".$row[0]."<br>";
		if((int)$row[0] > 0){
	
			$up_sql = "UPDATE Attendance_info 
			SET
			worker_attend_time = '".$work_attend_time."'
			,worker_finish_time = '".$worker_finish_time."'
			,worker_attend_ot_time = ".$worker_attend_ot_time."
			,worker_finish_ot_time = ".$worker_finish_ot_time."
			,worker_attend_day = '".$date."'"."
			,worker_total_work_ot_time = ".$only_ot_total."
			,worker_total_work_time = ".$only_ba_total."  
			,update_date =  '".$date."'"."
			FROM 
			Attendance_info 
			where 
			worker_attend_day = '".$date."'"." 
			and phone_id = '".$uname."'"; 
			//김희수 수정 end ***
			/*
			$up_sql = "UPDATE Attendance_info 
			SET 
			worker_attend_time = '".$worker_attend_time."'"."  
			,worker_finish_time = '".$worker_finish_time."'"."
			,worker_attend_ot_time = '".$worker_attend_ot_time."'"."
			,worker_finish_ot_time = '".$worker_finish_ot_time."'"."
			,worker_attend_day = '".$date."'"."
			,worker_total_work_ot_time = '".$only_ot_total."'"."
			,worker_total_work_time = ".$only_ba_total.""."  
			,update_date =  '".$date."'"."
			FROM 
			Attendance_info 
			where 
			worker_attend_day = '".$date."'"." 
			and phone_id = '".$uname."'"; 
			*/
			echo $up_sql;
			sqlsrv_query($con, $up_sql);
		}
		else{
			$in_sql = "insert into Attendance_info(
				phone_id
				,worker_attend_time
				,worker_finish_time
				,worker_attend_ot_time
				,worker_finish_ot_time
				,worker_attend_day
				,worker_total_work_ot_time
				,worker_total_work_time
			)
			values("
				."'".$uname."',"
				."'".$work_attend_time."',"
				.$worker_finish_time.","
				.$worker_attend_ot_time.","
				.$worker_finish_ot_time.","
				."'".$date."',"
				.$only_ot_total.","
				.$only_ba_total.")";
			echo $in_sql;
			sqlsrv_query($con, $in_sql);
		}
		sqlsrv_close($con);
		//20171213
		exit;
		echo "<script>alert(\"퇴근 처리가 완료 되었습니다.\"); location.href='responsive_main.php';</script>";
	}//퇴근이 있으면 
	sqlsrv_close($con);
	//퇴근 기록과 날짜 아이디 만 기록한다.
	//20171213
	exit;
	echo "<script>alert(\"출근 기록이 존재하지 없습니다.\"); location.href='responsive_main.php';</script>";
}

else if ($mode == "ch_time") {
		$ID = $_GET['ID'];
		$mode = $_GET['chan_mode'];
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
		phone_id,
		worker_attend_time, 
		worker_finish_time, 
		worker_attend_ot_time, 
		worker_finish_ot_time
		from Attendance_info 
		where phone_id ='".$ID."' and worker_attend_day = '".$date."'";
		echo $sql;
		$result = sqlsrv_query($con, $sql);
		$row = sqlsrv_fetch_array($result,SQLSRV_FETCH_ASSOC);
		
		IF(ISSET($row['worker_attend_time'])==TRUE){
			$worker_attend_time = $row['worker_attend_time'] -> format('H:i');
			$worker_attend_time = "'".$worker_attend_time."'";
		}ELSE $worker_attend_time = "NULL";
		IF(ISSET($row['worker_finish_time'])==TRUE){
			$worker_finish_time = $row['worker_finish_time'] -> format('H:i');
			$worker_finish_time = "'".$worker_finish_time."'";
		}ELSE $worker_finish_time = "NULL";
		IF(ISSET($row['worker_attend_ot_time'])==TRUE){
			$worker_attend_ot_time = $row['worker_attend_ot_time'] -> format('H:i');
			$worker_attend_ot_time = "'".$worker_attend_ot_time."'";
		}ELSE $worker_attend_ot_time = "NULL";
		IF(ISSET($row['worker_finish_ot_time'])==TRUE){
			$worker_finish_ot_time = $row['worker_finish_ot_time'] -> format('H:i');
			$worker_finish_ot_time = "'".$worker_finish_ot_time."'";
		}ELSE $worker_finish_ot_time = "NULL";
		
		
		
		if($mode === '1'){//근로자 기본 출근
			//변경시간 측정 
			//12시 전 출근 인지 확인 13시 이후 인지 확인 
			//출근시간 변경에 따른 근로시간 수정 
			echo "모드1";
			//김희수 주석처리 st ***
			$worker_attend_time = "'".$hour.":".$min."'";
			//김희수 주석처리 end ***
			$worker_attend_min = time_to_min($worker_attend_time);
			
			$in_sql = "INSERT INTO time_history(
			phone_id, 
			worker_time, 
			worker_attend_day, 
			worker_stat,
			admin_update_date) 
			values("."'".$ID."',"
			.$worker_attend_time.","
			."'".$date."','2','"
			.date('Y-m-d')."')";
			
			echo $in_sql;
		
			sqlsrv_query($con, $in_sql);//히스토리에 기록
		}
		if($mode === '2'){//근로자 기본 퇴근
			
			$worker_finish_time = "'".$hour.":".$min."'";
			$worker_finish_min = time_to_min($worker_finish_time);
			echo "모드2";
			$in_sql = "INSERT INTO time_history(
			phone_id, 
			worker_time, 
			worker_attend_day, 
			worker_stat,
			admin_update_date) 
			values("."'".$ID."',"
			.$worker_finish_time.","
			."'".$date."','3','"
			.date('Y-m-d')."')";
			
			echo $in_sql;
			//exit();
			sqlsrv_query($con, $in_sql);//히스토리에 기록
		}
		if($mode === '3'){//근로자 ot출근
			echo "모드3";
			$worker_attend_ot_time = "'".$hour.":".$min."'";
			$worker_attend_ot_min = time_to_min($worker_attend_ot_time);
			
			$in_sql = "INSERT INTO time_history(
			phone_id, 
			worker_time, 
			worker_attend_day, 
			worker_stat,
			admin_update_date) 
			values("."'".$ID."',"
			.$worker_attend_ot_time.","
			."'".$date."','4','"
			.date('Y-m-d')."')";
			
			echo $in_sql;
						exit();
			sqlsrv_query($con, $in_sql);//히스토리에 기록
		}
		if($mode === '4'){//근로자 OT퇴근
			
			$worker_finish_ot_time = "'".$hour.":".$min."'";
			$worker_finish_ot_min = time_to_min($worker_finish_ot_time);
			echo "모드4";
			$in_sql = "INSERT INTO time_history(
			phone_id, 
			worker_time, 
			worker_attend_day, 
			worker_stat,
			admin_update_date) 
			values("."'".$ID."',"
			.$worker_finish_ot_time.","
			."'".$date."','5','"
			.date('Y-m-d')."')";
			//exit();
			echo $in_sql;
			sqlsrv_query($con, $in_sql);//히스토리에 기록
		}
		//////////////////////////////////////////공통영역
		if(isset($row['phone_id'])==FALSE){
			if($mode == '1'){
				ECHO "MODE_1";
				$worker_finish_time ="NULL";
				$worker_attend_ot_time ="NULL";
				$worker_finish_ot_time ="NULL";
				$only_ot_total ="NULL";
				$only_ba_total ="NULL";
			};
			if($mode == '2'){
				ECHO "MODE_2";
				$worker_attend_time ="NULL";
				$worker_attend_ot_time ="NULL";
				$worker_finish_ot_time ="NULL";
				$only_ot_total ="NULL";
				$only_ba_total ="NULL";
			};
			if($mode == '3'){
				ECHO "MODE_3";
				$worker_attend_time ="NULL";
				$worker_finish_time ="NULL";
				$worker_finish_ot_time ="NULL";
				$only_ot_total ="NULL";
				$only_ba_total ="NULL";
			};
			if($mode == '4'){
				ECHO "MODE_4";
				$worker_attend_time ="NULL";
				$worker_finish_time ="NULL";
				$worker_attend_ot_time ="NULL";
				$only_ot_total ="NULL";
				$only_ba_total ="NULL";
			};
			
			
			$in_sql = "insert into Attendance_info(
			phone_id
			,worker_attend_time
			,worker_finish_time
			,worker_attend_ot_time
			,worker_finish_ot_time
			,worker_attend_day
			,worker_total_work_ot_time
			,worker_total_work_time
			)
			values("
				."'".$ID."',"
				.$worker_attend_time.","
				.$worker_finish_time.","
				.$worker_attend_ot_time.","
				.$worker_finish_ot_time.","
				."'".$date."',"
				.$only_ot_total.","
				.$only_ba_total.")";
			echo $in_sql;
			sqlsrv_query($con, $in_sql);
		}
		else{//존재할 경우 
			//if($mode = 1){//출석 수정
				if(isset($row['worker_finish_time'])== TRUE or isset($worker_finish_time)== TRUE){//퇴근 값이 존재하며					//p
					if(isset($worker_finish_time)== FALSE){ 
						$worker_finish_time = $row['worker_finish_time']->format('Y-m-d'); 
						echo "<br>"."1worker_finish_time:".$worker_finish_time;//p
					}
					echo "<br>"."2worker_finish_time:".$worker_finish_time;//p
					if(strcmp($worker_finish_time,"00:00") != 0){//00:00분이 아닌 경우           					
						$worker_finish_min = time_to_min($worker_finish_time);
						$worker_attend_min = time_to_min($worker_attend_time);
						echo "<br>"."5worker_finish_min:".$worker_finish_min;
						echo "<br>"."6worker_attend_min:".$worker_attend_min;
						if($worker_finish_min < $worker_attend_min)	
							echo "<script>alert(\" 출근시간은 퇴근시간을 초과할수 없습니다. 퇴근시간을 수정하세요!!!.\"); location.href='responsive_dash_main.php?DATE=".$date."';</script>";
						//근무시간 계산하기 
						$only_ba_total = get_ba_total_time($worker_attend_min,$worker_finish_min);
						
					}else $worker_finish_time ="NULL";
				}else{
					if(isset($worker_attend_time)== FALSE){
						echo "work_attend_time 없어 ";
						$worker_attend_time = "NULL";
						$only_ba_total="NULL";
					}
					$worker_finish_time ="NULL";$only_ba_total="NULL";}//존재하지 안으면
				
				if(isset($row['worker_attend_ot_time'])== TRUE or isset($worker_attend_ot_time)== TRUE){  
					ECHO "1worker_attend_ot_time".$worker_attend_ot_time,"<BR>";				//p
					if(isset($worker_attend_ot_time)== FALSE){
						$worker_attend_ot_time = $row['worker_attend_ot_time']->format('Y-m-d');//p
						echo "<br>"."1worker_attend_ot_time:".$worker_finish_time;//p
					}
					ECHO "worker_attend_ot_time".$worker_attend_ot_time;
					if(strcmp($worker_attend_ot_time,"00:00") != 0){//00:00분이 아닌 경우		//p					
						if(isset($row['worker_finish_ot_time'])== TRUE  or isset($worker_finish_ot_time)== TRUE){//ot퇴근시간 체크
							ECHO "퇴근 있어1";
							
							if(isset($worker_finish_ot_time)== FALSE){
								$worker_finish_ot_time = $row['worker_finish_ot_time']->format('Y-m-d');
								echo "<br>"."1worker_attend_ot_time:".$worker_finish_time;//p
							}
							if(strcmp($worker_finish_ot_time,"00:00") != 0 and strcmp($worker_attend_ot_time,"00:00") != 0){//00:00분이 아닌 경우
								if($worker_finish_min < $worker_attend_min)	
									echo "<script>alert(\" OT출근시간은 퇴근시간을 초과할수 없습니다. OT퇴근시간을 수정하세요!!!.\"); location.href='responsive_dash_main.php?DATE=".$date."';</script>";
								//새벽일 경우 일반ot의 경우
								$worker_finish_ot_min = time_to_min($worker_finish_ot_time); 
								$worker_attend_ot_min = time_to_min($worker_attend_ot_time);
								$only_ot_total = get_ot_total_time($worker_attend_ot_min,$worker_finish_ot_min);
							}else $worker_finish_ot_time = "NULL";
						}else{
							$worker_finish_ot_time = "NULL";
							$only_ot_total = "NULL";
						};
					}else $worker_attend_ot_time = "NULL";
				}else {
					if(isset($worker_finish_ot_time) == FALSE){
						$worker_finish_ot_time = "NULL"; 
						$only_ot_total = "NULL";
					}
					$only_ot_total = "NULL";
					$worker_attend_ot_time = "NULL";}
			//}
			IF(strcmp($only_ot_total,"'24:0'")==0) $only_ot_total = "NULL";
			
			IF(strcmp($only_ba_total,"'24:0'")==0) $only_ot_total = "NULL";
			
			$up_sql = "UPDATE Attendance_info 
				SET 
				worker_attend_time = ".$worker_attend_time." 
				,worker_finish_time = ".$worker_finish_time." 
				,worker_attend_ot_time = ".$worker_attend_ot_time." 
				,worker_finish_ot_time = ".$worker_finish_ot_time." 
				,worker_attend_day = '".$date."'"." 
				,worker_total_work_ot_time = ".$only_ot_total." 
				,worker_total_work_time = ".$only_ba_total."  
				,update_date = '".date('Y-m-d')."'"."
				FROM 
				Attendance_info 
				where 
				worker_attend_day = '".$date."'"." 
				and phone_id = '".$ID."'";
     		
			echo $up_sql;
			sqlsrv_query($con, $up_sql);
		}
		if($mode === '1') echo "<script>alert(\"출근시간이 수정 되였습니다.\"); location.href='responsive_dash_main.php?DATE=".$date."';</script>";
		if($mode === '2') echo "<script>alert(\"퇴근시간이 수정 되였습니다.\"); location.href='responsive_dash_main.php?DATE=".$date."';</script>";
		if($mode === '3') echo "<script>alert(\"OT출근시간이 수정 되였습니다.\"); location.href='responsive_dash_main.php?DATE=".$date."';</script>";
		if($mode === '4') echo "<script>alert(\"OT퇴근시간이 수정 되였습니다.\"); location.href='responsive_dash_main.php?DATE=".$date."';</script>";
}

//출퇴근 메인 페이지
else if ($mode == "responsive_main") {
	header('location:./inout_check_page.php'); 
}
// 사용자 회원정보 수정
else if ($mode == "responsive_my_information") {
	header('location:./responsive_my_information.php'); 
}
//관리자 대시보드
else if ($mode == "responsive_dash_main") {
	
}
//관리자 승인
else if ($mode == "admin_approve") {
	
}
//  admin_approve
else{
	
}
?>