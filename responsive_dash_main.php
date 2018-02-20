<!DOCTYPE html>
<?php
    include_once ('./session_check.php');	  
	$p_month = (isset($_POST['month']) && $_POST['month']) ? $_POST['month'] : date('n');
	$p_year = (isset($_POST['year']) && $_POST['year']) ? $_POST['year'] : date('Y');
	$p_day = (isset($_POST['day']) && $_POST['day']) ? $_POST['day'] : date('d');
	$g_date = (isset($_GET['DATE']) && $_GET['DATE']) ? $_GET['DATE'] : NULL;
	if(isset($g_date)!=0){
		echo $g_date;
		$g_dates = array();
		$g_dates = preg_split('-',$g_date);
		$p_year = $g_dates[0];
		$p_month = $g_dates[1];
		$p_day = $g_dates[2];
		unset($g_dates);
		echo "get success";
	}
?>
<html lang="en">
    <head>
		
        <meta charset="utf-8">
        <!-- This file has been downloaded from Bootsnipp.com. Enjoy! -->
        <title>Responsive Mail Inbox and Compose - Bootsnipp.com</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">
        <!-- css 파일 임포트 -->
		<link type="text/css" rel="stylesheet" href="/css/common.css"/>
		<link type="text/css" rel="stylesheet" href="/css/responsive_dash_main.css"/>         
		<script type="text/javascript">
            function win_format($title, $url, $target, $width, $height, $scrollbars=1, $empty) {
				$title = text_format($title, $empty);
				return "<a href='#' onclick=\"open_window('{$url}', '{$target}', {$width}, {$height}, {$scrollbars})\">{$title}</a>";
			}			
			function printClock() {
                var clock = document.getElementById("clock");            // 출력할 장소 선택
                var currentDate = new Date();                                     // 현재시간
                var calendar = currentDate.getFullYear() + "-" + (currentDate.getMonth() + 1) + "-" + currentDate.getDate() // 현재 날짜
                var amPm = 'AM'; // 초기값 AM
                var currentHours = addZeros(currentDate.getHours(), 2);
                var currentMinute = addZeros(currentDate.getMinutes(), 2);
                var currentSeconds = addZeros(currentDate.getSeconds(), 2);

                if (currentHours >= 12) { // 시간이 12보다 클 때 PM으로 세팅, 12를 빼줌
                    amPm = 'PM';
                    currentHours = addZeros(currentHours - 12, 2);
                }

                if (currentSeconds >= 50) {// 50초 이상일 때 색을 변환해 준다.
                    currentSeconds = '<span style="color:#de1951;">' + currentSeconds + '</span>'
                }
                clock.innerHTML = calendar + '\r\n\r\n' + currentHours + ":" + currentMinute + ":" + currentSeconds + " <span style='font-size:50px;'>" + amPm + "</span>"; //날짜를 출력해 줌

                setTimeout("printClock()", 1000);         // 1초마다 printClock() 함수 호출
            }
            function addZeros(num, digit) { // 자릿수 맞춰주기
                var zero = '';
                num = num.toString();
                if (num.length < digit) {
                    for (i = 0; i < digit - num.length; i++) {
                        zero += '0';
                    }
                }
                return zero + num;
            }
            function mySubmit(index) {
                if (index == 1) {
                    document.inout_form.action = 'main_controller.php?mode=in';
                }
                if (index == 2) {
                    document.inout_form.action = 'main_controller.php?mode=out';
                }
				if (index == 3) {
                    document.inout_form.action = 'out_page.php';
                }
                document.inout_form.submit();
            }
			function addItem() {
				var lo_table = document.getElementById("TblAttach");
				var row_index = lo_table.rows.length;      // 테이블(TR) row 개수
				newTr = lo_table.insertRow(row_index);
				newTr.idName = "newTr" + row_index;
						
				newTd=newTr.insertCell(0);
				newTd.innerHTML="<tr><td><select name = project>"
								+"<option value = 에너지>에너지</option>"
								+"<option value = 삼림>삼림</option>"
								+"</select></td>"
								+"<td><select name = work_time>"
								+"<option value = 1>1</option>"
								+"<option value = 2>2</option>"
								+"<option value = 3>3</option>"
								+"<option value = 4>4</option>"
								+"<option value = 5>5</option>"
								+"<option value = 6>6</option>"
								+"<option value = 7>7</option>"
								+"<option value = 8>8</option>"
								+"<option value = 9>9</option>"
								+"<option value = 10>10</option>"
								+"</select></td></tr>";
			}
			function delItem(){
				var lo_table = document.getElementById("TblAttach");
				var row_index = lo_table.rows.length-1;      // 테이블(TR) row 개수
			
				if(row_index > 0) lo_table.deleteRow(row_index);    
			}
		</script>
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
                         include_once ('./manu/left_menu/admin_left_responsive_dash_main_menu.php'); 	    						
                     ?>
				   
				     </aside>
                <aside class="lg-side">
                    <div class="inbox-head">
						<?php
							include_once ('./manu/admin_top_manu.php');
					    ?>
						</div>
            <div class="content">
                    <div class="inbox-body">


                        <div class="row">
                            <div class="col-md-5"></div>
                            <div class="col-md-2">출퇴근_모니터링</div>
                            <div class="col-md-5"></div>
                        </div>	
                    </div>


					<form name="login_form" method="post" action="./responsive_dash_main.php">
					  <table class="table   table-bordered">
						<tbody>
                            <tr>
                                <td class="inbox-small-cells">년도</td>
                                <td class="inbox-small-cells">
								<select class="form-control" name = "year">
									<?php
										$show_year = 2016;
										for($i = 0; $show_year < 2020; $i++){
											$show_year = $show_year + 1;
											if($show_year == $p_year){?> <option value = "<?=$show_year?>" selected = "selected"><?=$show_year?></option><?php }
											else echo "<option value = ".$show_year.">".$show_year."</option>";
										}
									?>
								 </select>
								</td>
							<td class="view-message">월</td>
                                <td class="view-message ">
								<select class="form-control" name = "month" value = <?=$p_month?>>
									<?php
										$show_month = 0;
										for($i = 0; $show_month < 12; $i++){
											$show_month = $show_month + 1;
											if($show_month == $p_month){?> <option value = "<?=$show_month?>" selected = "selected"><?=$show_month?></option><?php }
											else echo "<option value = ".$show_month.">".$show_month."</option>";
										}
									?>
								 </select>
								</td>
								
                                <td class="view-message">일</td>
                                <td class="view-message ">
								<select class="form-control" name = "day" value = <?=$p_day?>>
									<?php
										$show_day = 0;
										for($i = 0; $show_day < 31; $i++){
											$show_day = $show_day + 1;
											if($show_day == $p_day){?> <option value = "<?=$show_day?>" selected = "selected"><?=$show_day?></option><?php }
											else echo "<option value = ".$show_day.">".$show_day."</option>";
										}
									?>
								</select>
								</td> 
							</tr>
	                        <tr class="unread">
                                <td class="inbox-small-cells">        
								    <div class=>
                                        <button type="submit" name = usercheck value = 0 class = "btn1">조회</button>
                                    </div>
				               </td>
                                <td class="inbox-small-cells"> 
								    <div class=>
                                        <button type="submit" name = usercheck value = 0 class = "btn1">엑셀저장</button>
                                    </div>
								 </td>
                             </tr>
						</tbody>
					</table>
				</form>
		              <BR>
                    <table class="table table-inbox table-hover table-bordered" id = 'worker_time_tb'>
                        <thead>
							<th>순번</th>
							<th>ID</th>
							<th>이름</th>
							<th>출근시간</th>
							<th>퇴근시간</th>
							<th>근무시간</th>
							<th>OT시작</th>
							<th>OT끝</th>
							<th>OT근무시간</th>
							<th>비고</th>
                        </thead>
                        <tbody>
							<?php
							include_once ('./config.php');
							$join_peaple = array();
							$join_date = array();
							$join_num = 1;
							if(isset($p_month) == FALSE){
								$search_date = date('Y-m-d');
								
							}
							else{
                               
								if((int)$p_month < 10) $p_month = "0".$p_month;
								$search_date = $p_year."-".$p_month."-".$p_day;
							}
							$con = sqlsrv_connect($serverName, $connectionInfo);

							?>
							<?php
								$sql = "select worker_info.phone_id, 
										worker_info.worker_nm,
										Attendance_info.worker_attend_time,
										Attendance_info.worker_finish_time,
										Attendance_info.worker_attend_ot_time,
										Attendance_info.worker_finish_ot_time,
										Attendance_info.worker_attend_day,
										DATEDIFF(mi,worker_attend_time,worker_finish_time)as worker_one_day_hour,
										DATEDIFF(mi,worker_attend_ot_time,worker_finish_ot_time)as worker_one_day_ot_hour 									
										from worker_info
										left outer join Attendance_info
										ON worker_info.phone_id = Attendance_info.phone_id 
										and worker_attend_day = '".$search_date."'
										where worker_info.worker_flag = 1
										order by Attendance_info.worker_attend_time DESC";
								//echo $sql;
								$result_in_sql = sqlsrv_query($con, $sql);
								while($in_row = sqlsrv_fetch_array($result_in_sql,SQLSRV_FETCH_ASSOC)){
								$worker_ID = $in_row['phone_id'];
								$worker_NM = $in_row['worker_nm'];
								$worker_NM = iconv("CP949", "UTF-8//TRANSLIT", $worker_NM);
								//데이터가 4개 다 있으면
								if($in_row['worker_attend_time'] != NULL AND $in_row['worker_finish_time'] != NULL 
									AND $in_row['worker_finish_ot_time'] != NULL AND $in_row['worker_finish_ot_time'] != NULL){
									$worker_attend_time = $in_row['worker_attend_time']->format('H:i');
									$worker_finish_time = $in_row['worker_finish_time']->format('H:i');
									$worker_attend_ot_time = $in_row['worker_attend_ot_time']->format('H:i');
									$worker_finish_ot_time = $in_row['worker_finish_ot_time']->format('H:i');
								}
								//데이터가 2개 있으면	
								else if($in_row['worker_attend_time'] != NULL AND $in_row['worker_finish_time'] != NULL){
									$worker_attend_time = $in_row['worker_attend_time']->format('H:i');
									$worker_finish_time = $in_row['worker_finish_time']->format('H:i');
									$worker_attend_ot_time = "-";
									$worker_finish_ot_time = "-";
								//데이터가 1개 있으면 	
								}else if($in_row['worker_attend_time'] != NULL ){
									$worker_attend_time = $in_row['worker_attend_time']->format('H:i');
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
								$worker_attend_day =$in_row['worker_one_day_hour'];
								$worker_one_day_hour = $in_row['worker_one_day_hour'];
								$worker_one_day_ot_hour = $in_row['worker_one_day_ot_hour'];
							?>
                            <tr class="">
								<td class=""><?= $join_num ?></td>
								<td class=""><a href="./user_info_modi.php?ID=<?= $worker_ID?>"><?= $worker_ID ?></a></td>
                                <td class=""><a href="./responsive_oneDay_approve.php?ID=<?= $worker_ID?>"><?= $worker_NM ?></a></td>
								<td class=""><a href="./time_change.php?ID=<?= $worker_ID?>&DATE=<?= $search_date?>&mode=1&time=<?= $worker_attend_time ?>"><?= $worker_attend_time ?></a></td>
								<td class=""><a href="./time_change.php?ID=<?= $worker_ID?>&DATE=<?= $search_date?>&mode=2&time=<?= $worker_finish_time ?>"><?= $worker_finish_time ?></a></td>
								<td class=""><?php
								///////////////////////////////////////////////////////////////////////////////////////////////
								$int_attend_time = (int)substr($worker_attend_time,0,2);//출근시간
									//echo "<br>".(int)$worker_one_day_hour."<br>";
									$int_attend_hour = (int)substr($worker_attend_time,0,2);//출근시간
									$int_attend_min = (int)substr($worker_attend_time,3,2);//출근시간
									if($int_attend_hour == 0 AND $int_attend_min == 0 AND (int)$worker_one_day_hour > 0) {
										$worker_one_day_hour = "관리자 문의요망";
										echo $worker_one_day_hour;
									}
									else if((int)$worker_one_day_hour > 0){//총 일한 시간이 0 이상일 경우
										if($int_attend_time < 13){//12시간 이전 일 경우 
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
								<td class=""><a href="./time_change.php?ID=<?= $worker_ID?>&DATE=<?= $search_date?>&mode=3&time=<?= $worker_attend_ot_time ?>"><?= $worker_attend_ot_time ?></a></td>
								<td class=""><a href="./time_change.php?ID=<?= $worker_ID?>&DATE=<?= $search_date?>&mode=4&time=<?= $worker_finish_ot_time ?>"><?= $worker_finish_ot_time ?></a></td>
								
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
								
								<td class=""><!--OT비고-->
									<a href="./responsive_oneDay_approve.php?ID=<?=$worker_ID?>">
										<?php
											//$sql = "select worker_info.phone_id, 
											//worker_info.worker_nm,
											//Attendance_info.worker_attend_time,
											//Attendance_info.worker_finish_time,
											//Attendance_info.worker_attend_ot_time,
											//Attendance_info.worker_finish_ot_time,
											//Attendance_info.worker_attend_day,
											//DATEDIFF(mi,worker_attend_time,worker_finish_time)as worker_one_day_hour,
											//DATEDIFF(mi,worker_attend_ot_time,worker_finish_ot_time)as worker_one_day_ot_hour 									
											//from worker_info
											//left outer join Attendance_info
											//ON worker_info.phone_id = Attendance_info.phone_id 
											//where worker_info.worker_flag = 1 and Attendance_info.phone_id = '".$worker_ID."'"."
											//order by Attendance_info.worker_attend_day DESC";
											//$result = sqlsrv_query($con, $sql);
											//$not_attend_cnt=0;
											//$not_finish_cnt=0;
											//while($error_row = sqlsrv_fetch_array($result,SQLSRV_FETCH_ASSOC)){
											//	$worker_attend_e_day = $error_row['worker_attend_day']->format('Y-m-d');
											//	$worker_attend_e_time = $error_row['worker_attend_time']->format('H:i');
											//	$worker_finish_e_time = $error_row['worker_finish_time']->format('H:i');
											//	if(strcmp($worker_attend_e_time,"00:00")==0 and strcmp($worker_attend_e_day,date('Y-m-d'))!=0){
											//		$not_attend_cnt++;
											//	}
											//	if(strcmp($worker_finish_e_time,"00:00")==0 and strcmp($worker_attend_e_day,date('Y-m-d'))!=0){
											//		$not_finish_cnt++;
											//	}
											//}
											//if($not_attend_cnt > 0) echo "미출근 :".$not_attend_cnt;
											//
											//if($not_finish_cnt > 0) echo "미퇴근 :".$not_finish_cnt;
										?>
									</a>
								</td>
                            </tr>
							
							<?php
							$join_num++;
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
<script type="text/javascript">

</script>
</body>
</html>