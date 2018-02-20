<!DOCTYPE html>

<!-- 로그인 여부 확인 -->
<?php
       include_once ('./session_check.php');	    
?>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <!-- This file has been downloaded from Bootsnipp.com. Enjoy! -->
        <title>Responsive Mail Inbox and Compose - Bootsnipp.com</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">
        
		<link type="text/css" rel="stylesheet" href="/css/common.css"/>
		<link type="text/css" rel="stylesheet" href="/css/responsive_main.css"/>
        
		<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    </head>
    <body>
	<div class="mail-box">
    <div class="container-fluid">
		<div class="col-lg-12">
		<div class="col-lg-11">
	    </div>
	     </div>
            <link rel='stylesheet prefetch' href='http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css'>
           
                <aside class="sm-side">
                    
					<?php
                         include_once ('./userHead_info/userHead_infor.php');
                         include_once ('./manu/left_menu/user_left_responsive_main_menu.php');						 
                     ?>
                </aside>
   				<aside class="lg-side">
                    <div class="inbox-head">
                
			        <?php
                          include_once ('./manu/user_top_manu.php');	    
                       ?>
                    </div>
					
				    <?php
							include_once ('./config.php');
							$uname = $_SESSION['uname'];
							$con = sqlsrv_connect($serverName, $connectionInfo);	
							
							$sql_count = "SELECT   count(*)
												from Attendance_info
												WHERE phone_id ="."'".$uname."'
												";
							
							$sql_count = sqlsrv_query($con, $sql_count);
							$row_num   = sqlsrv_fetch_array($sql_count, SQLSRV_FETCH_NUMERIC);
							$number    = (int) implode('',$row_num);
							
					 ?>
					
		      <div class="content">
                    <div class="inbox-body">
                        <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">출퇴근 정보 카드</div>
                            <div class="col-md-4"></div>
                        </div>	
                    </div>

                    <div class="row">
                        <div class="col-md-5"></div>
                        <div class="col-md-5"></div>
                    </div>	
                    <table class="table table-inbox table-hover table-bordered">
                        <tbody>
                            <tr class="">
                                <td class="">
                                   출근 일수
                                </td>
                                <td class=""><?= $number ?>&nbsp일</td>
						     </tr>
  
                        </tbody>
                    </table>
                   <BR>
                    <table class="table table-inbox table-hover table-bordered" id = 'worker_time_tb'>
                        <thead>
							<th>일자</th>
							<th>출근</th>
							<th>퇴근</th>
							<th>근무시간</th>
							<th>OT출근</th>
							<th>OT퇴근</th>
							<th>OT근무시간</th>
							<th>프로젝트 할당 시간</th>
                        </thead>
                        <tbody>
							<?php
							
							
							$con = sqlsrv_connect($serverName, $connectionInfo);
							       $sql = "SELECT worker_attend_time,
							                    worker_finish_time,
										        worker_attend_day,
												worker_finish_ot_time,
										        worker_attend_ot_time,
												DATEDIFF(mi,worker_attend_time,worker_finish_time)as worker_one_day_hour,
												DATEDIFF(mi,worker_attend_ot_time,worker_finish_ot_time)as worker_one_day_ot_hour 									
												from Attendance_info
												WHERE phone_id ="."'".$uname."'
												ORDER BY worker_attend_day DESC";
								     
							//$sql = "select count(case when worker_pone_number in ('".$uname."')"."then 1 end) from Attendance_info";
							// 확인용
							//echo $sql;
							$result = sqlsrv_query($con, $sql);
							//db 접속 실패 경우
							if ($con == false) {
								echo "Unable to connect.</br>";
								die(print_r(sqlsrv_errors(), true));
							}
							
							
							//$row = sqlsrv_fetch_array($result,SQLSRV_FETCH_NUMERIC);
							//echo $row[0];
							?>
							
							<?php
							//반복문 시작 
							 while($row = sqlsrv_fetch_array($result,SQLSRV_FETCH_ASSOC)){
							
							 $worker_attend_day = $row['worker_attend_day']  ->format('Y-m-d');
							 //데이터가 4개 다 있으면
							 if(is_null($row['worker_attend_time']) == FALSE AND is_null($row['worker_finish_time']) == FALSE 
									AND is_null($row['worker_attend_ot_time']) ==  FALSE AND is_null($row['worker_finish_ot_time']) == FALSE){
									$worker_attend_time = $row['worker_attend_time']->format('H:i');
									$worker_finish_time = $row['worker_finish_time']->format('H:i');
									$worker_attend_ot_time = $row['worker_attend_ot_time']->format('H:i');
									$worker_finish_ot_time = $row['worker_finish_ot_time']->format('H:i');
								}
							//데이터가 2개 있으면	
								else if(is_null($row['worker_attend_time'])== 0 AND is_null($row['worker_finish_time']) == 0){
									$worker_attend_time = $row['worker_attend_time']->format('H:i');
									$worker_finish_time = $row['worker_finish_time']->format('H:i');
									$worker_attend_ot_time = "-";
									$worker_finish_ot_time = "-";
							//데이터가 1개 있으면 		
								}else if(is_null($row['worker_attend_time'])== 0 ){
									$worker_attend_time    = $row['worker_attend_time']->format('H:i');
									$worker_finish_time    = "미퇴근";
									$worker_attend_ot_time = "-";
									$worker_finish_ot_time = "-";
								}
								else{
									$worker_attend_time = "미출근";
									$worker_finish_time = "미퇴근";
									$worker_attend_ot_time = "-";
									$worker_finish_ot_time = "-";
								} 
							
							 $worker_one_day_hour = $row['worker_one_day_hour'];
							 $worker_one_day_ot_hour = $row['worker_one_day_ot_hour'];
							 //$worker_finish_time = $row['worker_finish_time']  ->format(DateTime::W3C);
							?>
						
                            <tr class="">
								<td class=""><?= $worker_attend_day ?> </td>
								<td class=""><?= $worker_attend_time ?> </td>
                                <td class=""><?= $worker_finish_time ?></td>
								 <td class=""><?php
									$int_attend_hour = (int)substr($worker_attend_time,0,2);//출근시간
									$int_attend_min = (int)substr($worker_attend_time,3,2);//출근시간
									//echo "<br>".(int)$int_attend_min."<br>";
									if($int_attend_hour == 0 AND $int_attend_min == 0 AND (int)$worker_one_day_hour > 0) {
										$worker_one_day_hour = "관리자 문의요망";
										echo $worker_one_day_hour;
									}
									else if((int)$worker_one_day_hour > 0){//총 일한 시간이 0 이상일 경우
										//echo "<br>".(int)$worker_one_day_hour."<br>";
										if(($int_attend_hour * 60 + $int_attend_min) < 720 AND $worker_attend_time != "00:00" ){//12시간 이전 일 경우 
											if(((int)$worker_one_day_hour - 60)>0){//worker_one_day_hour => 쿼리에서 출퇴근 시간 뺀것
												$int_finish_time = (int)substr($worker_finish_time,0,2);//퇴근시간
												if($int_finish_time > 13){// 퇴근 시간이 13시 이상인지 확인 오전 퇴근 인지 확인
													$worker_one_day_hour = (int)$worker_one_day_hour - 60;//
												}
											}//echo "<br>".."<br>"
											if(floor($worker_one_day_hour / 60) < -1){//60분 이하로 일을 할 경우
												echo "00:";
											}
											else if(floor($worker_one_day_hour / 60 < 10)){//근로시간이 10시간 이하로 근무 했을 경우
												echo "0".floor($worker_one_day_hour / 60).":";//시간 출력 예 07:00
											}
											else floor($worker_one_day_hour / 60).":";//근로시간이 10시간 이상으로 근무 했을 경우
											if(((int)$worker_one_day_hour % 60) < 10){//10분 이하 출력
												echo "0".(int)$worker_one_day_hour % 60;
											}
											else echo (int)$worker_one_day_hour % 60;//10분 이상 출력
										}
										else{
											if(floor($worker_one_day_hour / 60) < -1){//60분 이하로 일을 할 경우
												echo "00:";
											}
											else if(floor($worker_one_day_hour / 60 < 10)){//10시 이하의 경우
												echo "0".floor($worker_one_day_hour / 60).":";
											}
											else floor($worker_one_day_hour / 60).":";//10시 이상 부터
											if(((int)$worker_one_day_hour % 60) < 10){//10분 이하 출력
												echo "0".(int)$worker_one_day_hour % 60;
											}	
											else echo (int)$worker_one_day_hour % 60;//10분 이상 출력
										}
									}
									else {
										$worker_one_day_hour = "-";
										echo $worker_one_day_hour;
									}
									?>
								</td>
								<td><?= $worker_attend_ot_time ?></td>
								<td><?= $worker_finish_ot_time ?></td>
								<td class=""><!--OT근무시간-->
									<?php
										if($worker_one_day_ot_hour>0){
											if(floor($worker_one_day_ot_hour / 60) < -1){//60분 이하로 일을 할 경우
													echo "00:";
											}
											else if(floor($worker_one_day_ot_hour / 60 < 10)){//10시 이하의 경우
													echo "0".floor($worker_one_day_ot_hour / 60).":";
											}
											else floor($worker_one_day_ot_hour / 60).":";//10시 이상 부터
											
											if(((int)$worker_one_day_ot_hour % 60) < 10){//10분 이하 출력
													echo "0".(int)$worker_one_day_ot_hour % 60;
											}	
											else echo (int)$worker_one_day_ot_hour % 60;//10분 이상 출력
										}
										else if($worker_one_day_ot_hour<0){
											$int_attend_ot_hour = (int)substr($worker_finish_ot_time,0,2);//출근시간
											$int_attend_ot_min = (int)substr($worker_finish_ot_time,3,2);//출근시간
											$int_attend_ot_hour = $int_attend_ot_hour + 6;
											
											if($int_attend_ot_hour < 10){
												echo "0".$int_attend_ot_hour.":";
											}
											else echo $int_attend_ot_hour.":";
											
											if($int_attend_ot_min < 10){
												echo "0".$int_attend_ot_min;
											}
											else echo $int_attend_ot_min;
										}
										else echo "-"
									?>
								</td>
								<td>
									<?php 
										$p_sql = "select sum(project_time)as time
											from project_time_info 
											where project_time_flag = '1' 
											 and 
											phone_id = '".$uname."'".
											" and ".
											"regi_date = '".$worker_attend_day."'";
										//echo $p_sql;
										$result_p = sqlsrv_query($con, $p_sql);
										$p_row = sqlsrv_fetch_array($result_p,SQLSRV_FETCH_ASSOC);
										if(isset($p_row['time'])== FALSE){
											echo "-";
										}
										else{
											$p_hour = floor($p_row['time']/60);
											$p_min = floor($p_row['time']%60);
											//echo $p_hour;
											
											if($p_hour < 10){
												echo "0".$p_hour.":";
											//	echo "10시 이하";
											}
											else echo $p_hour.":";
											
											if($p_min < 10){
												echo "0".$p_min;
											}
											else echo $p_min;
										}
									?>
								</td>
						     </tr>
						<?php
							}
							?>
                        </tbody>
                    </table>

            </div>
        </div>
    </div>
  </div>
</aside>
</div>
</div>
</body>
</html>