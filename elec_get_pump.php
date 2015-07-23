<?
include_once("inc/dbconnection.php");
?>
<select name="plant_transaction_id" id="plant_transaction_id" style="width:150px">
   <?php
	$plant_transaction_id = '';
	$sql= "select * from elec_plant_transaction where plant_id='".$_REQUEST['plant_id']."'";
	$res = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	//mysql_num_rows($res);
  if(mysql_num_rows($res)>0)
	{
		while($row = mysql_fetch_array($res))
		{
		?>
			<option value="<?= $row['plant_transaction_id']?>"><?= $row['name'] ?></option>
		<?
		 }
	}	
    ?>		
</select>