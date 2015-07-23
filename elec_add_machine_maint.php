<?
include("inc/elec_header.php");
?>
<script type="text/javascript">
function getMachineData() {
	var deptId = document.getElementById("department_id").value;
	document.getElementById("div_machine").style.border="none";
	//alert(deptId);
	document.getElementById("div_machine").style.padding="0";	
	get_frm("elec_get_machine_MM.php",deptId,"div_machine",'');
}
function getMotorData(motorId)
{
	// Need to make an empty function
	// Bcoz on selecting machine data
	// this is a function which is called as
	// requirement of motor maintenance.....
	// So Don't Delete It....By Rohan(NST) 16-3-2011(6:00 pm) 
}
</script>
<style>
.get_H_W_100
{
	width:100px;
}
</style>
<?
$Page = "elec_add_machine_maint.php";
$PageTitle = "Add Machine Maintenance";
$PageFor = "Machine Maintenance";
$PageKey = "machine_maint_id";
$PageKeyValue = "";
$Message = "";
$machine_maint_id = '';
$machine_maint_date = '';

$mode = "";
$details='';
$department_id = '';
$machine_id = '';
if(isset($_GET["mode"]))
{
	$mode = $_GET["mode"];
	$sql_idate="select * from elec_machine_maint where insert_date='".date('Y-m-d')."' and $PageKey='".$_GET[$PageKey]."'";
	$res_idate=mysql_query($sql_idate);
	if(mysql_num_rows($res_idate)==0 && !($SessionUserType=='Administrator'))
	{
		echo "<script>alert('You Cant Update Here');location.href='elec_homepage.php';</script>";
	}
}
if(isset($_POST["btn_submit"]))
{
	$PageKeyValue = $_POST[$PageKey];
	if($_POST['machine_maint_date']=="")
		$machine_maint_date=date("Y-m-d");
	else
		$machine_maint_date=getDateFormate($_POST['machine_maint_date']);
	$department_id = $_POST['department_id'];
	$machine_id =$_POST['machine_id'] ;
	$details = addslashes($_POST['details']);		
	if($department_id=='0' || $machine_id=='0')
	{
		$Message="Error While Adding Or Updating.";
		echo "<script>alert('Department or Machine or Machine Not Selected.Please Select It!!!');location.href='elec_add_machine_maint.php?Message=$Message';</script>";
	}
	else
	{
		if($PageKeyValue == "")
		{
			$tableName="elec_machine_maint";
			$tableData=array("''","'$machine_maint_date'","'$department_id'","'$machine_id'","'$details'","now()");
			addDataIntoTable($tableName,$tableData);
			//print_r($tableData);
			$Message = "$PageFor Inserted";
			redirect("$Page?Message=$Message");
		}	
		else
		{
			if($mode == "edit")
			{
				$tableName="elec_machine_maint";
				$tableColumns=array("machine_maint_id","machine_maint_date","department_id","machine_id","details");
				$tableData=array("'$PageKeyValue'","'$machine_maint_date'","'$department_id'","'$machine_id'","'$details'");
				updateDataIntoTable($tableName,$tableColumns,$tableData);
				$Message = "$PageFor Updated";
				redirect("elec_list_machine_maint.php?Message=$Message");
			}
		}
	}
}
if(isset($_GET[$PageKey]))
{
	$sql = "select * from elec_machine_maint where $PageKey = '".$_GET[$PageKey]."'";
	$result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row = mysql_fetch_array($result);
		$PageKeyValue = $row[$PageKey];
		$machine_maint_date = getDateFormate($row["machine_maint_date"]);	
		$details= $row["details"];		
		$department_id=$row['department_id'];
		$machine_id=$row['machine_id'];
	}
}

?>
<?
if(isset($_GET["Message"]))
{
	$Message = $_GET["Message"];
}
if(isset($_GET["machine_maint_id"]))
{
	$machine_maint_id = $_GET["machine_maint_id"];
}
else
{
	$sql="select max(machine_maint_id) as machine_maint_id from elec_machine_maint";
	$res=mysql_query($sql);
	$row=mysql_fetch_array($res);
	$machine_maint_id=($row['machine_maint_id']+1);
}

