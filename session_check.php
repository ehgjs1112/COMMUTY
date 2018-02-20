<!DOCTYPE html>

<!-- 로그인 여부 확인 -->
<?php

session_start(); 
   		    //세션 값 확인하기

			
			
			if(!isset($_SESSION['uname']) ) {
                
				echo "<script>alert(\"로그인을 해주세요.\"); location.href='responsive_main_login.html';</script>";
            } 

			
?>

