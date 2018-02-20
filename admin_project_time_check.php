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
	$search_date;
	if(count($_GET)== 1 or count($_GET)== 0 ){
	
	$year      = date( "Y" );  
	$month     = date( "m" ); 
  //$day       = date( "d" );
    $search_date = $year."-".$month;
	}else{
		
	$year      = $_GET['toYear'];
	$month     = $_GET['toMonth'];
	$month     = sprintf('%02d',$month);
	$search_date = $year."-".$month;
	//$day       =  $_GET['toDay'];
		
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


include_once ('./lib/lunarLib.php');
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
		<link type="text/css" rel="stylesheet" href="/css/admin_project_time_check.css" />
		<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
		<script type="text/javascript">	
		
		function mySubmit(index) {
                if (index == 1) {
                    document.time_sheet.action = 'admin_controller.php?mode=time_sheet';
					 document.time_sheet.submit();
                }
                if(index == 2){
					
			    location.href='admin_project_time_check.php?toYear=<?=$year?>&toMonth=<?=$month?>&phone_id=<?=$phone_id?>&eCheck=<?=excel?>'

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
							
							
							//$adress = iconv("UTF-8", "EUC-KR", $address);
							
							$phone_id       = $_GET['phone_id'];
							
							$date = date('Y-m-d');
							$con = sqlsrv_connect($serverName, $connectionInfo);
							       
                             $sql = "SELECT 
								      a.project_name,
								      a.project_code,
								      a.project_job_code,
							          a.regi_date,
									  a.project_state,
								      b.admin_nm
								      from project_registration_info as a 
									  left outer join admin_info as b on a.admin_id = b.admin_id
									  where project_flag = 1
										";	  
                                     
							$sql_count = "select count(*) from project_registration_info";
							
							
							
							$sql_2 = "select 
                                              project_job_code,
                                              phone_id,
                                              sum(project_time) as project_time,
                                              regi_date
                                      from project_time_info
									  where phone_id = '".$phone_id."' and 
									  convert(varchar(7), regi_date, 120) = '".$search_date."'
									  group by project_job_code,
									           regi_date,
											   phone_id
									  
                                      									  
									 ";
							echo $sql_2;
							
							$sql_3 = "select *  
									   from worker_info 
									   where  phone_id = '".$phone_id."'";
							
						$sql_count_2 = " select count(*) 
						                 from time_sheet
						                 where convert(varchar(7), moon_number, 120) = '".$search_date."'
						                 and moon_flag = 1
											";
							
							
							// 확인용
							//echo $sql;
							$result         = sqlsrv_query($con, $sql);
							$result_count   = sqlsrv_query($con, $sql_count);
							$result_2       = sqlsrv_query($con, $sql_2);
							$result_3       = sqlsrv_query($con, $sql_3);
							$result_count_2 = sqlsrv_query($con, $sql_count_2);
							
							//db 접속 실패 경우
							if ($con == false) {
								echo "Unable to connect.</br>";
								die(print_r(sqlsrv_errors(), true));
							}
							//카운트 숫자 출력 
							$result_count_2 = sqlsrv_fetch_array($result_count_2,SQLSRV_FETCH_NUMERIC);
							$number = (int) implode('',$result_count_2);
						
							
				            //사용자 정보 받기
							while($row = sqlsrv_fetch_array($result_3,SQLSRV_FETCH_ASSOC)){
								 $worker_nm        = $row['worker_nm'];
								 $worker_type      = $row['worker_type'];
								 $worker_nm        = iconv("CP949", "UTF-8//TRANSLIT", $worker_nm);
							     $worker_wage      = $row['worker_wage'];
							 } 
				         
						 ?>						

<?php
		 
        		 //사용자가 선택한 날짜를 받는다
  				 $qDate              =   sprintf('%d-%02d',$year,$month); 
			     $qDate_2            =   sprintf('%02d%02d',$month,$day);
				 //음력변환용
				 $qDate_3            =   sprintf('%d%02d%02d',$year,$month,$day);
				 
   				     //음력을 이용해 설날을 구하기 위함. 음력  전년 12월 31일은 설날 임. 
					 $fDate                = sprintf('%d',($year - 1)."1230");
					 $lunar_date         = SolaToLunar($qDate_3);
                     $fLunar_date        =(String) date("md", $lunar_date[time]);
					 $fYearLunar_date  = sprintf('%d',($year - 1).$fLunar_date );
				 
				 $zDate              =  date("Y-m-d");

				  
				  //총 근로시간 구하는 변수
				  $moonAllWorkHour   = 0;
                  //총 ot시간 구하는 변수				  
				  $moonAllOtWorkHour = 0;
				  
				  //주당 근무시간 구하는 변수
				   $weekWorkHour = 0;
				  //주당 근무시간 구하는 변수
				   $weekOtWorkHour = 0;
?> 

<?php
		if($eCheck != "excel"){ 
		?> 

<div class="content">   
<!---------- 달력 출력 ----------> 

   <br>
            <!-- 월 출력 -->
             <div class="row">
                <div class="col-md-5" >
						<table class="table table-inbox table-hover table-bordered">
						    <tr>
						     <td style="background-color:#EAEAEA;">이름  </td>
						     <td><?=$worker_nm?>                        </td>           
						    <td style="background-color:#EAEAEA;" >정산 여부    </td>
                             <td>
                             <?php   
										if($number == 0){
											echo "미완료";
									    }else{
											echo "완료"; 
		                     }?>      
							 </td>
							 <td><input type="button" value="정산버튼" onclick='mySubmit(1)' />      </td>
                          <td><input type="button" value="EXPORT" onclick='mySubmit(2)' />        </td>							 							 
						    </tr>
						</table>
			     </div>
                        <div class="col-md-2">
				 
				 <table>

                
			 <tr  ALIGN=CENTER HEIGHT=30>
                    <td onclick="location.href='<?=$_SERVER['PHP_SELF']?>?toYear=<?=$prevYear?>&toMonth=<?=$prevMonth?>&phone_id=<?=$phone_id?>'">◀</td>
				 <?php
				//양력 공휴일 와 음력 공휴일 설정 
				 if ($qDate_2 =="0101" or $qDate_2 =="0301" or $qDate_2 =="0503" or $qDate_2 =="0505" or $qDate_2 =="0606" or $qDate_2 =="0815"  or $qDate_2 =="1003" or $qDate_2 =="1009" or $qDate_2 =="1225" or  $fYearLunar_date == $fDate or $fLunar_date =="0101" or $fLunar_date =="0102"  or $fLunar_date =="0814" or $fLunar_date == "0815" or $fLunar_date == "0816") {
				 $bColor="#FF0000" ;
				 }else{
				 $bColor="#000000";	 
				 }
				 ?>
				 <td ><FONT SIZE=4 COLOR="<?=$bColor ?>"><?=$qDate?></FONT></td>
                 <td onclick="location.href='<?=$_SERVER['PHP_SELF']?>?toYear=<?=$nextYear?>&toMonth=<?=$nextMonth?>&phone_id=<?=$phone_id?>'">▶</td>
			 </tr>
		 </table>
				</div>
                        <div class="col-md-5 text-right">
 					 <table class="table table-inbox table-hover table-bordered">
						    <tr>
						     <td style="background-color:#EAEAEA;">시급    </td>
						     <td><?=$worker_wage?>                         </td>           
						     
		
                          <form method="get"> 
                                <!---------- 년, 월 동적으로 출력 ----------> 
	                        
                                  <td style="WIDTH:70pt; "> 
                              <select name="toYear" onchange="submit();" style="WIDTH: 70pt; "> 
                              <?php for( $i = $startYear; $i < $endYear; $i++ ) { ?> 
                              <option value="<?=$i?>" <?=($i==$year)?"selected":""?>><?=$i?></option> 
                              <?php } ?> 
                              </select>
	                      	</td>
	                      	<td style="WIDTH:10pt;" >년</td>	   
	                      	<td style="WIDTH: 70pt; ">
                              <select name="toMonth" onchange="submit();" style="WIDTH: 70pt; "> 
                              <?php for( $i = 1; $i <= 12; $i++ ) { ?> 
                              <option value="<?=$i?>" <?=($i==$month)?"selected":""?>><?=$i?></option> 
                              <?php } ?> 
                              </select> 
                              </td>
	                      	<td style="WIDTH: 10pt;" >
	                      	  월
	                      	</td>
	                      	
                              <!---------- 년, 월 동적으로 출력 ----------> 
                             <input type="hidden" name="phone_id" value="<?=$phone_id?>">		
                          </form> 
 
							 </tr>
						</table>
					</div>
             </div>
	<br>

	<?php
		    //엑셀 다운로드 범위
		     }
		 ?> 
	
<form  method="post" name="time_sheet"  action="admin_controller.php?mode=time_sheet">	
   <table  class="table-hover table-bordered" style="width:1300px; height:300px;">
              
			
	    <td style="width:400px;background-color:#EAEAEA;">CODE</td>
	    <td style="width:500px;background-color:#EAEAEA;">PROJECT NAME</td>
		
		       <?php 
        for( $cols = 0; $cols < 50; $cols++ ) 
        { 
            // 셀 인덱스 만들자 
            $cellIndex    = ( 7 * $rows ) + $cols; 
		
            ?> 
				                                 
			               <?php
						   
				               //현재 월 일 이 언제 인지  확인. 그리고 모두 2자리수로 포맷팅을 해준다.
				               $sMonth       = sprintf('%02d',$month);
                               $sDay          = sprintf('%02d',$nowDayCount);
                              // $sDate          = $year.$sMonth.$sDay;
							   $sDate_2       = $sMonth.$sDay;
                  
							   //음력을 이용해 설날을 구하기 위함. 음력  전년 12월 31일은 설날 임. 
							   //$fDate                = sprintf('%d',($year - 1)."1230");
							   //$lunar_date         = SolaToLunar($sDate);
                               //$fLunar_date        =(String) date("md", $lunar_date[time]);
						      // $fYearLunar_date  = sprintf('%d',($year - 1).$fLunar_date );
							  
							  //사용자가 선택했을때 색상변경
							  $colorDate =  $year.$month.$day;
							  $cellDate   =  $year.$month.$sDay;
	    				     
							 ?>
						
		          <?php 
            // 이번달이라면 
		
            if ( $startDay <= $cellIndex && $nowDayCount <= $days ) { ?> 
	      
            <td align="center" style="cursor:pointer; width:200px;background-color:#EAEAEA;" onClick="location.href='calendar_2.php?toYear=<?=$year?>&toMonth=<?=$month?>&toDay=<?=$nowDayCount?>'"   onmouseover="this.style.backgroundColor='orange'"  <?php if($colorDate  != $cellDate){  ?>onmouseout="this.style.backgroundColor='white'" <?php } ?><?php if($colorDate  == $cellDate){  ?> bgcolor="#999999" <?php } ?>> 
 				
				<?php if ( date( "w", mktime( 0, 0, 0, $month, $nowDayCount, $year ) ) == 6 ) { ?> 
                
				<b><font color="blue"><?=$nowDayCount++?></font>  </b><br> 
               
                <?php } 
				       //양력 공휴일   	   
				else if ( (date( "w", mktime( 0, 0, 0, $month, $nowDayCount, $year ) ) == 0)  or $sDate_2 =="0101" or $sDate_2 =="0301" or $sDate_2 =="0503" or $sDate_2 =="0505" or $sDate_2 =="0606" or $sDate_2 =="0815"  or $sDate_2 =="1003" or $sDate_2 =="1009" or $sDate_2 =="1225" or  $fYearLunar_date == $fDate or $fLunar_date =="0101" or $fLunar_date =="0102"  or $fLunar_date =="0814" or $fLunar_date == "0815" or $fLunar_date == "0816") {     ?> <!-- 몇주차 인지  date("W") --> 
                            
				<b><font color="red"><?=$nowDayCount++?></font>    </b><br>  
               

                <?php } else { ?> 
                <b><?=$nowDayCount++?></b><br> 
			   
                <?php } 
				?> 
            </td> 
            
            <?php 
            // 이전달이라면 
                } 
			}
			?>
            		
          
       		<?php
		
		//주휴 시간 그리고 주휴 수당 계산
		
		  $all_hour     =   $weekWorkHour + $weekOtWorkHour;
		
		  if(  $all_hour >= 16  ){
								   
								    $weekHoliHour = ($all_hour * 0.2);
								    $weekHoliPay  = ($all_hour * 0.2)  * $worker_wage;
								
								}		
		
		
		//   0으로 초기화 해야 다시 반복
							$nowDayCount =1;
		
		?>
		              <!-- 컨텐츠-->
		                   
						   <?php
								
							$project_list[$number][35];  	
							//반복문 시작
                             $project_seq = 0;							
							 while($row = sqlsrv_fetch_array($result,SQLSRV_FETCH_ASSOC)){
							 
							 $project_name      = $row['project_name'];
							 $project_code      = $row['project_code'];
							 $project_job_code  = $row['project_job_code'];
							 $admin_nm          = $row['admin_nm'];
							 $regi_date         = $row['regi_date']  ->format('Y-m-d');
							 $project_state     = $row['project_state'];
							
							 $project_name         = iconv("CP949", "UTF-8//TRANSLIT", $project_name);
							 $project_code         = iconv("CP949", "UTF-8//TRANSLIT", $project_code);
							 $project_job_code     = iconv("CP949", "UTF-8//TRANSLIT", $project_job_code);
							 $admin_nm             = iconv("CP949", "UTF-8//TRANSLIT", $admin_nm);
							 
							 //배열에..
							 $project_list[$project_seq][0]     = $project_job_code;
							 $project_list[$project_seq][1]     = $project_code;
							 $project_list[$project_seq][2]     = $project_name;
							 
							 
				     		 $project_seq++;
							?>
							
							<?php
							 
							 }//while 문 닫기
							
							?>
							
							<?php
							//반복문 시작
                             //$project_seq = 0;
                              $u = 0;							 
							 while($row = sqlsrv_fetch_array($result_2,SQLSRV_FETCH_ASSOC)){
							
							 $project_job_code_2[$u]         = $row['project_job_code'];
							 $phone_id_2[$u]                 = $row['phone_id'];
							 $project_time_2[$u]             = $row['project_time'];
							 $regi_date_2[$u]                = $row['regi_date']  ->format('j');
							 $project_time_flag_2[$u]        = $row['project_time_flag'];
							 $project_name                   = iconv("CP949", "UTF-8//TRANSLIT", $project_name);
							 $project_job_code_2[$u]         = iconv("CP949", "UTF-8//TRANSLIT", $project_job_code_2[$u]);
							
							 $u++; 
							
							?>
							
							<?php
							 
							 }//while 문 닫기
							
							?>
							
							<?php
							 //echo $u;
							 //여기서부터는 반복문
							$total = 0 ;
							for($m=1; $m<35; $m++){
								 
							   //타임 테이블에서
							   for($t=0; $t<$u; $t++){
                           			
								  //프로젝트 가져온 개수만큼
								   for($n=0;  $n<$project_seq; $n++){ //for st
								    
									 
									// 2차원 배열에 담긴 프로젝트 잡코드와 타임테이블에서 가져온 잡코드 와 비교 하고 타임 코드에서 가져온 일수를 비교 한다
									if($project_list[$n][0] == $project_job_code_2[$t] and $regi_date_2[$t] == $m ){
										
								       //타임 시간을 넣기
                                	     $project_list[$n][$m + 2 ] =  $project_time_2[$t];
									     
										
										 
									   //토탈 시간 채우기
										 $total                     =  $project_list[$n][$m + 2 ] + $total;
								         
										
											}
											
		                              } //for ed
									
									  
							   } //타임 테이블에서 end
							   
							     //echo "(".$total.")";
								       $project_list[$project_seq][$m + 2 ] = $total;
									  
								       $total = 0;
												
							   
							 }
							 
						?>
							
							
						<!--	test 
							<br>
							<table border="1">
							<?php
						for($n=0; $n<3; $n++){
							
							
							?>
							<tr>
							<?php
							for($m=1; $m<35; $m++){
							
							
							?>
							
							<td>
							<?= $m - 2 ?>
							</td>
							
							<td bgcolor="#FF0000">
							   <?= $project_list[$n][$m] ?>
							</td>
						    
							
							
							<?php
							
							   }
							   ?>
							
                         		</tr>					
							   
							   <?php
                             }
							?>
                              </table>
							-->
							
							<!-- 구분 시작 -->
							<input type="hidden"  name="rowCount"             value="<?=$project_seq ?>" /> 
                            <input type="hidden"  name="worker_type"          value="<?=$worker_type ?>">        
                            <input type="hidden"  name="worker_wage"          value="<?=$worker_wage ?>">
							<input type="hidden"  name="worker_nm"            value="<?=$worker_nm ?>">
                            <input type="hidden"  name="phone_id"             value="<?=$phone_id?>">									
							
							<?php
							   $y = 0;
     							for($y;$y<$project_seq;$y++ ) 
	     							{
							?>
							
							<!-- 프로젝트 리스트 출력하기 -->
	 	                        <tr> 
   								<td> <?= $project_list[$y][1]?>  </td>
								<td> <?= $project_list[$y][2]?> </td>
                                <input type="hidden" name="project_job_code[]"   value="<?=$project_list[$y][0] ?>">								
        	   		            <input type="hidden" name="project_code[]"       value="<?=$project_list[$y][1] ?>">
								<input type="hidden" name="project_name[]"       value="<?=$project_list[$y][2] ?>">
                                <input type="hidden" name="seq_number[]"         value="<?=$y ?>">
                                <input type="hidden" name="moon_number[]"               value="<?=$search_date."-01" ?>">					
		<?php                      
        for( $cols = 0; $cols < 45; $cols++ ) 
        { 
            // 셀 인덱스 만들자 
            $cellIndex    = ( 7 * $rows ) + $cols; 
			                  //사용자가 선택했을때 색상변경
			                    $colorDate =  $year.$month.$day;
							    $cellDate   =  $year.$month.$sDay;
			          ?> 
				
         <?php 
            // 이번달이라면 
            if ( $startDay <= $cellIndex && $nowDayCount <= $days ) { ?> 
	          <td align="center" style="cursor:pointer;" onClick="location.href='calendar_2.php?toYear=<?=$year?>&toMonth=<?=$month?>&toDay=<?=$nowDayCount?>'"   onmouseover="this.style.backgroundColor='orange'"  <?php if($colorDate  != $cellDate){  ?>onmouseout="this.style.backgroundColor='white'" <?php  } ?><?php if($colorDate  == $cellDate){  ?> bgcolor="#999999" <?php  } ?>> 
 				
				<!-- 테스트 해보고 이상 없으면 -->
			<!--<?= $project_list[$y][$cols  - 2] ?> -->
			
			
				 <?php   
										if($project_list[$y][$nowDayCount +2]/60 == 0){
											echo "";
									    }else{
											echo $project_list[$y][$nowDayCount +2]/60; 
		           }?>
		
		
		<input type="hidden" name="work_hour[]" value="<?=$project_list[$y][$nowDayCount +2]/60 ?>">  
	<input type="hidden" name="d<?=$nowDayCount?>[]" value="<?=$project_list[$y][$nowDayCount +2] ?>">
	<!--<?=$nowDayCount++?> -->
			
				
				<?php //if ( date( "w", mktime( 0, 0, 0, $month, $nowDayCount, $year ) ) == 6 ) { ?> 
   			    <?php //} 
				       //양력 공휴일   	   
				//else if ( (date( "w", mktime( 0, 0, 0, $month, $nowDayCount, $year ) ) == 0)  or $sDate_2 =="0101" or $sDate_2 =="0301" or $sDate_2 =="0503" or $sDate_2 =="0505" or $sDate_2 =="0606" or $sDate_2 =="0815"  or $sDate_2 =="1003" or $sDate_2 =="1009" or $sDate_2 =="1225" or  $fYearLunar_date == $fDate or $fLunar_date =="0101" or $fLunar_date =="0102"  or $fLunar_date =="0814" or $fLunar_date == "0815" or $fLunar_date == "0816") {     ?> <!-- 몇주차 인지  date("W") --> 
                <?php// } else { ?> 
                <?php 
				    // } 
				?> 
            </td> 
            
            <?php 
            // 이전달이라면 
                } 
			}
			?>
            		
       </tr>
			    <?php
					 //   0으로 초기화 해야 다시 반복
					$nowDayCount =1;
					 }
					 ?>
							
							<tr>
							     <td>
							     </td>
							     <td>
								 TOTAL
								 <input type="hidden" name="moon_number[]"               value="<?=$search_date."-01" ?>">
							     <input type="hidden" name="seq_number[]"                value="<?=$y  ?>">
								 
								 
								 </td>
							
							
	<?php 
        for( $cols = 0; $cols < 45; $cols++ ) 
        { 
            // 셀 인덱스 만들자 
            $cellIndex    = ( 7 * $rows ) + $cols; 
			
			//사용자가 선택했을때 색상변경
			$colorDate =  $year.$month.$day;
			$cellDate   =  $year.$month.$sDay;
			
           ?> 
				
			     						
            <?php 
            // 이번달이라면 
		
            if ( $startDay <= $cellIndex && $nowDayCount <= $days ) { ?> 
	      
            <td align="center" style="cursor:pointer;" onClick="location.href='calendar_2.php?toYear=<?=$year?>&toMonth=<?=$month?>&toDay=<?=$nowDayCount?>'"   onmouseover="this.style.backgroundColor='orange'"  <?php if($colorDate  != $cellDate){  ?>onmouseout="this.style.backgroundColor='white'" <?php } ?><?php if($colorDate  == $cellDate){  ?> bgcolor="#999999" <?php  } ?>> 
 				
				
				 <?php   
										if($project_list[$y][$nowDayCount +2]/60 == 0){
											echo "";
									    }else{
											 echo $project_list[$y][$nowDayCount +2] /60; 
		                                 }
						 					 ?>
											 
			    <input type="hidden" name="d<?=$nowDayCount?>[]" value="<?=$project_list[$y][$nowDayCount +2] ?>">
			    <!-- <?=$nowDayCount++?>  -->
				
				<?php //if ( date( "w", mktime( 0, 0, 0, $month, $nowDayCount, $year ) ) == 6 ) { ?> 
           				
						
                <?php //} 
				       //양력 공휴일   	   
				//else if ( (date( "w", mktime( 0, 0, 0, $month, $nowDayCount, $year ) ) == 0)  or $sDate_2 =="0101" or $sDate_2 =="0301" or $sDate_2 =="0503" or $sDate_2 =="0505" or $sDate_2 =="0606" or $sDate_2 =="0815"  or $sDate_2 =="1003" or $sDate_2 =="1009" or $sDate_2 =="1225" or  $fYearLunar_date == $fDate or $fLunar_date =="0101" or $fLunar_date =="0102"  or $fLunar_date =="0814" or $fLunar_date == "0815" or $fLunar_date == "0816") {     ?> <!-- 몇주차 인지  date("W") --> 
                            
		
               <?php// } else { ?> 
          
               <?php //} 
				
			   ?> 
            </td> 
            
            <?php 
            // 이전달이라면 
                } 
		}
			?>
							
														
</tr>
	<!--끝 -->
</table >
           <input type="hidden" name="toYear"  value="<?=$year  ?>">
		    <input type="hidden" name="toMonth" value="<?=$month ?>">
                 </form>	
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
	  
	  
	                     
							
	  
