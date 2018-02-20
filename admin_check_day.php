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
				   
				   
                    <div class="inbox-body">
                        <a href="inout_check_page.php"   title="Compose"    class="btn btn-compose">
                            출근/퇴근
                        </a>
                        <!-- Modal -->
                        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade" style="display: none;">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                        <h4 class="modal-title">Compose</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form role="form" class="form-horizontal">
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label">To</label>
                                                <div class="col-lg-10">
                                                    <input type="text" placeholder="" id="inputEmail1" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label">Cc / Bcc</label>
                                                <div class="col-lg-10">
                                                    <input type="text" placeholder="" id="cc" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label">Subject</label>
                                                <div class="col-lg-10">
                                                    <input type="text" placeholder="" id="inputPassword1" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label">Message</label>
                                                <div class="col-lg-10">
                                                    <textarea rows="10" cols="30" class="form-control" id="" name=""></textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-lg-offset-2 col-lg-10">
                                                    <span class="btn green fileinput-button">
                                                        <i class="fa fa-plus fa fa-white"></i>
                                                        <span>Attachment</span>
                                                        <input type="file" name="files[]" multiple="">
                                                    </span>
                                                    <button class="btn btn-send" type="submit">Send</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->
                    </div>
                     
					 <?php
                         include_once ('/manu/left_menu/admin_left_admin_approve_menu.php'); 	    						
                     ?>
                    
					<ul class="nav nav-pills nav-stacked labels-info inbox-divider">
                        <li> <h4>Labels</h4> </li>
                        <li> <a href="#"> <i class=" fa fa-sign-blank text-danger"></i>  </a> </li>
                        <li> <a href="#"> <i class=" fa fa-sign-blank text-success"></i>  </a> </li>
                        <li> <a href="#"> <i class=" fa fa-sign-blank text-info "></i>     </a>
                        </li><li> <a href="#"> <i class=" fa fa-sign-blank text-warning "></i>  </a>
                        </li><li> <a href="#"> <i class=" fa fa-sign-blank text-primary "></i>  </a>
                        </li>
                    </ul>
                    <ul class="nav nav-pills nav-stacked labels-info ">
                        <li> <h4>Buddy online</h4> </li>
                        <!--
