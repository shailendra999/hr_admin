<?php
$con = mysql_connect("localhost","root","");
if (!$con){
	die('Could not connect: ' . mysql_error());
}
mysql_select_db("mah", $con);
$result = mysql_query("select * from ms_GRN_master");
while($row = mysql_fetch_array($result)){
echo "<br />";
echo $qury = "Update ms_GRN_master set GRN_number = '".$row['GRN_id']."' where GRN_id = '".$row['GRN_id']."'";
	mysql_query($qury);

	echo "<br />"; 	
}

/*$result = mysql_query("SELECT emp_id, emp_category FROM mpc_official_detail");
$row = mysql_fetch_array($result);
print_r($row);die;
$count = mysql_num_rows($result); 
for($i=0; $i<$count; $i++){
	echo $i."  ".$row['emp_id'];
	echo '<br />';
}
/*for($i=0; $i<)

{
	echo $row['emp_id'] . " " . $row['emp_category'];
	echo "<br />";
}*/
mysql_close($con);
?>