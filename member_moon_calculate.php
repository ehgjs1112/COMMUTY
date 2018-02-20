<!DOCTYPE html>

<?php

include_once ('./session_check.php');	

if( count($_POST)== 0   ){
$eCheck ="확인";
}else{
$eCheck  =  $_POST["eCheck"];	
}	

if($eCheck == "excel"){

$output_file_name = "다운로드.xls";
header( "Content-type: application/vnd.ms-excel" );
header( "Content-Disposition: attachment; filename={$output_file_name}.xls" );
header( "Content-Description: PHP4 Generated Data");

}

  ?>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <!-- This file has been downloaded from Bootsnipp.com. Enjoy! -->
        <title>Responsive Mail Inbox and Compose - Bootsnipp.com</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">
        <!-- css파일 임포트 -->
		<link type="text/css" rel="stylesheet" href="/css/common.css"/>
		<link type="text/css" rel="stylesheet" href="/css/member_moon_calculate.css"/> 
        <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
		
	<script type="text/javascript">	
		function mySubmit(index) {
                if (index == 1) {
                    
					document.payment.action = 'admin_controller.php?mode=payment';
					document.payment.submit();
                
				}
		   		
			   if(index == 2){
					
                var form = document.createElement("form");
                           form.setAttribute("method", "Post"); // Get 또는 Post 입력
                           form.setAttribute("action", "member_moon_calculate.php");

				var hiddenField = document.createElement("input");

                           hiddenField.setAttribute("type" , "hidden");
                           hiddenField.setAttribute("name" , "eCheck");
                           hiddenField.setAttribute("value", "excel");
                        
						   form.appendChild(hiddenField);
						   
 						   
                           document.body.appendChild(form);

						   //엑셀 다운로드
                           form.submit();				

				
               }	
				
				
				
            }
			
		
	 </script>	
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
				    if($eCheck != "excel"){
                         include_once ('./userHead_info/userHead_infor.php');
                         include_once ('./manu/left_menu/admin_left_admin_approve_menu.php');
					}						 
                    ?>
				   
                </aside>
                <aside class="lg-side">
                    <div class="inbox-head">
   						<?php
							if($eCheck != "excel"){
							    include_once ('./manu/admin_top_manu.php');
							}	
					    ?>
						</div>

						 
<?php 

/****************************** 
달력 
******************************/ 

/********** 사용자 설정값 **********/ 
$startYear        = 2007; 
$endYear        = date( "Y" ) + 4; //사용자가  년도 select box 를 조절할수 있다  

/********** 입력값 **********/ 
$year  ;           //  = ( $_GET['toYear'] )? $_GET['toYear'] : date( "Y" );              //get 방식 매개 변수 자체가 없으면 현재 년 셋팅
$month ;          // = ( $_GET['toMonth'] )? $_GET['toMonth'] : date( "m" );     //get 방식 매개 변수 자체가 없으면 현재 월 셋팅
$day    ;         //   = ( $_GET['toDay'] )? $_GET['toDay'] : date( "d" );     //get 방식 매개 변수 자체가 없으면 현재 월 셋팅

    // get 방식 년,월,일에 대해서
    //if(empty($_GET)){
	//폰 아이디 때문에 1이거나 0일때
	$search_date;
	if(count($_GET)== 1 or count($_GET)== 0 ){
	
	$year      = date( "Y" );  
	$month     = date( "m" ); 
	
    $search_date = $year."-".$month;
	}else{
		
	$year      = $_GET['toYear'];
	$month     = $_GET['toMonth'];
	$month     = sprintf('%02d',$month);
	$search_date = $year."-".$month;
	
		
	}

