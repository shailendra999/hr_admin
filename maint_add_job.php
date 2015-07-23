<?
include("inc/maint_header.php");
?>
<style>
.getDataInDiv{
	background:#fff;
	border:1px solid #96A2BC;
	overflow:hidden;
}
</style>
<script type="text/javascript">
function overlay(MasterId,RecordId) 
{
	e1 = document.getElementById("overlay");
	document.getElementById("hidden_overlay_master").value=MasterId;
	document.getElementById("hidden_overlay").value=RecordId;
	e1.style.visibility = (e1.style.visibility == "visible") ? "hidden" : "visible";	
}
</script>
<script type="text/javascript">
	function getDataInDiv(job_code, divid, page)
	{
		//var job_code=document.getElementById('job_code').value;
		var strURL1=page+"?job_code="+job_code+"&sid="+Math.random();
		var req = getXMLHTTP();
		var req1 = getXMLHTTP();

		if (req)
		{																					
				req.onreadystatechange = function() {
						if (req.readyState == 4) {
								if (req.status == 200)                         
										document.getElementById(divid).innerHTML=req.responseText;
								 else 
										alert("There was a problem while using XMLHTTP:\n" + req.statusText);
						}                
				}            
				req.open("GET", strURL1, true);
				req.send(null);
		}
		
	}																	
</script>
<?
$Page = "maint_add_job.php";
$PageTitle = "Add Job";
$PageFor = "Job";
$PageKey = "";
$PageKeyValue = "";
$Message = "";
$mode = "";
if(isset($_GET["mode"]))
{
	$mode = $_GET["mode"];
}

if(isset($_POST["btn_submit"]))
{
	//$PageKeyValue = $_POST[$PageKey];
	$job_code = $_POST["job_code"];
	$remark = $_POST["remark"];
	$status = $_POST["status"];
	if($_POST['attend_date']=="")
		$attend_date=date("Y-m-d");
	else
		$attend_date = getDateFormate($_POST['attend_date']);
	
	if($PageKeyValue == "")
	{
		$tableName="maint_job";
		if($status=='F')
		{
			$tableColumns=array("job_code","status","remark","attend_date","insert_date");
			$tableDataJob=array("'$job_code'","'$status'","'$remark'","'$attend_date'","now()");
			//print_r($tableDataJob);
			updateDataIntoTable("maint_job",$tableColumns,$tableDataJob);
			$sql_J="select max(job_code) as job_code from maint_job";
			$res_J=mysql_query($sql_J);
			$row_J=mysql_fetch_array($res_J);
			$jc=($row_J['job_code']+1);
			$duration=$_POST['duration'];
			$duration_type=$_POST['duration_type'];
			
			$machine_id=$_POST['machine_id'];
			$service_id=$_POST['service_id'];
			$maint_date=$_POST['maint_date'];
			
			$schedule_date=$_POST['schedule_date'];
			$da=explode('-',$schedule_date);//$da=explode('-','31-01-2011');
			$sch_date='';
			if($duration_type=="M")
				$sch_date= date("Y-m-d", mktime(0, 0, 0,$da[1]+$duration ,$da[2] , $da[0]));
			if($duration_type=="D")
				$sch_date= date("Y-m-d", mktime(0, 0, 0,$da[1] ,$da[2]+$duration , $da[0]));
			$tableDataJob=array("''","'$jc'","'$service_id'","'$machine_id'","'P'","'$sch_date'","'$maint_date'","''","''","now()");
			//echo '<br />';
			//print_r($tableDataJob);
			addDataIntoTable("maint_job",$tableDataJob);
		}
	}	
	
}
?>
<?
if(isset($_GET["Message"]))
{
	$Message = $_GET["Message"];
}

$job_code = "";
if(isset($_GET["job_code"]))
{
	$job_code = $_GET["job_code"];
	if(!isset($_POST["btn_submit"]))
	{
	?>
    <script>
		getDataInDiv(<?=$job_code?>,'getDataDiv','maint_get_add_job.php')
	</script>
    <?
	}
	else
	{
	echo "<script>";
	echo "location.href = 'maint_pendeing_job_report.php'";
	echo "</script>";
	}
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
          <td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; Add/Edit Job</td>
        </tr>
        <tr>
          <td valign="top" style="padding-top:10px;" bgcolor="#EAE3E1">
            <table align="left" width="80%" cellpadding="0" cellspacing="0" border="0" class="text_1">
              <tr>
                <td class="red" colspan="2"><?=$Message?></td>
              </tr>
              <tr>
                <td align="left"><b>Job No</b></td>
                <td align="left">
                  <input type="text" id="job_code" name="job_code" value="<?=$job_code?>" />&nbsp;&nbsp;&nbsp;&nbsp;
                  <input type="button" id="btn_Ok" name="btn_Ok" value="Ok" class="btn_bg" onClick="getDataInDiv(document.getElementById('job_code').value,'getDataDiv','maint_get_add_job.php')"/>
                </td>
              </tr>
              <tr>
                <td align="center" colspan="2"><div id="getDataDiv"></div></td>
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