<!DOCTYPE html>

<?php
       include_once ('./session_check.php');	    
?>

<?
//이 밑 라인 꼭 필요함 
error_reporting(E_ERROR | E_WARNING | E_PARSE);



//음력 계산 로직 start
function sunlunar_data() {
return
"1212122322121-1212121221220-1121121222120-2112132122122-2112112121220-2121211212120-2212321121212-2122121121210-2122121212120-1232122121212-1212121221220-1121123221222-1121121212220-1212112121220-2121231212121-2221211212120-1221212121210-2123221212121-2121212212120-1211212232212-1211212122210-2121121212220-1212132112212-2212112112210-2212211212120-1221412121212-1212122121210-2112212122120-1231212122212-1211212122210-2121123122122-2121121122120-2212112112120-2212231212112-2122121212120-1212122121210-2132122122121-2112121222120-1211212322122-1211211221220-2121121121220-2122132112122-1221212121120-2121221212110-2122321221212-1121212212210-2112121221220-1231211221222-1211211212220-1221123121221-2221121121210-2221212112120-1221241212112-1212212212120-1121212212210-2114121212221-2112112122210-2211211412212-2211211212120-2212121121210-2212214112121-2122122121120-1212122122120-1121412122122-1121121222120-2112112122120-2231211212122-2121211212120-2212121321212-2122121121210-2122121212120-1212142121212-1211221221220-1121121221220-2114112121222-1212112121220-2121211232122-1221211212120-1221212121210-2121223212121-2121212212120-1211212212210-2121321212221-2121121212220-1212112112210-2223211211221-2212211212120-1221212321212-1212122121210-2112212122120-1211232122212-1211212122210-2121121122210-2212312112212-2212112112120-2212121232112-2122121212110-2212122121210-2112124122121-2112121221220-1211211221220-2121321122122-2121121121220-2122112112322-1221212112120-1221221212110-2122123221212-1121212212210-2112121221220-1211231212222-1211211212220-1221121121220-1223212112121-2221212112120-1221221232112-1212212122120-1121212212210-2112132212221-2112112122210-2211211212210-2221321121212-2212121121210-2212212112120-1232212122112-1212122122120-1121212322122-1121121222120-2112112122120-2211231212122-2121211212120-2122121121210-2124212112121-2122121212120-1212121223212-1211212221220-1121121221220-2112132121222-1212112121220-2121211212120-2122321121212-1221212121210-2121221212120-1232121221212-1211212212210-2121123212221-2121121212220-1212112112220-1221231211221-2212211211220-1212212121210-2123212212121-2112122122120-1211212322212-1211212122210-2121121122120-2212114112122-2212112112120-2212121211210-2212232121211-2122122121210-2112122122120-1231212122212-1211211221220-2121121321222-2121121121220-2122112112120-2122141211212-1221221212110-2121221221210-2114121221221";
}

