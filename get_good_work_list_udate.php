<? include ("inc/dbconnection.php");?>
<? include ("inc/function.php");?>
<?
$id="";
$add_div = "";
$hidden_value = "";
$id = $_GET["id"];
$type = $_GET["type"];
$date = $_GET["str"];
$shift= $_GET["shift"];
?>
<?
if(isset($_GET['start']))
{
	if($_GET['start']=='All')
	{
		$start = 0;
	}
	else
	{
		$start = $_GET['start'];
	}
}
else
{
	$start = 0;
}	
$sql = "SELECT emp_id,good_work FROM mpc_good_work_master  where  date='$date' and emp_id='$id'";
$result_doc = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
if(mysql_num_rows($result_doc)>0)
{
	$row_update = mysql_fetch_array($result_doc);
	$good_work=$row_update['good_work'];
}

$sql = "SELECT mpc_employee_master.last_name,mpc_employee_master.first_name,mpc_employee_master.emp_id,mpc_employee_master.  	ticket_no FROM mpc_employee_master where mpc_employee_master.emp_id  and mpc_employee_master.rec_id = '$id'";

$query_count = "select count(*) as count from ".$mysql_adm_table_prefix."document_master where DocumentFor = '$id'";

$result_doc = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
$query_count = $query_count;
$result_q= mysql_query($query_count);
$row_count = mysql_fetch_array($result_q);
$numrows = $row_count['count'];
$count = ceil($numrows/$row_limit);
if(mysql_num_rows($result_doc)>0)
{
	$sno = 1;
?>
<table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
    <tr class="navigation_row">
        <td class="headingSmall">
            <div style="margin:1px;text-align:left;" >
               Update Employee Attendance
            </div>
        </td>   
    </tr>
</table> 
<div> 
    <table align="center" width="100%" border="0" class="border">
        <tr class="blackHead">
            <td width="6%" align="center">S.No.</td>
            <td width="7%" align="center">Emp no.</td>
            <td width="21%" align="center">Employee Name</td>
            <td width="19%" align="center">Good Work</td>
      </tr>
<?
	while($row_doc = mysql_fetch_array($result_doc))
	{
?>
		<tr <? if ($sno%2==1) { ?> bgcolor="#F8F8F8" <? } ?> class="tableTxt">
            <td align="center"><?=$sno?></td>
            <td align="center"><?=$row_doc['ticket_no']?></td>
            <td align="center"><?=$row_doc['first_name']?>-<?=$row_doc['last_name']?></td>
            <td>
          <select name="good_work" id="good_work" onkeydown="if (event.keyCode == 13) get_frm_attendence('get_employee_good_work_update.php','<?=$date?>','div_employee_last','<?=$id?>',this.value,'<?=$type?>','<?=$shift?>')">
               		<?
						if($shift=='G')
			  				{
								$hour=18;
							}
			  				else
							{
								$hour=8;
							}
						$j=0;
						for($i=0;$i<$hour;)
						{
							if($j==60)
							{
								$i++;
								$j=0;
							}
							
					?>
                	<option value="<?=$i.':'.$j?>" <? if($good_work==($i.':'.$j)){ echo 'selected="selected"';}?>><?=$i.':'.$j?></option>
					<?
						$j=$j+30;
						}
					?>
               </select>
               </td>
        </tr>
<?
	 $sno++;
	}
?>       
 <input type="hidden" id="count_row" name="count_row" value="<?=mysql_num_rows($result_doc)?>"/> 
 <tr bgcolor="#F8F8F8">
    <td colspan="8" align="center">
        <input type="button" src="images/btn_submit.png" name="btn_attend" id="btn_attend" value="Submit" onclick="get_frm_attendence('get_employee_good_work_update.php','<?=$date?>','div_employee_last','<?=$id?>',document.getElementById('good_work').value,'<?=$type?>','<?=$shift?>')"/>
    </td>
</tr>    	    
</table>
</div>
<?    	
}
else
{
?>
	<div align="center">no record found</div>	
<?
}	
?>	
          			