<li> <a href="#"> <i class=" fa fa-circle text-success"></i>Alireza Zare <p>I do not think</p></a>  </li>
<li> <a href="#"> <i class=" fa fa-circle text-danger"></i>Dark Coders<p>Busy with coding</p></a> </li>
<li> <a href="#"> <i class=" fa fa-circle text-muted "></i>Mentaalist <p>I out of control</p></a>
</li><li> <a href="#"> <i class=" fa fa-circle text-muted "></i>H3s4m<p>I am not here</p></a>
</li><li> <a href="#"> <i class=" fa fa-circle text-muted "></i>Dead man<p>I do not think</p></a>
</li>
                        -->
                    </ul>

                    <div class="inbox-body text-center">
                        <div class="btn-group">
                            <a class="btn mini btn-primary" href="javascript:;">
                                <i class="fa fa-plus"></i>
                            </a>
                        </div>
                        <div class="btn-group">
                            <a class="btn mini btn-success" href="javascript:;">
                                <i class="fa fa-phone"></i>
                            </a>
                        </div>
                        <div class="btn-group">
                            <a class="btn mini btn-info" href="javascript:;">
                                <i class="fa fa-cog"></i>
                            </a>
                        </div>
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

                        <!--
       <div class="mail-option">
           <div class="chk-all">
               <input type="checkbox" class="mail-checkbox mail-group-checkbox">
               <div class="btn-group">
                   <a data-toggle="dropdown" href="#" class="btn mini all" aria-expanded="false">
                       All
                       <i class="fa fa-angle-down "></i>
                   </a>
                   <ul class="dropdown-menu">
                       <li><a href="#"> None</a></li>
                       <li><a href="#"> Read</a></li>
                       <li><a href="#"> Unread</a></li>
                   </ul>
               </div>
           </div>

           <div class="btn-group">
               <a data-original-title="Refresh" data-placement="top" data-toggle="dropdown" href="#" class="btn mini tooltips">
                   <i class=" fa fa-refresh"></i>
               </a>
           </div>
           <div class="btn-group hidden-phone">
               <a data-toggle="dropdown" href="#" class="btn mini blue" aria-expanded="false">
                   More
                   <i class="fa fa-angle-down "></i>
               </a>
               <ul class="dropdown-menu">
                   <li><a href="#"><i class="fa fa-pencil"></i> Mark as Read</a></li>
                   <li><a href="#"><i class="fa fa-ban"></i> Spam</a></li>
                   <li class="divider"></li>
                   <li><a href="#"><i class="fa fa-trash-o"></i> Delete</a></li>
               </ul>
           </div>
           <div class="btn-group">
               <a data-toggle="dropdown" href="#" class="btn mini blue">
                   Move to
                   <i class="fa fa-angle-down "></i>
               </a>
               <ul class="dropdown-menu">
                   <li><a href="#"><i class="fa fa-pencil"></i> Mark as Read</a></li>
                   <li><a href="#"><i class="fa fa-ban"></i> Spam</a></li>
                   <li class="divider"></li>
                   <li><a href="#"><i class="fa fa-trash-o"></i> Delete</a></li>
               </ul>
           </div>

          <ul class="unstyled inbox-pagination">
               <li><span>1-50 of 234</span></li>
               <li>
                   <a class="np-btn" href="#"><i class="fa fa-angle-left  pagination-left"></i></a>
               </li>
               <li>
                   <a class="np-btn" href="#"><i class="fa fa-angle-right pagination-right"></i></a>
               </li>
           </ul>
                        -->


                        <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">출퇴근 정보 카드(관리자 확인)</div>
                            <div class="col-md-4"></div>
                        </div>	
                    </div>

                    <div class="row">
                        <div class="col-md-5"></div>
                        <div class="col-md-5"></div>
                        <div class="col-md-2">서기 년 일</div>
                    </div>	


                    <table class="table table-inbox table-hover table-bordered">
                        <tbody>
                            <tr class="unread">
                                <td class="inbox-small-cells">
                                    성명
                                </td>
                                <td class="inbox-small-cells"></td>
                                <td class="view-message  dont-show">시급</td>
                                <td class="view-message "></td>

                            </tr>
                            <tr class="unread">
                                <td class="inbox-small-cells">
                                    출근일수
                                </td>
                                <td class="inbox-small-cells"></td>
                                <td class="view-message  dont-show">OT</td>
                                <td class="view-message "></td>

                            </tr>
                            <tr class="unread">
                                <td class="inbox-small-cells">
                                    근무타입
                                </td>
                                <td class="inbox-small-cells"></td>
                                <td class="view-message  dont-show">시급</td>
                                <td class="view-message "></td>

                            </tr>

                        </tbody>
                    </table>

                    <BR>
                    <table class="table table-inbox table-hover table-bordered" id = 'worker_time_tb'>
                        <thead>
							<th>일자</th>
							<th>출근</th>
							<th>퇴근</th>
							<th>총시간</th>
							<th>승인여부</th>
                        </thead>
                        <tbody>
							
							<?php
							include_once ('./config.php');
							$uname = $_GET['uname'];
							
							$con = sqlsrv_connect($serverName, $connectionInfo);
							       $sql = "SELECT worker_attend_time,
							                      worker_finish_time,
										          worker_attend_day,
												  DATEDIFF(mi,worker_attend_time,worker_finish_time)as worker_one_day_hour 
												  from Attendance_info_test
												  WHERE worker_pone_number ="."'".$uname."'";
								     
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
							
							 $worker_attend_day = $row['worker_attend_day']  ->format('Y-m-d');
							 $worker_attend_time = $row['worker_attend_time']  ->format('H:i');
							 $worker_finish_time = $row['worker_finish_time']  ->format('H:i');
							 $worker_one_day_hour = $row['worker_one_day_hour'];
							 
							 //$worker_finish_time = $row['worker_finish_time']  ->format(DateTime::W3C);
							 
							?>
						
                            <tr class="">
								<td class=""><?= $worker_attend_day ?> </td>
								<td class=""><?= $worker_attend_time ?> </td>
                                <td class=""><?= $worker_finish_time ?></td>
								 <td class=""><?
									$int_attend_time = (int)substr($worker_attend_time,0,2);
									if($worker_one_day_hour > -1){
										if($int_attend_time < 13){
											$worker_one_day_hour = $worker_one_day_hour - 60;
										}
										if($worker_one_day_hour < 0) $worker_one_day_hour = 0;
										
										echo $worker_one_day_hour; 
									}
									else {
										$worker_one_day_hour = 0;
										echo $worker_one_day_hour;
									}
									?>
								</td>
								<td class=""><?php echo "미승인";?></td>
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
        <!--
                 
<table class="table table-inbox table-hover">
<tbody>
<tr class="unread">
  <td class="inbox-small-cells">
      <input type="checkbox" class="mail-checkbox">
  </td>
  <td class="inbox-small-cells"><i class="fa fa-star"></i></td>
  <td class="view-message  dont-show">PHPClass</td>
  <td class="view-message ">Added a new class: Login Class Fast Site</td>
  <td class="view-message  inbox-small-cells"><i class="fa fa-paperclip"></i></td>
  <td class="view-message  text-right">9:27 AM</td>
