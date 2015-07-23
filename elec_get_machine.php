<?
include_once("inc/dbconnection.php");
$sql_mach= "select * from elec_machine where department_id=$_REQUEST[id] order by name asc";
$res_mach = mysql_query ($sql_mach) or die ("Invalid query : ".$sql_mach."<br>".mysql_errno()." : ".mysql_error());
//echo mysql_num_rows($res_mach);
?>
	
<select name="machine_id" id="machine_id" style="width:150px;height:20px">
	<option value="0"></option>
<?
	$machine_id = '';	
  if(mysql_num_rows($res_mach)>0)
  {
  	while($row_machine = mysql_fetch_array($res_mach))
    {
    ?>
    	<option value="<?=$row_machine['machine_id'] ?>" ><?= $row_machine['name']?></option>
    <?
    }
  }	
?>		
</select>