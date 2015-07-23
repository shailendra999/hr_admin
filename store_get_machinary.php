<?
include_once("inc/dbconnection.php");
?>
<select name="machinary_id" id="machinary_id" style="width:145px;height:20px">
	<option value="0"></option>
	<?
  $machinary_id = '';
  $sql_M= "select * from ms_machinary where department_id=$_REQUEST[id]";
  $res_M = mysql_query ($sql_M) or die ("Invalid query : ".$sql_M."<br>".mysql_errno()." : ".mysql_error());
  if(mysql_num_rows($res_M)>0)
  {
		while($row_M = mysql_fetch_array($res_M))
		{
		?>
			<option value="<?= $row_M['machinary_id'] ?>" ><?= $row_M['name'] ?></option>
		<?
		}
  }	
  ?>		
</select>