function SolaToLunar($yyyymmdd) {
$getYEAR = substr($yyyymmdd,0,4);
$getMONTH = substr($yyyymmdd,4,2);
$getDAY = substr($yyyymmdd,6,2);

$arrayDATASTR = sunlunar_data();
$arrayDATA = explode("-",$arrayDATASTR);
$arrayLDAYSTR="31-0-31-30-31-30-31-31-30-31-30-31";
$arrayLDAY = explode("-",$arrayLDAYSTR);
$dt = $arrayDATA;



for ($i=0;$i<=168;$i++) {
  $dt[$i] = 0;
  for ($j=0;$j<12;$j++) {
    switch (substr($arrayDATA[$i],$j,1)) {

    case 1:
      $dt[$i] += 29;
      break;

    case 3:
      $dt[$i] += 29;
      break;

    case 2:
      $dt[$i] += 30;
      break;

    case 4:
      $dt[$i] += 30;
      break;
    }
  }

  switch (substr($arrayDATA[$i],12,1)) {

  case 0:
    break;

  case 1:
    $dt[$i] += 29;
    break;

  case 3:
    $dt[$i] += 29;
    break;

  case 2:
    $dt[$i] += 30;
    break;

  case 4:
    $dt[$i] += 30;
    break;
  }
}

$td1 = 1880 * 365 + (int)(1880/4) - (int)(1880/100) + (int)(1880/400) + 30;
$k11 = $getYEAR - 1;
$td2 = $k11 * 365 + (int)($k11/4) - (int)($k11/100) + (int)($k11/400);

if ($getYEAR % 400 == 0 || $getYEAR % 100 != 0 && $getYEAR % 4 == 0) {
  $arrayLDAY[1] = 29;

} else {
  $arrayLDAY[1] = 28;
}

if ($getMONTH > 13) {
  $gf_sol2lun = 0;
}

if ($getDAY > $arrayLDAY[$getMONTH-1]) {
  $gf_sol2lun = 0;
}

for ($i=0;$i<=$getMONTH-2;$i++) {
  $td2 += $arrayLDAY[$i];
}

$td2 += $getDAY;
$td = $td2 - $td1 + 1;
$td0 = $dt[0];

for ($i=0;$i<=168;$i++) {
  if ($td <= $td0) {
    break;
  }
  $td0 += $dt[$i+1];
}

$ryear = $i + 1881;
$td0 -= $dt[$i];
$td -= $td0;

if (substr($arrayDATA[$i], 12, 1) == 0) {
  $jcount = 11;

} else {
  $jcount = 12;
}

$m2 = 0;

for ($j=0;$j<=$jcount;$j++) { // 달수 check, 윤달 > 2 (by harcoon)
  if (substr($arrayDATA[$i],$j,1) <= 2) {
    $m2++;
    $m1 = substr($arrayDATA[$i],$j,1) + 28;
    $gf_yun = 0;
  } else {
    $m1 = substr($arrayDATA[$i],$j,1) + 26;
    $gf_yun = 1;
  }
  if ($td <= $m1) {
    break;
  }
  $td = $td - $m1;
}




$k1=($ryear+6) % 10;
$syuk = $arrayYUK[$k1];
$k2=($ryear+8) % 12;
$sgap = $arrayGAP[$k2];
$sddi = $arrayDDI[$k2];
$gf_sol2lun = 1;

if($m2<10) $m2="0".$m2;
if($sday<10) $td="0".$td;

$Ary[year]=$ryear;
$Ary[month]=$m2;
$Ary[day]=$td;
$Ary[time]=mktime(0,0,0,$Ary[month],$Ary[day],$Ary[year]);

return $Ary;

}

//사용 예 $f_date
//$lunar_date = SolaToLunar(20170822);
//echo date("Y-m-d", $lunar_date[time]);

//음력 계산 로직 end
?>
<style type="text/css">
        body { text-align:center; width:100%; height:100%;}
        
         #header {
            width:1300px; height:90px; background-color:; border:groove 0px silver;  font: bold italic 1.0em/1.0em 돋움체;
            }
			
		  #header_left{
            width:150px; height:100px; background-color:; border:groove 0px silver;  font: bold italic 2.0em/1.0em 돋움체; float:left;
            }	
			
			
		 #header_right{
            width:300px; height:100px; background-color:; border:groove 0px silver; font-weight: bold;  font-style: italic; font-size: 2.0em; line-height: 1.0em; float:left  
            }	

            
		 #header_2 {
            width:1300px; height:900px; background-color:; border:groove 0px silver; 
            }	
		
         #header_2_calendar{
            width:400px; height:100px; background-color:; border:groove 0px silver;  font: bold italic 2.0em/1.0em 돋움체; float:left;
            }	

		
         #header_3 {
            width:1200px; height:200px; background-color:; border:groove 1px silver;
            padding:5px 5px 5px 5px; margin:0px 0px 10px 0px;}			

         #header_4 {
            width:1200px; height:500px; background-color: border:groove 1px silver;
            padding:5px 5px 5px 5px; margin:0px 0px 10px 0px;}			


		#header_4_left_chart_class_average {
            width:720px; height:500px; background-color:; border:groove 1px silver;
            padding:5px 5px 5px 5px; margin:0px 0px 10px 0px; float:left;}

        #header_4_right_chart_class_average {
            width:450px; height:500px; background-color:; border:groove 1px silver;
            padding:5px 5px 5px 5px; margin:0px 0px 10px 0px; float:left;}						
		
		 #header_4_right_chart_class_average_top {
            width:440px; height:200px; background-color:; border:groove 1px silver;
            padding:5px 5px 5px 5px; margin:0px 0px 10px 0px; float:left;}						
		
		#header_4_right_chart_class_average_bottom {
            width:440px; height:270px; background-color:; border:groove 1px silver;
            padding:5px 5px 5px 5px; margin:0px 0px 10px 0px; float:left;}
		
		 #header_5 {
            width:1200px; height:500px; background-color:; border:groove 1px silver;
            padding:5px 5px 5px 5px; margin:0px 0px 10px 0px;}	
		
		
		#header_5_left_chart_class_average {
            width:720px; height:500px; background-color:; border:groove 1px silver;
            padding:5px 5px 5px 5px; margin:0px 0px 10px 0px; float:left;}
		
		
		 #header_5_right_chart_class_average {
            width:450px; height:500px; background-color:; border:groove 1px silver;
            padding:5px 5px 5px 5px; margin:0px 0px 10px 0px; float:left;}						
		
		.calendar_menu{
		background-color:#D5D5D5; width:150px;	
		}
	<!--	
		.time_menu{
		  width:50px;	
		}
		
		.cal_table{
			border:1px;
		}
		.cal_td{
			width:50px;
			font:6px;
			align:right;
		}
		-->
		
		b{
			font-weight: bold;
			font-size: 5.5em; 
		}
		
		<!-- 드래그 테스트 -->
		   table td {
         width: 200px;
         height:100px;
         text-align:center;
         vertical-align:middle;
         background-color:pink;
                     }

    table td.highlighted {
      background-color:pink;
	  
    }
			</style>
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





