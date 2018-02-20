 <!-- 로그인 여부 확인 -->
<?php

     session_destroy();
     //세션 값 확인하기				
	if(!isset($_SESSION['uname']) ) {
        echo "<script>alert(\"로그아웃 하셨습니다.\"); location.href='responsive_main_login.php';</script>";
            
	     } 

			
?>




