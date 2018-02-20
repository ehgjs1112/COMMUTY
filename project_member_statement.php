<!DOCTYPE html>

<?php
       include_once ('./session_check.php');

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
		<link type="text/css" rel="stylesheet" href="/css/project_member_statement.css"/> 
        
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
                         include_once ('./manu/left_menu/admin_left_admin_approve_menu.php'); 	    												 
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
                            <div class="col-md-4"></div>
                            <div class="col-md-4">PROJECT별 개인 내역서</div>
                            <div class="col-md-4"></div>
                        </div>	
                    </div>

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
			
		
						<?php
							include_once ('./config.php');
							$uname = $_SESSION['uname'];
							
							//$adress = iconv("UTF-8", "EUC-KR", $address);
							
							$phone_id       = $_GET['phone_id'];
							
							$date = date('Y-m-d');
							$con = sqlsrv_connect($serverName, $connectionInfo);
							       
                             $cdCount = " select count(distinct project_job_code)
                                                from time_sheet
						                        where convert(varchar(10), moon_number, 120) = '".$search_date."-01'
						                        and moon_flag = 1
											";
				            
							// 확인용
							//echo $sql;
							$cdCount  = sqlsrv_query($con, $cdCount);
							
							//db 접속 실패 경우
							if ($con == false) {
								echo "Unable to connect.</br>";
								die(print_r(sqlsrv_errors(), true));
							}
							//카운트 숫자 출력 
							$cdCount = sqlsrv_fetch_array($cdCount,SQLSRV_FETCH_NUMERIC);
							$pNumber = (int) implode('',$cdCount);
						    
							
							$nmCount = " select count(distinct worker_nm)
                                                from time_sheet
						                        where convert(varchar(10), moon_number, 120) = '".$search_date."-01'
						                        and moon_flag = 1
											";
				            
							// 확인용
							//echo $sql;
							$nmCount  = sqlsrv_query($con, $nmCount);
							
							//db 접속 실패 경우
							if ($con == false) {
								echo "Unable to connect.</br>";
								die(print_r(sqlsrv_errors(), true));
							}
							//카운트 숫자 출력 
							$nmCount = sqlsrv_fetch_array($nmCount,SQLSRV_FETCH_NUMERIC);
							$nmNumber = (int) implode('',$nmCount);
							
							 ?>						

						 <table class="table table-inbox table-hover table-bordered">
           
		   <tr>
             <td></td>
           </tr>
           <tr>
             <td></td>
           </tr>
           <tr>
             <td></td>
           </tr>
           
		   <?php
		 
			   for($n=0; $n<$pNumber + 1; $n++){
			 ?>
		   
		        <tr>
                  <td><?php  if ($n == 0  ) { ?>CODE    <?php }?></td>
		           <td><?php  if ($n == 0  ) { ?>PROJECT <?php }?></td>
		           	  
					   <?php
		       	       for($m=0; $m<$nmNumber ; $m++){
		       	       ?>
		           	  <td></td>
		             <?php 
		       	        }
		       	       ?>
					   <td><?php  if ($n == 0  ) { ?>Y60합계(7000)<?php }?></td>
					   <td></td>
					   <td></td>
					   <td></td>
					   <td></td>
					   <td><?php  if ($n == 0  ) { ?>합계<?php }?></td>
		        </tr>
			<?php 
			}
			?>
			<tr>
			     <td>합  계</td>
			</tr>
			<tr>
			     <td>CR</td>
			</tr>
           <tr>
			     <td>OT/td>
			</tr>
           <tr>
			     <td>주휴</td>
			</tr>
           <tr>
			     <td>RMS</td>
			</tr>
           <tr>
			     <td>야근 수당</td>
			</tr>
           <tr>
			     <td>수당(야근수당 제외</td>
			</tr>
           <tr>
			     <td>주휴 수당</td>
			</tr>			
			<tr>
			     <td>전체 수당</td>
			</tr>			
			</table>



			
			 </div> <!-- content end 태그임 -->

        </div>

    </div>
</aside>
</div>
</div>

</body>
</html>