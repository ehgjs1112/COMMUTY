<!DOCTYPE html>

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
        
		<!-- css파일 임포트 -->
		<link type="text/css" rel="stylesheet" href="/css/common.css"/> 
		<link type="text/css" rel="stylesheet" href="/css/project_code_regestration.css"/> 
        
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
				     </div>

                    <div class="inbox-body">
                       <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">프로젝트 코드 등록</div>
                            <div class="col-md-4"></div>
                        </div>	
                    </div>
                   <BR>

	                	<?php
							include_once ('./config.php');
							$uname = $_SESSION['uname'];
							
							
							//$adress = iconv("UTF-8", "EUC-KR", $address);
							
							$date = date('Y-m-d');
							$con = sqlsrv_connect($serverName, $connectionInfo);
							 // 등록된 모든 프로젝트 가져옴       
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
                                        
                             
							 //근무자 출력 
							$sql_2 = "SELECT 
								        a.worker_pone_number,
										a.phone_id,
										a.worker_nm,
										a.worker_type,
							            a.join_date,
										a.worker_wage,
										a.worker_address,
										a.worker_state,
										b.admin_nm
										from 
										worker_info as a left outer join
										admin_info as b 
										on a.ad_approval = b.admin_id
										where  a.worker_flag = 1						
										";	     
							 
							 
							 //시간 데이터 가져오기 (정상근무, ot 근무 총합) 								
                             $sql_3 = "select              
                                       distinct a.worker_nm,
									            a.phone_id,
								                b.project_job_code,
								                b.project_time
								          from worker_info as a 
									      left outer join 
                                          (
										        select phone_id,
                                                project_job_code,
												sum(project_time) as project_time
										        from 
										        project_time_info 
											    group by project_job_code,phone_id
                                          )b							  
 									      on a.phone_id = b.phone_id			
										
									 ";
							
                             //시간 데이터 가져오기 (ot 근무 총합) 		0: 정상 근무 1: OT 근무						
                             $sql_4 = "select              
                                       distinct a.worker_nm,
									            a.phone_id,
								                b.project_job_code,
								                b.project_time
								          from worker_info as a 
									      left outer join 
                                          (
										        select phone_id,
                                                project_job_code,
												sum(project_time) as project_time
										        from 
										        project_time_info
                                                where division = 1 												
											    group by project_job_code,phone_id
                                          )b							  
 									      on a.phone_id = b.phone_id			
										
									 ";	   							
							 
							//$sql = "select count(case when worker_pone_number in ('".$uname."')"."then 1 end) from Attendance_info";
							// 확인용
							//echo $sql;
							
							$result   = sqlsrv_query($con, $sql);
							$result_2 = sqlsrv_query($con, $sql_2);
							$result_3 = sqlsrv_query($con, $sql_3);
							$result_4 = sqlsrv_query($con, $sql_4);
							
							//db 접속 실패 경우
							if ($con == false) {
								echo "Unable to connect.</br>";
								die(print_r(sqlsrv_errors(), true));
							}
							//$row = sqlsrv_fetch_array($result,SQLSRV_FETCH_NUMERIC);
							//echo $row[0];
							?>
			
							<?php
							//1.프로젝트 등록 테이블에서 모든 프로젝트를 가져옴
							$i = 0;
							 while($row = sqlsrv_fetch_array($result,SQLSRV_FETCH_ASSOC)){
							 
							 $project_name[$i]              = $row['project_name'];
							 $project_code[$i]              = $row['project_code'];
							 $project_job_code[$i]          = $row['project_job_code'];
							 
							 $project_name[$i]         = iconv("CP949", "UTF-8//TRANSLIT", $project_name[$i]);
							 
							 $i++;
							  }
						//	  echo $i; 
							?>
						
                            
	
                         <?php
							//2.근무자 테이블에서 모든 근무자 가져옴
							$m=0;
							 while($row = sqlsrv_fetch_array($result_2,SQLSRV_FETCH_ASSOC))
							 {
							 
							// $worker_nm                = $row['worker_nm'];
							 $phone_id_worker[$m]        = $row['phone_id'];
							 $worker_type[$m]            = $row['worker_type'];
							 $worker_wage[$m]            = $row['worker_wage'];
							 $worker_nm[$m]              = $row['worker_nm'];
							 $worker_nm[$m]              = iconv("CP949", "UTF-8//TRANSLIT", $worker_nm[$m]);
							 $m++;
							  }
					    ?>
							
				         <?php
						     $q=0;
							//3.시간테이블에서 에서 모든 기록 가져옴  (정상근무시간 + OT 근무시간)
							 while($row = sqlsrv_fetch_array($result_3,SQLSRV_FETCH_ASSOC)){
							 
						     
							     $phone_id_3[$q]                         = $row['phone_id'];
							     $project_job_code_3[$q]                 = $row['project_job_code'];
							     $project_time[$q]                       = $row['project_time'];
							 
							 //$worker_nm[$q]                = iconv("CP949", "UTF-8//TRANSLIT", $worker_nm);
							 //$phone_id[$q]                = iconv("CP949", "UTF-8//TRANSLIT", $phone_id);
							 //$project_job_code[$q]         = iconv("CP949", "UTF-8//TRANSLIT", $project_job_code);
							 //$project_time[$q]             = iconv("CP949", "UTF-8//TRANSLIT", $project_time);
							// echo $phone_id[$q];
							 $q++;
							   
							  }
							  
						//	  echo $q; 
						 ?>
						 
						 
						 <?php
						     $b=0;
							//4.시간테이블에서 에서 모든 기록 가져옴  (OT 근무시간)
							 while($row = sqlsrv_fetch_array($result_4,SQLSRV_FETCH_ASSOC)){
							 
						   		 $phone_id_ot[$b]                          = $row['phone_id'];
							     $project_job_code_ot[$b]                  = $row['project_job_code'];
							     $project_time_ot[$b]                      = $row['project_time'];
							 
							 //$worker_nm[$q]                = iconv("CP949", "UTF-8//TRANSLIT", $worker_nm);
							 //$phone_id[$q]                = iconv("CP949", "UTF-8//TRANSLIT", $phone_id);
							 //$project_job_code[$q]         = iconv("CP949", "UTF-8//TRANSLIT", $project_job_code);
							 //$project_time[$q]             = iconv("CP949", "UTF-8//TRANSLIT", $project_time);
							// echo $phone_id[$q];
							 $b++;
							        }
							  
						//	  echo $q; 
						 ?>
						 
     				     <?php
				    
				         //2차원 배열 선언하기 start ***
				         $project_statement[100][100] = array(0);
				         
						 $project_statement[0][0]     ="";
                         $project_statement[0][1]     ="";
						 $project_statement[0][2]     ="";
						 
						 $project_statement[1][0]     ="";
						 $project_statement[1][1]     ="";
                         $project_statement[1][2]     ="";
						 
						 $project_statement[2][0]     ="";
						 $project_statement[2][1]     ="";
                         $project_statement[2][2]     ="";
						 
						 $project_statement[3][0]     ="job code";
				         $project_statement[3][1]     ="code";
				         $project_statement[3][2]     ="project";
				         
						 
						 $project_statement[0] [$m + 3 + 0]     ="";
						 $project_statement[0] [$m + 3 + 1]     ="";
						 $project_statement[0] [$m + 3 + 2]     ="";
						 $project_statement[0] [$m + 3 + 3]     ="";
						 $project_statement[0] [$m + 3 + 4]     ="";
						 $project_statement[0] [$m + 3 + 5]     ="";
						 
						 $project_statement[1] [$m + 3 + 0]     ="";
						 $project_statement[1] [$m + 3 + 1]     ="";
						 $project_statement[1] [$m + 3 + 2]     ="";
						 $project_statement[1] [$m + 3 + 3]     ="";
						 $project_statement[1] [$m + 3 + 4]     ="";
						 $project_statement[1] [$m + 3 + 5]     ="";
						 
						 $project_statement[2] [$m + 3 + 0]     ="Y60";
						 $project_statement[2] [$m + 3 + 1]     ="Y59";
						 $project_statement[2] [$m + 3 + 2]     ="N60";
						 $project_statement[2] [$m + 3 + 3]     ="Y59";
						 $project_statement[2] [$m + 3 + 4]     ="Y60";
						 $project_statement[2] [$m + 3 + 5]     ="";
						 
						 $project_statement[3] [$m + 3 + 0]     ="Y60합계";
						 $project_statement[3] [$m + 3 + 1]     ="Y59합계";
						 $project_statement[3] [$m + 3 + 2]     ="N60합계";
						 $project_statement[3] [$m + 3 + 3]     ="Y59합계";
						 $project_statement[3] [$m + 3 + 4]     ="Y60합계";
						 $project_statement[3] [$m + 3 + 5]     ="합계";
						 
						 
						 //*****
						 $project_statement_ot[0][0]     ="";
                         $project_statement_ot[0][1]     ="";
						 $project_statement_ot[0][2]     ="";
						 
						 $project_statement_ot[1][0]     ="";
						 $project_statement_ot[1][1]     ="";
                         $project_statement_ot[1][2]     ="";
						 
						 $project_statement_ot[2][0]     ="";
						 $project_statement_ot[2][1]     ="";
                         $project_statement_ot[2][2]     ="";
						 
						 $project_statement_ot[3][0]     ="job code";
				         $project_statement_ot[3][1]     ="code";
				         $project_statement_ot[3][2]     ="project";
				         
						 
						 $project_statement_ot[0] [$m + 3 + 0]     ="";
						 $project_statement_ot[0] [$m + 3 + 1]     ="";
						 $project_statement_ot[0] [$m + 3 + 2]     ="";
						 $project_statement_ot[0] [$m + 3 + 3]     ="";
						 $project_statement_ot[0] [$m + 3 + 4]     ="";
						 $project_statement_ot[0] [$m + 3 + 5]     ="";
						 
						 $project_statement_ot[1] [$m + 3 + 0]     ="";
						 $project_statement_ot[1] [$m + 3 + 1]     ="";
						 $project_statement_ot[1] [$m + 3 + 2]     ="";
						 $project_statement_ot[1] [$m + 3 + 3]     ="";
						 $project_statement_ot[1] [$m + 3 + 4]     ="";
						 $project_statement_ot[1] [$m + 3 + 5]     ="";
						 
						 $project_statement_ot[2] [$m + 3 + 0]     ="Y60";
						 $project_statement_ot[2] [$m + 3 + 1]     ="Y59";
						 $project_statement_ot[2] [$m + 3 + 2]     ="N60";
						 $project_statement_ot[2] [$m + 3 + 3]     ="Y59";
						 $project_statement_ot[2] [$m + 3 + 4]     ="Y60";
						 $project_statement_ot[2] [$m + 3 + 5]     ="";
						 
						 $project_statement_ot[3] [$m + 3 + 0]     ="Y60합계";
						 $project_statement_ot[3] [$m + 3 + 1]     ="Y59합계";
						 $project_statement_ot[3] [$m + 3 + 2]     ="N60합계";
						 $project_statement_ot[3] [$m + 3 + 3]     ="Y59합계";
						 $project_statement_ot[3] [$m + 3 + 4]     ="Y60합계";
						 $project_statement_ot[3] [$m + 3 + 5]     ="합계";
						 //*****
						 
						 //2차원 배열 선언하기 end ***
						 
						 
						 // 1. 2차원 배열 설계를 토대로 프로젝트 정보 부터 채워 넣기  
						   for($w=4; $w<$i + 4; $w++){
							   
							   
						    $project_statement[$w][0] = $project_job_code[$w - 4];
							$project_statement[$w][1] = $project_code[$w - 4];
							$project_statement[$w][2] = $project_name[$w - 4];
							
							$project_statement[$w + 1][0] = "합계";
							$project_statement[$w + 1][1] = "";
							$project_statement[$w + 1][2] = "";
						    
							$project_statement[$w + 2][0] = "CR";
							$project_statement[$w + 2][1] = "";
							$project_statement[$w + 2][2] = "";
						 
						    $project_statement[$w + 3][0] = "OT";
							$project_statement[$w + 3][1] = "";
							$project_statement[$w + 3][2] = "";
						 
						    $project_statement_ot[$w][0] = $project_job_code[$w - 4];
							$project_statement_ot[$w][1] = $project_code[$w - 4];
							$project_statement_ot[$w][2] = $project_name[$w - 4];
							
							$project_statement_ot[$w + 1][0] = "합계";
							$project_statement_ot[$w + 1][1] = "";
							$project_statement_ot[$w + 1][2] = "";
						   
						    $project_statement_ot[$w + 2][0] = "CR";
							$project_statement_ot[$w + 2][1] = "";
							$project_statement_ot[$w + 2][2] = "";
						   
						    $project_statement[$w + 3][0] = "OT";
							$project_statement[$w + 3][1] = "";
							$project_statement[$w + 3][2] = "";
						                           }
						   
						   // 2. 2차원 배열 설계를 토대로 직원 정보 채워 넣기  
						   for($w=3; $w<$m + 3; $w++){
							
							     $project_statement[0][$w]       = $worker_wage[$w - 3]; 
							     $project_statement[1][$w] = $phone_id_worker[$w - 3]; 
								 $project_statement[2][$w] = $worker_type[$w - 3];
								 $project_statement[3][$w] = $worker_nm[$w - 3];
						//		 echo "(".$project_statement[0][$w].")";
						//		 echo "(".$project_statement[1][$w].")";
						   
						   
						         $project_statement_ot[0][$w]       = $worker_wage[$w - 3]; 
							     $project_statement_ot[1][$w] = $phone_id_worker[$w - 3]; 
								 $project_statement_ot[2][$w] = $worker_type[$w - 3];
								 $project_statement_ot[3][$w] = $worker_nm[$w - 3];
						                            }
                    
                    // 3. 2차원 배열 설계를 토대로 타임 데이터 찾아서 넣기  (오티)  *****
					$total_ot = 0 ;
                    //가져온 직원 수 					
					for($p=3; $p<$m + 3; $p++){
						 //가져온 프로젝트 개수 
						 for($w=4; $w<$i + 4; $w++){
						         //타임 데이터 개수
								 $project_statement_ot[$w][$p] = 0;
                                 for($e=0; $e<$b;  $e++){
                                   
								     // x, y 좌표 기준으로 적합한 칸 이면 (정상 근무,ot 근무 통합시간 ) 
                               		 if( $project_statement[$w][0] == $project_job_code_ot[$e] and  $project_statement[1][$p] == $phone_id_ot[$e]  ){								 
                                     
											 //$project_statement[$w][$p]     =   $project_time[$e];
											 //합계 칸 에 값 주기 위해서
											// $total_ot = $project_statement[$w][$p] + $total;
											 
											 //ot 시간도 제대로 되는지 확인
											 $project_statement_ot[$w][$p] =   $project_time_ot[$e];
											
											 $total_ot = $project_statement_ot[$w][$p] + $total_ot;
											 //echo "(".$project_statement[$w][$p].")"."(".$w.",".$p.")" ;
									                  
									 								                                         }								 
							                               }
										            }
													
											    //합계칸에 합계 데이터 넣기 
											    $project_statement_ot[$w][$p] =  $total_ot;
                                                //다시 초기화 하기
                                                $total_ot = 0;												
												}	




					
					//합계를 위한 변수
							$total = 0;						
                    // 3. 2차원 배열 설계를 토대로 타임 데이터 찾아서 넣기 
                    //가져온 직원 수 					
					for($p=3; $p<$m + 3; $p++){
						 //가져온 프로젝트 개수 
						 for($w=4; $w<$i + 4; $w++){
						         //타임 데이터 개수
								 $project_statement[$w][$p] = 0;
                                 for($e=0; $e<$q;  $e++){
                                   
								     // x, y 좌표 기준으로 적합한 칸 이면 (정상 근무,ot 근무 통합시간 ) 
                               		 if( $project_statement[$w][0] == $project_job_code_3[$e] and  $project_statement[1][$p] == $phone_id_3[$e]  ){								 
                                     
											 $project_statement[$w][$p]     =   $project_time[$e];
											 //합계 칸 에 값 주기 위해서
											 $total = $project_statement[$w][$p] + $total;
											 
											 //ot 시간도 제대로 되는지 확인
											// if( $project_statement[$w][0] == $project_job_code_ot[$e] and  $project_statement[1][$p] == $phone_id_ot[$e]  ){								 
											// $project_statement_ot[$w][$p];
											// }
											 //echo "(".$project_statement[$w][$p].")"."(".$w.",".$p.")" ;
									                  
									 								                                                                             }								 
							                               }
										            }
													
											    //합계칸에 합계 데이터 넣기 
											    $project_statement[$w ][$p] =  $total;
                                                //다시 초기화 하기
                                                $total = 0;		
												//CR(정상 근무시간 칸 채워넣기)
												$project_statement[$w + 1][$p] = $project_statement[$w][$p] - $project_statement_ot[$w][$p];
												//OT 합계를 채워넣기
												$project_statement[$w + 2][$p] = $project_statement_ot[$w][$p];
												
												}	
						
       				//오른쪽 근무자 타입별 합계 구하는 로직
				   	$Y60_7000 = 0;
					$Y59_7000 = 0;
					$N60_7000 = 0;
					$Y59_6700 = 0;
					$Y60_6700 = 0;
					
					//CR 과 OT 에 대해서 
					$Y60_7000_CR = 0;
					$Y59_7000_CR = 0;
					$N60_7000_CR = 0;
					$Y59_6700_CR = 0;
					$Y60_6700_CR = 0;
					
					$Y60_7000_OT = 0;
					$Y59_7000_OT = 0;
					$N60_7000_OT = 0;
					$Y59_6700_OT = 0;
					$Y60_6700_OT = 0;
					
					$type_total = 0;
					 
					 //프로젝트 수		 
					 for($w=4; $w<$i + 5; $w++){
    					
						//직원수
						 for($p=3; $p<$m + 3; $p++){
							 
							
					         if($project_statement[2][$p] == "Y60" && $project_statement[0][$p] == 7000 ){
								 
								 $Y60_7000 = $Y60_7000 + $project_statement[$w][$p];
								 
								 $Y60_7000_CR = $Y60_7000_CR + $project_statement[$i + 4][$p];
								 $Y60_7000_OT = $Y60_7000_OT + $project_statement[$i + 5][$p];
							 }
							 
							if($project_statement[2][$p] =="Y59" and $project_statement[0][$p] == 7000){
								 
								 $Y59_7000 = $Y59_7000 + $project_statement[$w][$p];
								 
								 $Y59_7000_CR = $Y59_7000_CR + $project_statement[$i + 4][$p];
								 $Y59_7000_OT = $Y59_7000_OT + $project_statement[$i + 5][$p];
							 }
							
							if($project_statement[2][$p] =="N60" and $project_statement[0][$p] == 7000){
								 
								 $N60_7000 = $N60_7000 + $project_statement[$w][$p];
								 
								 $N60_7000_CR = $N60_7000_CR + $project_statement[$i  + 4][$p];
								 $N60_7000_OR = $N60_7000_OT  + $project_statement[$i + 5][$p];
							 }
							 
							if($project_statement[2][$p] =="Y59" and $project_statement[0][$p] == 6700){
								 
								 $Y59_6700 = $Y59_6700 + $project_statement[$w][$p];
								 
								 $Y59_6700_CR = $Y59_6700_CR  + $project_statement[$i + 4][$p];
								 $Y59_6700_OT = $Y59_6700_OT  + $project_statement[$i + 5][$p];
							 } 
							 
							 if($project_statement[1][$p] =="Y60" and $project_statement[$w][$p] == 6700){
								 
								 $Y60_6700 = $Y60_6700 + $project_statement[$w][$p];
								 
								 $Y60_6700_CR = $Y60_6700_CR + $project_statement[$i + 4][$p];
								 $Y59_6700_OT = $Y59_6700_OT + $project_statement[$i + 5][$p];
							 } 
							 
							 
											     }
						 // 근무자 타입별 합계 배열에 넣기
						
                         $type_total = $Y60_7000 + $Y59_7000 + $N60_7000 + $Y59_6700 + $Y60_6700;                             
							 
						 $project_statement[$w][$p + 0] = $Y60_7000;
						 $project_statement[$w][$p + 1] = $Y59_7000;
						 $project_statement[$w][$p + 2] = $N60_7000;
						 $project_statement[$w][$p + 3] = $Y59_6700;
						 $project_statement[$w][$p + 4] = $Y60_6700;
					 	 $project_statement[$w][$p + 5]  = $type_total;
						 
					    $Y60_7000 = 0;
					    $Y59_7000 = 0;
						$N60_7000 = 0;
						$Y59_6700 = 0;
						$Y60_6700 = 0;
						$type_total = 0;
						
						//CR OT 에 대한 합계
						$type_total_CR = $Y60_7000_CR + $Y59_7000_CR + $N60_7000_CR +$Y59_6700_CR;
						 $project_statement[$i + 5][$p + 0] = $Y60_7000_CR;
						 $project_statement[$i + 5][$p + 1] = $Y59_7000_CR;
						 $project_statement[$i + 5][$p + 2] = $N60_7000_CR;
						 $project_statement[$i + 5][$p + 3] = $Y59_6700_CR;
						 $project_statement[$i + 5][$p + 4] = $Y60_6700_CR;
					 	 //$project_statement[$i + 5][$p + 5] = $type_total_CR;
						 
						 $project_statement[$i + 6][$p + 0] = $Y60_7000_OT;
						 $project_statement[$i + 6][$p + 1] = $Y59_7000_OT;
						 $project_statement[$i + 6][$p + 2] = $N60_7000_OT;
						 $project_statement[$i + 6][$p + 3] = $Y59_6700_OT;
						 $project_statement[$i + 6][$p + 4] = $Y60_6700_OT;
					 	// $project_statement[$i + 6][$p + 5] = $type_total_OT;
						
						}
						 
						 ?>
						 
						 
						 <table border="1">
						  
						 <?
						 
						   for($g=0; $g<$i + 3 + 1 +1 + 1 + 1; $g++){
                        ?>
                        <tr>	
						
                            <?						
						        for($c=0; $c<$m +3 + 6; $c++){
						     ?>	   		
							  <td> <?=$project_statement[$g][$c] ?></td>
						       
							   
							   <?	
							      }
								  ?>	
						</tr>		  
					    <?			  
						   }
						 ?>
						 </table>
			
					<br>
					<br>
					
					 <table border="1">
						  
						 <?
						 
						   for($g=0; $g<$i + 3 + 1 +1 ; $g++){
                        ?>
                        <tr>	
						
                            <?						
						        for($c=0; $c<$m +3 + 6; $c++){
						     ?>	   		
							  <td> <?=$project_statement_ot[$g][$c] ?></td>
						       
							   
							   <?	
							      }
								  ?>	
						</tr>		  
					    <?			  
						   }
						 ?>
						 </table>
					
					
					
					
					
					<div class="row">
                        <div class="col-md-5"></div>
                        <div class="col-md-5"></div>
                        <div class="col-md-2 text-right"></div>
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