<?
include("inc/maint_header.php");
?>

<?
$Page = "maint_view_job.php";
$PageTitle = "View Job";
$PageFor = "Job";
$PageKey = "job_code";
$PageKeyValue = "";
$Message = "";
$mode = "";
if(isset($_GET["mode"]))
{
	$mode = $_GET["mode"];
}

if(isset($_GET[$PageKey]))
{
	$sql = "select * from maint_job where $PageKey = '".$_GET[$PageKey]."'";
	$result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row = mysql_fetch_array($result);
		$PageKeyValue = $row[$PageKey];$job_code = $row['job_code'];
		$remark = $row['remark'];$status = $row['status'];
		$schedule_date = getDateFormate($row['schedule_date']);
		$attend_date = getDateFormate($row['attend_date']);
				
	}
}

?>
<?
if(isset($_GET["Message"]))
{
	$Message = $_GET["Message"];
}


?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
	<tr>
		<td align="left" valign="top" width="230px" style="padding-top:5px;">
			<? include ("inc/maint_snb.php"); ?>
		</td>
		<td style="padding-left:5px; padding-top:5px;" valign="top">
			<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
        <tr>
          <td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; View Job</td>
        </tr>
        <tr>
          <td valign="top" style="padding-top:10px;">
            <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0" class="border">
              <tr>
                <td class="red"><?=$Message?></td>
              </tr>
              <tr>
                <td align="center" style="padding-bottom:5px;" valign="top" class="border" width="100%" bgcolor="#EAE3E1">
                  <table align="center" width="100%" cellpadding="2" cellspacing="2" border="0" class="text_1">
                    <tr>
                      <td align="left"><b>Job Code</b></td>
                      <td align="left"><?=$job_code?></td>
                      <td align="left"><b>Status</b></td>
                      <td align="left">
                        <? 
                        $st='';
                        if($status=='P') $st="Pending";
                        if($status=='F') $st="Finished";
                        if($status=='C') $st="Cancelled";
                        echo $st;
                        ?>
                      </td>
                    </tr>
                    <tr>
                      <td align="left"><b>Machine</b></td>
                      <td align="left">
                        <?
                          $sql_M = "select mmm.name from maint_machine_master mmm,maint_job mj where mmm.machine_id= '".$row['machine_id']."' and mj.job_code='".$row['job_code']."'";
                          $res_M = mysql_query($sql_M) or die ("Invalid query : ".$sql_M."<br>".mysql_errno().":".mysql_error());
                          $row_M = mysql_fetch_array($res_M);
                          echo $row_M['name'];
                        ?>
                      </td>
                      <td align="left"><b>Department</b></td>
                      <td align="left">
                        <?
                         $sql_dep = "select md.name from maint_department md,maint_machine_master mmm,maint_job mj where mmm.department_code =md.department_code and mmm.machine_id= '".$row['machine_id']."' and mj.job_code='".$row['job_code']."'";
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
                        ?>
                      </td>
                    </tr>
                    <tr>
                      <td align="left"><b>Schedule Date</b></td>
                      <td align="left"><?=$schedule_date?>
                      </td>
                      <td align="left"><b>Attend Date</b></td>
                      <td align="left"><?=$attend_date?></td>
                    </tr>
                    <tr>
                      <td align="left"><b>Remark</b></td>
                      <td align="left" colspan="3"><?=$remark?></td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
  	</td>
  </tr>
</table>
   
<? 
include("inc/hr_footer.php");
?>