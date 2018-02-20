<HTML>
<HEAD>
    <TITLE>출퇴근부</TITLE>
    <meta charset="utf-8">
</HEAD>
<BODY>
<hr />
<form name="login_form" method="post" action="./login_check.php">
    ID : <input type="text" name="user_id" /><br>
    PW : <input type="password" name="user_pass" /><br>
    <input type="submit" value="로그인" /><br>
    <input type=radio name=state value=1>IN
    <input type=radio name=state value=0>OUT
    <input type=checkbox name=user_check value=1>관리자<br>
</form>
<a href="signup.php">회원가입</a>
</BODY>
</HTML>