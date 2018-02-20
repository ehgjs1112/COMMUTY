<!DOCTYPE html>

<!-- 로그인 여부 확인 -->
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
        <link type="text/css" rel="stylesheet" href="/css/responsive_main.css"/>
        <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    
    	  	<script language="javascript">
				function getQuerystring(paramName)
				{ 
					var _tempUrl = window.location.search.substring(1); //url에서 처음부터 '?'까지 삭제 
					var _tempArray = _tempUrl.split('&'); // '&'을 기준으로 분리하기 
					for(var i = 0; _tempArray.length; i++) { 
						var _keyValuePair = _tempArray[i].split('='); // '=' 을 기준으로 분리하기 
	
						if(_keyValuePair[0] == paramName){ // _keyValuePair[0] : 파라미터 명 
								// _keyValuePair[1] : 파라미터 값 
								return _keyValuePair[1]; 
						} 
					} 
				}	   
				function moveCode(project_job_code,project_code,project_name){
					var count = getQuerystring('count') 
					var project_job_code = project_job_code ;
					var project_code     = project_code;
					var project_name     = project_name;
					var a = "project_job_code" + count;
					var b = "project_code"     + count;
					var c = "project_name"     + count;
						
						
					window.opener.document.getElementById( "project_job_code" + count).value     = project_job_code;  // 부모창에 우편번호 값입력
					window.opener.document.getElementById("project_code"      + count).value     = project_code;  // 부모창에 우편번호 값입력
					window.opener.document.getElementById("project_name"      + count).value     = project_name;  // 부모창에 우편번호 값입력
					
					self.close();  // 팝업창 닫기
				}
			</script>
		</head>
    <body>
	 
    <div class="container">

	             <table class="table table-bordered">
						    <form role="form" class="form-horizontal" name="signup_form" method="post" action="./responsive_code_search_main.php">
                            <tbody>
				            <tr class="">
							<td class="">
                            *
                            </td>
                            <td>
                               프로젝트명
                            </td>
                            <td class="">
							<input type="text" class="form-control" placeholder="" name="searchNm" >
							</td>
                                  <td class=""> <button type="submit" name = usercheck value = 0 class = "btn1">검색</button></td>
                            </tr>
							</tbody>
                            </form>                        
				 </table>
	             <table class="table table-inbox table-hover table-bordered" id = 'worker_time_tb'>
                        <thead>
							<th>순서                  </th>
							<th>프로젝트명               </th>
							<th>job_코드 명            </th>
							<th>코드명                 </th>
							<th>등록자                 </th>
							<th>첫 등록일               </th>
				        </thead>
                        <tbody>
						<?php
							include_once ('./config.php');
							//$uname = $_SESSION['uname'];
							//검색 데이터 받기
							//$searchNm  = $_POST['searchNm'];
							// 값이 없을때 문제 해결해서 처리
							$num = 1;
							$searchNm = (isset($_POST["searchNm"]) && $_POST["searchNm"]) ? $_POST["searchNm"] : NULL; 
							
							//$searchNm = iconv("CP949", "UTF-8//TRANSLIT", $searchNm);
						    //WHERE worker_pone_number ="."'".$worker_pone_number."' and worker_attend_day ="."'".$date."'";
							//$str = "에너지";
							
							$str = iconv("UTF-8", "EUC-KR",$searchNm);
							
							
							$date = date('Y-m-d');
							$con = sqlsrv_connect($serverName, $connectionInfo);
								
										$sql     = "SELECT 
												a.project_name,
												a.project_code,
												a.project_job_code,
												a.regi_date,
												b.admin_id
												from project_registration_info as a left outer join admin_info as b on a.admin_id = b.admin_id
												WHERE a.project_name like '%". $str . "%' and project_state = 1 ";
							// 확인용
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
							 $admin_id          = $row['admin_id'];
							 $regi_date         = $row['regi_date']  ->format('Y-m-d');
							
							$project_job_code         = iconv("CP949", "UTF-8//TRANSLIT", $project_job_code);
							$project_code         = iconv("CP949", "UTF-8//TRANSLIT", $project_code);
							
							 $project_name         = iconv("CP949", "UTF-8//TRANSLIT", $project_name);
							 //$project_code         = iconv("CP949", "UTF-8//TRANSLIT", $project_code);
							 //$project_job_code     = iconv("CP949", "UTF-8//TRANSLIT", $project_job_code);
							 $admin_id             = iconv("CP949", "UTF-8//TRANSLIT", $admin_id);
							 
							 
							?>
						
                            <tr class="">
								<td class=""><?=$num++?> </td>
								<td class=""><a href='javascript:moveCode("<?=$project_job_code?>","<?=$project_code?>","<?=$project_name?>")' class="btn btn-compose"><?= $project_name?></a></td>
								<td class=""><?=$project_job_code?></a></td>
								<td class=""><?= $project_code?></a></td>
                                <td class=""><?= $admin_id?></a></td>
                                <td class=""><?= $regi_date?></a></td>								
                            </tr>
							
							<?php
							       }
							?>
                            </tbody>
                    </table> 
		     </div>

</body>
</html>