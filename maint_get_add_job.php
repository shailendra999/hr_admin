<?
include("inc/dbconnection.php");
include("inc/common_function_mt_elect.php");
$job_code=$_REQUEST['job_code'];
$status='';$sname='';$mname='';$department_id='';$schedule_date='';$attend_date='';$remark='';
if($job_code!='')
{
	$today=date("Y-m-d");
	$sql_job="select * from maint_job where job_code='".$job_code."' and schedule_date<='".$today."' and status='P'";
	$result=mysql_query($sql_job);
	//echo mysql_num_rows($result);
?>
<form action="<? $_SERVER['PHP_SELF'] ?>" method="post" onsubmit="if(document.getElementById('status').value!='F') return confirm('Job is Not Finished');">

<table align="left" width="100%" class="text_1" cellpadding="5" cellspacing="3" border="0" bgcolor="#EAE3E1">
  <?
	if(mysql_num_rows($result)>0)
	{
		$row=mysql_fetch_array($result);
		$status=$row['status'];$machine_id=$row['machine_id'];$service_id=$row['service_id'];
		$schedule_date=getdateFormate($row['schedule_date']);$attend_date=date('d-m-Y');$remark=$row['remark'];
	?>
    <tr>
      <td align="left"><b>Job Code</b></td>
      <td align="left"><input type="text" readonly="readonly" style="width:100px" id="job_code" name="job_code" value="<?=$job_code?>"/></td>
      <td align="left"><b>Status</b></td>
      <td align="left">
        <select id="status" name="status">
          <option value="P" <? if($status=='P'){?> selected="selected"<? }?>>Pending</option>
          <option value="F" <? if($status=='F'){?> selected="selected"<? }?>>Finished</option>
          <option value="C" <? if($status=='C'){?> selected="selected"<? }?>>Cancelled</option>
        </select>
      </td>
    </tr>
    <tr>
      <td align="left"><b>Machine</b></td>
      <td align="left">
      	<?
         	$sql_M = "select mmm.name from maint_machine_master mmm,maint_job mj where mmm.machine_code= '".$row['machine_id']."' and mj.job_code='".$row['job_code']."'";
          $res_M = mysql_query($sql_M) or die ("Invalid query : ".$sql_M."<br>".mysql_errno().":".mysql_error());
          $row_M = mysql_fetch_array($res_M);
          echo $row_M['name'];
        ?>
      </td>
      <td align="left"><b>Department</b></td>
      <td align="left">
      	<?
         $sql_dep = "select md.name from maint_department md,maint_machine_master mmm,maint_job mj where mmm.department_code =md.department_code and mmm.machine_code= '".$row['machine_id']."' and mj.job_code='".$row['job_code']."'";
          $res_dep = mysql_query($sql_dep) or die ("Invalid query : ".$sql_dep."<br>".mysql_errno().":".mysql_error());
          $row_dep = mysql_fetch_array($res_dep);
          echo $row_dep['name'];
        ?>	
      </td>
    </tr>
    <tr>
      <td align="left"><b>Service</b></td>
      <td align="left">
      	<?
         	$sql_S = "select ms.name,ms.duration,ms.duration_type from maint_services ms,maint_job mj where ms.s_code =mj.service_id and mj.job_code='".$row['job_code']."'";
          $res_S = mysql_query($sql_S) or die ("Invalid query : ".$sql_S."<br>".mysql_errno().":".mysql_error());
          $row_S = mysql_fetch_array($res_S);
          echo $row_S['name'];
        ?>
      </td>
      <td align="left"><b>Duration</b></td>
      <td align="left">
      	<?
				$dt='';
          if($row_S['duration_type']=="M")
						$dt='Month(s)';
					if($row_S['duration_type']=="D")
						$dt='Day(s)';
					echo $row_S['duration'].' '.$dt;
					$duration=$row_S['duration'];
					$duration_type=$row_S['duration_type'];
        ?>
      </td>
    </tr>
    <tr>
      <td align="left"><b>Schedule Date</b></td>
      <td align="left"><?=$schedule_date?>
      </td>
      <td align="left"><b>Attend Date</b></td>
      <td align="left">
      	<input type="text" id="attend_date" name="attend_date" value="<?=$attend_date?>" />
        <a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.getElementById('attend_date'));return false;" HIDEFOCUS>
          <img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
        </a> 
      </td>
    </tr>
    <tr>
      <td align="left"><b>Remark</b></td>
      <td align="left" colspan="3"><textarea id="remark" name="remark" rows="3" cols="35"><?=$remark?></textarea></td>
    </tr>
    <tr>
    	<td align="center" colspan="4">
        <input type="hidden" id="machine_id" name="machine_id" value="<?=$machine_id?>"/>
        <input type="hidden" id="service_id" name="service_id" value="<?=$service_id?>"/>
        <input type="hidden" id="schedule_date" name="schedule_date" value="<?=$row['schedule_date']?>"/>
        <input type="hidden" id="maint_date" name="maint_date" value="<?=$row['maint_date']?>"/>
        <input type="hidden" id="duration" name="duration" value="<?=$duration?>"/>
        <input type="hidden" id="duration_type" name="duration_type" value="<?=$duration_type?>"/>
        <input type="submit" name="btn_submit" id="btn_submit" value="Save" />
      </td>
    </tr>
  <?
	}
	else
	{
		?>
    <tr>
      <td align="center" colspan="4"><b>No Record Found or Job is already Done or Schedule Date Not Came.</b></td>      
    </tr>
    <?
	}
  ?>
</table>
</form>
<?
}
else
{
?>
<table align="left" width="100%" class="text_1" cellpadding="0" cellspacing="0" border="0" bgcolor="#EAE3E1">
  <tr>
    <td align="center" style="color:#FF0000;text-decoration:blink"><b>Enter Job Code</b></td>
  </tr>
  
</table>          
<?
}
?>
<iframe width=168 height=190 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="calendar/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
</iframe>