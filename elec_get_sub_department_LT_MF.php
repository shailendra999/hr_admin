<?
include_once("inc/dbconnection.php");
$sql_mach= "select * from elec_sub_department where department_id=$_REQUEST[id] and sub_department_id NOT IN (select sub_department_id  from elec_LT_MF)  order by name asc";
$res_mach = mysql_query ($sql_mach) or die ("Invalid query : ".$sql_mach."<br>".mysql_errno()." : ".mysql_error());
//echo mysql_num_rows($res_mach);$sql_mach= "select * from elec_sub_department esd,elec_LT_MF eLM where esd.department_id=$_REQUEST[id] and eLM.sub_department_id NOT IN elm.sub_department_id order by name asc";
?>
	
<select name="sub_department_id" id="sub_department_id" style="width:150px;height:20px">
	<option value="0"></option>
<?
	$machine_id = '';	
  if(mysql_num_rows($res_mach)>0)
  {
  	while($row_machine = mysql_fetch_array($res_mach))
    {
    ?>
    	<option value="<?=$row_machine['sub_department_id'] ?>" ><?= $row_machine['name']?></option>
    <?
    }
  }	
?>		
</select>