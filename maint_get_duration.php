<? include ("inc/dbconnection.php");?>
<?
$id="";
$id = $_REQUEST['id'];$idno = $_REQUEST['id_no'];
$sql = "SELECT * FROM  maint_services where s_code = '$id' order by name ";
$res = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
$duration=0;
if(mysql_num_rows($res)>0)
{
	$row = mysql_fetch_array($res);
	$duration= $row['duration'];
}
?> 
<input type="text" readonly="readonly" id="duration_<?= $idno?>" name="duration_<?= $idno?>"  value="<?=$duration?>"/>