/********** 계산값 **********/ 
$mktime            = mktime( 0, 0, 0, $month, 1, $year );      // 입력된 값으로 년-월-01을 만든다. mktime 함수는 연도, 월,일,시,분, 초를 받아서 타임스탬프값을 만들어 리턴하는 역활을 합니다. 타임스탬프는 GMT기준 1970년 1월 1일 0시 0분 0초부터 기준날짜까지 지나온 초를 말합니다.
$days              = date( "t", $mktime );                        // 현재의 year와 month로 현재 달의 일수 구해오기.숫자로 리턴 됨
$startDay          = date( "w", $mktime );                        // 시작요일 알아내기 

// 지난달 일수 구하기 
$prevDayCount    = date( "t", mktime( 0, 0, 0, $month, 0, $year ) ) - $startDay + 1; 



// 이전, 다음 만들기 
$prevYear        = ( $month == 1 )? ( $year - 1 ) : $year; 
$prevMonth        = ( $month == 1 )? 12 : ( $month - 1 ); 
$nextYear        = ( $month == 12 )? ( $year + 1 ) : $year; 
$nextMonth     = ( $month == 12 )? 1 : ( $month + 1 ); 

// 출력행 계산 
$setRows	= ceil( ( $startDay + $days ) / 7 ); 
?> 

<?php
							$uname = $_SESSION['uname'];
?>

<!---------- 달력 출력 ----------> 

<?php

include_once ('./config.php');
							$uname = $_SESSION['uname'];
							$date = date('Y-m-d');						
							
							$con = sqlsrv_connect($serverName, $connectionInfo);


$sql_count = "   select count(*) 
						from moon_adjust
						where convert(varchar(7), moon_number, 120) = '".$search_date."'
						and moon_flag = 1
											";
						echo $sql_count;	


    //총 개수를 구하려고 함
	$sql_count = sqlsrv_query($con, $sql_count);
	$row_num   = sqlsrv_fetch_array($sql_count,SQLSRV_FETCH_NUMERIC);
	$number    = (int) implode('',$row_num);

echo $number;								

?>


