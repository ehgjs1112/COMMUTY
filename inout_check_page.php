<!-- 로그인 여부 확인 -->
<?php
    include_once ('./session_check.php');	    
?>

<html lang="en">
    <HEAD>
        <TITLE>출*퇴근 확인 창</TITLE>
        <meta charset="utf-8">
		<link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">
		
		<link type="text/css" rel="stylesheet" href="/css/common.css"/>
		<link type="text/css" rel="stylesheet" href="/css/inout_check_page.css"/>
        
		<script type="text/javascript">
		var count = 1;
		var addCount;
		var checkbox_Name = 'CHECK';
		var Student_NUMBER = 'ST_NUMBER[]';
		var Student_NAME = 'ST_NAME[]';
		var Student_LANG = 'ST_LANG_SCORE[]';
		var Student_ENG = 'ST_ENG_SCORE[]';
		var Student_SCIEN = 'ST_SCIEN_SCORE[]';
		var Student_SOCIE = 'ST_SOCIE_SCORE[]';
		var Student_CLASS = 'ST_CLAS_NAME[]'; 
		var table_hidden = 'style = DISPLAY:none';
		
			function add_row() {  			
						var table_Str =  	"        <tr>                                                                                                                                                             "
							table_Str  +=    "         <td "+table_hidden+"><input type=text name=project_job_code[] id=project_job_code"+count+" class=form-control  readonly></td>    "              
							table_Str  +=    "         <td "+table_hidden+"><input type=text name=project_code[]       id=project_code"+count+" class=form-control  readonly></td>          "                
							table_Str  +=    "         <td><a href=javascript:doPopupopen("+count+")><input type=text name=project_name[]       id=project_name"+count+" class=form-control  ></a></td>        "
							table_Str  +=    "         <td>                                                                                                                                                     "
							table_Str  += 	"           <select class=form-control name=project_time[] id=project_time>                                                                                                         "
							table_Str  += 	"			<option>30분</option>"
							table_Str  += 	"			<option>1시간</option>"
							table_Str  += 	"			<option>1시간30분</option>"
							table_Str  += 	"			<option>2시간</option>"
							table_Str  += 	"			<option>2시간30분</option>"
							table_Str  += 	"			<option>3시간</option>"
							table_Str  += 	"			<option>3시간30분</option"
							table_Str  += 	"			<option>4시간</option>"
							table_Str  += 	"			<option>4시간30분</option>"
							table_Str  += 	"			<option>5시간</option>"
							table_Str  += 	"			<option>5시간30분</option>"
							table_Str  += 	"			<option>6시간</option>"
							table_Str  += 	"			<option>6시간30분</option>"
							table_Str  += 	"			<option>7시간</option>"
							table_Str  += 	"			<option>7시간30분</option>"
							table_Str  += 	"			<option>8시간</option>"
							table_Str  += 	"			<option>8시간30분</option>"
							table_Str  += 	"			<option>9시간</option"
							table_Str  += 	"			<option>9시간30분</option>"
							table_Str  += 	"			<option>10시간</option>"
							table_Str  += 	"			<option>10시간30분</option>"
							table_Str  += 	"		    </select>                                                                                                                                                        "
							table_Str  += 	"	      </td>                                                                                                                                                              "
							table_Str  += 	"	      <td>                                                                                                                                                                     "
							table_Str  += 	"	        <select class=form-control name=division[] id =division >                                                                                                                                                               "
							table_Str  += 	"	           <option value='0'>정상 근무 시간</option>                                                                                                                                                             "
							table_Str  += 	"	           <option value='1'>OT 근무 시간</option>                                                                                                                                                             "
							table_Str  += 	"	         </select>                                                                                                                                                                     "
							table_Str  += 	"	      </td>                                                                                                                                                                     "
							table_Str  +=    "       </tr>                                                                                                                                                               " 
						
						
						var table = document.getElementById("dynamic_table");
						var newRow = table.insertRow();
						newRow.innerHTML = table_Str;
						
						count++;
			
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
					var f=document.inout_form;
                        f.formCount.value = count;
                }
                document.inout_form.submit();
            }
			function delete_row() {
				var my_tbody = document.getElementById('dynamic_table');
				//맨 마지막 row 는 남기기 table 내의 tr개수로 row 개수를 확인한다 
				if (my_tbody.rows.length <= 2) return;
				
				// my_tbody.deleteRow(0); // 상단부터 삭제
				my_tbody.deleteRow( my_tbody.rows.length-1 ); // 하단부터 삭제
				count--;
			}
			
			function subtractInputBox() {
				var table = document.getElementById("dynamic_table");
				var rows = dynamic_table.rows.length;
				var chk = 0;
				var delet_array = new Array();
				var flag = 0;
				if(rows > 1){
					for(var i = 1; i < document.gForm.CHECK.length; i++){
						if(document.gForm.CHECK[i].checked == true){
							table.deleteRow(i+1);
							i--;
							count--;
							chk++;
						}
					}
					if(chk <= 0){
							alert("삭제할 행 선택하세여");
					}
				}
			}
			function showtable(){
				var show_table = document.getElementById("show_table");
			}
			function doPopupopen(count) {
				var count = count;
				var url= "responsive_code_search_main.php?count="+count;
				window.open(url,  "popupNo1", "width=600, height=600");
			}
		
		</script>
		<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
	    
	</HEAD>
        <body onload ="printClock()">
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
						$ID = $_SESSION['uname'];
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
												
							$sql = "select  worker_attend_time
									from Attendance_info
									where phone_id = '".$ID."' 
									and
									worker_attend_day = '".$search_date."'";
									
									
							$result_in_sql = sqlsrv_query($con, $sql);
							$today_attend = sqlsrv_fetch_array($result_in_sql,SQLSRV_FETCH_ASSOC);
							
							if(isset($today_attend)){
								$today_attend = $today_attend['worker_attend_time']->format('H:i');						
								$today_attend_array = array();
								$today_attend_array = explode(':',$today_attend);
								
								
								if((int)$today_attend_array[0] === 12){
									$today_attend_array[1] = 0;
									$today_attend_array[0] = 13; 
									echo "1";
								}
								
								if((int)$today_attend_array[0] < 9){
									$today_attend_array[0] = 9;
									$today_attend_array[1] = 0;
									echo "2";
								}
								elseif((int)$today_attend_array[1] < 30 and (int)$today_attend_array[1] > 0){ 
									$today_attend_array[1] = 30;
									echo "3";
								}
								elseif((int)$today_attend_array[1] > 30){ 
									$today_attend_array[0] = $today_attend_array[0] + 1;
									$today_attend_array[1] = 0;
									echo "4";
								}
			
								$now_time = date('H:i');
								$today_finish_array = array();
								$today_finish_array = explode(':',$now_time);
								if((int)$today_finish_array[0] > (int)$today_attend_array[0]){
									if((int)$today_finish_array[1] < 30){
										$today_finish_array[1] = 0;
										echo "5";
									}
									else{
										$today_finish_array[1] = 30; 
										echo "6";
									}
									$today_finish_min = ($today_finish_array[0]*60)+$today_finish_array[1];
									if($today_finish_min > 1110){//ot
										$today_work_hour = 18 - (int)$today_attend_array[0]; 
										$today_work_min = 0 - (int)$today_attend_array[1]; 
		
										$today_ot_work_hour = $today_finish_array[0] - 18; 
										$today_ot_work_min = $today_finish_array[1];
										
										$today_ot_work_time = $today_ot_work_hour.":".$today_ot_work_min;
									}
									else{
										$today_work_hour = $today_finish_array[0] - (int)$today_attend_array[0]; 
										$today_work_min = $today_finish_array[1] - (int)$today_attend_array[1]; 
										$today_ot_work_time = "None";
									}
									
									if($today_work_min < 0 and (int)$today_finish_array[0] > (int)$today_attend_array[0]){
											echo $today_finish_array[0];
											echo $today_attend_array[0];
											$today_work_hour = $today_work_hour - 1;
											$today_work_min = 30;
									}
									if((int)$today_attend_array[0] < 12 and $today_finish_array[0] > 12) $today_work_hour = $today_work_hour - 1;
									
									$today_work_time = $today_work_hour.":".$today_work_min;
								}
								else{

									$today_work_time = "None";
									$today_attend = $today_attend_array[0].":".$today_attend_array[1];
									$now_time = "None";
									$today_ot_work_time = "None";
								}
							}
							else {
								$today_work_time = "None";
								$today_attend = "None";
								$now_time = "None";
								$today_ot_work_time = "None";
							}

							echo "today_work_time :".$today_work_time."<br>";
							echo "today_ot_work_time :".$today_ot_work_time."<br>";
							echo $today_attend."/".$now_time."<br>"
						?>		
						
              <div class="content">   
						<div class="inbox-body">
							<form name="time" method="post">
								<table>
									<tr>
										<td>출*퇴근 확인 
									<tr>
										<td width = "2">
											<div style="border:1px solid #dedede; 
													width : 600px; height: 60px; 
													line-height:50px; 
													color:#666;
													font-size:50px; 
													text-align:left;
													"id = "clock">
											</div>
										</td>
								</table>
							</form>
						</div>
					    <?php echo "&nbsp"."* 프로젝트별 시간배분은 총 15시간까지 할수 있도록 제한 되어 있습니다. *";?>
		                <div class="inbox-body">
								

							<form name="inout_form" method="post" id="inout_form" action="main_controller.php">
                                <input type="hidden" name="formCount" id="formCount"/>							 
                               		<table border = 0>
										<tr>
											<td>
												<input type="button" value="출근" onclick='mySubmit(1)'/>
												<?php
													//$s_sql = "select worker_time from time_history where phone_id = '".$ID."' and worker_stat = 2 and finish_check = 0 and worker_attend_day = '".$search_date."' or phone_id = '".$ID."' and worker_stat = 0 and finish_check = 0 and worker_attend_day = '".$search_date."' order by worker_time desc"; 
										
													$s_sql =  "select worker_time from time_history where phone_id = '".$ID."' and (worker_stat = 2 or worker_stat = 0 ) and finish_check = 0 and worker_attend_day = '".$search_date."' order by idx desc";
													//echo $s_sql;
													//exit();
													$get_today_attend = sqlsrv_query($con, $s_sql);
													$today_attend = sqlsrv_fetch_array($get_today_attend,SQLSRV_FETCH_ASSOC);
													$worker_attend_time = (isset($today_attend['worker_time']) && $today_attend['worker_time']) ? $today_attend['worker_time'] -> format('H:i') : "미출근"; 
													echo $worker_attend_time;
												?>
											</td>
										<tr>
											<td>
												<input type="button" value="퇴근" onclick='mySubmit(2)'/>
												<?php
													$f_sql = "select worker_finish_time, worker_finish_ot_time from Attendance_info where phone_id = '".$ID."' and "."worker_attend_day = '".$search_date."'";
													$get_today_finish = sqlsrv_query($con, $f_sql);
													$worker_finish = sqlsrv_fetch_array($get_today_finish,SQLSRV_FETCH_ASSOC);
													if(isset($worker_finish['worker_finish_ot_time'])){
														$f_sql =  "select worker_time from time_history where phone_id = '".$ID."' and (worker_stat = 1 or worker_stat = 5 ) and finish_check = 1 and worker_attend_day = '".$search_date."' order by idx desc";
													
													}
													elseif(isset($worker_finish['worker_finish_time'])){
														$f_sql =  "select worker_time from time_history where phone_id = '".$ID."' and (worker_stat = 1 or worker_stat = 3 ) and finish_check = 1 and worker_attend_day = '".$search_date."' order by idx desc";
													
													}
													else $worker_finish_time = "미퇴근";
													
													//echo $s_sql;
													//exit();
													$get_today_finish = sqlsrv_query($con, $f_sql);
													$today_finish = sqlsrv_fetch_array($get_today_finish,SQLSRV_FETCH_ASSOC);
													$worker_finish_time = (isset($today_finish['worker_time']) && $today_finish['worker_time']) ? $today_finish['worker_time'] -> format('H:i') : "미출근"; 
													
													echo $worker_finish_time;
												?>												
											</td>
										<tr>
											<td style="visibility: hidden">빈칸</td>
									
									</table>

								   <table name="dynamic_table" id="dynamic_table" class="table table-bordered">
                                         <tbody>
										
										<tr class="">
											<td class="">프로젝트명</td>
											<td class="">시간</td>
											<td class="">구분</td>
										</tr>
										<tr class="">
                                            
											<td class=""><a href='javascript:doPopupopen(0)' ><input type="text" name="project_name[]"     id="project_name0" class="form-control" placeholder=""  value="" ></a>                                          
                                            <td class="" style="DISPLAY: none"><input type="text" name="project_job_code[]" id="project_job_code0" placeholder="" value="" readonly class="form-control">
                                            <td class="" style="DISPLAY: none"><input type="text" name="project_code[]"     id="project_code0" placeholder=""  value=""  readonly class="form-control">
											
											<!--
											<td class=""><a href='javascript:doPopupopen(0)' ><input type="text" name="project_name[]"     id="project_name0" class="form-control" placeholder=""  value=""  readonly></a></td>
                                            <td class=""><input type="text" name="project_job_code[]" id="project_job_code0" class="form-control" placeholder="" value="" readonly></td>
                                            <td class=""><input type="text" name="project_code[]"     id="project_code0" class="form-control" placeholder=""  value=""  readonly></td>
                                            -->   
											<td class="">
						         	            <select class="form-control" name="project_time[]" id="project_time0">
												<option>30분</option>
						         				<option>1시간</option>
						         				<option>1시간30분</option>
						         				<option>2시간</option>
						         				<option>2시간30분</option>
						         				<option>3시간</option>
						         				<option>3시간30분</option>
						         				<option>4시간</option>
						         				<option>4시간30분</option>
						         				<option>5시간</option>
						         				<option>5시간30분</option>
						         				<option>6시간</option>
						         				<option>6시간30분</option>
						         				<option>7시간</option>
						         				<option>7시간30분</option>
						         				<option>8시간</option>
						         				<option>8시간30분</option>
						         				<option>9시간</option>
						         				<option>9시간30분</option>
						         				<option>10시간</option>
						         				<option>10시간30분</option>
												</select>
						         		    </td>
											<td class="">
						         	            <select class="form-control" name="division[]" id="division0">
												  <option value="0">정상 근무 시간</option>
						         				  <option value="1">OT 근무 시간</option>
						     					</select>
						         		    </td>
										</tr>
								        </tbody>
                                    </table>
                                     <table class="table">
									  <tr>       
	                                     <td style="text-align:right">
											 <input type="button" value="+" onclick='add_row()' />	
											 <input type="button" value="-" onclick='delete_row()' />	
										 </td>
									  </tr>
  		                             </table>
							</form>					

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