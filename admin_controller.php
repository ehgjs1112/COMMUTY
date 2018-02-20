
<?php
$ot_start_hour = 18;
$ot_start_min = 30;

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


} 
//

else if ($mode == "in") {

}
else if ($mode == "payment") {
 	
	$phone_id          =  $_SESSION["uname"];
	$selectedDate      =  $_POST["selectedDate"];
	
	$toYear            =  $_POST["toYear"];
	$toMonth           =  $_POST["toMonth"];
	
	
	//정산 테이블에서 select 하기  
    $payCount = "select  count(*)
                      from moon_adjust
					  where moon_admin= '".$phone_id."' and 
					  convert(varchar(7), moon_number, 120) = '".$selectedDate."'
					  ";
	echo $payCount;				  
	//총 개수를 구하려고 함
		$payCount = sqlsrv_query($con, $payCount);
		$row_num = sqlsrv_fetch_array( $payCount, SQLSRV_FETCH_NUMERIC);
		$number = (int) implode('',$row_num);
		
		echo $number; 
		//db 접속 실패 경우
		if ($con == false) {
			echo "Unable to connect.</br>";
			die(print_r(sqlsrv_errors(), true));
		}
    
	// 리턴 숫자가 0이면 정산 미완료 이기 때문에 정산 진행 0초과이면 정산 이미 완료 되었음.
	if ($number > 0) {
					sqlsrv_close($con);
					echo "<script>alert(\"정산은 이미 완료 되었습니다.\");location.href='member_moon_calculate.php?toYear=".$toYear."&toMonth=".$toMonth."';</script>";
				}
	
    $time = date('H:i');
    $date = date('Y-m-d');
	$only_ot_total = NULL;
	$worker_attend_ot_time = NULL;
	$worker_finish_ot_time = NULL;
	
	$finish_hour = substr($time,0,2);
	$finish_min = substr($time,3,2);
	//print_r($_POST); // post모든 값 출력
	$rowCount   =	$_POST["rowCount"];
	//echo  $rowCount;
	//값 변수 선언
	
	$department                = array();              
	$cost_center               = array();            
	$worker_nm                 = array();              
	$woker_jumin               = array();            
	$join_date                 = array();            
	$resign_date               = array();              
	$resign_reason             = array();            
	$worker_address            = array();
	$bank_name                 = array();
	$bank_account              = array();
	$worker_wage               = array();
	$worker_attend_time        = array();
	$normal_cost               = array();            
	$meal_allowance            = array();
	$worker_total_work_ot_time = array();
	$ot_cost                   = array();
	$week_rest_cost            = array();
	$working_day               = array();
	$moon_cost                 = array();
	$payment                   = array();
	                         
	$moon_number               = array();
	$moon_admin                = array();
	$moon_flag                 = array();
	
	
	$poject_check_sum = 0;
	for($i=0;$i<$rowCount;$i++){
		
		$department[$i]                   =		$_POST["department"][$i];
		$cost_center[$i]                  =		$_POST["cost_center"][$i];
		$worker_nm[$i]                    =		$_POST["worker_nm"][$i];
		$woker_jumin[$i]                  =		$_POST["woker_jumin"][$i];
		$join_date[$i]                    =		$_POST["join_date"][$i];
		$resign_date[$i]                  =		$_POST["resign_date"][$i];
		$resign_reason[$i]                =		$_POST["resign_reason"][$i];
		$worker_address[$i]               =		$_POST["worker_address"][$i];
		$bank_name[$i]                    =		$_POST["bank_name"][$i];
		$bank_account[$i]                 =		$_POST["bank_account"][$i];
		$worker_wage[$i]                  =		$_POST["worker_wage"][$i];
		$worker_attend_time[$i]           =		$_POST["worker_attend_time"][$i];
		$normal_cost[$i]                  =		$_POST["normal_cost"][$i];
		$meal_allowance[$i]               =		$_POST["meal_allowance"][$i];
		$worker_total_work_ot_time[$i]    =		$_POST["worker_total_work_ot_time"][$i];
		$ot_cost[$i]                      =		$_POST["ot_cost"][$i];
		$week_rest_cost[$i]               =		$_POST["week_rest_cost"][$i];
		$working_day[$i]                  =		$_POST["working_day"][$i];
		$moon_cost[$i]                    =		$_POST["moon_cost"][$i];
		$payment[$i]                      =		$_POST["payment"][$i];
		 
		$moon_number[$i]                  =		$_POST["moon_number"][$i];
		
		$moon_flag[$i]                    =		$_POST["moon_flag"][$i];
		
		
		$moon_admin[$i]			=		$_SESSION["uname"];
		
		//$time_S 				= 		str_replace("시간",":",$project_time[$i]);
		//$project_time[$i] 		= 		trim(str_replace("분","",$time_S));
		
		//$time_S 				= 		explode(':', $project_time[$i]);
		/*
		if((int)$time_S[0] === 30){
			$time_S[0]=0; 
			$time_S[1]=30;
		}
		*/
		//$project_time[$i] 		= 		(int)$time_S[0]*60+$time_S[1];	
		//$poject_check_sum 		=		$poject_check_sum + $project_time[$i];
		
	}
			$query = 'INSERT INTO moon_adjust (
				department                
                ,cost_center               
                ,worker_nm                 
                ,woker_jumin               
                ,join_date                 
                ,resign_date               
                ,resign_reason             
                ,worker_address            
                ,bank_name                 
                ,bank_account              
                ,worker_wage               
                ,worker_attend_time        
                ,normal_cost               
                ,meal_allowance            
                ,worker_total_work_ot_time 
                ,ot_cost                   
                ,week_rest_cost            
                ,working_day               
                ,moon_cost                 
                ,payment                   
                ,moon_number               
                ,moon_admin                
                ,moon_flag                 
                ,adjust_day                
    				) 
				VALUES ';
			//for($x=0; $x<count($worker_nm); $x++){
			for($x=0; $x<count($worker_nm) ; $x++){
				$query_parts[] = "('" 
				.iconv("UTF-8", "EUC-KR",$department[$x] ) 
				. "','"
				.iconv("UTF-8", "EUC-KR", $cost_center[$x]  ) 
				. "','" 
				. iconv("UTF-8", "EUC-KR", $worker_nm[$x]   ) 
				. "','" 
				. $woker_jumin[$x] 
				. "','" 
				. $join_date[$x] 
				. "','" 
				. $resign_date[$x] 
				. "','" 
				. $resign_reason[$x] 
				. "','" 
				. iconv("UTF-8", "EUC-KR", $worker_address[$x]   )  
				. "','" 
				. iconv("UTF-8", "EUC-KR", $bank_name[$x]    ) 
				. "','" 
				. $bank_account[$x] 
				. "','" 
				. (int)$worker_wage[$x] 
				. "','" 
				. (int)$worker_attend_time[$x] 
				. "','" 
				. (int)$normal_cost[$x] 
				. "','" 
				. (int)$meal_allowance[$x] 
				. "','" 				
				. (int)$worker_total_work_ot_time[$x] 
				. "','" 
				. (int)$ot_cost[$x] 
				. "','" 
				. (int)$week_rest_cost[$x] 
				. "','" 
				. (int)$working_day[$x] 
				. "','" 
				. (int)$moon_cost[$x] 
				. "','" 
				. (int)$payment[$x] 
				. "','" 
				. $moon_number[$x] 
				. "','" 
				. $moon_admin [$x] 
				. "','" 
				. $moon_flag[$x] 
				. "'," 
				. "getdate()" 
				.")";
					}
			  //echo $query;
			echo $query .= implode(',', $query_parts);

			
			if ($con == false) {
				echo "Unable to connect.</br>";
				die(print_r(sqlsrv_errors(), true));
			}
		$result = sqlsrv_query($con,$query);
		 
		 if ($result) {
					echo "Row successfully inserted.\n";
					sqlsrv_close($con);
					//sqlsrv_free_stmt($result);
					echo "<script>alert(\"정산을 성공하였습니다.\");location.href='member_moon_calculate.php?toYear=".$toYear."&toMonth=".$toMonth."';</script>";
				} else {
					echo "Row insertion failed.\n";
					die(print_r(sqlsrv_errors(), true));
				}
			echo "<script>alert(\"프로젝트별 시간배분 등록이 완료되었습니다.\");</script>";
	}

