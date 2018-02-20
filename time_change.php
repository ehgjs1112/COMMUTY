<html>
<head>
<title>임시 출근 수정 창입니다.</title>
</head>
<body>
	<?php 	
		$mode = $_GET['mode'];
		$ID = $_GET['ID'];
		$date = $_GET['DATE'];
		$time = $_GET['time'];
		
		
		$hour = (int)substr($time,0,2);
		$min = (int)substr($time,3,2);

	?>
	<form role="form" class="form-horizontal" name="signup_form" method="post" action="main_controller.php?mode=ch_time&chan_mode=<?=$mode?>&ID=<?=$ID?>&date=<?=$date?>">
		<table>
			<thead>
				<th></th>
				<th></th>
			</thead>
			<tr>
				<td>시간
				<td><INPUT TYPE = "TEXT" maxlength='2' NAME = "hour" SIZE = "2" VALUE = "<?=$hour?>">
					: 
					<INPUT TYPE = "TEXT" maxlength='2' NAME = "min" SIZE = "2" VALUE = "<?=$min?>">
			<tr>
				<td>비고
				<td><INPUT TYPE = "TEXT" maxlength='100'>
			<tr>
				<td>
				<td><input type="submit" value="확인"/>
		</table>
	</form>						
</body>
</html>