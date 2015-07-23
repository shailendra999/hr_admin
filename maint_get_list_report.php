<?
include("inc/dbconnection.php");
include("inc/common_function_mt_elect.php");
if(isset($_REQUEST['value']))
{
	$val=$_REQUEST['value'];
}
else
	$val='';
$ScheduleDate='';
$Department='';
$Pending='';
$Finished='';
if($val!='')
{
	$val=explode(',',$val);
	$val1=getDateFormate($val[2]);$val2=getDateFormate($val[3]);
	$ScheduleDate="(mj.schedule_date BETWEEN '".$val1."' AND '".$val2."')";
	if($val[1]=='All')
	{
		if($val[0]!='')
			$Department=" and mmm.department_code='".$val[0]."'";
	}
	if($val[1]=='Pending')
	{
		$Pending=" and mj.status='P'";
		if($val[0]!='')
			$Department=" and mmm.department_code='".$val[0]."'";
	}
	if($val[1]=='Finished')
	{
		$Finished=" and mj.status='F'";
		if($val[0]!='')
			$Department=" and mmm.department_code='".$val[0]."'";
	}
}


/*{
	if($val[0]=='0')
		$sql="select * from maint_job mj where (mj.schedule_date >='".$val1."' and mj.schedule_date <='".$val2."') order by mj.schedule_date asc";
	else
		$sql="select * from maint_job mj,maint_machine_master mmm where (mj.schedule_date >='".$val1."' and mj.schedule_date <='".$val2."') and mmm.department_code='".$val[0]."' and mmm.machine_id=mj.machine_id order by mj.schedule_date asc";
}
else if($val[1]=='Pending')
{
	if($val[0]=='0')
		$sql="select * from maint_job mj where (mj.schedule_date >='".$val1."' and mj.schedule_date <='".$val2."') and mj.status='P' order by mj.schedule_date asc";
	else
		$sql="select * from maint_job mj,maint_machine_master mmm where (mj.schedule_date >='".$val1."' and mj.schedule_date <='".$val2."') and mmm.department_code='".$val[0]."' and mmm.machine_id=mj.machine_id and mj.status='P' order by mj.schedule_date asc";
}
else if($val[1]=='Finished')
{
	if($val[0]=='0')
		$sql="select * from maint_job mj where (mj.schedule_date >='".$val1."' and mj.schedule_date <='".$val2."') and mj.status='F' order by mj.schedule_date asc";
	else
		$sql="select * from maint_job mj,maint_machine_master mmm where (mj.schedule_date >='".$val1."' and mj.schedule_date <='".$val2."') and mmm.department_code='".$val[0]."' and mmm.machine_id=mj.machine_id and mj.status='F' order by mj.schedule_date asc";
}
*/
$sql="select * from maint_job mj,maint_machine_master mmm where 
$ScheduleDate
$Department
$Pending
$Finished
and mmm.machine_code=mj.machine_id order by mj.schedule_date asc";

$result=mysql_query($sql) or die("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
$sum=0;

?> 
<div class="AddMore" style="padding-top:10px">
	<form action="maint_print_report_job.php" name="test" id="test" method="post" target="_blank"> 
    <input type="hidden" name="value" id="value" value="<?=$_REQUEST['value'] ?>" />
    <a href="#" onclick="test.submit();">Print&nbsp;&nbsp;&nbsp;</a>
 	</form>
</div> 
<table id="tableItems" align="center" width="100%" border="1" class="table1 text_1">
	<tr>
    <td class="gredBg">S.No.</td>
    <td class="gredBg">Job Code</td>
    <td class="gredBg">Department</td>
    <td class="gredBg">Machine</td>
    <td class="gredBg">Service</td>
    <td class="gredBg">Sch.Date</td>
    <td class="gredBg">Done Date</td>
  </tr>
	 <?  
		if(mysql_num_rows($result)>0)
		{
			$sno = 1;
			while($row=mysql_fetch_array($result))
			{	
			
			?>
			<tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
        <td align="center" valign="top"><?=$sno?></td>
        <td align="center" valign="top"><?=$row['job_code']?></td>
        <td align="left" style="padding-left:3px" valign="top">
        <?
				//if($val[0]!='0')
          $sql_dep = "select name from maint_department where department_code ='".$row['department_code']."'";
				//else
					//echo $sql_dep = "select md.name from maint_department md,maint_machine_master mmm,maint_job mj where mmm.department_code =md.department_code and mmm.machine_code= '".$row['machine_id']."' and mj.job_code='".$row['job_code']."' and md.deparment_code=$val[0]";
          $res_dep = mysql_query($sql_dep) or die ("Invalid query : ".$sql_dep."<br>".mysql_errno().":".mysql_error());
          $row_dep = mysql_fetch_array($res_dep);
          echo $row_dep['name'];
        ?>	
        </td>
        <td align="left" style="padding-left:3px" valign="top">
				<?
         	$sql_M = "select mmm.machine_code,mmm.name from maint_machine_master mmm,maint_job mj where mj.job_code='".$row['job_code']."' and mmm.machine_code=mj.machine_id";
          $res_M = mysql_query($sql_M) or die ("Invalid query : ".$sql_M."<br>".mysql_errno().":".mysql_error());
          $row_M = mysql_fetch_array($res_M);
          echo $row_M['machine_code'].' : '.$row_M['name'];
        ?>
        </td>
        <td align="left" style="padding-left:3px" valign="top">
        <?
        	$i=1;
					/*$sql_S = "SELECT ms.name, ms.s_code,ms.duration,ms.duration_type FROM maint_services ms,maint_machine_transaction mmt, maint_job mj 
					WHERE ms.s_code = mmt.service_id AND mmt.machine_id='".$row['machine_id']."' AND mj.job_code = '".$row['job_code']."'";*/
         $sql_S = "select ms.s_code,ms.name,ms.duration,ms.duration_type,ms.work_to_do from maint_services ms,maint_job mj where ms.s_code =mj.service_id and mj.job_code='".$row['job_code']."'";
          $res_S = mysql_query($sql_S) or die ("Invalid query : ".$sql_S."<br>".mysql_errno().":".mysql_error());
          while($row_S = mysql_fetch_array($res_S))
					{
						$dt='';
						if($row_S['duration_type']=="M")
							$dt='Months';
						else
							$dt='Days';
          	echo $row_S['s_code']." : ".$row_S['name'].'  <b>'.$row_S['duration'].' '.$dt."</b><br />";
						$work_to_do= $row_S['work_to_do'];
						$wtd=explode("\n",$work_to_do);
						foreach($wtd as $str)
						{
							if(trim($str)!='')	
							{	
								echo $str;
								if(count($wtd)>1)
									echo '<br />';
							}
						}
					}
						
        ?>
        </td>
        <td align="center" valign="top"><b><?=getDateFormate($row['schedule_date'])?></b></td>
        <td align="center" valign="top"><?=getDateFormate($row['attend_date'])?></td>
			</tr>
			<?
			$sno++;
			}	
		}
		else
		{
		?>
		<tr>
			<td colspan="6" align="center" style="font-weight:bold">No Records Found</td>
		</tr>
		<?
		}
		?>        
</table>