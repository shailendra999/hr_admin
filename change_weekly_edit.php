<? include ("inc/dbconnection.php");?>
<?
if(isset($_GET["id"]))
{
	$weekly_off = $_GET["id"];
	$emp_id = $_GET["str"];
}

$sql_check1 = "update ".$mysql_table_prefix."weekly_off_employee set	
																to_date  =now()
																where emp_id='$emp_id' and to_date ='0000-00-00'";
																
$result_check1=mysql_query($sql_check1) or die ("Query Failed ".mysql_error());

$sql_check = "insert into  ".$mysql_table_prefix."weekly_off_employee set	
																emp_id  ='$emp_id',
																off_day ='$weekly_off',
																from_date =now(),
																to_date ='0000-00-00'";
																
$result_check=mysql_query($sql_check) or die ("Query Failed ".mysql_error());
echo $weekly_off;
?>