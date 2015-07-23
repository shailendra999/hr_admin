<? include ("inc/dbconnection.php");?>
<?
$id="";
$id = $_REQUEST['item_name'];
$sql = "SELECT * FROM  ms_item_master where item_id = '$id' order by name ";
$result_item = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
if(mysql_num_rows($result_item)>0)
{
	while($row_item = mysql_fetch_array($result_item))
		{
			$sql_dept = "SELECT * FROM  ms_department where department_id = '".$row_item['department_id']."' order by name ";
			$result_dept = mysql_query ($sql_dept) or die ("Error in : ".$sql_dept."<br>".mysql_errno()." : ".mysql_error());
			if(mysql_num_rows($result_dept)>0)
			{
				while($row_dept = mysql_fetch_array($result_dept))
					{
						echo $row_dept['name'];
					}
			}
			
		}
}
?> 