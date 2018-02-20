<?php
    $serverName = "localhost";
    $uid ="sa";
    $pwd = "ms-sql!234";
    $connectionInfo = array("UID"=>$uid,"PWD"=>$pwd,"DATABASE"=>"COMMUTY");
/* @var $uname type */
	
	function timeformat($time_min){	
		echo "timeformat".$time_min."<br>";
		$time_hour = floor($time_min/60);
		echo "timeformat".$time_hour."<br>";
		if($time_hour < 1) $time_hour = 0;
		$time_min = (int)$time_min%60;
		echo "timeformat".$time_min."<br>";
		$time_format = "'".$time_hour.":".$time_min."'";
		return $time_format;
	}
	
	function time_to_min($time_format){
		if(strcmp($time_format,"NULL")==0){ 
			$time_min = 0;
			return $time_min;
		}
		ECHO "time_format:".$time_format;
		
		$time_format = substr($time_format,1,-1);
		echo "time_format:".$time_format;
		$times = array();
		$times = explode(':',$time_format);
		echo "times1:".(int)$times[0];
		echo "times2:".(int)$times[1];
		
		if(isset($times[0])=== TRUE){
			echo "success"."<br>";
			$time_min = (int)$times[0]*60 + (int)$times[1];}
		else $time_min = $times[0];
		unset($times);
		return $time_min;
	}
	
	function attend_cut($time_min){
		echo "<br>"."1attend_cut".$time_min."<br>";
		if(($time_min % 60)>0){
			$attend_hour = floor($time_min / 60 )+ 1;
		}
		else $attend_hour = floor($time_min / 60);
		$attend_hour = $attend_hour * 60;
		return $attend_hour;
	}
	function finish_cut($time_min){
		echo "<br>"."2finish_cut".$time_min."<br>";
		$finish_hour = floor($time_min / 60);
		$finish_hour = $finish_hour * 60;
		return $finish_hour;
	}
	
	function get_ba_total_time($worker_attend_min, $worker_finish_min){
		$worker_attend_cut = attend_cut($worker_attend_min);
		if($worker_attend_cut <= 540)$worker_attend_cut = 540;//9시 전 출근은 무조건 9시로 
		if($worker_attend_cut < 720){//12시전 출근
			$worker_finish_cut = finish_cut($worker_finish_min);
			if($worker_finish_cut < 720){ 
			$only_ba_total = $worker_finish_min - $worker_attend_cut;
			$only_ba_total = timeformat($only_ba_total);}
			if($worker_finish_cut >= 780){ 
			$only_ba_total = $worker_finish_min - $worker_attend_cut - 60;
			$only_ba_total = timeformat($only_ba_total);}
		}else{//1시 이후 
			$only_ba_total = $worker_finish_min - $worker_attend_cut; 
			$only_ba_total = timeformat($only_ba_total);}
		return $only_ba_total;
	}
	function get_ot_total_time($worker_attend_ot_min, $worker_finish_ot_min){
		echo "worker_attend:".$worker_attend_ot_min."<br>";
		echo "worker_finish:".$worker_finish_ot_min."<br>";
		$worker_attend_ot_cut = attend_cut($worker_attend_ot_min);
		if($worker_finish_ot_min  < 300){
			$worker_finish_ot_min = $worker_finish_ot_min + 1440;
			$worker_finish_ot_cut = finish_cut($worker_finish_ot_min);
			$only_ot_total = $worker_finish_ot_cut - $worker_attend_ot_cut;
		}else{
			$worker_finish_ot_cut = finish_cut($worker_finish_ot_min);
			$only_ot_total = $worker_finish_ot_cut - $worker_attend_ot_cut;}
		$only_ot_total = timeformat($only_ot_total);
		return $only_ot_total;
	}
?>