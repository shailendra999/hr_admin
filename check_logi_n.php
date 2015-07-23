<?
include("inc/dbconnection.php");
	include("inc/function.php");
$data ='';
if(isset($_GET['id']))
{
$id=$_GET['id'];
$sql_user = "SELECT * FROM  ".$mysql_table_prefix."employee_master Where ticket_no='$id' ";
$result_user = mysql_query ($sql_user) or die ("Invalid query : " . mysql_error().$sql_user);
	 if(mysql_num_rows($result_user)>0)
	  {
	  $data .='0';	
	  }
	  else
	  	{
			$data .='1';
		}
}
echo $data;
?>