?>

<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
  <tr>
    <td align="left" valign="top" width="230px" style="padding-top:5px;">
    	<? include ("inc/elec_snb.php"); ?>
    </td>
    <td style="padding-left:5px; padding-top:5px;"  valign="top">
      <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
        <tr>
        	<td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; Add Machine Maintenance</td>
        </tr>
        <tr>
          <td valign="top" style="padding-top:10px;">
            <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td class="red"><?=$Message?></td>
              </tr>
              <tr>
                <td valign="top" style="padding-bottom:5px;" bgcolor="#EAE3E1">
                  <form name="frm_add" id="frm_add" method="post">
                    <table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border text_1">
                      <tr>
                      	<td align="left"><b>Machine Maint. No.</b></td>
                        <td align="left">
                        	<input type="text" name="machine_maint_id" id="machine_maint_id" readonly="readonly" value="<?= $machine_maint_id?>" />
                        </td>
                        <td align="left"><b>Date</b></td>
                        <td align="left">
                        	<input type="text" name="machine_maint_date" id="machine_maint_date" readonly="readonly" value="<?=$machine_maint_date?>" />
                          <a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.frm_add.machine_maint_date);return false;" HIDEFOCUS>
                            <img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
                          </a> 
                        </td>
                      </tr>
                      <tr>
                      	<td align="left"><b>Department</b></td>
                        <td align="left">
                        	<?
														$sql_dept= "select * from elec_department order by name asc";
														$res_dept = mysql_query ($sql_dept) or die (mysql_error());
														?>
														<select name="department_id" id="department_id" onChange="getMachineData()" style="width:145px;">
															<option value="0"></option>
															<?
															if(mysql_num_rows($res_dept)>0)
															{
																while($row_dept = mysql_fetch_array($res_dept))
																{
																?>
																<option value="<?= $row_dept['department_id']; ?>" <? if($row_dept['department_id']==$department_id){ ?> selected="selected"<? }?> ><?= $row_dept['name']?></option>
																<?
																}
														}	
														?>
											   </select>
                       	</td>
                       	<td align="left"><b>Machine</b></td>
                      	<td align="left">
                        	<? 
													  $machine_name = '';
                          	if($mode == "edit")
                            {
															$sql_mach = "select * from elec_machine where machine_id = '".$machine_id."' ";
															$res_mach = mysql_query ($sql_mach) or die ("Invalid query : ".$sql_mach."<br>".mysql_errno()." : ".mysql_error());
															$row = mysql_fetch_array($res_mach);
															if(mysql_num_rows($res_mach)>0)
																$machine_name = $row['name'];
															?>
                              <input type="hidden" name="machine_id" id="machine_id" value="<?= $machine_id ?>" />
                              <?
														}
														else
															$machine_id=0;		
														?>
                            <div id="div_machine" style="height:20px;width:150px;" class="getAjaxDataInDiv">
                            	<input type="hidden" name="machine_id" id="machine_id" value="<?= $machine_id ?>" /><?= $machine_name ?>
                            </div>
                         </td>
                      </tr>
                      <tr>
                         <td align="left" valign="top"><b>Details</b></td>
                         <td align="left"><textarea id="details" name="details" rows="3" cols="35"><?=$details?></textarea></td>
                      </tr>
                      <tr>
                        <td align="center" bgcolor="#EAE3E1" colspan="4">
                          <input type="hidden" id="mode" name="mode" value="<?=$mode?>"/>
                          <input type="hidden" id="<?=$PageKey?>" name="<?=$PageKey?>" value="<?=$PageKeyValue?>" />
                          <input type="submit" id="btn_submit" name="btn_submit" value="Save" class="btn_bg" />
                        </td>
                      </tr>
                    </table>
                  </form>
                </td>
              </tr>
            </table> 
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<iframe width=168 height=190 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="calendar/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
</iframe>                                        
<? 
include("inc/hr_footer.php");
?>