</tr>
<tr class="unread">
  <td class="inbox-small-cells">
      <input type="checkbox" class="mail-checkbox">
  </td>
  <td class="inbox-small-cells"><i class="fa fa-star"></i></td>
  <td class="view-message dont-show">Google Webmaster </td>
  <td class="view-message">Improve the search presence of WebSite</td>
  <td class="view-message inbox-small-cells"></td>
  <td class="view-message text-right">March 15</td>
</tr>
<tr class="">
  <td class="inbox-small-cells">
      <input type="checkbox" class="mail-checkbox">
  </td>
  <td class="inbox-small-cells"><i class="fa fa-star"></i></td>
  <td class="view-message dont-show">JW Player</td>
  <td class="view-message">Last Chance: Upgrade to Pro for </td>
  <td class="view-message inbox-small-cells"></td>
  <td class="view-message text-right">March 15</td>
</tr>
<tr class="">
  <td class="inbox-small-cells">
      <input type="checkbox" class="mail-checkbox">
  </td>
  <td class="inbox-small-cells"><i class="fa fa-star"></i></td>
  <td class="view-message dont-show">Tim Reid, S P N</td>
  <td class="view-message">Boost Your Website Traffic</td>
  <td class="view-message inbox-small-cells"></td>
  <td class="view-message text-right">April 01</td>
</tr>
<tr class="">
  <td class="inbox-small-cells">
      <input type="checkbox" class="mail-checkbox">
  </td>
  <td class="inbox-small-cells"><i class="fa fa-star inbox-started"></i></td>
  <td class="view-message dont-show">Freelancer.com <span class="label label-danger pull-right">urgent</span></td>
  <td class="view-message">Stop wasting your visitors </td>
  <td class="view-message inbox-small-cells"></td>
  <td class="view-message text-right">May 23</td>
</tr>
<tr class="">
  <td class="inbox-small-cells">
      <input type="checkbox" class="mail-checkbox">
  </td>
  <td class="inbox-small-cells"><i class="fa fa-star inbox-started"></i></td>
  <td class="view-message dont-show">WOW Slider </td>
  <td class="view-message">New WOW Slider v7.8 - 67% off</td>
  <td class="view-message inbox-small-cells"><i class="fa fa-paperclip"></i></td>
  <td class="view-message text-right">March 14</td>
</tr>
<tr class="">
  <td class="inbox-small-cells">
      <input type="checkbox" class="mail-checkbox">
  </td>
  <td class="inbox-small-cells"><i class="fa fa-star inbox-started"></i></td>
  <td class="view-message dont-show">LinkedIn Pulse</td>
  <td class="view-message">The One Sign Your Co-Worker Will Stab</td>
  <td class="view-message inbox-small-cells"><i class="fa fa-paperclip"></i></td>
  <td class="view-message text-right">Feb 19</td>
</tr>
<tr class="">
  <td class="inbox-small-cells">
      <input type="checkbox" class="mail-checkbox">
  </td>
  <td class="inbox-small-cells"><i class="fa fa-star"></i></td>
  <td class="view-message dont-show">Drupal Community<span class="label label-success pull-right">megazine</span></td>
  <td class="view-message view-message">Welcome to the Drupal Community</td>
  <td class="view-message inbox-small-cells"></td>
  <td class="view-message text-right">March 04</td>
</tr>
<tr class="">
  <td class="inbox-small-cells">
      <input type="checkbox" class="mail-checkbox">
  </td>
  <td class="inbox-small-cells"><i class="fa fa-star"></i></td>
  <td class="view-message dont-show">Facebook</td>
  <td class="view-message view-message">Somebody requested a new password </td>
  <td class="view-message inbox-small-cells"></td>
  <td class="view-message text-right">June 13</td>
</tr>
<tr class="">
  <td class="inbox-small-cells">
      <input type="checkbox" class="mail-checkbox">
  </td>
  <td class="inbox-small-cells"><i class="fa fa-star"></i></td>
  <td class="view-message dont-show">Skype <span class="label label-info pull-right">family</span></td>
  <td class="view-message view-message">Password successfully changed</td>
  <td class="view-message inbox-small-cells"></td>
  <td class="view-message text-right">March 24</td>
</tr>
<tr class="">
  <td class="inbox-small-cells">
      <input type="checkbox" class="mail-checkbox">
  </td>
  <td class="inbox-small-cells"><i class="fa fa-star inbox-started"></i></td>
  <td class="view-message dont-show">Google+</td>
  <td class="view-message">alireza, do you know</td>
  <td class="view-message inbox-small-cells"></td>
  <td class="view-message text-right">March 09</td>
