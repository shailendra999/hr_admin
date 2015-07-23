<? include ("inc/dbconnection.php");?>
<?
$id	=	"";
$id = 	$_GET["id"];

$sql = "SELECT * FROM  mpc_department_master where reference_id = '$id' order by department_name";
$result_city = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
//if(mysql_num_rows($result_city)>0)
//{
?>
	<select name="<?=$_GET["str"]?>" id="<?=$_GET["str"]?>">
        	<option value="">--Select--</option>
<?
if(mysql_num_rows($result_city)>0)
{
	if($id!="")
	{
	while($row_city = mysql_fetch_array($result_city))
	{
?> 
      		<option value="<?=$row_city['rec_id']?>"><?=$row_city['department_name']?></option>
<?
	}
	}
	}
?>
	</select>
<?    	

?>
          			