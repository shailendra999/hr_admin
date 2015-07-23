<?
include_once("inc/dbconnection.php");
$whereCondition = '';
if($_REQUEST['id'] != ''){
	$whereCondition = 'where department_id='.$_REQUEST['id'];
}
$sql_mach= "select * from elec_sub_department $whereCondition order by name asc";
$res_mach = mysql_query ($sql_mach) or die ("Invalid query : ".$sql_mach."<br>".mysql_errno()." : ".mysql_error());
//echo mysql_num_rows($res_mach);
?>
<select name="sub_department_id" id="sub_department_id" style="width:150px;height:20px">
	<option value="0"></option>
<? $machine_id = '';	
if(mysql_num_rows($res_mach)>0){
  	while($row_machine = mysql_fetch_array($res_mach)){ ?>
    	<option value="<?=$row_machine['sub_department_id'] ?>" ><?= $row_machine['name']?></option>
<? }
} ?>		
</select>