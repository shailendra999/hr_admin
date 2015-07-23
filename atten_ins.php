<?php
include ("inc/hr_header.php"); 
if(isset($_POST['submite']))
{
	echo $id=$_POST['idd'];
	echo $attendance=$_POST['attendace'];
	echo "heloo".$id=explode(',',$attendance);
	echo "what up".$a=explode(',',$id)."<br>";
	$que=mysql_query("select * from mpc_attendance");
	while($a=mysql_fetch_row($que))
	{
		echo "<pre>";
		print_r($a);
	}

	include ("inc/hr_footer.php"); 
}
?>