<?php
	date_default_timezone_set("Asia/Kathmandu");
	$date=time();
	$get_time=strftime("%d-%m-%Y %H:%M:%S",$date);
	echo $get_time;
?>