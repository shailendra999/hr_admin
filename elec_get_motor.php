<?
include_once("inc/dbconnection.php");
$val=explode(',',$_REQUEST['id']);
$deptid=$val[0];$machid=$val[1];
$sql_motor= "select * from elec_motor where department_id=$deptid and machine_id=$machid order by name asc";
 
$res_motor = mysql_query ($sql_motor) or die (mysql_error());
//echo mysql_num_rows($res_mach);
?>
<select name="motor_id" id="motor_id" style="width:150px;height:20px">
	<option value="0"></option>
<?
	$motor_id = '';	
  if(mysql_num_rows($res_motor)>0)
  {
  	while($row_motor = mysql_fetch_array($res_motor))
    {
    ?>
    	<option value="<?=$row_motor['motor_id'] ?>" ><?= $row_motor['name']?></option>
    <?
    }
  }	
?>		
</select>