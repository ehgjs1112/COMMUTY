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
        <style type="text/css">
            .mail-box {
                border-collapse: collapse;
                border-spacing: 0;
                display: table;
                table-layout: fixed;
                width: 100%;
            }
            .mail-box aside {
                display: table-cell;
                float: none;
                height: 100%;
                padding: 0;
                vertical-align: top;
            }
            .mail-box .sm-side {
                background: none repeat scroll 0 0 #e5e8ef;
                border-radius: 4px 0 0 4px;
                width: 25%;
            }
            .mail-box .lg-side {
                background: none repeat scroll 0 0 #fff;
                border-radius: 0 4px 4px 0;
                width: 75%;
            }
            .mail-box .sm-side .user-head {
                background: none repeat scroll 0 0 #00a8b3;
                border-radius: 4px 0 0;
                color: #fff;
                min-height: 80px;
                padding: 10px;
            }
            .user-head .inbox-avatar {
                float: left;
                width: 65px;
            }
            .user-head .inbox-avatar img {
                border-radius: 4px;
            }
            .user-head .user-name {
                display: inline-block;
                margin: 0 0 0 10px;
            }
            .user-head .user-name h5 {
                font-size: 14px;
                font-weight: 300;
                margin-bottom: 0;
                margin-top: 15px;
            }
            .user-head .user-name h5 a {
                color: #fff;
            }
            .user-head .user-name span a {
                color: #87e2e7;
                font-size: 12px;
            }
            a.mail-dropdown {
                background: none repeat scroll 0 0 #80d3d9;
                border-radius: 2px;
                color: #01a7b3;
                font-size: 10px;
                margin-top: 20px;
                padding: 3px 5px;
            }
            .inbox-body {
                padding: 20px;
            }
            .btn-compose {
                background: none repeat scroll 0 0 #ff6c60;
                color: #fff;
                padding: 12px 0;
                text-align: center;
                width: 100%;
            }
            .btn-compose:hover {
                background: none repeat scroll 0 0 #f5675c;
                color: #fff;
            }
            ul.inbox-nav {
                display: inline-block;
                margin: 0;
                padding: 0;
                width: 100%;
            }
            .inbox-divider {
                border-bottom: 1px solid #d5d8df;
            }
            ul.inbox-nav li {
                display: inline-block;
                line-height: 45px;
                width: 100%;
            }
            ul.inbox-nav li a {
                color: #6a6a6a;
                display: inline-block;
                line-height: 45px;
                padding: 0 20px;
                width: 100%;
            }
            ul.inbox-nav li a:hover, ul.inbox-nav li.active a, ul.inbox-nav li a:focus {
                background: none repeat scroll 0 0 #d5d7de;
                color: #6a6a6a;
            }
            ul.inbox-nav li a i {
                color: #6a6a6a;
                font-size: 16px;
                padding-right: 10px;
            }
            ul.inbox-nav li a span.label {
                margin-top: 13px;
            }
            ul.labels-info li h4 {
                color: #5c5c5e;
                font-size: 13px;
                padding-left: 15px;
                padding-right: 15px;
                padding-top: 5px;
                text-transform: uppercase;
            }
            ul.labels-info li {
                margin: 0;
            }
            ul.labels-info li a {
                border-radius: 0;
                color: #6a6a6a;
            }
            ul.labels-info li a:hover, ul.labels-info li a:focus {
                background: none repeat scroll 0 0 #d5d7de;
                color: #6a6a6a;
            }
            ul.labels-info li a i {
                padding-right: 10px;
            }
            .nav.nav-pills.nav-stacked.labels-info p {
                color: #9d9f9e;
                font-size: 11px;
                margin-bottom: 0;
                padding: 0 22px;
            }
            .inbox-head {
                background: none repeat scroll 0 0 #41cac0;
                border-radius: 0 4px 0 0;
                color: #fff;
                min-height: 80px;
                padding: 20px;
            }
            .inbox-head h3 {
                display: inline-block;
                font-weight: 300;
                margin: 0;
                padding-top: 6px;
            }
            .inbox-head .sr-input {
                border: medium none;
                border-radius: 4px 0 0 4px;
                box-shadow: none;
                color: #8a8a8a;
                float: left;
                height: 40px;
                padding: 0 10px;
            }
            .inbox-head .sr-btn {
                background: none repeat scroll 0 0 #00a6b2;
                border: medium none;
                border-radius: 0 4px 4px 0;
                color: #fff;
                height: 40px;
                padding: 0 20px;
            }
            .table-inbox {
                border: 1px solid #d3d3d3;
                margin-bottom: 0;
            }
            .table-inbox tr td {
                padding: 12px !important;
            }
            .table-inbox tr td:hover {
                cursor: pointer;
            }
            .table-inbox tr td .fa-star.inbox-started, .table-inbox tr td .fa-star:hover {
                color: #f78a09;
            }
            .table-inbox tr td .fa-star {
                color: #d5d5d5;
            }
            .table-inbox tr.unread td {
                background: none repeat scroll 0 0 #f7f7f7;
                font-weight: 600;
            }
            ul.inbox-pagination {
                float: right;
            }
            ul.inbox-pagination li {
                float: left;
            }
            .mail-option {
                display: inline-block;
                margin-bottom: 10px;
                width: 100%;
            }
            .mail-option .chk-all, .mail-option .btn-group {
                margin-right: 5px;
            }
            .mail-option .chk-all, .mail-option .btn-group a.btn {
                background: none repeat scroll 0 0 #fcfcfc;
                border: 1px solid #e7e7e7;
                border-radius: 3px !important;
                color: #afafaf;
                display: inline-block;
                padding: 5px 10px;
            }
            .inbox-pagination a.np-btn {
                background: none repeat scroll 0 0 #fcfcfc;
                border: 1px solid #e7e7e7;
                border-radius: 3px !important;
                color: #afafaf;
                display: inline-block;
                padding: 5px 15px;
            }
            .mail-option .chk-all input[type="checkbox"] {
                margin-top: 0;
            }
            .mail-option .btn-group a.all {
                border: medium none;
                padding: 0;
            }
            .inbox-pagination a.np-btn {
                margin-left: 5px;
            }
            .inbox-pagination li span {
                display: inline-block;
                margin-right: 5px;
                margin-top: 7px;
            }
            .fileinput-button {
                background: none repeat scroll 0 0 #eeeeee;
                border: 1px solid #e6e6e6;
            }
            .inbox-body .modal .modal-body input, .inbox-body .modal .modal-body textarea {
                border: 1px solid #e6e6e6;
                box-shadow: none;
            }
            .btn-send, .btn-send:hover {
                background: none repeat scroll 0 0 #00a8b3;
                color: #fff;
            }
            .btn-send:hover {
                background: none repeat scroll 0 0 #009da7;
            }
            .modal-header h4.modal-title {
                font-family: "Open Sans",sans-serif;
                font-weight: 300;
            }
            .modal-body label {
                font-family: "Open Sans",sans-serif;
                font-weight: 400;
            }
            .heading-inbox h4 {
                border-bottom: 1px solid #ddd;
                color: #444;
                font-size: 18px;
                margin-top: 20px;
                padding-bottom: 10px;
            }
            .sender-info {
                margin-bottom: 20px;
            }
            .sender-info img {
                height: 30px;
                width: 30px;
            }
            .sender-dropdown {
                background: none repeat scroll 0 0 #eaeaea;
                color: #777;
                font-size: 10px;
                padding: 0 3px;
            }
            .view-mail a {
                color: #ff6c60;
            }
            .attachment-mail {
                margin-top: 30px;
            }
            .attachment-mail ul {
                display: inline-block;
                margin-bottom: 30px;
                width: 100%;
            }
            .attachment-mail ul li {
                float: left;
                margin-bottom: 10px;
                margin-right: 10px;
                width: 150px;
            }
            .attachment-mail ul li img {
                width: 100%;
            }
            .attachment-mail ul li span {
                float: right;
            }
            .attachment-mail .file-name {
                float: left;
            }
            .attachment-mail .links {
                display: inline-block;
                width: 100%;
            }

            .fileinput-button {
                float: left;
                margin-right: 4px;
                overflow: hidden;
                position: relative;
            }
            .fileinput-button input {
                cursor: pointer;
                direction: ltr;
                font-size: 23px;
                margin: 0;
                opacity: 0;
                position: absolute;
                right: 0;
                top: 0;
                transform: translate(-300px, 0px) scale(4);
            }
            .fileupload-buttonbar .btn, .fileupload-buttonbar .toggle {
                margin-bottom: 5px;
            }
            .files .progress {
                width: 200px;
            }
            .fileupload-processing .fileupload-loading {
                display: block;
            }
            * html .fileinput-button {
                line-height: 24px;
                margin: 1px -3px 0 0;
            }
            * + html .fileinput-button {
                margin: 1px 0 0;
                padding: 2px 15px;
            }
            @media (max-width: 767px) {
                .files .btn span {
                    display: none;
                }
                .files .preview * {
                    width: 40px;
                }
                .files .name * {
                    display: inline-block;
                    width: 80px;
                    word-wrap: break-word;
                }
                .files .progress {
                    width: 20px;
                }
                .files .delete {
                    width: 60px;
                }
            }
            ul {
                list-style-type: none;
                padding: 0px;
                margin: 0px;
            }

        </style>
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
                         include_once ('/manu/left_menu/admin_left_responsive_dash_main_menu.php'); 	    						
                     ?>
					    
				<div class="inbox-body">
 
 
                    </div>
					


                </aside>
                <aside class="lg-side">
                    <div class="inbox-head">
                        <!-- 
                        <h3>근태기록</h3>
                        <h3>내정보</h3>
                        <h3>출 퇴근 모니터링</h3>
                        <h3>멤버 등록 급여관리</h3>
                        주석처리
