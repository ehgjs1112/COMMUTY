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
        <link type="text/css" rel="stylesheet" href="/css/common.css"/>
		<link type="text/css" rel="stylesheet" href="/css/responsive_my_information.css"/>
        <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
		<script language = "javascript">
			function password_check_f(){
				var password = document.getElementById("password").value;
				var passwordcheck = document.getElementById("password_check").value;
				
				if(passwordcheck == ""){
					document.getElementById("passwordcheckText").innerHTML = ""
				}
				else if(password != passwordcheck){
					document.getElementById("passwordcheckText").innerHTML = "<b><font color = red size = 5pt>FAIL</FONT></B>"
				}
				else{
					document.getElementById("passwordcheckText").innerHTML = "<b><font color = red size = 5pt>OK</FONT></B>"
				}
			}
		</script>
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
                         include_once ('./manu/left_menu/user_left_responsive_my_information_main_menu.php'); 	    						
                     ?>
					
		      </aside>
               

			   <aside class="lg-side">
                    <div class="inbox-head">
						<?php
						
							include_once ('./manu/user_top_manu.php');
						
						?>
                    </div>

                    <div class="inbox-body">
                        <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">출퇴근 정보 카드</div>
                            <div class="col-md-4"></div>
                        </div>	
                    </div>

                    <div class="row">
                        <div class="col-md-5"></div>
                        <div class="col-md-2"></div>
                        <div class="col-md-5"><?=date('Y')?>년 <?=date('m')?>월 <?=date('d')?>일</div>
                    </div>	
					<?php 
						include_once ('./config.php');
						$con = sqlsrv_connect($serverName, $connectionInfo);
						$ID = $_SESSION['uname'];
						$sql = "select 
							distinct
							worker_nm, 
							worker_pone_number,
							worker_address, 
							bank_name, 
							bank_account, 
							woker_jumin,
							worker_type,
							worker_mail,
							join_date,
							worker_attend_day
							from Attendance_info, worker_info
							where 
							worker_info.phone_id ='".$ID."'
							and
							Attendance_info.phone_id ='".$ID."'
							and
							worker_info.worker_flag = 1
							ORDER BY worker_attend_day DESC";  
						if ($con == false) {
							echo "Unable to connect.</br>";
							die(print_r(sqlsrv_errors(), true));
						}
						//echo $sql;
						$result = sqlsrv_query($con, $sql);
						$row = sqlsrv_fetch_array($result,SQLSRV_FETCH_ASSOC);
						$row['worker_nm'] = iconv("CP949", "UTF-8//TRANSLIT", $row['worker_nm']);
						$row['bank_name'] = iconv("CP949", "UTF-8//TRANSLIT", $row['bank_name']);
						$row['worker_address'] = iconv("CP949", "UTF-8//TRANSLIT", $row['worker_address']);
					?>
				 <form name="signup_form" method="post" action="worker_info_modify.php" >
					<table border = 0 align =center> 
						<tr>
							<td align = center>이름  
							<td><input type="text" name="uname" value = <?=$row['worker_nm']?>>
							<td>
						<tr>
							<td align = center>주민번호  
							<td><input type="text" name="woker_jumin" value = <?=$row['woker_jumin']?>>
							<td>
						<tr>
							<td align = center>전화번호
							<td class=""><input type="text" name="worker_pone_number" id="worker_pone_number" class="form-control" placeholder="" value="<?=$row['worker_pone_number']?>" readonly></td>
							<td>
							<td>
						<tr>
							<td align = center>비밀번호
							<td><input type="password" id = "password" name="user_pass" /><br />
							<td>
						<tr>
							<td align = center>비밀번호 확인
							<td><input type="password" id = "password_check" name="user_pass2" onkeyup = "password_check_f()"/><br />
							<td id = "passwordcheckText" width = 100>
						<tr>
							<td align = center>주소
							<td><input type="text" name="address" value = <?=$row['worker_address']?>><br />
							<td>
						<tr>
							<td align = center>이메일주소
							<td><input type="text" name="mail" value = <?=$row['worker_mail']?>><br />
							<td>
						<tr>
							<td align = center>은행
							<td><input type="text" name="bank" value = <?=$row['bank_name']?>><br />
							<td>
						<tr>
							<td align = center>은행번호 
							<td><input type="text" name="bankaccount" value= <?=$row['bank_account']?>><br />
							<td>
						<tr>
							<td align = center>가입일
							<td class=""><input type="text" name="join_date" id="join_date" class="form-control" placeholder="" value="<?=$row['join_date']?>" readonly></td>
							<td>
						<tr>
							<td><td><td><td><input type="submit" value="변경" />

					</table>
					</form>    
            </div>
        </div>
    </div>
</aside>
</div>
</div>

</body>
</html>