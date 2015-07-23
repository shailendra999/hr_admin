<?
include("inc/check_session.php"); 
include ("inc/dbconnection.php");?>
<?
$id="";
$id = $_GET["id"];
$sql = "select * from ".$mysql_adm_table_prefix."count_master where ProductId = '$id'";
$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
if(mysql_num_rows($result)>0)
{

?>    
<select name="<?=$_GET["str"]?>" id="<?=$_GET["str"]?>" style="width:150px;">
		<option value="">--select--</option>
		<? 
		while ($row=mysql_fetch_array($result))
		{
		?>
		<option value="<?=$row['rec_id']?>">
		<?=$row["Count"]?>
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
	no record found
	
<?
}
	
?>		