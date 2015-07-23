<? include ("inc/dbconnection.php");?>
<?
$id="";
$id = $_GET["id"];
$sql = "SELECT * FROM  ".$mysql_adm_table_prefix."product_master where CategoryId = '$id' order by ProductName";
$result_prd = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
if(mysql_num_rows($result_prd)>0)
{
?>
	<select name="<?=$_GET["str"]?>" id="<?=$_GET["str"]?>">
        	<option value="">--Select--</option>
<?
	while($row_prd = mysql_fetch_array($result_prd))
	{
?> 
      		<option value="<?=$row_prd['rec_id']?>"><?=$row_prd['ProductName']?></option>
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
          			