<br>
<br>
<br>
  <div class="content">     
		 
	
		<?php
		if($eCheck != "excel"){ 
		?> 
		 
		 <!-- 월 출력 -->
            <div class="row">
                <div class="col-md-5" >
				
				
						  <table class="table table-inbox table-hover table-bordered">
						    <tr>
						     <td style="background-color:#EAEAEA;" >구분    </td>
					   
							 <td>    
							<select name="toMonth" onchange="submit();" style="WIDTH: 70pt; "> 
                               <option value="">전 체     </option>
							   <option value="">닐슨 서비스</option> 
                               <option value="">닐슨 컴퍼니</option>
                            </select> 
 							 </td>
							 <td style="background-color:#EAEAEA;" >정산 여부    </td>
                          <td>
							 <?php   
										if($number == 0){
											echo "미완료";
									    }else{
											echo "완료"; 
		                     }?>      
							 </td>
							 <td><input type="button" value="정산버튼" onclick  ='mySubmit(1)' />     </td>
                          <td><input type="button" value="EXPORT"   onclick  ='mySubmit(2)' />     </td>							 							 
								</tr>
						</table>
						
				    </div>
                <div class="col-md-2">						
			     <table>

                <?php
   				  //사용자가 선택한 날짜를 받는다
  				 $qDate              =   sprintf('%d-%02d',$year,$month); 
			     
                 
				 ?>
			     <tr  ALIGN=CENTER HEIGHT=30>
				     <td></td>
			
                    <td onclick="location.href='<?=$_SERVER['PHP_SELF']?>?toYear=<?=$prevYear?>&toMonth=<?=$prevMonth?>'   ">◀</td>
				
				 <td ><FONT SIZE=4 COLOR="<?=$bColor ?>"><?=$qDate?></FONT></td>
                 <td onclick="location.href='<?=$_SERVER['PHP_SELF']?>?toYear=<?=$nextYear?>&toMonth=<?=$nextMonth?>'">      ▶</td>
				 </tr>
			 </table>
						
						
							</div>
                        <div class="col-md-5 text-right">
	                                 
                         
  <table class="table table-inbox table-hover table-bordered"> 
    <form method="get"> 
          <!---------- 년, 월 동적으로 출력 ----------> 
	   <tr>
        
        <td style="WIDTH: 70pt; "> 
		
        <select name="toYear" onchange="submit();" style="WIDTH: 70pt; "> 
        <?php for( $i = $startYear; $i < $endYear; $i++ ) { ?> 
        <option value="<?=$i?>" <?=($i==$year)?"selected":""?>><?=$i?></option> 
        <?php } ?> 
        </select>
		</td>
		 <td style="WIDTH:10pt;background-color:#EAEAEA;" >년</td>	   
		
		
		<td style="WIDTH: 70pt; ">
        <select name="toMonth" onchange="submit();" style="WIDTH: 70pt; "> 
        <?php for( $i = 1; $i <= 12; $i++ ) { ?> 
        <option value="<?=$i?>" <?=($i==$month)?"selected":""?>><?=$i?></option> 
        <?php } ?> 
        </select> 
        </td>
				<td style="WIDTH:10pt;background-color:#EAEAEA;" >
		  월
		</td>
		
		</tr>
		<tr>

            </tr>
        <!---------- 년, 월 동적으로 출력 ----------> 			
    </form> 
 </table> 

    </div>
        </div>	 
        <?php
		    //엑셀 다운로드 범위
		     }
		 ?> 

		
        <form  method="post" name="payment"  action="admin_controller.php?mode=payment">
    
           <input type="hidden" name="selectedDate"   value="<?=$qDate ?>">

			
					<table style="width:1600px;height:670px; " class="table-bordered" >
                        <thead>
						  <tr>
							<th rowspan="2" style="background-color:#EAEAEA; text-align:center;"> 부서                   </th>
							<th rowspan="2" style="background-color:#EAEAEA; text-align:center;"> cost center           </th>
							<th colspan="8" style="background-color:#EAEAEA; text-align:center;"> 기본사항               </th>
							<th colspan="9" style="background-color:#EAEAEA; text-align:center;"> 급여기초               </th>
							<th style="background-color:#EAEAEA; text-align:center;">             지급액                 </th>
						  </tr>
                       	   <tr>
							<th style="background-color:#EAEAEA; text-align:center;">   성명                    </th>
							<th style="background-color:#EAEAEA; text-align:center;">   주민등록번호             </th>
							<th style="background-color:#EAEAEA; text-align:center;">   입사일                  </th>
							<th style="background-color:#EAEAEA; text-align:center;">   퇴사일                  </th>
							<th style="background-color:#EAEAEA; text-align:center;">   퇴사사유                 </th>
							<th style="background-color:#EAEAEA; text-align:center;">   주소                    </th>
							<th style="background-color:#EAEAEA; text-align:center;">   은행                    </th>
							<th style="background-color:#EAEAEA; text-align:center;">   계좌                    </th>
							<th style="background-color:#EAEAEA; text-align:center;">   시급                    </th>
							<th style="background-color:#EAEAEA; text-align:center;">   근무시간                </th>
							<th style="background-color:#EAEAEA; text-align:center;">   기본금                  </th>
							<th style="background-color:#EAEAEA; text-align:center;">   식대                    </th>
							<th style="background-color:#EAEAEA; text-align:center;">   연장근무시간             </th>
							<th style="background-color:#EAEAEA; text-align:center;">   연장근무수당             </th>
							<th style="background-color:#EAEAEA; text-align:center;">   주휴수당                 </th>
							<th style="background-color:#EAEAEA; text-align:center;">   근무일수                 </th>
							<th style="background-color:#EAEAEA; text-align:center;">   보수월액                 </th>
							<th style="background-color:#EAEAEA; text-align:center;">   지급액                   </th>
	                     </tr>						
				        </thead>
					
                        <tbody>
 							<?php
							
							       $sql = "
                                     	SELECT 
								            a.worker_pone_number,
										    a.phone_id,
										    a.worker_nm,
										    a.woker_jumin,
										    a.worker_type,
							                a.join_date,
										    a.worker_address,
										    a.bank_name,
										    a.bank_account,
											a.worker_wage,
											a.cost_center,
											a.department,
											b.total_time,
											b.all_ot_time,
											b.moon_working_day,
											DATEPART ( hh , b.total_time ) as work_hour,
											DATEPART ( hh , b.all_ot_time ) as work_ot_hour,
										   (DATEPART ( hh , b.total_time ) * a.worker_wage )       as  Amount,
									       (DATEPART ( hh ,b.all_ot_time ) * a.worker_wage * 1.5 ) as  ot_amount, 
										    (  (DATEPART ( hh , b.total_time ) * a.worker_wage )  ) as  all_amount
											from 	worker_info    a
												left outer join
											  (
											  SELECT phone_id,
											         CONVERT(TIME, DATEADD(s, SUM(( DATEPART(hh, worker_total_work_time) * 3600 ) + ( DATEPART(mi, worker_total_work_time) * 60 ) + DATEPART(ss, worker_total_work_time)), 0)) AS total_time,
													 CONVERT(TIME, DATEADD(s, SUM(( DATEPART(hh, worker_total_work_ot_time) * 3600 ) + ( DATEPART(mi, worker_total_work_ot_time) * 60 ) + DATEPART(ss, worker_total_work_ot_time)), 0)) AS all_ot_time,
													 count(phone_id) as moon_working_day
                                              FROM   Attendance_info
											  where
											  convert(varchar(7), worker_attend_day, 120) = '".$search_date."'
									          group by phone_id
											  
											  )   b
											 on a.phone_id = b.phone_id
											 where  a.worker_flag = 1;
										  
											  ";	     
							   		
								// 확인용
								$result = sqlsrv_query($con, $sql);
								
								//db 접속 실패 경우
								if ($con == false) {
									echo "Unable to connect.</br>";
									die(print_r(sqlsrv_errors(), true));
								}
							?>

							<?php
							 $rowCount = 0;
							 
							 //반복문 시작 
							 while($row = sqlsrv_fetch_array($result,SQLSRV_FETCH_ASSOC)){
								
								
								$worker_nm   = $row['worker_nm'];
								$phone_id    = $row['phone_id'];
								$woker_jumin = $row['woker_jumin'];
								$join_date   = $row['join_date'];
								
								$worker_address   = $row['worker_address'];
								$bank_name        = $row['bank_name'];
								$bank_account     = $row['bank_account'];
								$worker_wage      = $row['worker_wage'];
					        
								
								//한달 총 근로시간 
								$work_hour      = $row['work_hour'];
								
								//주휴 수당 계산 st *************************************
								if($work_hour >= 16){
								
								    $weekHoliPay  = ($work_hour * 0.2)  * $worker_wage;
								//16시간 이상이 아닐때
								}else{
									
									$weekHoliPay = "";
									
								}
								//주휴 수당 계산 ed ************************************
								
								$work_ot_hour             = $row['work_ot_hour'];
								
								$Amount                   = $row['Amount'];
								$ot_amount                = $row['ot_amount'];
								$all_amount               = $row['all_amount'];
								$moon_working_day         = $row['moon_working_day'];
								
								$cost_center               = $row['cost_center'];
								$department                = $row['department'];
								$worker_nm        = iconv("CP949", "UTF-8//TRANSLIT", $worker_nm);
								$worker_address   = iconv("CP949", "UTF-8//TRANSLIT", $worker_address);
								$bank_name        = iconv("CP949", "UTF-8//TRANSLIT", $bank_name);
								$bank_account     = iconv("CP949", "UTF-8//TRANSLIT", $bank_account);
								$worker_wage      = iconv("CP949", "UTF-8//TRANSLIT", $worker_wage);
								
								
							?>
						
                            <tr class="">
								<td class="">    <?= $department ?>                                                      </td>
								<td class="">    <?= $cost_center ?>                                    </td>
								<td class=""><a href="./calendar_2_worker.php?phone_id=<?=$phone_id?>"><?= $worker_nm?></a>     </td>
                                <td class=""><?= $woker_jumin?>                    </td>
								<td class=""><a href="./admin_project_time_check.php?phone_id=<?=$phone_id?>"><?= $join_date?>  </a>    </td>
								<td class="">                                      </td>
								<td class="">                                      </td>
								<td class="">  <?= $worker_address?>                 </td>
								<td class="">  <?= $bank_name?>                      </td>
								<td class="">  <?= $bank_account?>                   </td>
								<td class="">  <?= $worker_wage ?>                   </td>
								<td class="">  <?= $work_hour ?>                     </td>
								<td class="">  <?= $Amount  ?>                       </td>
								<td class="">                                      </td>
								<td class="">  <?= $work_ot_hour ?>                  </td>
								<td class="">  <?= $ot_amount  ?>                    </td>
								<td class="">  <?= $weekHoliPay  ?>                  </td>
								<td class="">  <?= $moon_working_day ?>               </td>
								<td class="">                                      </td>
								<!-- 주휴수당때문에 DB 에서 계산 안함 -->
								<td class="">  <?= $Amount + $ot_amount + $weekHoliPay ?> </td>
							</tr>
							<input type="hidden" name="department[]"                value="<?=$department ?>">
							<input type="hidden" name="cost_center[]"               value="<?=$cost_center ?>">
							<input type="hidden" name="worker_nm[]"                 value="<?=$worker_nm ?>">
							<input type="hidden" name="woker_jumin[]"               value="<?=$woker_jumin ?>">
							<input type="hidden" name="join_date[]"                 value="<?=$join_date ?>">
							<input type="hidden" name="resign_date[]"               value="<?=null ?>">
							<input type="hidden" name="resign_reason[]"             value="<?=null ?>">
							<input type="hidden" name="worker_address[]"            value="<?=$worker_address ?>">
							<input type="hidden" name="bank_name[]"                  value="<?=$bank_name ?>">
							<input type="hidden" name="bank_account[]"              value="<?=$bank_account ?>">
							<input type="hidden" name="worker_wage[]"               value="<?=$worker_wage ?>">
							<input type="hidden" name="worker_attend_time[]"        value="<?=$work_hour ?>">
							<input type="hidden" name="normal_cost[]"               value="<?=$Amount ?>">
							<input type="hidden" name="meal_allowance[]"            value="<?=0 ?>">
							<input type="hidden" name="worker_total_work_ot_time[]" value="<?=$work_ot_hour ?>">
							<input type="hidden" name="ot_cost[]"                   value="<?=$ot_amount ?>">
							<input type="hidden" name="week_rest_cost[]"            value="<?=$weekHoliPay ?>">
							<input type="hidden" name="working_day[]"              value="<?=$moon_working_day ?>">
							<input type="hidden" name="moon_cost[]"                 value="<?=0 ?>">
							<input type="hidden" name="payment[]"                   value="<?=$Amount + $ot_amount + $weekHoliPay ?>">
							<!-- 화면에 안보이는 영역 -->
							
							<input type="hidden" name="moon_number[]"               value="<?=$search_date."-01" ?>">
							<input type="hidden" name="moon_flag[]"                 value="<?=1 ?>">
							<input type="hidden" name="rowCount" id="rowCount"  value="<?=$rowCount ?>" />     
							
							
							
							<?php
							  //1씩 증가해서 몇번 루프를 돌았는지 확인
							  $rowCount++;
							       }
							?>
                           <input type="hidden"  name="toYear"        value="<?=$year  ?>">
						      <input type="hidden"  name="toMonth"        value="<?=$month ?>">
						</form>							
						  <tr>
						  </tr>
                         </tbody>
                    </table>
		     </div>
    </div>
</aside>
</div>
</div>
</body>
</html>


