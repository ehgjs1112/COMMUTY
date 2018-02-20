<html>
<head>
<title>임시 출근 수정 창입니다.</title>
</head>
<body>
	<?php 
		include_once ('./config.php');
		$con = sqlsrv_connect($serverName, $connectionInfo);
		$ID = $_GET['ID'];
		$sql = "select 
			distinct
			worker_nm, 
			worker_address, 
			bank_name, 
			bank_account, 
			woker_jumin,
			worker_type,
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
		$result = sqlsrv_query($con, $sql);
		$row = sqlsrv_fetch_array($result,SQLSRV_FETCH_ASSOC);
		$row['worker_nm'] = iconv("CP949", "UTF-8//TRANSLIT", $row['worker_nm']);
		$row['bank_name'] = iconv("CP949", "UTF-8//TRANSLIT", $row['bank_name']);
		$row['worker_address'] = iconv("CP949", "UTF-8//TRANSLIT", $row['worker_address']);
	?>
	<form role="form" class="form-horizontal" name="signup_form" method="post" action="change_user_set.php?ID=<?= $ID?>">
		<div class="form-group">
			<table align = "center">
				<tr>
					<td>이름 
					<td><input type="text" name="uname" value = "<?=$row['worker_nm']?>"/></td>
				<tr>
					<td>주소
					<td><input type="text" name="actual_adress" value = "<?=$row['worker_address']?>"/></td>
				<tr>
					<td>은행 
					<td><input type="text" name="bank_name" value = "<?=$row['bank_name']?>"/></td>
				<tr>
					<td>은행 계좌번호
					<td><input type="text" name="bankaccount" value = "<?=$row['bank_account']?>"/></td>
				<tr>
					<td>주민등록번호 
					<td><input type="text" name="woker_jumin" value = "<?=$row['woker_jumin']?>"/></td>	
				<tr>
					<td>근로자 타입 
					<td><input type="text" name="work_type" value = "<?=$row['worker_type']?>"/></td>														
				<tr>
					<td>가입일
					<td><?=$row['join_date']?>
				<tr>
					<td>마지막 퇴근일
					<td><?=$row['worker_attend_day'] -> format('Y-m-d')?>
				<tr>
					<td><td><td><input type="submit" value="확인"/>
			</table>
		</div>
	</form>
</body>
</html>