<html lang="en">
    <head>
        <meta charset="utf-8">
        <!-- This file has been downloaded from Bootsnipp.com. Enjoy! -->
        <title>Responsive Mail Inbox and Compose - Bootsnipp.com</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">
        <!-- css파일 임포트 -->
		<link type="text/css" rel="stylesheet" href="/css/project_code_regestration.css"/> 
        <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    </head>
    <body>
	 
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
                    ?>
				   
					 <?php
                         include_once ('/manu/left_menu/admin_left_admin_approve_menu.php'); 	    						
                     ?>
                    


                </aside>
                <aside class="lg-side">
                    <div class="inbox-head">
                        
						
						<?php
							
							    include_once ('/manu/admin_top_manu.php');
							
					    ?>
						
			             
						   <div id="header_2"> 
 
                <table  WIDTH="95%">
			     <tr ALIGN=CENTER>
				 <td>                     </td>
				 <td>                     </td>
				 <td WIDTH="12%"></td>
				 <td WIDTH="12%" ></td>
				 <td WIDTH="12%"></td>
				 <td WIDTH="18%" bgcolor="#999999" ><FONT SIZE=4><?=$year?>년</FONT></td>
				 <td WIDTH="12%"></td>
				 <td WIDTH="12%"></td>
				 <td WIDTH="12%"></td>
				 <td ></td>
				 </tr>
<?
                 $qMonth       = sprintf('%02d',$month);
                 $qDay           = sprintf('%02d',$day);                 
		
   				  //사용자가 선택한 날짜를 받는다
  				 $qDate              =   sprintf('%d-%02d-%02d',$year,$month,$day); 
			     $qDate_2           =   sprintf('%02d%02d',$month,$day);
				 //음력변환용
				 $qDate_3          =   sprintf('%d%02d%02d',$year,$month,$day);
				 
   				     //음력을 이용해 설날을 구하기 위함. 음력  전년 12월 31일은 설날 임. 
					 $fDate                = sprintf('%d',($year - 1)."1230");
					 $lunar_date         = SolaToLunar($qDate_3);
                     $fLunar_date        =(String) date("md", $lunar_date[time]);
					 $fYearLunar_date  = sprintf('%d',($year - 1).$fLunar_date );
				 
				 $zDate              =  date("Y-m-d");
			
				//1.사용자가 클릭한 날짜와 현재 날짜를 비교해서 처음 들어온건지 아닌지 판별 할수 있음 
				if( $qDate == $zDate   ){
  					 $currentDay = date( "Y-m-d" );
					 
				//2.처음 접속할때는 현재 날짜
				}else{
					//
	   				$currentDay = $qDate;
				}	
				 
				 $before3Day = date("Y-m-d", strtotime($currentDay." -3 day"));
				 $before2Day = date("Y-m-d", strtotime($currentDay." -2 day"));
				 $before1Day = date("Y-m-d", strtotime($currentDay." -1 day"));
				 
				 $bYear    = date( "Y", strtotime($currentDay." -1 day"));
				 $bMonth = date("m", strtotime($currentDay." -1 day"));
				 $bDay     = date("d", strtotime($currentDay." -1 day"));
				
				 $beforeDay1 = date("Y-m-d", strtotime($currentDay." +1 day"));
				 $beforeDay2 = date("Y-m-d", strtotime($currentDay." +2 day"));
				 $beforeDay3 = date("Y-m-d", strtotime($currentDay." +3 day"));
				 
				  $abYear     = date("Y", strtotime($currentDay."  +1 day"));
				  $aMonth   = date("m", strtotime($currentDay." +1 day"));
				  $aDay       = date("d", strtotime($currentDay."  +1 day"));
