<?
include("inc/maint_header.php");
?>
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
function changeExtService()
{
	var type=document.getElementById('ex_service_req');
	if(type.value=='Y')
		document.getElementById('divExternalService').style.display='block';
	else 
		document.getElementById('divExternalService').style.display='none';
}
function validate()
{
	var status=true;
	var name=document.getElementById('name').value;
	var duration=document.getElementById('duration').value;
	var tolerance=document.getElementById('tolerance').value;
	var dept_id=document.getElementById('department_id').value;
	if(name=='')
	{
		alert("Enter Name");
		status=false;
	}
	if(duration=='')
	{
		alert("Enter Duration");
		status=false;
	}
	if(tolerance=='')
	{
		alert("Enter Tolerance");
		status=false;
	}
	if(dept_id=='0')
	{
		alert("Select Department");
		status=false;
	}
	return status;
}
</script>
<?
$Page = "maint_add_services.php";
$PageTitle = "Add Service";
$PageFor = "Service";
$PageKey = "service_id";
$PageKeyValue = "";
$Message = "";
$mode = "";
$service_id= "";$service_code= "";$name= "";$department_id= "";$duration_type= "";$duration= "";
$tolerance= "";$ex_service_req= "";$company_name= "";$company_charges= "";$work_to_do= "";
if(isset($_GET["mode"]))
{
	$mode = $_GET["mode"];
	$sql_idate="select * from maint_services where insert_date='".date('Y-m-d')."' and service_id='".$_GET[$PageKey]."'";
	$res_idate=mysql_query($sql_idate);
	if(mysql_num_rows($res_idate)==0 && !($SessionUserType=='Administrator'))
	{
		echo "<script>alert('You Cant Update Here');location.href='maint_homepage.php';</script>";
	}
}
$ex_service_req=="";


