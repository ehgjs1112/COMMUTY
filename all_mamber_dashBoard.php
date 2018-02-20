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
		<link type="text/css" rel="stylesheet" href="/css/all_mamber_dashBoard.css" />
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
                            <div class="col-md-5"></div>
                            <div class="col-md-2">근무자 상태 관리</div>
                            <div class="col-md-5"></div>
                        </div>	
                    </div>

                   

                    <BR>
                    <table   class="table table-inbox table-hover table-bordered" id = 'worker_time_tb'>
                        <thead>
							<th>순서                  </th>
							<th>전화번호                </th>
							<th>이름                  </th>
							<th>근무상태(근무중,휴면)      </th>
							<th>담당 관리자              </th>
							<th>첫 등록일               </th>
							<th>휴면 처리일             </th>
                        </thead>
                        <tbody>
							<?php
							include_once ('./config.php');
							$uname = $_SESSION['uname'];
							$date = date('Y-m-d');						
							
							$con = sqlsrv_connect($serverName, $connectionInfo);
							       $sql = "SELECT 
								        a.worker_pone_number,
										a.phone_id,
										a.worker_nm,
										a.worker_type,
							            a.join_date,
										a.worker_address,
										a.worker_state,
										a.update_date,
										b.admin_nm
										from 
										worker_info as a left outer join
										admin_info as b 
										on a.ad_approval = b.admin_id
										where  a.worker_flag = 1						
										";	     
							    $sql_count = "select count(*) from 
										worker_info as a left outer join
										admin_info as b 
										on a.ad_approval = b.admin_id
										where  a.worker_flag = 1";
								// 확인용
								$result = sqlsrv_query($con, $sql);
								//총 개수를 구하려고 함
								$sql_count = sqlsrv_query($con, $sql_count);
								
								$row_num = sqlsrv_fetch_array( $sql_count, SQLSRV_FETCH_NUMERIC);
								$number = (int) implode('',$row_num);
								//db 접속 실패 경우
								if ($con == false) {
									echo "Unable to connect.</br>";
									die(print_r(sqlsrv_errors(), true));
								}
							?>
			
							<?php
							//반복문 시작 
							 while($row = sqlsrv_fetch_array($result,SQLSRV_FETCH_ASSOC)){
								$phone_id = $row['phone_id'];
								$worker_nm = $row['worker_nm'];
								$join_date = $row['join_date'];
								$worker_pone_number = $row['worker_pone_number'];
								$worker_address = $row['worker_address'];
								$worker_type = $row['worker_type'];
								$admin_nm = $row['admin_nm'];
								$worker_state = $row['worker_state'];
								$update_date = $row['update_date'];
								
								$phone_id        = iconv("CP949", "UTF-8//TRANSLIT", $phone_id);
								$worker_nm       = iconv("CP949", "UTF-8//TRANSLIT", $worker_nm);
								$admin_nm        = iconv("CP949", "UTF-8//TRANSLIT", $admin_nm);
							?>
						
                            <tr class="">
								<td class=""><?php echo $number--  ?></td>
								<td class=""><?= $worker_pone_number?></td>
								<td class=""><?= $worker_nm?></td>
                                <td><a href="./admin_worker_state_update.php?phone_id=<?=$phone_id?>&worker_state=<?=$worker_state?>">
								       <?php   
										if($worker_state == 1){
											echo "근무중";
									    }else{
											 echo "휴면"; 
										}?></a>
								 </td>
									<td class=""><?= $admin_nm      ?>   </td>
									<td class=""><?= $join_date     ?>   </td>
									<td class=""><?= $update_date   ?>   </td>
								</tr>
							<?php
							       }
							?>
                            </tbody>
                    </table>
					<br>
					<br>
					<div class="row">
                        <div class="col-md-5"></div>
                        <div class="col-md-5"></div>
                        <div class="col-md-2 text-right"></div>
                    </div>
					
		             </div>
                </div>
        </div>
    </div>
</aside>
</div>
</div>

</body>
</html>