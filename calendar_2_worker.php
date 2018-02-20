<?php
    
	include_once ('./session_check.php');

    if( count($_GET) != 4   ){
     $eCheck ="확인";
     }else{
     $eCheck  =  $_GET["eCheck"];	
     }	
    
     if($eCheck == "excel"){
     
     $output_file_name = "다운로드.xls";
     header( "Content-type: application/vnd.ms-excel" );
     header( "Content-Disposition: attachment; filename={$output_file_name}.xls" );
     header( "Content-Description: PHP4 Generated Data");	   
     
	 }

    //폰 아이디 가져옴
	$phone_id     = $_GET['phone_id'];
	
	include_once ('./lib/lunarLib.php');

?>


<?php 
	$search_date;

	if(count($_GET)== 1 or count($_GET)== 0 ){
	
	$year      = date( "Y" );  
	$month     = date( "m" ); 

    $search_date = $year."-".$month;
	
	}else{
		
	$year        = $_GET['toYear'];
	$month       = $_GET['toMonth'];
	$month       = sprintf('%02d',$month);
	$search_date = $year."-".$month;

		
	}
	//년 월 계산
	//echo $search_date;			
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
		<link type="text/css" rel="stylesheet" href="/css/calendar_2_worker.css" />
		<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
		
	   <script type="text/javascript">	
		function mySubmit(index) {
            if (index == 1) {
                    document.holiWork.action = 'admin_controller.php?mode=holiWork';
                    document.holiWork.submit();
				}
                
            if(index == 2){
					
			    location.href='calendar_2_worker.php?toYear=<?=$year?>&toMonth=<?=$month?>&phone_id=<?=$phone_id?>&eCheck=<?=excel?>'

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

                   
  	<!-- 드래그 테스트 -->
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js" type="text/javascript"></script>
  <script type="text/javascript" charset="utf-8">
    $(function () {
      var isMouseDown = false;
   	  $("#our_table td")
        .mousedown(function () {
          isMouseDown = true;
		  
          $(this).toggleClass("highlighted");
          return false; // prevent text selection
        })
        .mouseover(function () {
          if (isMouseDown) {
            $(this).toggleClass("highlighted");
          }
        })
        .bind("selectstart", function () {
          return false; // prevent text selection in IE
        });

      $(document)
        .mouseup(function () {
          isMouseDown = false;
        });
    });
    </script>
  </head>
<body>


  						<?php
							include_once ('./config.php');
							$uname = $_SESSION['uname'];
							$date = date('Y-m-d');						
							
							$con = sqlsrv_connect($serverName, $connectionInfo);
							       $sql = "
                          					 SELECT 
										         a.phone_id
                                                ,a.worker_attend_time
                                                ,a.worker_finish_time
                                                ,a.worker_attend_ot_time
                                                ,a.worker_finish_ot_time
                                                ,a.worker_attend_day
                                                ,a.worker_total_work_ot_time
                                                ,a.worker_total_work_time
                                                ,a.update_date
												,b.worker_wage
										        FROM   Attendance_info as a 
												left outer join worker_info as b on a.phone_id = b.phone_id
											  where
											  a.phone_id = '".$phone_id."' and
											  convert(varchar(7), a.worker_attend_day, 120) = '".$search_date."'
									          
											  ";	     
							   		
									$sql_count = "          select count(*) 
						                                           from holi_sheet
						                                           where convert(varchar(10), moon_number, 120) = '".$search_date."-01'
						                                           and moon_flag = 1
																   and phone_id = '".$phone_id."'
											                         ";
						                              echo $sql_count;	
										
									$sql_2 = "select *  
									          from 	worker_info 
										      where  phone_id = '".$phone_id."'";	
								
								// 확인용
								$result    = sqlsrv_query($con, $sql);
								//총 개수를 구하려고 함
								$sql_count = sqlsrv_query($con, $sql_count);
								//근무자 정보 구하기
								$result_2  = sqlsrv_query($con, $sql_2);
								
								$row_num = sqlsrv_fetch_array( $sql_count, SQLSRV_FETCH_NUMERIC);
								$number = (int) implode('',$row_num);
								echo $number ;
								//db 접속 실패 경우
								if ($con == false) {
									echo "Unable to connect.</br>";
									die(print_r(sqlsrv_errors(), true));
								}
							?>
							<?php
								while($row = sqlsrv_fetch_array($result_2,SQLSRV_FETCH_ASSOC)){
								
								 $worker_nm          = $row['worker_nm'];
								 $worker_type        = $row['worker_type'];
								 $worker_wage        = $row['worker_wage'];
								 $worker_nm          = iconv("CP949", "UTF-8//TRANSLIT", $worker_nm);
							     $worker_wage        = $row['worker_wage'];
							 } 
				         
						 ?>
						             <!-- start  날짜 비교**********************************************   -->
				             <?php
				
							//반복문 시작 
						    $workDay = 0;
							//while($row = sqlsrv_fetch_array($result,SQLSRV_FETCH_ASSOC)){
							while($row = sqlsrv_fetch_array($result,SQLSRV_FETCH_ASSOC)){
								
								
								if($row['worker_total_work_time'] == null){
								$worker_total_work_time[$workDay] = "";
								}else{
							    //시간 포맷
								$worker_total_work_time[$workDay]      = $row['worker_total_work_time']->format('G');	
								}
							    
								
								// ot 타임에 대해서 st************
							    if($row['worker_total_work_ot_time'] == null){
								$worker_total_work_ot_time[$workDay] = "";
								}else{
							    //시간 포맷
								$worker_total_work_ot_time[$workDay]      = $row['worker_total_work_ot_time']->format('G');	
								}
							    // ot 타임에 대해서  end************
                               
                                 
								if($row['worker_attend_day'] == null){
								$worker_attend_day[$workDay]      = "";
								}else{
								//년,월,일 포맷
								$worker_attend_day[$workDay]      = $row['worker_attend_day']        ->format('Ymj');	
								
								}
								
								//echo $worker_total_work_time[$workDay];
							    //echo "(".$worker_attend_day[$workDay].")"; 
						
							$workDay ++ ;
							
							 //echo "*";
						     $worker_wage      = $row['worker_wage'];
							
							 } 
				         
						 ?>
				 
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
	if(count($_GET)== 1 or count($_GET)== 0 ){
	
	$year      = date( "Y" );  
	$month     = date( "m" ); 
	$day       = date( "d" );

	}else{
		
	$year      = $_GET['toYear'];
	$month     = $_GET['toMonth'];
	$day       = $_GET['toDay'];
		
	}

$doms          = array( "일", "월", "화", "수", "목", "금", "토" ); 
/********** 계산값 **********/ 
$mktime            = mktime( 0, 0, 0, $month, 1, $year );      // 입력된 값으로 년-월-01을 만든다. mktime 함수는 연도, 월,일,시,분, 초를 받아서 타임스탬프값을 만들어 리턴하는 역활을 합니다. 타임스탬프는 GMT기준 1970년 1월 1일 0시 0분 0초부터 기준날짜까지 지나온 초를 말합니다.
$days            = date( "t", $mktime );                        // 현재의 year와 month로 현재 달의 일수 구해오기.숫자로 리턴 됨
$startDay        = date( "w", $mktime );                        // 시작요일 알아내기 

// 지난달 일수 구하기 
$prevDayCount    = date( "t", mktime( 0, 0, 0, $month, 0, $year ) ) - $startDay + 1; 

$nowDayCount    = 1;                                            // 이번달 일자 카운팅
//** st
$nowDayCount_2    = 1;                                            // 이번달 일자 카운팅 
//** en
$nextDayCount    = 1;                                            // 다음달 일자 카운팅 

// 이전, 다음 만들기 
$prevYear        = ( $month == 1 )? ( $year - 1 ) : $year; 
$prevMonth        = ( $month == 1 )? 12 : ( $month - 1 ); 
$nextYear        = ( $month == 12 )? ( $year + 1 ) : $year; 
$nextMonth     = ( $month == 12 )? 1 : ( $month + 1 ); 

// 출력행 계산 
$setRows	= ceil( ( $startDay + $days ) / 7 ); 
?> 

<div class="content">   
<br>
<!---------- 달력 출력 ----------> 


<br>

<?php
                 $qMonth         = sprintf('%02d',$month);
                 $qDay           = sprintf('%02d',$day);                 
		
   				  //사용자가 선택한 날짜를 받는다
  				 $qDate              =   sprintf('%d-%02d',$year,$month); 
			     $qDate_2           =   sprintf('%02d%02d',$month,$day);
				 //음력변환용
				 $qDate_3          =   sprintf('%d%02d%02d',$year,$month,$day);
				 
   				     //음력을 이용해 설날을 구하기 위함. 음력  전년 12월 31일은 설날 임. 
					 $fDate                = sprintf('%d',($year - 1)."1230");
					 $lunar_date           = SolaToLunar($qDate_3);
                     $fLunar_date          =(String) date("md", $lunar_date[time]);
					 $fYearLunar_date      = sprintf('%d',($year - 1).$fLunar_date );
				 
				     $zDate                =  date("Y-m-d");
			
				//1.사용자가 클릭한 날짜와 현재 날짜를 비교해서 처음 들어온건지 아닌지 판별 할수 있음 
				if( $qDate == $zDate   ){
  					 $currentDay = date( "Y-m-d" );
					 
				//2.처음 접속할때는 현재 날짜
				}else{
					//
	   				$currentDay = $qDate;
				}	

				  
				  //총 근로시간 구하는 변수
				  $moonAllWorkHour     = 0;
                  //총 ot시간 구하는 변수				  
				  $moonAllOtWorkHour   = 0;
				  //총 주휴시간 구하는 변수
				  $weeAllkHoliHour     = 0;
				  
				  //주당 근무시간 구하는 변수
				   $weekWorkHour = 0;
				  //주당 근무시간 구하는 변수
				   $weekOtWorkHour = 0;
?> 

       <?php
		if($eCheck != "excel"){ 
		?> 
      <!-- 월 출력 -->
             <div class="row">
                        <div class="col-md-5" >
						  <table class="table table-inbox table-hover table-bordered">
						    <tr>
						     <td style="background-color:#EAEAEA;">이름      </td>
						     <td><?= $worker_nm ?>    </td>           
						     <td style="background-color:#EAEAEA;">정산 여부  </td>
						     <td> 
                             <?php   
										if($number == 0){
											echo "미완료";
									    }else{
											echo "완료"; 
		                     }?>      
							 
							 </td>
							 <td><input type="button" value="정산버튼" onclick='mySubmit(1)' />      </td>
                          <td><input type="button" value="EXPORT" onclick='mySubmit(2)' />      </td>							  							 
						    </tr>
						  </table>
						</div>
                        <div class="col-md-2">
			     <table>

   			     <tr  ALIGN=CENTER HEIGHT=30>
				     <td></td>
		
                    <td onclick="location.href='<?=$_SERVER['PHP_SELF']?>?toYear=<?=$prevYear?>&toMonth=<?=$prevMonth?>&phone_id=<?=$phone_id?>'   ">◀</td>
				 <?php
				//양력 공휴일 와 음력 공휴일 설정 
				 if ($qDate_2 =="0101" or $qDate_2 =="0301" or $qDate_2 =="0503" or $qDate_2 =="0505" or $qDate_2 =="0606" or $qDate_2 =="0815"  or $qDate_2 =="1003" or $qDate_2 =="1009" or $qDate_2 =="1225" or  $fYearLunar_date == $fDate or $fLunar_date =="0101" or $fLunar_date =="0102"  or $fLunar_date =="0814" or $fLunar_date == "0815" or $fLunar_date == "0816") {
				 $bColor="#FF0000" ;
				
				 }else{
				 $bColor="#000000";	 
				 }
				 
				 ?>
		
		
				 <td ><FONT SIZE=4 COLOR="<?=$bColor ?>"><?=$qDate?></FONT></td>

		
				     <td onclick="location.href='<?=$_SERVER['PHP_SELF']?>?toYear=<?=$nextYear?>&toMonth=<?=$nextMonth?>&phone_id=<?=$phone_id?>'">      ▶</td>
				 </tr>
				 
		 </table>
						
						
							</div>
                        <div class="col-md-5 text-right">
						
						 <table class="table table-inbox table-hover table-bordered">
						    <tr>
						     <td style="background-color:#EAEAEA;">시급     </td>
						     <td><?=$worker_wage?></td>
                          
						 
                           <form method="get"> 
                                 <!---------- 년, 월 동적으로 출력 ----------> 
  	                        
                          <td style="WIDTH: 70pt; "> 
                              <select name="toYear" onchange="submit();" style="WIDTH: 70pt; "> 
                               <?php for( $i = $startYear; $i < $endYear; $i++ ) { ?> 
                               <option value="<?=$i?>" <?=($i==$year)?"selected":""?>><?=$i?></option> 
                               <?php } ?> 
                               </select>
  	                     	</td>
  	                     	 <td style="WIDTH: 10pt;background-color:#EAEAEA;" >년</td>	  
  	                     	<td style="WIDTH: 70pt; ">
                               <select name="toMonth" onchange="submit();" style="WIDTH: 70pt; "> 
                               <?php for( $i = 1; $i <= 12; $i++ ) { ?> 
                               <option value="<?=$i?>" <?=($i==$month)?"selected":""?>><?=$i?></option> 
                               <?php } ?> 
                               </select> 
                               </td>
                               <td style="WIDTH:10pt;background-color:#EAEAEA;" >월</td>
  	                     	
                              
  	                     	
                              <!---------- 년, 월 동적으로 출력 ---------->
                               <input type="hidden" name="phone_id" value="<?=$phone_id?>">
                           </form> 
 
						  
						     <!--   <td style="background-color:#EAEAEA;">총계     </td>
						     <td>        </td> -->
						    </tr>
						</table>
						
						 </div>
           </div>

       <?php
		    //엑셀 다운로드 범위
		     }
		 ?> 
				 
				 
	<br>			 
	<form  method="post" name="holiWork"  action="admin_controller.php?mode=holiWork">
         <input type="hidden" name="phone_id" value="<?=$phone_id?>">	
      <table  class=" table-bordered" style="width:1200px; height:500px; ">
	  <tr> 
	    
	 <!-- 새로 추가했음  st-->			 
	<td align="center"></td> 
	 <!-- 새로 추가했음  ed-->
        <?php for( $i = 0; $i < count( $doms ); $i++ ) { ?> 

		<td style="background-color:#EAEAEA;" align="center"><?=$doms[$i]?></td> 
		
        <?php } ?>
		<!-- 새로 추가했음  st-->		
		<td align="center" style="background-color:#EAEAEA;">근로<br>시간</td>
	    <td align="center" style="background-color:#EAEAEA;">근로<br>수당</td>
	    <td align="center" style="background-color:#EAEAEA;">초과<br>근무</td>
		<td align="center" style="background-color:#EAEAEA;">초과<br>수당</td> 
		<td align="center" style="background-color:#EAEAEA;">주휴<br>시간</td>
		<td align="center" style="background-color:#EAEAEA;">주휴<br>수당</td>
		<!-- 새로 추가했음  ed-->			
    </tr> 
	<!-- set row 가 5칸인지 6칸인지 판단 해주는듯 -->
     <!--     <?=$setRows ?>	               -->
	 <input type="hidden" name="rowCount"             value="<?=$setRows?>">
	 <input type="hidden"  name="worker_type"         value="<?=$worker_type ?>">        
     <input type="hidden"  name="worker_wage"         value="<?=$worker_wage ?>">
     <input type="hidden"  name="phone_id"            value="<?=$phone_id    ?>">	
	
	<?php for( $rows = 0; $rows < $setRows; $rows++ ) { ?>
	
	<input type="hidden" name="seq_number[]"         value="<?=$rows?>">		
     <tr>
	     <!-- 새로 추가했음  st-->		
         <td>날짜</td>	
         <!-- 새로 추가했음  ed-->			 
        <?php 
        for( $cols = 0; $cols < 7; $cols++ ) 
        { 
            // 셀 인덱스 만들자 
            $cellIndex    = ( 7 * $rows ) + $cols; 
		
            ?> 
				
			  			                  <?php//사용자가 선택했을때 색상변경
							     $colorDate =  $year.$month.$day;
								 
							     $cellDate   =  $year.$month.$sDay;
							
			                   ?>
							  
		          <?php 
            // 이번달이라면 
		
            if ( $startDay <= $cellIndex && $nowDayCount <= $days ) { ?> 
	      
            <td align="center" style="cursor:pointer;" onClick="location.href='calendar_2.php?toYear=<?=$year?>&toMonth=<?=$month?>&toDay=<?=$nowDayCount?>'"   onmouseover="this.style.backgroundColor='orange'"  <?php if($colorDate  != $cellDate){  ?>onmouseout="this.style.backgroundColor='white'" <?php } ?><?php if($colorDate  == $cellDate){  ?> bgcolor="#999999" <?php  } ?>> 
 				<?php if ( date( "w", mktime( 0, 0, 0, $month, $nowDayCount, $year ) ) == 6 ) { ?> 
            
				 
				
				<b><font color="blue"><?=$nowDayCount++?></font>  </b><br> 
               
				<!-- 음력 출력                              -->
				  <!-- <?=date("m.d", $lunar_date[time]);?>          -->
				
                <?php } 
				       //양력 공휴일   	   
				else if ( (date( "w", mktime( 0, 0, 0, $month, $nowDayCount, $year ) ) == 0)  or $sDate_2 =="0101" or $sDate_2 =="0301" or $sDate_2 =="0503" or $sDate_2 =="0505" or $sDate_2 =="0606" or $sDate_2 =="0815"  or $sDate_2 =="1003" or $sDate_2 =="1009" or $sDate_2 =="1225" or  $fYearLunar_date == $fDate or $fLunar_date =="0101" or $fLunar_date =="0102"  or $fLunar_date =="0814" or $fLunar_date == "0815" or $fLunar_date == "0816") {     ?> <!-- 몇주차 인지  date("W") --> 
                            
				<b><font color="red"><?=$nowDayCount++?></font>    </b><br>  
                <!-- 음력 출력                              -->
				  <!-- <?=date("m.d", $lunar_date[time]);?>  -->

                <?php } else { ?> 
                <b><?=$nowDayCount++?></b><br> 
			    <!-- 음력 출력                              -->
				  <!-- <?=date("m.d", $lunar_date[time]);?>  -->
                <?php } 
				
			
			
						//캘린더 에서 찍힌 날짜 
			$payDate = $year.$qMonth.$nowDayCount - 1;
			
			
			
			for($z=0;$z<$workDay;$z++){
				
				//echo "(".$payDate.")";
				//echo "(".$worker_attend_day[$z].")";
				if( $worker_attend_day[$z] == $payDate){
				  // 달력에서 근무 시간을 출력함
           	     // echo  $worker_total_work_time[$z];
				        //주당 근무시간 + 주당 ot 근무시간 (누적하고 있음 )
			            $weekWorkHour     =  $worker_total_work_time[$z]    +   $weekWorkHour;
			            //주당 오티 시간을 구하기 위해서 누적하고 있음
						$weekOtWorkHour   =  $worker_total_work_ot_time[$z] +  $weekOtWorkHour;
						//주당 주휴 시간을 구하기 위해서 누적하고 있음
						//$weeAllkHoliHour  =
						
						//echo "(".$weekOtWorkHour.")";						
			}

		}
						
?>
   
   </td> 
            
            <?php 
            // 이전달이라면 
            } else if ( $cellIndex < $startDay ) { ?>
            		
            <td align="center" style="cursor:pointer;"> 
           
            </td> 
            
            <?php 
            // 다음달 이라면 
            } else if ( $cellIndex >= $days ) { ?> 
            <td align="center" style="cursor:pointer;"> 
           
            </td> 
			
            <?php 
			} 
			
        } 
        ?> 
		
		
		<?php
		
		//주휴 시간 그리고 주휴 수당 을 구한다
		
		  $all_hour     =   $weekWorkHour + $weekOtWorkHour;
		
		  if(  $all_hour >= 16  ){
								   //주휴 시간
								    $weekHoliHour = ($all_hour * 0.2);
								   //주휴 수당	
								    $weekHoliPay  = ($all_hour * 0.2)  * $worker_wage;
								    //주휴 총시간 누적 하기
								    $weeAllkHoliHour = $weeAllkHoliHour + $weekHoliHour; 
								}		
		?>
		<td rowspan="2">
		<!--<?=$weekWorkHour?> -->
		 <?php   
										if($weekWorkHour == 0){
											echo "";
									    }else{
											 echo $weekWorkHour; 
		 }?>
		 
		<input type="hidden" name="work_hour[]"     value="<?=$weekWorkHour ?>">
        <input type="hidden" name="moon_number[]"   value="<?=$search_date."-01" ?>">		
		</td>
	<td rowspan="2">
		
		<!--<?=$weekWorkHour *  $worker_wage ?> -->
		
		<?php   
										if($weekWorkHour == 0 && $weekOtWorkHour == 0){
											echo "";
									    }else{
        											//정상 근무시간 수당                  +  ot 근무시간 수당
											 echo ($weekWorkHour *  $worker_wage) + (($weekOtWorkHour  *  $worker_wage) * 1.5) ;
		    
		 }   ?>
		</td>  
		<td rowspan="2">
		<!--<?=$weekOtWorkHour ?>   -->
		<?php   
										if($weekOtWorkHour == 0){
											echo "";
									    }else{
											 echo $weekOtWorkHour;
                                   											 
		 }  
		 ?>
		<input type="hidden" name="work_ot_hour[]" value="<?=$weekOtWorkHour ?>">  
		</td>  
		
	    <td rowspan="2"> 
		<!--<?=($weekOtWorkHour  *  $worker_wage) * 1.5 ?> -->
		<?php   	
										if($weekOtWorkHour == 0){
											echo "";
									    }else{
											 echo ($weekOtWorkHour  *  $worker_wage) * 1.5 ; 
					 						 
		 }
		 ?>
		</td>
		<td rowspan="2">
     		<!--<?=$weekHoliHour ?>-->
		<?php   
										if($weekHoliHour == 0){
											echo "";
									    }else{
											 echo $weekHoliHour ; 
		 }?>
		<input type="hidden" name="holi_hour[]" value="<?=$weekHoliHour ?>">  
		</td>
		<td rowspan="2">
		<!--<?=$weekHoliPay ?>-->
		<?php   
										if($weekHoliPay == 0){
											echo "";
									    }else{
											 echo $weekHoliPay ; 
		 }?>
		<input type="hidden" name="holi_pay[]" value="<?=$weekHoliPay ?>">  		
		</td>
		<?php 
		// 주 근무시간은 누적이 아니기때문에 다시 0으로 초기화 
		$weekWorkHour = 0;
		$weekOtWorkHour = 0;
		$weekHoliPay = 0;
		$weekHoliHour = 0;
		 ?>
    </tr>
	
	
     <!-- start **********************************************   -->
     <tr>
	     <!-- 새로 추가했음  st-->		
         <td style="background-color:#EAEAEA;">시간</td>	
		 
         <!-- 새로 추가했음  ed-->			 
        <?php 
//최종 월 근무시간 ***

        for( $cols = 0; $cols < 7; $cols++ ) 
        { 
            // 셀 인덱스 만들자 
            $cellIndex    = ( 7 * $rows ) + $cols; 
		
            ?> 
				
			               <?php
				               //현재 월 일 이 언제 인지  확인. 그리고 모두 2자리수로 포맷팅을 해준다.
				              //$sMonth       = sprintf('%02d',$month);
                               $sDay           = sprintf('%02d',$nowDayCount_2);
                               $sDate          = $year.$qMonth.$sDay;
							   $sDate_2       = $qMonth.$sDay;
                  
							   //음력을 이용해 설날을 구하기 위함. 음력  전년 12월 31일은 설날 임. 
							   $fDate                = sprintf('%d',($year - 1)."1230");
							   $lunar_date         = SolaToLunar($sDate);
                               $fLunar_date        =(String) date("md", $lunar_date[time]);
						       $fYearLunar_date  = sprintf('%d',($year - 1).$fLunar_date );
							   
							   //사용자가 선택했을때 색상변경
							    $colorDate  =  $year.$month.$day;
								$cellDate   =  $year.$month.$sDay;
	    				     ?>
						
			                  
							  
		          <?php 
            // 이번달이라면 
		
            if ( $startDay <= $cellIndex && $nowDayCount_2 <= $days ) { ?> 
	      
            <td align="center" style="cursor:pointer;" onClick="location.href='calendar_2.php?toYear=<?=$year?>&toMonth=<?=$month?>&toDay=<?=$nowDayCount?>'"   onmouseover="this.style.backgroundColor='orange'"  <?php if($colorDate  != $cellDate){  ?>onmouseout="this.style.backgroundColor='white'" <?php } ?><?php if($colorDate  == $cellDate){  ?> bgcolor="#999999" <?php } ?>> 
 				
				<?php if ( date( "w", mktime( 0, 0, 0, $month, $nowDayCount_2, $year ) ) == 6 ) { ?> 
                			
                        <?php    $nowDayCount_2++     ?>
			   		   
				<!-- 음력 출력                              -->
							
                <?php } 
				       //양력 공휴일   	   
				else if ( (date( "w", mktime( 0, 0, 0, $month, $nowDayCount_2, $year ) ) == 0)  or $sDate_2 =="0101" or $sDate_2 =="0301" or $sDate_2 =="0503" or $sDate_2 =="0505" or $sDate_2 =="0606" or $sDate_2 =="0815"  or $sDate_2 =="1003" or $sDate_2 =="1009" or $sDate_2 =="1225" or  $fYearLunar_date == $fDate or $fLunar_date =="0101" or $fLunar_date =="0102"  or $fLunar_date =="0814" or $fLunar_date == "0815" or $fLunar_date == "0816") {     ?> <!-- 몇주차 인지  date("W") --> 
                                           
				                   <?php    $nowDayCount_2++     ?>
				
				<!-- 음력 출력                              -->
			
                <?php } else { ?> 
           			    
				 <?php    $nowDayCount_2++     ?>
				<!-- 음력 출력                              -->
			
                <?php } ?> 
				
			<?php	
			//캘린더 에서 찍힌 날짜 
			$payDate = $year.$qMonth.$nowDayCount_2 - 1;
			
			$allTime = 0;
			
			for($z=0;$z<$workDay;$z++){
				
				//echo "(".$payDate.")";
				//echo "(".$worker_attend_day[$z].")";
				if( $worker_attend_day[$z] == $payDate){
				  // 달력에서 근무 시간을 출력함 st*****
           	     // echo  "".$worker_total_work_time[$z]."" ;
				 // echo  "(".$worker_total_work_ot_time[$z].")";
				 $allTime = $worker_total_work_time[$z] + $worker_total_work_ot_time[$z];
				 echo  $allTime ;
				  // 달력에서 근무 시간을 출력함 *****
				        //총 근로 시간을 구하기 위해서 누적 하고 있음 ( 정상 근무시간 + 오티 근무시간 )
			            $moonAllWorkHour     =  $worker_total_work_time[$z]   + $moonAllWorkHour;
			            //총 오티 시간을 구하기 위해서 누적하고 있음
						$moonAllOtWorkHour   =  $worker_total_work_ot_time[$z] +  $moonAllOtWorkHour;
			}
		}
     ?>
   <!-- 히든값 설정 -->
   <input type="hidden" name="w_<?=$cols + 1 ?>[]" value="<?=$allTime ?>">
   
   </td> 
            <?php 
            // 이전달이라면 
            } else if ( $cellIndex < $startDay ) { ?>
            		
            <td align="center" style="cursor:pointer;"> 
            <input type="hidden" name="w_<?=$cols + 1?>[]" value="<?=$allTime ?>">
		
            </td> 
            
            <?php 
            // 다음달 이라면 
            } else if ( $cellIndex >= $days ) { ?> 
            <td align="center" style="cursor:pointer;"> 
            <input type="hidden" name="w_<?=$cols + 1?>[]" value="<?=$allTime ?>">
			
            </td> 
			
            <?php 
			
			} 
	       
		   } 
        ?> 

    </tr>

	<!-- 새로 추가했음  ed-->		
    <?php } ?> 
<!-- 새로 추가했음  st-->		
    <tr>
	 <td  style="background-color:#EAEAEA;" colspan="8">계</td>
	 <td><?= $moonAllWorkHour ?></td>
	 <td><?= $moonAllWorkHour *  $worker_wage?></td>
     <td><?= $moonAllOtWorkHour  ?></td>
	 <td><?= ($moonAllOtWorkHour *  $worker_wage) * 1.5  ?></td>	
	 <td><?= $weeAllkHoliHour ?></td>
	 <td><?= $weeAllkHoliHour *  $worker_wage ?></td>
	 
	 <input type="hidden" name="work_hour[]"    value="<?=$moonAllWorkHour ?>">
	 <input type="hidden" name="work_ot_hour[]" value="<?=$moonAllOtWorkHour ?>">
	 <input type="hidden" name="holi_hour[]"    value="<?=$weeAllkHoliHour ?>">
	 <input type="hidden" name="holi_pay[]"     value="<?=$weeAllkHoliHour *  $worker_wage ?>">

	 <input type="hidden" name="moon_number[]"   value="<?=$search_date."-01" ?>">
	<?= $search_date."-01" ?>
    
	<input type="hidden" name="toYear"     value="<?=$year  ?>">
	<input type="hidden" name="toMonth"    value="<?=$month ?>">
	</tr>  
<!-- 새로 추가했음  ed-->		
	</form>	
</table >   
				       </tbody>
                    </table>
					<br>
					<br>

					
		         </div>

      </div>
  </div>
</aside>
</div>
</div>


</div>
</body>
</html>
	  
	  
	                     
							
	  
