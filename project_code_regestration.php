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
                            <div class="col-md-4">프로젝트 코드 등록</div>
                            <div class="col-md-4"></div>
                        </div>	
                    </div>

					<BR>
				<form role="form" class="form-horizontal" name="signup_form" method="post" action="project_code_proc.php">
                    <table class="table  table-hover table-bordered" id = 'worker_time_tb'>
                         <tbody>
                       <tr>
					     <td>job코드</td>
					   <td>
					   <input type="text" placeholder="" id="uname" name="project_job_code"  >
					   </td>
					   <td>일반코드</td>
					   <td>
					   <input type="text" placeholder="" id="uname" name="project_code"  >
					   </td>
					   <td>프로젝트명</td>
					   <td>
					   <input type="text" placeholder="" id="uname" name="project_name"  >
					   </td>
					   <td><input type="submit" value="확인"/></td>
					   </tr>
                       </tbody>
                    </table>
					<br>
					<br>
				</form>
					
				<table class="table table-inbox table-hover table-bordered" id = 'worker_time_tb'>
                        <thead>
							<th>순서                    </th>
							<th>job_코드 명             </th>
							<th>코드명                  </th>
							<th>프로젝트명               </th>
							<th>등록자                  </th>
							<th>첫 등록일               </th>
							<th>정산 여부               </th>
							<th>정산 완료일             </th>
				        </thead>
                        <tbody>
							<?php
							include_once ('./config.php');
							$uname = $_SESSION['uname'];
							
							
							//$adress = iconv("UTF-8", "EUC-KR", $address);
							
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
									  where  a.project_flag = 1;
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
							 
							 
							?>
						
                            <tr class="">
								<td class=""></td>
								<td class=""><?=$project_job_code?></a></td>
								<td class=""><?= $project_code?></a>   </td>
                                <td class=""><?= $project_name?></a>   </td>
                                <td class=""><?= $admin_nm?></a>       </td>
                                <td class=""><?= $regi_date?></a>      </td>
								
                                <td>
                                <a href="./admin_project_code_state_update.php?project_job_code=<?=$project_job_code?>&project_state=<?=$project_state?>">
								       <?php   if($project_state == 1){
										             echo "완료";
									              }else{
													 echo "미완료"; 
										}?>
								</a>
								</td>
								<td></td>
                            </tr>
							
							<?php
							       }
							?>
                            </tbody>
                    </table>
				             </div>

        </div>
    </div>
    </div>
</aside>
</div>
</div>

</body>
</html>