//
else if ($mode == "time_sheet") {
	
	$phone_id      =  $_POST["phone_id"];
    $selectedDate  =  $_POST["moon_number"][0];
 
    $toYear            =  $_POST["toYear"];
	$toMonth           =  $_POST["toMonth"];

    //정산 테이블에서 select 하기  
    $timeCount   = "select count(*)
                      from time_sheet
					  where phone_id= '".$phone_id."' and 
					  convert(varchar(10), moon_number, 120) = '".$selectedDate."'
					  ";
	echo $timeCount;				  
	//총 개수를 구하려고 함
	$timeCount  = sqlsrv_query($con, $timeCount);
	$row_num    = sqlsrv_fetch_array( $timeCount, SQLSRV_FETCH_NUMERIC);
	$number     = (int) implode('',$row_num);
		
	echo $number; 
	//db 접속 실패 경우
	if ($con == false) {
		echo "Unable to connect.</br>";
		die(print_r(sqlsrv_errors(), true));
	}
    
	// 리턴 숫자가 0이면 정산 미완료 이기 때문에 정산 진행 0초과이면 정산 이미 완료 되었음.
	if ($number > 0) {
					sqlsrv_close($con);
					echo "<script>alert(\"이미 정산이 완료되었습니다.\");location.href='admin_project_time_check.php?toYear=".$toYear."&toMonth=".$toMonth."&phone_id=".$phone_id."';</script>";
				     
					 }


    $time = date('H:i');
    $date = date('Y-m-d');
	$only_ot_total = NULL;
	$worker_attend_ot_time = NULL;
	$worker_finish_ot_time = NULL;
	
	//print_r($_POST); // post모든 값 출력
	
	$finish_hour = substr($time,0,2);
	$finish_min = substr($time,3,2);
    print_r($_POST); // post모든 값 출력
	$rowCount   =	$_POST["rowCount"];
	//echo  $rowCount;
	//값 변수 선언
	
	
	$phone_id                   ;              
	$project_job_code           ;            
	$project_code               ;              
	$project_name               ;            
	$d1                          = array();            
	$d2                          = array();              
	$d3                          = array();            
	$d4                          = array();
	$d5                          = array();
	$d6                          = array();
	$d7                          = array();
	$d8                          = array();
	$d9                          = array();            
	$d10                         = array();
	$d11                         = array();
	$d12                         = array();
	$d13                         = array();
	$d14                         = array();
	$d15                         = array();
	$d16                         = array();
	$d17                         = array();
	$d18                         = array();            
	$d19                         = array();
	$d20                         = array();
	$d21                         = array();
	$d22                         = array();
	$d23                         = array();
	$d24                         = array();
	$d25                         = array();
	$d25                         = array();
	$d26                         = array();
	$d27                         = array();
	$d28                         = array();
	$d29                         = array();
	$d30                         = array();
	$d31                         = array();
	$d32                         = array();
	$moon_number                 = array();                          
	$moon_admin                  = array();
	$moon_flag                   = array();
	$adjust_date                 = array();
	$seq_number                  = array();
	
	 $phone_id                            =		$_POST["phone_id"];
     $worker_type                         =		$_POST["worker_type"];
	 $worker_wage                         =		$_POST["worker_wage"];
	 $worker_nm                           =		$_POST["worker_nm"];
	
	
	
	
//	$poject_check_sum = 0;
	for($i=0;$i<$rowCount + 1;$i++){
		
		$d1[$i]                              =		$_POST["d1"][$i];
		$d2[$i]                              =		$_POST["d2"][$i];
		$d3[$i]                              =		$_POST["d3"][$i];
		$d4[$i]                              =		$_POST["d4"][$i];
		$d5[$i]                              =		$_POST["d5"][$i];
		$d6[$i]                              =		$_POST["d6"][$i];
		$d7[$i]                              =		$_POST["d7"][$i];
		$d8[$i]                              =		$_POST["d8"][$i];
		$d9[$i]                              =		$_POST["d9"][$i];
		$d10[$i]                             =		$_POST["d10"][$i];
		$d11[$i]                             =		$_POST["d11"][$i];
		$d12[$i]                             =		$_POST["d12"][$i];
		$d13[$i]                             =		$_POST["d13"][$i];
		$d14[$i]                             =		$_POST["d14"][$i];
		$d15[$i]                             =		$_POST["d15"][$i];
		$d16[$i]                             =		$_POST["d16"][$i];
		$d17[$i]                             =		$_POST["d17"][$i];
		$d18[$i]                             =		$_POST["d18"][$i];
		$d19[$i]                             =		$_POST["d19"][$i];
		$d20[$i]                             =		$_POST["d20"][$i];
		$d21[$i]                             =		$_POST["d21"][$i];
		$d22[$i]                             =		$_POST["d22"][$i];
		$d23[$i]                             =		$_POST["d23"][$i];
		$d24[$i]                             =		$_POST["d24"][$i];
		$d25[$i]                             =		$_POST["d25"][$i];
		$d25[$i]                             =		$_POST["d25"][$i];
		$d26[$i]                             =		$_POST["d26"][$i];
		$d27[$i]                             =		$_POST["d27"][$i];
		$d28[$i]                             =		$_POST["d28"][$i];
		$d29[$i]                             =		$_POST["d29"][$i];
		$d30[$i]                             =		$_POST["d30"][$i];
		$d31[$i]                             =		$_POST["d31"][$i];
		$moon_number[$i]                     =		$_POST["moon_number"][$i];
		$moon_admin[$i]                      =		$_SESSION["uname"];
		$seq_number[$i]                      =		$_POST["seq_number"][$i];
		
		//$time_S 				= 		str_replace("시간",":",$project_time[$i]);
		//$project_time[$i] 		= 		trim(str_replace("분","",$time_S));
		
		//$time_S 				= 		explode(':', $project_time[$i]);
		/*
		if((int)$time_S[0] === 30){
			$time_S[0]=0; 
			$time_S[1]=30;
		}
		*/
		//$project_time[$i] 		= 		(int)$time_S[0]*60+$time_S[1];	
		//$poject_check_sum 		=		$poject_check_sum + $project_time[$i];
		
	}
	for($i=0;$i<$rowCount;$i++){
		
		$project_job_code[$i]                =		$_POST["project_job_code"][$i];
		$project_code[$i]                    =		$_POST["project_code"][$i];
		$project_name[$i]                    =		$_POST["project_name"][$i];
		
		
	}
	
	$project_job_code[$rowCount]        = "";
	$project_code[$rowCount]            = "";
	$project_name[$rowCount]            = "";
	
			$query = 'INSERT INTO time_sheet (
				 phone_id        
                ,worker_type      
                ,worker_wage
                ,worker_nm				
                ,project_job_code 
                ,project_code     
				,project_name     
				,d1              
                ,d2              
                ,d3              
                ,d4              
                ,d5              
                ,d6              
                ,d7              
                ,d8              
                ,d9              
                ,d10             
                ,d11             
                ,d12             
                ,d13             
                ,d14             
                ,d15             
                ,d16             
                ,d17             
                ,d18             
                ,d19             
                ,d20             
    			,d21             	
				,d22             	
				,d23             	
				,d24             	
				,d25             	
				,d26             	
				,d27             	
				,d28             	
				,d29             	
				,d30             	
				,d31
                ,moon_number             	
				,moon_admin      	
				,moon_flag       	
				,adjust_date     	
				,seq_number      	
					) 
				VALUES ';
			//for($x=0; $x<count($worker_nm); $x++){
			for($x=0; $x<$rowCount + 1; $x++){
				$query_parts[] = "('" 
				.$phone_id
				. "','"
				.$worker_type
				. "','" 
				.$worker_wage
				. "','"
                .iconv("UTF-8", "EUC-KR",$worker_nm   )  
                . "','"				
				. $project_job_code[$x] 
				. "','" 
				. $project_code[$x] 
				. "','" 
				. iconv("UTF-8", "EUC-KR",$project_name[$x]   )  
				. "','" 
				. (int)$d1[$x] 
				. "','" 
				. (int)$d2[$x] 
				. "','" 
				. (int)$d3[$x] 
				. "','" 
				. (int)$d4[$x] 
				. "','" 
				. (int)$d5[$x] 
				. "','" 
				. (int)$d6[$x] 
				. "','" 
				. (int)$d7[$x] 
				. "','" 
				. (int)$d8[$x]
                . "','" 
				. (int)$d9[$x] 
                . "','" 
				.(int)$d10[$x] 
                . "','" 
				.(int)$d11[$x] 
                . "','" 
				.(int)$d12[$x] 
                . "','" 
				.(int)$d13[$x] 
                . "','" 
				.(int)$d14[$x] 
                . "','" 
				.(int)$d15[$x] 
                . "','" 
				.(int)$d16[$x] 
                . "','" 
				.(int)$d17[$x] 
                . "','" 
				.(int)$d18[$x] 
                . "','" 
				.(int)$d19[$x] 
                . "','" 
				.(int)$d20[$x] 
                . "','" 
				.(int)$d21[$x] 
                . "','" 
				.(int)$d22[$x] 
                . "','" 
				.(int)$d23[$x] 
                 . "','" 
				.(int)$d24[$x] 
                . "','" 
				.(int)$d25[$x] 
                . "','" 
				.(int)$d26[$x]
                . "','" 
				.(int)$d27[$x] 	
                . "','" 
				.(int)$d28[$x]
                . "','" 
				.(int)$d29[$x]
                . "','" 
				.(int)$d30[$x]
                . "','" 
				.(int)$d31[$x]				
				. "','" 
				.$moon_number[$x]
				. "','" 
				. $moon_admin[$x] 
				. "','" 
				. '1'
				. "'," 
				. "getdate()"
				. ",'" 
				. (int)$seq_number[$x]
				. "')";
					}
			  //echo $query;
			echo $query .= implode(',', $query_parts);

			
			if ($con == false) {
				echo "Unable to connect.</br>";
				die(print_r(sqlsrv_errors(), true));
			}
		$result = sqlsrv_query($con,$query);
		 
		 if ($result) {
					echo "Row successfully inserted.\n";
					sqlsrv_close($con);
					//sqlsrv_free_stmt($result);
					echo "<script>alert(\"성공적으로 정산이 완료되었습니다.\");location.href='admin_project_time_check.php?toYear=".$toYear."&toMonth=".$toMonth."&phone_id=".$phone_id."';</script>";
				} else {
					echo "Row insertion failed.\n";
					die(print_r(sqlsrv_errors(), true));
				}
			//echo "<script>alert(\"프로젝트별 시간배분 등록이 완료되었습니다.\");</script>";
		
}
// 사용자 회원정보 수정
else if ($mode == "holiWork") {

 	$phone_id      =  $_POST["phone_id"];
    $selectedDate  =  $_POST["moon_number"][0];
    
	$toYear            =  $_POST["toYear"];
	$toMonth           =  $_POST["toMonth"];
	
	//정산 테이블에서 select 하기  
    $holiCount   = "select count(*)
                      from holi_sheet
					  where phone_id = '".$phone_id."' and 
					  convert(varchar(10), moon_number, 120) = '".$selectedDate."'
					  ";
	echo $holiCount;				  
	//총 개수를 구하려고 함
	$holiCount  = sqlsrv_query($con, $holiCount);
	$row_num    = sqlsrv_fetch_array( $holiCount, SQLSRV_FETCH_NUMERIC);
	$number     = (int) implode('',$row_num);
		
	echo $number; 
	//db 접속 실패 경우
	if ($con == false) {
		echo "Unable to connect.</br>";
		die(print_r(sqlsrv_errors(), true));
	}
    
	// 리턴 숫자가 0이면 정산 미완료 이기 때문에 정산 진행 0초과이면 정산 이미 완료 되었음.
	if ($number > 0) {
					sqlsrv_close($con);
					echo "<script>alert(\"이미 정산이 완료되었습니다.\");location.href='calendar_2_worker.php?toYear=".$toYear."&toMonth=".$toMonth."&phone_id=".$phone_id."';</script>";
				}
	
	
	
	$time = date('H:i');
    $date = date('Y-m-d');
	$only_ot_total = NULL;
	$worker_attend_ot_time = NULL;
	$worker_finish_ot_time = NULL;
	
	$finish_hour = substr($time,0,2);
	$finish_min = substr($time,3,2);
	print_r($_POST); // post모든 값 출력
	$rowCount   =	$_POST["rowCount"];
	//echo  $rowCount;
	//값 변수 선언
	
	$phone_id                           =		$_POST["phone_id"];
    $worker_type                        =		$_POST["worker_type"];
	$worker_wage                        =		$_POST["worker_wage"]; 
	$w_1                                =        array();
	$w_2                                =        array();
	$w_3                                =        array();
	$w_4                                =        array();
	$w_5                                =        array();
	$w_6                                =        array();
	$w_7                                =        array();
	$work_hour                          =        array();
	$work_ot_hour                       =        array();
	$holi_hour                          =        array();
	$holi_pay                           =        array();
	$moon_number                        =        array();
	$moon_admin                         =        array();
	$seq_number                         =        array();
	                         
//	$poject_check_sum = 0;
	for($i=0;$i<$rowCount + 1;$i++){
		
		$phone_id                            =		$_POST["phone_id"];
		$worker_type                         =		$_POST["worker_type"];
		$worker_wage                         =		$_POST["worker_wage"];
		$work_hour[$i]                       =		$_POST["work_hour"][$i];
		$work_ot_hour[$i]                    =		$_POST["work_ot_hour"][$i];
		$holi_hour[$i]                       =		$_POST["holi_hour"][$i];
		$holi_pay[$i]                        =		$_POST["holi_pay"][$i];
		$moon_number[$i]                      =		$_POST["moon_number"][$i];
		$moon_admin [$i]                      =		$_SESSION["uname"];
		
				
		//$time_S 				= 		str_replace("시간",":",$project_time[$i]);
		//$project_time[$i] 		= 		trim(str_replace("분","",$time_S));
		
		//$time_S 				= 		explode(':', $project_time[$i]);
		/*
		if((int)$time_S[0] === 30){
			$time_S[0]=0; 
			$time_S[1]=30;
		}
		*/
		//$project_time[$i] 		= 		(int)$time_S[0]*60+$time_S[1];	
		//$poject_check_sum 		=		$poject_check_sum + $project_time[$i];
		
	}
	
	for($i=0;$i<$rowCount ;$i++){
		
		$phone_id                         =		$_POST["phone_id"];
		$worker_type                      =		$_POST["worker_type"];
		$worker_wage                      =		$_POST["worker_wage"];
		$w_1[$i]                          =		$_POST["w_1"][$i];
		$w_2[$i]                          =		$_POST["w_2"][$i];
		$w_3[$i]                          =		$_POST["w_3"][$i];
		$w_4[$i]                          =		$_POST["w_4"][$i];
		$w_5[$i]                          =		$_POST["w_5"][$i];
		$w_6[$i]                          =		$_POST["w_6"][$i];
		$w_7[$i]                          =		$_POST["w_7"][$i];
		$work_hour[$i]                    =		$_POST["work_hour"][$i];
		$work_ot_hour[$i]                 =		$_POST["work_ot_hour"][$i];
		$holi_hour[$i]                    =		$_POST["holi_hour"][$i];
		$holi_pay[$i]                     =		$_POST["holi_pay"][$i];
		$moon_number[$i]                  =		$_POST["moon_number"][$i];
		$moon_admin[$i]                   =		$_SESSION["uname"];
		$seq_number[$i]                   =		$_POST["seq_number"][$i];
		$division[$i]                     = 0;
		//$time_S 				= 		str_replace("시간",":",$project_time[$i]);
		//$project_time[$i] 		= 		trim(str_replace("분","",$time_S));
		
		//$time_S 				= 		explode(':', $project_time[$i]);
		/*
		if((int)$time_S[0] === 30){
			$time_S[0]=0; 
			$time_S[1]=30;
		}
		*/
		//$project_time[$i] 		= 		(int)$time_S[0]*60+$time_S[1];	
		//$poject_check_sum 		=		$poject_check_sum + $project_time[$i];
		
	}
	
	$w_1[$rowCount]= 0;
	$w_2[$rowCount]= 0;
	$w_3[$rowCount]= 0;
	$w_4[$rowCount]= 0;
	$w_5[$rowCount]= 0;
	$w_6[$rowCount]= 0;
	$w_7[$rowCount]= 0;
	$division[$rowCount] = 1;
	$seq_number[$rowCount] = $seq_number[$rowCount - 1] + 1;
			   $query = 'INSERT INTO holi_sheet (
				 phone_id   
                ,worker_type
                ,worker_wage
                ,w_1        
                ,w_2        
                ,w_3        
                ,w_4        
                ,w_5        
                ,w_6        
                ,w_7        
                ,work_hour
                ,work_ot_hour 				
                ,holi_hour  
                ,holi_pay
				,moon_number
                ,moon_admin 
                ,moon_flag  
                ,adjust_date
                ,seq_number 
    				) 
				VALUES ';
			//for($x=0; $x<count($worker_nm); $x++){
			for($x=0; $x<$rowCount +1 ; $x++){
				$query_parts[] = "('" 
				. $phone_id 
				. "','" 
				. $worker_type 
				. "','" 
				. $worker_wage 
				. "','" 
				. (int)$w_1[$x] 
				. "','" 
				. (int)$w_2[$x] 
				. "','" 
				. (int)$w_3[$x]  
				. "','" 
				. (int)$w_4[$x]  
				. "','" 
				. (int)$w_5[$x]  
				. "','" 				
				. (int)$w_6[$x]
				. "','" 
				. (int)$w_7[$x]
				. "','" 
				. (int)$work_hour[$x] 
				. "','" 
				. (int)$work_ot_hour[$x]
                . "','"				
				. (int)$holi_hour[$x] 
				. "','" 
				. (int)$holi_pay[$x] 
				. "','" 
				. $moon_number[$x]
                . "','" 				
				. $moon_admin[$x] 
				. "','" 
				. '1'
				. "'," 
				. "getdate()"
				. ",'" 
				. (int)$seq_number[$x]
				. "')";
					}
			  //echo $query;
			     echo $query .= implode(',', $query_parts);

			
			if ($con == false) {
				echo "Unable to connect.</br>";
				die(print_r(sqlsrv_errors(), true));
			}
		$result = sqlsrv_query($con,$query);
		 
		 if ($result) {
					echo "Row successfully inserted.\n";
					sqlsrv_close($con);
					//sqlsrv_free_stmt($result);
					//echo "<script>alert(\"성공적으로 정산이 완료되었습니다.\");location.href='calendar_2_worker.php?toYear=".$toYear."&toMonth=".$toMonth."&phone_id=".$phone_id."';</script>";
				} else {
					echo "Row insertion failed.\n";
					die(print_r(sqlsrv_errors(), true));
				}
			//echo "<script>alert(\"프로젝트별 시간배분 등록이 완료되었습니다.\");</script>";

}
//관리자 대시보드
else if ($mode == "responsive_dash_main") {
	
}
//관리자 승인
else if ($mode == "admin_approve") {
	header('location:./responsive_my_information.php'); 
}
//  admin_approve
else{
	
}
?>