</tr>
<tr class="">
  <td class="inbox-small-cells">
      <input type="checkbox" class="mail-checkbox">
  </td>
  <td class="inbox-small-cells"><i class="fa fa-star inbox-started"></i></td>
  <td class="dont-show">Zoosk </td>
  <td class="view-message">7 new singles we think you'll like</td>
  <td class="view-message inbox-small-cells"><i class="fa fa-paperclip"></i></td>
  <td class="view-message text-right">May 14</td>
</tr>
<tr class="">
  <td class="inbox-small-cells">
      <input type="checkbox" class="mail-checkbox">
  </td>
  <td class="inbox-small-cells"><i class="fa fa-star"></i></td>
  <td class="view-message dont-show">LinkedIn </td>
  <td class="view-message">Alireza: Nokia Networks, System Group and </td>
  <td class="view-message inbox-small-cells"><i class="fa fa-paperclip"></i></td>
  <td class="view-message text-right">February 25</td>
</tr>
<tr class="">
  <td class="inbox-small-cells">
      <input type="checkbox" class="mail-checkbox">
  </td>
  <td class="inbox-small-cells"><i class="fa fa-star"></i></td>
  <td class="dont-show">Facebook</td>
  <td class="view-message view-message">Your account was recently logged into</td>
  <td class="view-message inbox-small-cells"></td>
  <td class="view-message text-right">March 14</td>
</tr>
<tr class="">
  <td class="inbox-small-cells">
      <input type="checkbox" class="mail-checkbox">
  </td>
  <td class="inbox-small-cells"><i class="fa fa-star"></i></td>
  <td class="view-message dont-show">Twitter</td>
  <td class="view-message">Your Twitter password has been changed</td>
  <td class="view-message inbox-small-cells"></td>
  <td class="view-message text-right">April 07</td>
</tr>
<tr class="">
  <td class="inbox-small-cells">
      <input type="checkbox" class="mail-checkbox">
  </td>
  <td class="inbox-small-cells"><i class="fa fa-star"></i></td>
  <td class="view-message dont-show">InternetSeer Website Monitoring</td>
  <td class="view-message">http://golddesigner.org/ Performance Report</td>
  <td class="view-message inbox-small-cells"></td>
  <td class="view-message text-right">July 14</td>
</tr>
<tr class="">
  <td class="inbox-small-cells">
      <input type="checkbox" class="mail-checkbox">
  </td>
  <td class="inbox-small-cells"><i class="fa fa-star inbox-started"></i></td>
  <td class="view-message dont-show">AddMe.com</td>
  <td class="view-message">Submit Your Website to the AddMe Business Directory</td>
  <td class="view-message inbox-small-cells"></td>
  <td class="view-message text-right">August 10</td>
</tr>
<tr class="">
  <td class="inbox-small-cells">
      <input type="checkbox" class="mail-checkbox">
  </td>
  <td class="inbox-small-cells"><i class="fa fa-star"></i></td>
  <td class="view-message dont-show">Terri Rexer, S P N</td>
  <td class="view-message view-message">Forget Google AdWords: Un-Limited Clicks fo</td>
  <td class="view-message inbox-small-cells"><i class="fa fa-paperclip"></i></td>
  <td class="view-message text-right">April 14</td>
</tr>
<tr class="">
  <td class="inbox-small-cells">
      <input type="checkbox" class="mail-checkbox">
  </td>
  <td class="inbox-small-cells"><i class="fa fa-star"></i></td>
  <td class="view-message dont-show">Bertina </td>
  <td class="view-message">IMPORTANT: Don't lose your domains!</td>
  <td class="view-message inbox-small-cells"><i class="fa fa-paperclip"></i></td>
  <td class="view-message text-right">June 16</td>
</tr>
<tr class="">
  <td class="inbox-small-cells">
      <input type="checkbox" class="mail-checkbox">
  </td>
  <td class="inbox-small-cells"><i class="fa fa-star inbox-started"></i></td>
  <td class="view-message dont-show">Laura Gaffin, S P N </td>
  <td class="view-message">Your Website On Google (Higher Rankings Are Better)</td>
  <td class="view-message inbox-small-cells"></td>
  <td class="view-message text-right">August 10</td>
</tr>
<tr class="">
  <td class="inbox-small-cells">
      <input type="checkbox" class="mail-checkbox">
  </td>
  <td class="inbox-small-cells"><i class="fa fa-star"></i></td>
  <td class="view-message dont-show">Facebook</td>
  <td class="view-message view-message">Alireza Zare Login faild</td>
  <td class="view-message inbox-small-cells"><i class="fa fa-paperclip"></i></td>
  <td class="view-message text-right">feb 14</td>
</tr>
</tbody>
</table>
                  
        -->
    </div>
</aside>
</div>
</div>
<script type="text/javascript">

</script>
</body>
</html>