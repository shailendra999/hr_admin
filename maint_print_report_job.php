<?
include("inc/dbconnection.php");include("inc/common_function_mt_elect.php");
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
	if($val[0]!='')
			$Department=" and mmm.department_code='".$val[0]."'";
	if($val[1]=='Pending')
	{
		$Pending=" and mj.status='P'";
	}
	if($val[1]=='Finished')
	{
		$Finished=" and mj.status='F'";
	}
}

$sql="select * from maint_job mj,maint_machine_master mmm where 
$ScheduleDate
$Department
$Pending
$Finished
and mmm.machine_code=mj.machine_id order by mj.schedule_date asc";

$result=mysql_query($sql) or die("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());$sum=0;

?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Print Job Report</title>
<style>
.note
{
font: Arial, Helvetica, sans-serif;
font-size:13px;
font-weight:bold;
}
.particulars
{
font: Arial, Helvetica, sans-serif;
font-size:11px;
height:25px;
}
.tblborder
{
 border-collapse:collapse;border-color:1px solid #000;
}

</style>

</head>

<body onload="print();">
<div style="margin:0 auto;width:740px;">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <thead>
      <tr height="70px">
        <td align="center">
          <b><u>MAHIMA PURESPUN</u></b><br />
          <b>JOB REPORT (<u> <?=$val[1] ?> </u>)</b>
    				BETWEEN <b><?=getDateFormate($val1) ?></b> And <b><?=getDateFormate($val2)?></b>
        		<?
						//echo 'sdfsdf'.$val[0];
							if($val[0]!='')
							{
								$sql_D = "select name from maint_department where department_code ='".$val[0]."'";
								$res_D = mysql_query($sql_D) or die ("Invalid query : ".$sql_D."<br>".mysql_errno().":".mysql_error());
								$row_D = mysql_fetch_array($res_D);
								echo 'Of '.'<b><u>'.$row_D['name'].'</u></b>';
							}
							else if($val[0]=='')
							{
								echo 'Of '.'<b><u> All Department </u></b>';
							}
						?>
        </td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>
        	<table align="center" width="100%" border="1" class="tblborder">
            <tr class="note">
              <td align="center">S.No.</td>
              <td align="center">Job Code</td>
              <td align="center">Machine</td>
              <td align="center">Sch.Date</td>
              <td align="center">Service</td>
              <td align="center">Done Date</td>
            </tr>
             <?  
              if(mysql_num_rows($result)>0)
              {
                $sno = 1;
                while($row=mysql_fetch_array($result))
                {	
                ?>
                <tr class="particulars" valign="top">
                  <td align="center"><?=$sno?></td>
                  <td align="center"><?=$row['job_code']?></td>
                  <td align="left" style="padding-left:2px">
                  <?
                    $sql_M = "select mmm.name from maint_machine_master mmm,maint_job mj where mj.job_code='".$row['job_code']."' and mmm.machine_code=mj.machine_id";
                    $res_M = mysql_query($sql_M) or die ("Invalid query : ".$sql_M."<br>".mysql_errno().":".mysql_error());
                    $row_M = mysql_fetch_array($res_M);
                    echo $row_M['name'];
                  ?>
                  </td>
                  <td align="center"><?=getDateFormate($row['schedule_date'])?></td>
                  <td align="left" style="padding-left:2px">
                  <?
                  $sql_S = "select ms.name,ms.duration,ms.duration_type,ms.work_to_do from maint_services ms,maint_job mj where ms.s_code =mj.service_id and mj.job_code='".$row['job_code']."'";
                    $res_S = mysql_query($sql_S) or die ("Invalid query : ".$sql_S."<br>".mysql_errno().":".mysql_error());
										while($row_S = mysql_fetch_array($res_S))
										{
											$dt='';
											if($row_S['duration_type']=="M")
												$dt='Months';
											else
												$dt='Days';
											echo $row_S['name'].'  <b>'.$row_S['duration'].' '.$dt."</b><br />";
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
                  <td align="center">&nbsp;</td>
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
        </td>
      </tr>
    </tbody>
  </table>
</div>
</body>
</html>
