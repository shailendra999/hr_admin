<? include ("inc/dbconnection.php");?>
<?
$id="";
$id = $_REQUEST['id'];$idno = $_REQUEST['id_no'];
$sql = "SELECT * FROM  maint_services where s_code = '$id' order by name ";
$res = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
$dt='';
if(mysql_num_rows($res)>0)
{
	$row = mysql_fetch_array($res);
	if($row['duration_type']=="M")
		$dt= "Month(s)";
	if($row['duration_type']=="D")
		$dt ="Day(s)";
}
?> 
<input type="text" readonly="readonly" id="duration_type_<?= $idno?>" name="duration_type_<?= $idno?>"  value="<?=$dt?>"/>