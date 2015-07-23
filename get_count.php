<? include ("inc/dbconnection.php");?>
<?
$id="";
$id = $_GET["id"];
$sql_count = "SELECT * FROM  ".$mysql_adm_table_prefix."count_master where ProductId = '$id' order by Count ";
$result_count = mysql_query ($sql_count) or die ("Error in : ".$sql_count."<br>".mysql_errno()." : ".mysql_error());
if(mysql_num_rows($result_count)>0)
{
?>
	<select name="<?=$_GET["str"]?>" id="<?=$_GET["str"]?>" style="width:100px;">
        	<option value="">--Select--</option>
<?
	while($row_count = mysql_fetch_array($result_count))
	{
?> 
      		<option value="<?=$row_count['rec_id']?>"><?=$row_count['Count']?></option>
<?
	}
?>
	</select>
<?    	
}
?>         			