?>
			     <tr bgcolor="#999999" ALIGN=CENTER HEIGHT=30>
				     <td></td>
				    <td onClick="location.href='calendar_2.php?toYear=<?=$bYear?>&toMonth=<?=$bMonth?>&toDay=<?=$bDay?>'   ">◀</td>
				    <td>
				 <?

				 $beforeDay = date("Y-m-d", strtotime($currentDay." -3 day"));
                  ECHO  $beforeDay;
				 ?>
				 </td>
				 <td>
				 <?
				 
				 $beforeDay = date("Y-m-d", strtotime($currentDay." -2 day"));
                  ECHO  $beforeDay;
				 ?>
				</td>
				 <td>      
				 <?
				 
				 $beforeDay = date("Y-m-d", strtotime($currentDay." -1 day"));
                  ECHO  $beforeDay;
				 ?>
				 </td>
				 <?
				//양력 공휴일 와 음력 공휴일 설정 
				 if ($qDate_2 =="0101" or $qDate_2 =="0301" or $qDate_2 =="0503" or $qDate_2 =="0505" or $qDate_2 =="0606" or $qDate_2 =="0815"  or $qDate_2 =="1003" or $qDate_2 =="1009" or $qDate_2 =="1225" or  $fYearLunar_date == $fDate or $fLunar_date =="0101" or $fLunar_date =="0102"  or $fLunar_date =="0814" or $fLunar_date == "0815" or $fLunar_date == "0816") {
				 $bColor="#FF0000" ;
				
				 }else{
				 $bColor="#000000";	 
				 }
				 
				 ?>
				 <td ><FONT SIZE=4 COLOR="<?=$bColor ?>"><?=$qDate?></FONT></td>
				 <td>
				 <?
				
				 $beforeDay = date("Y-m-d", strtotime($currentDay." 1 day"));
                  ECHO  $beforeDay;
				 ?>
				 </td>
				 <td>
				 <?
				 
				 $beforeDay = date("Y-m-d", strtotime($currentDay." 2 day"));
                  ECHO  $beforeDay;
				 ?>
				 </td>
				 <td>
				 <?
				 
				 $beforeDay = date("Y-m-d", strtotime($currentDay." 3 day"));
                  ECHO  $beforeDay;
				 ?>
				 </td>
				 <td onClick="location.href='calendar_2.php?toYear=<?= $abYear?>&toMonth=<?=$aMonth?>&toDay=<?= $aDay?>'   ">▶</td>
				 </tr>
				 <tr>
				 <td></td>
				 <td></td>
				 <td></td>
				 <td></td>
				 <td></td>
                 <td bgcolor="#999999" ALIGN=CENTER> <FONT SIZE=1> <?=$year?>년 <?=$month?>월<?=$day?>일 (음) </FONT></td>
				 <td></td>
				 <td></td>
				 <td></td>
				 <td></td>
				 </tr>
				 </table>

				 
				 
				 
				 
