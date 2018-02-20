<!-- 로그인 여부 확인 -->
<?php
       include_once ('./session_check.php');	    
?>

<html lang="en">
    <HEAD>
        <TITLE>출*퇴근 확인 창</TITLE>
        <meta charset="utf-8">
		<link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">
		<link type="text/css" rel="stylesheet" href="/css/inout_check_page.css"/>
        
		
<script language="javascript">
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
 
//행추가

 function add_row() {  			
			var table_Str =  	"        <tr>                                                                                                                                                             "
			    table_Str  += 	"	         <td>                                                                                                                                                         "
                table_Str  +=   "        <a href=javascript:doPopupopen("+count+")>     선택    </a>                                                                                                                                                                   "
			    table_Str  += 	"			 </td>                                                                                                                                                           "      
			    table_Str  +=    "          <td ><input type=text name=project_job_code[] id=project_job_code"+count+" class=form-control  readonly></td>    "              
                table_Str  +=    "         <td><input type=text name=project_code[]       id=project_code"+count+" class=form-control  readonly></td>          "                
                table_Str  +=    "         <td><input type=text name=project_name[]       id=project_name"+count+" class=form-control  readonly></td>        "
                table_Str  +=    "         <td >                                                                                                                                                     "
			    table_Str  += 	"           <select class=form-control name=project_time[] id=project_time>                                                                                                         "
			    table_Str  += 	"			<option>0.5</option>"
			    table_Str  += 	"			<option>1</option>"
			    table_Str  += 	"			<option>1.5</option>"
			    table_Str  += 	"			<option>2</option>"
			    table_Str  += 	"			<option>2.5</option>"
			    table_Str  += 	"			<option>3</option>"
			    table_Str  += 	"			<option>3.5</option"
			    table_Str  += 	"			<option>4</option>"
			    table_Str  += 	"			<option>4.5</option>"
			    table_Str  += 	"			<option>5</option>"
			    table_Str  += 	"			<option>5.5</option>"
			    table_Str  += 	"			<option>6</option>"
			    table_Str  += 	"			<option>6.5</option>"
			    table_Str  += 	"			<option>7</option>"
			    table_Str  += 	"			<option>7.5</option>"
			    table_Str  += 	"			<option>8</option>"
			    table_Str  += 	"			<option>8.5</option>"
			    table_Str  += 	"			<option>9</option"
			    table_Str  += 	"			<option>9.5</option>"
			    table_Str  += 	"			<option>10</option>"
			    table_Str  += 	"			<option>10.5</option>"
			    table_Str  += 	"		    </select>                                                                                                                                                        "
			    table_Str  += 	"	      </td>                                                                                                                                                              "
			    table_Str  += 	"	                                                                                                                                                                           "
                table_Str  +=    "         </tr>                                                                                                                                                               " 
              
			
			var table = document.getElementById("dynamic_table");
			var newRow = table.insertRow();
			newRow.innerHTML = table_Str;
	         
			 count++;
  
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
</script>
		
		<script type="text/javascript">
			function doPopupopen(count) {
				var count = count;
				var url= "responsive_code_search_main.php?count="+count;
				window.open(url,  "popupNo1", "width=600, height=600");
			}
        </script>
		
		<script type="text/javascript">
            function mySubmit(index) {
                if (index == 1) {
                    document.inout_form.action = 'main_controller.php?mode=in';
                }
                if (index == 2) {
					 var f=document.inout_form;
                        f.formCount.value = count;
						document.inout_form.submit();
                }
            }
        </script>

		<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
	    
	</HEAD>
        <body onload ="printClock()">
        <div class="container">
         <div class="col-lg-12">
		<div class="col-lg-11">
		
		</div>
		
	 
	 </div>   
			<link rel='stylesheet prefetch' href='http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css'>
            <div class="mail-box">
                <aside class="sm-side">
                    
					<?php
						include_once ('/userHead_info/userHead_infor.php'); 	    						
                        include_once ('/manu/left_menu/user_left_responsive_main_menu.php'); 	    						
                    ?>
				   
               </aside>
                <aside class="lg-side">
                    <div class="inbox-head">
                       
                     
                  <?php
					include_once ('/manu/user_top_manu.php');	    
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
//							$sql = "SELECT  
//									phone_id,
//									worker_nm
//									from worker_info
//									WHERE worker_state = '1'
//									ORDER BY worker_nm ASC";
							
//							$result_sql = sqlsrv_query($con, $sql);
							//echo $sql;
							//db 접속 실패 경우
//							if ($con == false) {
//								echo "Unable to connect.</br>";
//								die(print_r(sqlsrv_errors(), true));
//							}
							?>

							<?php
							//반복문 시작 
							//  while($row = sqlsrv_fetch_array($result_sql,SQLSRV_FETCH_ASSOC)){

								//$in_sql = "select
								//			worker_info.phone_id.
								//			worker_info.worker_nm,
								//			worker_attend_time, 
								//			worker_finish_time, 
								//			worker_attend_ot_time, 
								//			worker_finish_ot_time, 
								//			DATEDIFF(mi,worker_attend_time,worker_finish_time)as worker_one_day_hour,
								//			DATEDIFF(mi,worker_attend_ot_time,worker_finish_ot_time)as worker_one_day_ot_hour 
								//			from Attendance_info, worker_info
								//			where worker_state = '1' and worker_attend_day ='".$search_date."'";

                                // $time = date('H:i');								
								$sql = "select  worker_info.phone_id, 
										worker_info.worker_nm,
										Attendance_info.worker_attend_time,
										CONVERT(varchar(5), GetDate(),114) as worker_finish_time,
										Attendance_info.worker_attend_ot_time,
										Attendance_info.worker_finish_ot_time,
										Attendance_info.worker_attend_day,
										DATEDIFF(mi,worker_attend_time,CONVERT(varchar(5), GetDate(),114))as worker_one_day_hour,
										DATEDIFF(mi,worker_attend_ot_time,worker_finish_ot_time)as worker_one_day_ot_hour 									
										from worker_info
										left outer join Attendance_info
										ON worker_info.phone_id = Attendance_info.phone_id and worker_attend_day = '".$search_date."'
										where worker_info.phone_id = '".$ID."' and worker_flag = 1";
							  //echo $sql;
								echo "<br>";								
								$result_in_sql = sqlsrv_query($con, $sql);
						      //echo $sql;
								while($in_row = sqlsrv_fetch_array($result_in_sql,SQLSRV_FETCH_ASSOC)){
								$worker_ID = $in_row['phone_id'];
								$worker_NM = $in_row['worker_nm'];
								$worker_NM = iconv("CP949", "UTF-8//TRANSLIT", $worker_NM);
								if($in_row['worker_attend_time'] != NULL AND $in_row['worker_finish_time'] != NULL 
									AND $in_row['worker_finish_ot_time'] != NULL AND $in_row['worker_finish_ot_time'] != NULL){
									$worker_attend_time = $in_row['worker_attend_time']->format('H:i');
									$worker_finish_time = $in_row['worker_finish_time'];
									$worker_attend_ot_time = $in_row['worker_attend_ot_time']->format('H:i');
									$worker_finish_ot_time = $in_row['worker_finish_ot_time']->format('H:i');
								}
								else if($in_row['worker_attend_time'] != NULL AND $in_row['worker_finish_time'] != NULL){
									$worker_attend_time = $in_row['worker_attend_time']->format('H:i');
									$worker_finish_time = $in_row['worker_finish_time'];
									$worker_attend_ot_time = "-";
									$worker_finish_ot_time = "-";
								}
								else{
									$worker_attend_time = "미출근";
									$worker_finish_time = "미퇴근";
									$worker_attend_ot_time = "-";
									$worker_finish_ot_time = "-";
								} 
								
								$worker_one_day_hour = $in_row['worker_one_day_hour'];
								$worker_one_day_ot_hour = $in_row['worker_one_day_ot_hour'];
								
								//echo "aaabbbbcc";
								//echo $worker_one_day_hour;
							?>					
					
							<?
								///////////////////////////////////////////////////////////////////////////////////////////////
								$int_attend_time = (int)substr($worker_attend_time,0,2);//출근시간
									if((int)$worker_one_day_hour > 0){//총 일한 시간이 0 이상일 경우
										if($int_attend_time < 13 and $int_attend_time > 8){//12시간 이전 일 경우 
											if(((int)$worker_one_day_hour - 60)>0){//worker_one_day_hour => 쿼리에서 출퇴근 시간 뺀것
											
												$int_finish_time = (int)substr($worker_finish_time,0,2);//퇴근시간
												if($int_finish_time > 13){// 퇴근 시간이 13시 이상인지 확인 오전 퇴근 인지 확인
													$worker_one_day_hour = (int)$worker_one_day_hour - 60;//
												}
											}//echo "<br>".."<br>"
											if(floor($worker_one_day_hour / 60) < -1){//60분 이하로 일을 할 경우
												echo "00:";
												$total_hour = 0;
											}
											else if(floor($worker_one_day_hour / 60 < 10)){//근로시간이 10시간 이하로 근무 했을 경우
												echo "0".floor($worker_one_day_hour / 60).":";//시간 출력 예 07:00
												$total_hour = floor($worker_one_day_hour / 60);
											}
											else floor($worker_one_day_hour / 60).":";//근로시간이 10시간 이상으로 근무 했을 경우
											if(((int)$worker_one_day_hour % 60) < 10){//10분 이하 출력
												echo "0".(int)$worker_one_day_hour % 60;
												$total_min = (int)$worker_one_day_hour % 60;
											}
											else {echo (int)$worker_one_day_hour % 60;//10분 이상 출력
												$total_min = (int)$worker_one_day_hour % 60;
											}
										}
										else{
											if(floor($worker_one_day_hour / 60) < -1){//60분 이하로 일을 할 경우
												echo "00:";
												$total_hour = 0;
											}
											else if(floor($worker_one_day_hour / 60 < 10)){//10시 이하의 경우
												echo "0".floor($worker_one_day_hour / 60).":";
												$total_hour = floor($worker_one_day_hour / 60);
											}
											else {
												echo floor($worker_one_day_hour / 60).":";//10시 이상 부터
												$total_hour = floor($worker_one_day_hour / 60);
											}
											if(((int)$worker_one_day_hour % 60) < 10){//10분 이하 출력
												echo "0".(int)$worker_one_day_hour % 60;
												$total_min = (int)$worker_one_day_hour % 60;
											}	
											else{ 
												echo (int)$worker_one_day_hour % 60;//10분 이상 출력
												$total_min = (int)$worker_one_day_hour % 60;
											}
										}
									}
									else {
										$worker_one_day_hour = "-";
										echo $worker_one_day_hour;
										$total_min = 0;
										$total_hour = 0;
									}
									
									if($worker_one_day_ot_hour>0){
											if(floor($worker_one_day_ot_hour / 60) < -1){//60분 이하로 일을 할 경우
												echo "00:";
												$total_ot_hour = 0;
											}
											else if(floor($worker_one_day_ot_hour / 60 < 10)){//10시 이하의 경우
												echo "0".floor($worker_one_day_ot_hour / 60).":";
												$total_ot_hour = floor($worker_one_day_ot_hour / 60);	
											}
											else {
												echo floor($worker_one_day_ot_hour / 60).":";//10시 이상 부터
												$total_ot_hour = floor($worker_one_day_ot_hour / 60);
											}
											if(((int)$worker_one_day_ot_hour % 60) < 10){//10분 이하 출력
													echo "0".(int)$worker_one_day_ot_hour % 60;
													$total_ot_min = (int)$worker_one_day_ot_hour % 60;
											}	
											else{ 
												echo (int)$worker_one_day_ot_hour % 60;//10분 이상 출력
												$total_ot_min = (int)$worker_one_day_ot_hour % 60;
											}
										}
										else {
											echo "-";
											$total_ot_hour = 0;
											$total_ot_min = 0;
										}
								?>
						
								<?php
								    //임시 주석처리
									//echo "<br>"."하루 일반 근무시간입니다 : ";
									//echo $total_hour." 시 ".$total_min."분".(int)$worker_one_day_hour."<br>";
									//echo "하루 ot 근무시간입니다 : ";
									//echo $total_ot_hour." 시 ".$total_ot_min."분".(int)$worker_one_day_ot_hour;
								?>					
					         <?php
							$join_num++;
							}
							 ?>
					       * 프로젝트별 시간배분은 총 15시간까지 할수 있도록 제한 되어 있습니다. *
		                <div class="inbox-body">
								

							 <form name="inout_form" method="post" id="inout_form" action="main_controller.php?mode=out">
                                <input type="hidden" name="formCount" id="formCount"/>							 
                                    <table name="dynamic_table" id="dynamic_table" class="table table-bordered">
                                         <tbody>
						         	        
										<tr class="">
											<td>
											</td>
											<td class="">프로젝트명</td>
											<td class="">job 코드</td>
											<td class="">WBS코드</td>
											<td class="">시간</td>
										</tr>
											<tr class="">
						         			     
												<td class="">
													<a href='javascript:doPopupopen(0)' >선택</a>
                                                </td>
                                                <td class=""><input type="text" name="project_name[]"     id="project_name0" class="form-control" placeholder=""  value=""  readonly></td>
						         			   
                                                <td class=""><input type="text" name="project_job_code[]" id="project_job_code0" class="form-control" placeholder="" value="" readonly></td>
                                                
                                                <td class=""><input type="text" name="project_code[]"     id="project_code0" class="form-control" placeholder=""  value=""  readonly></td>
                                                 
                                                 
                                                <td class="">
						         	             <select class="form-control" name="project_time[]"          id="project_time0">
													<option>0.5</option>
						         					<option>1</option>
						         					<option>1.5</option>
						         					<option>2</option>
						         					<option>2.5</option>
						         					<option>3</option>
						         					<option>3.5</option>
						         					<option>4</option>
						         					<option>4.5</option>
						         					<option>5</option>
						         					<option>5.5</option>
						         					<option>6</option>
						         					<option>6.5</option>
						         					<option>7</option>
						         					<option>7.5</option>
						         					<option>8</option>
						         					<option>8.5</option>
						         					<option>9</option>
						         					<option>9.5</option>
						         					<option>10</option>
						         					<option>10.5</option>
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
									 <input type="button" value="완료" onclick='mySubmit(2)' />	
							</form>					

                       </div>
				   
				     	
				    </div>
</aside>
</div>
</div>
<script type="text/javascript">

</script>
</body>
</html>