<form action="#" class="pull-right position">
    <div class="input-append">
        <input type="text" class="sr-input" placeholder="Search Mail">
        <button class="btn sr-btn" type="button"><i class="fa fa-search"></i></button>
    </div>
</form>
                       
                        -->
						
						<?php
							
							    include_once ('/manu/admin_top_manu.php');
							
					    ?>
						
	                   </div>

                    <div class="inbox-body">

                    <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">일별 출퇴근 현황 및 결제</div>
                            <div class="col-md-4"></div>
                        </div>	
                    </div>

                    <div class="row">
                        <div class="col-md-5"></div>
                        <div class="col-md-5"></div>
                        <div class="col-md-2">서기 년 일</div>
                    </div>	

                    <BR>
                    <table class="table table-inbox table-hover table-bordered" id = 'worker_time_tb'>
                        <thead>
							
							<th class="text-center"><input type="checkbox"  id="blankCheckbox" value="option1" aria-label="..."></th>
							<th>날짜</th>
							<th>출근시간</th>
							<th>퇴근시간</th>
							<th>OT출근시간</th>
							<th>OT퇴근시간</th>
							<th>총 근무시간</th>
							<th>승인여부</th>
                        </thead>
                        <tbody>
							<?php
							include_once ('./config.php');
							$worker_id=$_GET['ID'];
							$con = sqlsrv_connect($serverName, $connectionInfo);
								$sql = "select worker_info.phone_id, 
										worker_info.worker_nm,
										Attendance_info.worker_attend_time,
										Attendance_info.worker_finish_time,
										Attendance_info.worker_attend_ot_time,
										Attendance_info.worker_finish_ot_time,
										Attendance_info.worker_attend_day,
										DATEDIFF(mi,worker_attend_time,worker_finish_time)as worker_one_day_hour,
										DATEDIFF(mi,worker_attend_ot_time,worker_finish_ot_time)as worker_one_day_ot_hour 									
										from worker_info
										left outer join Attendance_info
										ON worker_info.phone_id = Attendance_info.phone_id 
										where worker_info.worker_flag = 1 and Attendance_info.phone_id = '".$worker_id."'"."
										order by Attendance_info.worker_attend_day DESC";
							echo $sql;
							$result = sqlsrv_query($con, $sql);
							//db 접속 실패 경우
							if ($con == false) {
								echo "Unable to connect.</br>";
								die(print_r(sqlsrv_errors(), true));
							}
							?>
							<?php
							//반복문 시작 
							  while($row = sqlsrv_fetch_array($result,SQLSRV_FETCH_ASSOC)){
							 $worker_attend_day = $row['worker_attend_day']  ->format('Y-m-d');
							 
							 $worker_attend_time = $row['worker_attend_time']->format('H:i');
							 $worker_finish_time = $row['worker_finish_time']->format('H:i');
							 
							 if(isset($row['worker_attend_ot_time']) == TRUE){
								$worker_ot_attend_time = $row['worker_attend_ot_time']->format('H:i');
								$worker_ot_finish_time = $row['worker_finish_ot_time']->format('H:i');
							 }
							 else{
								$worker_ot_attend_time = "-";
								$worker_ot_finish_time = "-";
							 }
							 $worker_one_day_hour = $row['worker_one_day_hour'];
							?>
                            <tr class="">
								<td class="text-center"><input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."></td>
                                <td class=""><?=$worker_attend_day?></td>
								<td class=""><a href="./time_change.php?ID=<?= $worker_id?>&DATE=<?= $worker_attend_day?>&mode=1&time=<?= $worker_attend_time ?>"><?= $worker_attend_time ?></a></td>
								<td class=""><a href="./time_change.php?ID=<?= $worker_id?>&DATE=<?= $worker_attend_day?>&mode=2&time=<?= $worker_finish_time ?>"><?= $worker_finish_time ?></a></td>
								<td class=""><a href="./time_change.php?ID=<?= $worker_id?>&DATE=<?= $worker_attend_day?>&mode=3&time=<?= $worker_ot_attend_time ?>"><?= $worker_ot_attend_time ?></a></td>
								<td class=""><a href="./time_change.php?ID=<?= $worker_id?>&DATE=<?= $worker_attend_day?>&mode=4&time=<?= $worker_ot_finish_time ?>"><?= $worker_ot_finish_time ?></a></td>
								
								<!--
								<td class=""><a href=""></a><?=$worker_attend_time?></td>
								<td class=""><a href=""></a><?=$worker_finish_time?></td>
								<td class=""><a href=""></a><?=$worker_ot_attend_time?></td>
								<td class=""><a href=""></a><?=$worker_ot_finish_time?></td>
								-->
								<td class="">
									<?php
										if (strcmp($worker_finish_time,"00:00") === 0 and strcmp(date('Y-m-d'),$worker_attend_day)!=0) echo "관리자 퇴근 처리 요망";
										else if (strcmp($worker_attend_time,"00:00") === 0 and strcmp(date('Y-m-d'),$worker_attend_day)!=0) echo "관리자 출근 처리 요망";
									
										else if(strcmp($worker_ot_attend_time,"-") === 0){
											$int_attend_hour = (int)substr($worker_attend_time,0,2);//출근시간
											$int_attend_min = (int)substr($worker_attend_time,3,2);//출근시간
											$worker_attend_min = $int_attend_hour * 60 + $int_attend_min;
											$worker_finish_hour = (int)substr($worker_finish_time,0,2);//퇴근시간
											$worker_finish_min = (int)substr($worker_finish_time,3,2);//퇴근시간
											
											$worker_finish_min = $worker_finish_hour * 60 + $worker_finish_min;
											
											if($worker_attend_min < 720){
												$total_work_time = $worker_finish_min - $worker_attend_min - 60;
											}
											else{
												$total_work_time = $worker_finish_min - $worker_attend_min;
											}
											$total_work_hour = floor($total_work_time / 60);
											$total_work_min = floor($total_work_time % 60);
																
											if($total_work_hour == 0){
												echo "00:";
											}
											else if($total_work_hour < 10){
												echo "0".$total_work_hour,":";
											}
											else echo $total_work_hour.":";
											
											if($total_work_min == 0){
												echo "00";
											}
											else if($total_work_min < 10){
												echo "0".$total_work_min;
											}
											else echo $total_work_min;
										}
										else{
											$int_attend_hour = (int)substr($worker_attend_time,0,2);//출근시간
											$int_attend_min = (int)substr($worker_attend_time,3,2);//출근시간
											$worker_attend_min = $int_attend_hour * 60 + $int_attend_min;
											
											$int_finish_ot_hour = (int)substr($worker_ot_finish_time,0,2);//퇴근시간
											$int_finish_ot_min = (int)substr($worker_ot_finish_time,3,2);//퇴근시간
											$worker_finish_ot_min = $int_finish_ot_hour * 60 + $int_finish_ot_min;
											
											if($worker_attend_min < 720){
												$total_work_ot_time = $worker_finish_ot_min - $worker_attend_min - 60;
											}
											else{
												$total_work_ot_time = $worker_finish_ot_min - $worker_attend_min;
											}
											$total_work_ot_time = $worker_finish_ot_min - $worker_attend_min;
											$total_work_ot_hour = floor($total_work_ot_time / 60);
											$total_work_ot_min = floor($total_work_ot_time % 60);
																
											if($total_work_ot_hour == 0){
												echo "00:";
											}
											else if($total_work_ot_hour < 10){
												echo "0".$total_work_ot_hour,":";
											}
											else echo $total_work_ot_hour.":";
											
											if($total_work_ot_min == 0){
												echo "00";
											}
											else if($total_work_ot_min < 10){
												echo "0".$total_work_ot_min;
											}
											else echo $total_work_ot_min;
										}
									?>
								</td>
								<td class=""><a href=""></a><??></td>
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
                        <div class="col-md-2 text-right"><button type="submit" name = usercheck value = 0 class = "btn1">승인</button></div>
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