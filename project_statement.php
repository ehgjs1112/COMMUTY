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
                         include_once ('./userHead_info/userHead_infor.php'); 	    						
                    ?>
				   
					 <?php
                         include_once ('./manu/left_menu/admin_left_admin_approve_menu.php'); 	    						
                     ?>
                 </aside>
                <aside class="lg-side">
                    <div class="inbox-head">
                        
						<?php
							
							    include_once ('./manu/admin_top_manu.php');
							
					    ?>
				     </div>

					<?php
							include_once ('./config.php');
							$uname = $_SESSION['uname'];
							
							
							//$adress = iconv("UTF-8", "EUC-KR", $address);
							
							$date = date('Y-m-d');
							$con = sqlsrv_connect($serverName, $connectionInfo);
							  //프로젝트 명      
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
                                        

										  
							//$sql = "select count(case when worker_pone_number in ('".$uname."')"."then 1 end) from Attendance_info";
							// 확인용
							//echo $sql;
							$result = sqlsrv_query($con, $sql);
							
							//db 접속 실패 경우
							if ($con == false) {
								echo "Unable to connect.</br>";
								die(print_r(sqlsrv_errors(), true));
							}
							//$row = sqlsrv_fetch_array($result,SQLSRV_FETCH_NUMERIC);
							//echo $row[0];
							?>
					 
                   
                            <?php
							//반복문 시작 
							 $project_seq = 0;
							 //$project_list[100][100];  
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
							 
							 
							 $project_seq++;
							  }
							?>





				   <div class="inbox-body">
                       <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">프로젝트 별 내역서</div>
                            <div class="col-md-4"></div>
                        </div>	
                    </div>

                    

                    <BR>

					
					
				  <table class="table table-inbox table-hover table-bordered" id = 'worker_time_tb'>
                        <thead>
							<th>순서                   </th>
							<th>JOB CODE              </th>
							<th>CODE                  </th>
							<th>PROJECT              </th>
							<th>코딩                   </th>
							<th>입력                   </th>
							<th>60시간 미만            </th>
							<th>60시간 이상            </th>
							<th>60시간 미만            </th>
							<th>60시간 이상            </th>
							<th>전체 합계              </th>
							
							
							
				        </thead>
                        <tbody>
							
			
							
						
                            <tr class="">
								<td class=""></td>
								<td class=""><?=$project_job_code?></a></td>
								<td class=""><?= $project_code?></a></td>
                                <td class=""><?= $project_name?></a></td>
								<td>  </td>
								<td>  </td>
								<td>  </td>
								<td>  </td>
								<td>  </td>
								<td>  </td>
								<td>  </td>
                            </tr>
							
							
							<tr>
							<td>  </td>
							<td colspan="3"> 전체 합계 </td>
							<td>  </td>
							<td>  </td>
							<td>  </td>
							<td>  </td>
							<td>  </td>
							<td>  </td>
							<td>  </td>
							
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