if(isset($_GET[$PageKey]))
{
	$sql = "select * from maint_services where $PageKey = '".$_GET[$PageKey]."'";
	$result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row = mysql_fetch_array($result);
		$service_id= $row["service_id"];
		$PageKeyValue = $row[$PageKey];
		$service_code = $row["service_code"];$s_code = $row["s_code"];
		$name = $row["name"];
		$department_id = $row["department_code"];
		$duration_type = $row["duration_type"];
		$duration = $row["duration"];
		$tolerance = $row["tolerance"];
		$ex_service_req = $row["ex_service_req"];
		$company_name = $row["company_name"];	
		$company_charges = $row["company_charges"];
		$work_to_do = stripslashes($row["work_to_do"]);
				
	}
}
else if(!isset($_GET[$PageKey]))
{
	$sql="select max(s_code) as s_code from maint_services";
	$res=mysql_query($sql);
	$row=mysql_fetch_array($res);
	$s_code=($row['s_code']+1);
	$sql="select count(service_id) as service_id from maint_services";
	$res=mysql_query($sql);
	$row=mysql_fetch_array($res);
	$service_id=($row['service_id']+1);
}
if(isset($_POST["btn_submit"]))
{
	$service_id= $_POST["service_id"];
	$PageKeyValue = $_POST[$PageKey];
	$service_code = $_POST["service_code"];
	$name = $_POST["name"];
	$department_id = $_POST["department_id"];
	$duration_type = $_POST["duration_type"];
	$duration = $_POST["duration"];
	$tolerance = $_POST["tolerance"];
	$ex_service_req = $_POST["ex_service_req"];
	if($ex_service_req=='Y')
	{
		$company_name = $_POST["company_name"];	
		$company_charges = $_POST["company_charges"];
	}
	else
	{
		$company_name = '';	
		$company_charges = '';
	}
	$work_to_do = addslashes($_POST["work_to_do"]);
	if($PageKeyValue == "")
	{
		$tableName="maint_services";
		
		$tableData=array("''","'$s_code'","'$service_code'","'$name'","'$department_id'","'$duration_type'","'$duration'","'$tolerance'","'$ex_service_req'","'$company_name'","'$company_charges'","'$work_to_do'","now()");
		addDataIntoTable($tableName,$tableData);
		$Message = "$PageFor Inserted";
		redirect("$Page?Message=$Message");
	}	
	else
	{
		if($mode == "edit")
		{
			$tableName="maint_services";
			$tableColumns=array("service_id","service_code","name","department_code","duration_type","duration","tolerance","ex_service_req","company_name","company_charges","work_to_do");
			$tableData=array("'$PageKeyValue'","'$service_code'","'$name'","'$department_id'","'$duration_type'","'$duration'","'$tolerance'","'$ex_service_req'","'$company_name'","'$company_charges'","'$work_to_do'");
			updateDataIntoTable($tableName,$tableColumns,$tableData);
			$Message = "$PageFor Updated";
			redirect("maint_list_services.php?Message=$Message");
		}
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
          <td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; Add/Edit Service</td>
        </tr>
        <tr>
          <td valign="top" style="padding-top:10px;">
            <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td class="red"><?=$Message?></td>
              </tr>
              <tr>
                <td valign="top" style="padding-bottom:5px;">
                  <form name="frm_add" id="frm_add" action="" method="post" onsubmit="return validate();" >
                  <table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                    <tr>
                      <td align="center" valign="top" class="border" width="50%" bgcolor="#EAE3E1">
                        <table align="center" width="100%" cellpadding="2" cellspacing="2" border="0" class="text_1">
                          <tr>
                            <td align="left"><b>Service No</b></td>
                            <td align="left">
                              <input type="text" readonly="readonly" id="service_id" name="service_id" value="<?= $service_id ?>"  />
                            </td>
                            <td align="left"><b>Service Code</b></td>
                            <td align="left">
                              <input type="text" id="service_code" name="service_code" value="<?= $service_code ?>"  />
                            </td>
                          </tr>
                          <tr>
                            <td align="left"><b>Service Name</b></td>
                            <td align="left">
                              <input style="width:200px" type="text" id="name"  name="name" value="<?= $name ?>" />
                            </td>
                            <td align="left"><b>Department</b></td>
                            <td align="left">
                              <?
                              $sql_d= "select * from maint_department order by name asc";
                              $res_d =mysql_query ($sql_d) or die ("Invalid query : ".$sql_d."<br>".mysql_errno()." : ".mysql_error());
                              ?>
                              <select name="department_id" id="department_id" style="width:125px;">
                                <option value=""></option>
                                <?
                                if(mysql_num_rows($res_d)>0)
                                {
																	while($row_d = mysql_fetch_array($res_d))
																	{
																	?>
																<option value="<?=$row_d['department_code']?>" <? if($row_d['department_code']==$department_id){ ?>selected="selected"<? }?>><?=$row_d['name']?></option>
																	<?
																	}
                                }	
                                ?>
                              </select>
                            </td>
                          </tr>
                          <tr>
                            <td align="left"><b>Duration Type</b></td>
                            <td align="left">
                              <select id="duration_type" name="duration_type" style="width:145px">
                              	<option value="M"  <? if($duration_type=='M' || $duration_type==''){?> selected="selected" <? } ?>>Months</option>
                                <option value="D" <? if($duration_type=='D'){?> selected="selected" <? } ?>>Days</option>
                              </select>
                            </td>
                            <td align="left"><b>Duration</b></td>
                            <td align="left">
                              <input type="text" id="duration" name="duration" value="<?= $duration ?>" />&nbsp;<b></b>
                            </td>
                          </tr>                          
                          <tr>
                            <td align="left"><b>Tolerance</b></td>
                            <td align="left">
	                          	<input type="text" id="tolerance" name="tolerance" value="<?= $tolerance ?>" />&nbsp;<b>(Days)</b>
                            </td>
                            <td align="left"><b>External Service Req.</b></td>
                            <td align="left">
                            	<select id="ex_service_req" name="ex_service_req" style="width:80px" onchange="changeExtService()">
                              	<option value="N"  <? if($ex_service_req=='N'||$ex_service_req==''){?> selected="selected" <? }?>>No</option>
                                <option value="Y" <? if($ex_service_req=='Y'){?> selected="selected" <? } ?>>Yes</option>
                              </select>
                            </td>
                          </tr>
                          <tr>
                            <td colspan="4" align="left">
                            <?
                            if($ex_service_req=="N" || $ex_service_req=="")
                            {
                            ?>
                              <div style="display:none" id="divExternalService"> 
                                <table width="100%" align="center" border="0" cellpadding="2" cellspacing="0" style="font-size:12px;color:#666666;">
                                  <tr>
                                    <td align="left" width="15%"><b>Company Name</b></td>
                                    <td align="left" width="32%">
                                      <textarea id="company_name" name="company_name" rows="2" cols="30"></textarea>
                                    </td>
                                    <td align="left" width="20%"><b>Charges</b></td>
                                    <td align="left" width="33%">
                                      <input type="text" id="company_charges" name="company_charges" />
                                    </td>
                                  </tr>
                                </table>
                              </div>
                            <?
                            }
                            else
                            {
                            ?>
                              <div style="display:block" id="divExternalService"> 
                                <table width="100%" align="center" border="0" cellpadding="2" cellspacing="0" style="font-size:12px;color:#666666;">
                                  <tr>
                                    <td align="left" width="15%"><b>Company Name</b></td>
                                    <td align="left" width="32%">
                                      <textarea id="company_name" name="company_name" rows="2" cols="30"><?= $company_name?></textarea>
                                    </td>
                                    <td align="left" width="20%"><b>Charges</b></td>
                                    <td align="left" width="33%">
                                      <input type="text" id="company_charges" name="company_charges" value="<?= $company_charges?>"/>
                                    </td>
                                  </tr>
                                </table>
                              </div>
                            <?
                            }
                            ?>
                            </td>
                          </tr>  
                          <tr>
                            <td align="left"><b>Work To Do</b></td>
                            <td align="left" colspan="3">
                            	<textarea id="work_to_do" name="work_to_do" rows="2" cols="30"><?= $work_to_do?></textarea>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                    <tr>
                      <td align="center" colspan="3">
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
<div id="overlay">
	<div>
    <p class="form_msg">Are you sure to delete this Record</p>
		<form name="frm_del" action="<?=$_SERVER['PHP_SELF']?>" method="post">
        <input type="hidden" name="hidden_overlay_master" id="hidden_overlay_master" value="" />
        <input type="hidden" name="hidden_overlay" id="hidden_overlay" value="" />
        <input type="submit" class="submit" name="btn_delete" id="btn_delete" value="Yes" />
        <input type="button" class="submit" onClick="overlay();" name="btn_close" id="btn_close" value="No" />
		</form>
	</div>
</div>
<iframe width=168 height=190 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="calendar/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
</iframe>                                        
   
<? 
include("inc/hr_footer.php");
?>