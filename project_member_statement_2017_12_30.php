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
                            <div class="col-md-4">project별 개인 내역서 </div>
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
							   //프로젝트 명 출력  
                             $sql = "SELECT 
								      a.project_name,
								      a.project_code,
								      a.project_job_code,
							          a.regi_date,
									  a.project_state,
								      b.admin_nm
								      from project_registration_info as a 
									  left outer join admin_info as b on a.admin_id = b.admin_id
										";	  
                                        
                            //근무자 출력 
							$sql_2 = "SELECT 
								        a.worker_pone_number,
										a.phone_id,
										a.worker_nm,
										a.worker_type,
							            a.join_date,
										a.worker_address,
										a.worker_state,
										b.admin_nm
										from 
										worker_info as a left outer join
										admin_info as b 
										on a.ad_approval = b.admin_id
										where  a.worker_flag = 1						
										";	     	
										
                              //시간 데이터 가져오기								
                             $sql_3 = "select              
                                       distinct    a.worker_nm,
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


								
							//$sql = "select count(case when worker_pone_number in ('".$uname."')"."then 1 end) from Attendance_info";
							// 확인용
							//echo $sql;
						    $result   = sqlsrv_query($con, $sql);
							$result_2 = sqlsrv_query($con, $sql_2);
							$result_3 = sqlsrv_query($con, $sql_3);
							//db 접속 실패 경우
							if ($con == false) {
								echo "Unable to connect.</br>";
								die(print_r(sqlsrv_errors(), true));
							}
							//$row = sqlsrv_fetch_array($result,SQLSRV_FETCH_NUMERIC);
							//echo $row[0];
							?>
						
						
                         <?php
						     $q=0;
							//반복문 시작 
							 while($row = sqlsrv_fetch_array($result_3,SQLSRV_FETCH_ASSOC)){
							 
						     //$worker_nm             = $row['worker_nm'];
							 $phone_id[$q]              = $row['phone_id'];
							 $project_job_code      = $row['project_job_code'];
							 $project_time          = $row['project_time'];
							 
							 //$worker_nm[$q]                = iconv("CP949", "UTF-8//TRANSLIT", $worker_nm);
							 //$phone_id[$q]                = iconv("CP949", "UTF-8//TRANSLIT", $phone_id);
							 //$project_job_code[$q]         = iconv("CP949", "UTF-8//TRANSLIT", $project_job_code);
							 //$project_time[$q]             = iconv("CP949", "UTF-8//TRANSLIT", $project_time);
							 echo $phone_id[$q];
							 $q++;
							   
							  }
							  
							  echo $q; 
						 ?>
						
					
				  <table class="table table-inbox table-hover table-bordered" id = 'worker_time_tb' style="width:2500px; height:500px; ">
                        <thead>
						    <tr>
							<th>                   </th>
							<th>                   </th>
							<th>                   </th>
							<th>                   </th>
							<th>                   </th>
							<th>                   </th>
							</tr>
						    <tr>
							
							<th>code                    </th>
							<th>project                 </th>
							<?php
							//반복문 시작 
							$m=0;
							 while($row = sqlsrv_fetch_array($result_2,SQLSRV_FETCH_ASSOC))
							 {
							 
							 $worker_nm             = $row['worker_nm'];
							 $phone_id_worker       = $row['phone_id'];
							 $worker_nm[$m]         = iconv("CP949", "UTF-8//TRANSLIT", $worker_nm);
							
							 $m++
							 
							?>
							
							<td class=""><?= $worker_nm?></a></td>
							
							<?php
							       }
							?>
							
							<td>   Y60합계         </td>
							<td>   Y59합계         </td>
							<td>   N60합계         </td>
							<td>   Y59합계         </td>
							<td>   Y60합계         </td>
							<td>   합   계         </td>
							</tr>
				        </thead>
                        <tbody>
							
			
							<?php
							//반복문 시작 
							 while($row = sqlsrv_fetch_array($result,SQLSRV_FETCH_ASSOC)){
							 
							 $project_name           = $row['project_name'];
							 $project_code           = $row['project_code'];
							 $project_job_code_base  = $row['project_job_code'];
							 
							
							 $project_name         = iconv("CP949", "UTF-8//TRANSLIT", $project_name);
							 $project_code         = iconv("CP949", "UTF-8//TRANSLIT", $project_code);
							 $project_job_code_base     = iconv("CP949", "UTF-8//TRANSLIT", $project_job_code_base);
							 
							 
							 
							?>
						
						

                            <tr class="">
							
								
								<td class=""><?= $project_code?></a></td>
								<td class=""><?= $project_name?></a></td>
                                
								
								<!-- 배열 만들기 -->
					    <?php
						//불러온 직원 명수 만큼
					        for($u=0;$u<$m;$u++){
								//불러온 타임 테이블 개수 만큼
								for($i=0;$i<$q;$i++){
									echo "()";
									$phone_id;
								 // if( $phone_id_worker[$u] == $phone_id[$i] && $project_job_code_base == $project_job_code[$i]   ){
									 
								// }
								     } 
							?>
						        <td class=""> </td>
						
						
						<?php
                                  }
                         ?>						
								
							   
								
                            </tr>
							
							<?php
							       }
							?>
							<tr>
							<td colspan="2">합계</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							</tr>
							
							<tr>
							<td colspan="2">CR</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							</tr>
							
							<tr>
							<td colspan="2">OT</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							</tr>
							
							<tr>
							<td colspan="2">주휴</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							</tr>
							
							<tr>
							<td colspan="2">RMS</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							</tr>
							
							<tr>
							<td colspan="2">야근수당</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							</tr>
							
							<tr>
							<td colspan="2">수당(야근수당 제외)</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							</tr>
							
							<tr>
							<td colspan="2">주휴 수당</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							</tr>
							
							<tr>
							<td colspan="2">전체 수당</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							</tr>
							
                            </tbody>
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