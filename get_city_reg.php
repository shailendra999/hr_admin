<? include ("inc/dbconnection.php");?>
<? 
$id="";
$id = $_GET["id"];
$sql = "SELECT * FROM mpc_city_master where state_id = '$id ' order by city_name";
$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
if((mysql_num_rows($result)>0) or ($id=='99'))
{
?>
<select name="<?=$_GET["str"]?>" id="<?=$_GET["str"]?>">
<option value="">--select city--</option>
<? 
while ($row=mysql_fetch_array($result))
{
?>
<option value="<?=$row['rec_id']?>">
<?=$row["city_name"]?>
</option>
<?
}
?>
</select>
<?
}
else
{
?>
	<input type="text" name="other_city" id="other_city" value="">	
<?
}
	
?>																				