<div id="header_2_calendar">				   


	<table border="1"> 
      <tr> 
	     <!--  -->
	 <!-- 새로 추가했음  st-->			 
	<td align="center"></td> 
	 <!-- 새로 추가했음  ed-->
        <? for( $i = 0; $i < count( $doms ); $i++ ) { ?> 

		<td align="center"><?=$doms[$i]?></td> 
		
        <? } ?>
		 <!-- 새로 추가했음  st-->		
		<td align="center">근로시간</td>
		<td align="center">근로수당</td>
		<td align="center">초과근무</td>
		<td align="center">초과수당</td>
		<td align="center">주휴시간</td>
		<td align="center">주휴수당</td>
		
         <!-- 새로 추가했음  ed-->			
    </tr> 

             <? for( $rows = 0; $rows < $setRows ; $rows++ ) { ?> 
     <tr>
	     <!-- 새로 추가했음  st-->		
         <td>날짜</td>	
         <!-- 새로 추가했음  ed-->			 
        <? 
        for( $cols = 0; $cols < 7; $cols++ ) 
        { 
            // 셀 인덱스 만들자 
            $cellIndex    = ( 7 * $rows ) + $cols; 
            ?> 
				
			               <?
				               //현재 월 일 이 언제 인지  확인. 그리고 모두 2자리수로 포맷팅을 해준다.
				               $sMonth       = sprintf('%02d',$month);
                               $sDay           = sprintf('%02d',$nowDayCount);
                               $sDate          = $year.$sMonth.$sDay;
							   $sDate_2       = $sMonth.$sDay;
                  
							   //음력을 이용해 설날을 구하기 위함. 음력  전년 12월 31일은 설날 임. 
							   $fDate                = sprintf('%d',($year - 1)."1230");
							   $lunar_date         = SolaToLunar($sDate);
                               $fLunar_date        =(String) date("md", $lunar_date[time]);
						       $fYearLunar_date  = sprintf('%d',($year - 1).$fLunar_date );
	    				     ?>
						
			                  <?//사용자가 선택했을때 색상변경
							     $colorDate =  $year.$month.$day;
								 
							     $cellDate   =  $year.$month.$sDay;
							
			                   ?>
							  
		          <? 
            // 이번달이라면 
		
            if ( $startDay <= $cellIndex && $nowDayCount <= $days ) { ?> 
	        
            <td align="center" style="cursor:pointer;" onClick="location.href='calendar_2.php?toYear=<?=$year?>&toMonth=<?=$month?>&toDay=<?=$nowDayCount?>'"   onmouseover="this.style.backgroundColor='orange'"  <?if($colorDate  != $cellDate){  ?>onmouseout="this.style.backgroundColor='white'" <? } ?><?if($colorDate  == $cellDate){  ?> bgcolor="#999999" <? } ?>> 
 				<? if ( date( "w", mktime( 0, 0, 0, $month, $nowDayCount, $year ) ) == 6 ) { ?> 
                <b><font color="blue"><?=$nowDayCount++?></font>  </b><br> 
                <!-- 음력 출력                              -->
				  <!-- <?=date("m.d", $lunar_date[time]);?>          -->
				
                <? } 
				       //양력 공휴일   	   
				else if ( (date( "w", mktime( 0, 0, 0, $month, $nowDayCount, $year ) ) == 0)  or $sDate_2 =="0101" or $sDate_2 =="0301" or $sDate_2 =="0503" or $sDate_2 =="0505" or $sDate_2 =="0606" or $sDate_2 =="0815"  or $sDate_2 =="1003" or $sDate_2 =="1009" or $sDate_2 =="1225" or  $fYearLunar_date == $fDate or $fLunar_date =="0101" or $fLunar_date =="0102"  or $fLunar_date =="0814" or $fLunar_date == "0815" or $fLunar_date == "0816") {     ?> <!-- 몇주차 인지  date("W") --> 
                            
				<b><font color="red"><?=$nowDayCount++?></font>    </b><br>  
                <!-- 음력 출력                              -->
				  <!-- <?=date("m.d", $lunar_date[time]);?>  -->

                <? } else { ?> 
                <b><?=$nowDayCount++?></b><br> 
			    <!-- 음력 출력                              -->
				  <!-- <?=date("m.d", $lunar_date[time]);?>  -->
                <? } ?> 
            </td> 
            
            <? 
            // 이전달이라면 
            } else if ( $cellIndex < $startDay ) { ?>
            		
            <td align="center" style="cursor:pointer;"> 
            <font color="gray"><b><?=$prevDayCount++?></b></font> 
            </td> 
            
            <? 
            // 다음달 이라면 
            } else if ( $cellIndex >= $days ) { ?> 
            <td align="center" style="cursor:pointer;"> 
            <font color="gray"><b><?=$nextDayCount++?></b></font> 
            </td> 
			
            <? } 
        } 
        ?> 
		<td rowspan="2">11</td>
		<td rowspan="2">11</td>
		<td rowspan="2">11</td>
		<td rowspan="2">11</td>
		<td rowspan="2">11</td>
		<td rowspan="2">11</td>
    </tr>
     <!-- 새로 추가했음  st-->		
	 <tr>
	 <td>근무시간</td>
	 <td>ss</td>
	 <td>ss</td>
	 <td>ss</td>
	 <td>ss</td>
	 <td>ss</td>
	 <td>ss</td>
	 <td>ss</td>
    </tr>  
 <!-- 새로 추가했음  ed-->		
    <? } ?> 
<!-- 새로 추가했음  st-->		
		 <tr>
	 <td colspan="7">계</td>
	 <td></td>
	 <td></td>
	 <td></td>
	 <td></td>
	 <td></td>
	 <td></td>
    </tr>  
<!-- 새로 추가했음  ed-->		
	
</table >   
				   
				 
				 
				 
 
          </div>
						 
						 
						 
						 
						 
						 
						 
						 
						 
						 
						 
						 
						 
						 
						 
						 
						 
						 
						 
						 
						 
						 
						 
						 
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