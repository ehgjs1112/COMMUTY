<!DOCTYPE html>
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
                padding: px;
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
                font-weight: 200;
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

            /*  로그인  CSS   */

            .well
            {
                padding: 45px;
                padding-left: 45px;
                box-shadow: 0 0 50px #666666;
                margin: 7% auto 0;
                width: 450px;
                background: rgba(0.4, 0, 0, 0.4);
            }

            .btn1
            {
                background-color: #00ADEE;
                color: white;
                transition: all 0.5s;
				padding: 20%;
				margin-left: 20px;
				margin-top: 5px;
            }
            .btn1:hover, .btn1:focus
            {
                background-color: white;
                color: black;
                border: 1px solid;
                border-color: #00ADEE;
                transition: 0.5s;
            }
            a:hover
            {
                text-decoration: none;
                color: red;
            }

            body
            {
                background: url('http://www.nielsen.com/content/cus_config/homepg-hero-bground/background-textures/Purple/data-texture-slider-background-1920x600-purple.png'); 
				-webkit-background-size: cover;
				-moz-background-size: cover;
				-o-background-size: cover;
				background-size: cover;
			}

            .well-header
            {
                background-color: #00ADEE;
            }

            .input-group-addon
            {
                background-color: #00ADEE;
                border-color: #00ADEE;
                color: white;
            }

            .btn2
            {
                transition: all 0.5s;
            }


            .btn2:hover, .btn2:focus
            {
                border-color: #428bca;
                color: black;
                background-color: white;
                transition: 0.5s;
            } 

        </style>

        <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    </head>
    <body>
        
            <div class="col-md-12">
                <div class="well center-block">                
                    <div class="row">
                        <div class="col-md-4"><img src = "./img/n-tab.png" style ="width: 70%; max-width:60px; padding-left: 10px"></div>
						<form name="login_form" method="post" action="./admin_responsive_main_login.html">
							<div class="col-md-4 col-md-offset-4"><button type="submit" name = usercheck class="btn btn-lg btn2 btn-block">Admin</button></div>
						</form>
					</div>
			<!--<form name="login_form" method="post" action="./login_check.php"> -->
                 <form name="login_form" method="post" action="./main_controller.php?mode=login_check">   
					<h2 class="text-center">출 퇴근 관리 시스템</h2><hr>
                    <div class="well-header">
                        <center><img src="http://www.kisanpoint.com/mrb/includes/images/design_stuff/default_user_icon.png" class="img-thumbnail img-circle img-responsive" height="80px;" width="80px;"></center>
                        <h1 class="text-center" style="color: white;">Login</h1><hr>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="col-xs-8 col-sm-8 col-md-8">
                                <div class="row">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <span class="glyphicon glyphicon-user"></span>
                                            </div>
                                            <input type="text" placeholder="User Name" id="uname" name="uname" class="form-control">
                                            <div class="input-group-btn">
                                                <button type="button" id="remove" data-val="1" class="btn btn-default btn-md"> <span class="glyphicon glyphicon-remove"></span></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class = "row">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <span class="glyphicon glyphicon-lock"></span>
                                            </div>
                                            <input type="password" id="pwd" class="form-control" placeholder="Password" name="pass">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default btn-md" id="showhide" data-val='1'><span id='eye' class="glyphicon glyphicon-eye-open"></span></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-4 col-sm-4 col-md-4">
                                <div class="row">
                                    <div class=>
                                        <button type="submit" name = usercheck value = 0 class = "btn1">로그인</button>
                                    </div>
                                </div>
                            </div>
                        </div>
						        </form>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="col-xs-8 col-sm-8 col-md-8">
                                <input type="checkbox" name="check" checked> 번호 기억하기
                            </div>
                                <div class="inbox-body col-xs-4 col-sm-4 col-md-4">
                       
                        <div class="inbox-body">
						   
				         <?php
							include_once ('./config.php');
							
							$con = sqlsrv_connect($serverName, $connectionInfo);
							       $sql = "SELECT admin_id,
                                                  admin_nm
		                                          from admin_info;
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

		     	    	 <a href="#myModal_1" data-toggle="modal">가입하기</a>
						
						<!-- Modal -->
							<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal_1" class="modal fade" style="display: none;">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
											<img src = "./img/n-tab.png" style ="width: 70%; max-width:60px; padding-left: 10px">
											회원가입
										</div>
										<div class="modal-body">
											<form role="form" class="form-horizontal" name="signup_form" method="POST" action="signup_check_v1.php">
												<div class="form-group">
													<table align = "center">
														<tr>
															<td>이름 
															<td><input type="text" name="uname"/>
														<tr>
															<td>전화번호 
															<td><input type="text" name="user_id"/>
														<tr>
															<td>비밀번호 
															<td><input type="password" name="user_pass"/>
														<tr>
															<td>비밀번호 확인 
															<td><input type="password" name="user_pass2"/>
														<tr>
															<td>주소 
															<td><input type="text" name="address"/>
														<tr>
															<td>이메일 
															<td><input type="text" name="mail"/>	
														<tr>
															<td>은행 
															<td><input type="text" name="bank"/>														
														<tr>
															<td>계좌번호 
															<td><input type="text" name="bankaccount"/>
														<tr>
														<tr>
															<td>관리자 선택 
															<td>
															<select class="form-control" name="admin_id">
															     <option>선택해주세요</option>
															<?php
						                                        	//반복문 시작 
						                                        	 while($row = sqlsrv_fetch_array($result,SQLSRV_FETCH_ASSOC)){
						                                        	 $admin_id = $row['admin_id'];
						                                           	 $admin_id = iconv("CP949", "UTF-8", $admin_id);		 
																	 $admin_nm = $row['admin_nm'];
																	 $admin_nm = iconv("CP949", "UTF-8", $admin_nm);
							                                ?>  
														    <option value="<?=$admin_id?>"><?= $admin_nm ?> </option>
															<?php	
																}
															?> 	
															</select>
															</td>
															
															
														</tr>
														<tr>
															<td> 컴퍼니,서비스 선택  </td>
															<td>
															<select class="form-control" name="cost_center">
															     <option>선택해주세요</option>
															     <option value="5382103">닐슨 컴퍼니</option>
														         <option value="5382105">닐슨 서비스</option>
															</select>
															</td>
														</tr>
														 
														 <tr>
															<td> 부서 선택  </td>
															<td>
															<select class="form-control" name="department">
															     <option>선택해주세요</option>
                                                                 <option value="GBS IVPO CR">GO 부서    </option>
															</select>
															</td>
														 </tr>
														
														
														
														
														<td><td><td><input type="submit" value="확인"/>
													</table>
												</div>
											</form>
										</div>
									</div><!-- /.modal-content -->
									</div><!-- /.modal-dialog -->
									</div><!-- /.modal -->
								</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </body>
</html>