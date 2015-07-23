<?
include("inc/elec_header.php");
?>
<script type="text/javascript">
function getSubDeptData() {
	var deptId = document.getElementById("department_id").value;
	document.getElementById("div_sub_dept").style.border="none";
	//alert(deptId);
	document.getElementById("div_sub_dept").style.padding="0";	
	get_frm("elec_get_sub_department.php",deptId,"div_sub_dept",'');
}
</script>
<?
$Page = "elec_add_energy_consumption.php";
$PageTitle = "Add Energy Consumption";
$PageFor = "Energy Consumption";
$PageKey = "EC_id";
$PageKeyValue = "";
$Message = "";
$mode = "";
$EC_id = "";$department_id = "";$machine_name = "";
$reading = "";$time = "";$hr_mtr_reading = "";$reading_date = "";
if(isset($_GET["mode"]))
{
	$mode = $_GET["mode"];
	$sql_idate="select * from elec_energy_consumption where insert_date='".date('Y-m-d')."' and $PageKey='".$_GET[$PageKey]."'";
	$res_idate=mysql_query($sql_idate);
	if(mysql_num_rows($res_idate)==0 && !($SessionUserType=='Administrator'))
	{
		echo "<script>alert('You Cant Update Here');location.href='elec_homepage.php';</script>";
	}
}

if(isset($_GET[$PageKey]))
{
	$sql = "select * from elec_energy_consumption where $PageKey = '".$_GET[$PageKey]."'";
	$result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row = mysql_fetch_array($result);
		$PageKeyValue = $row[$PageKey];$EC_id = $row['EC_id'];
		$department_id = $row["department_id"];
		$machine_name = $row["machine_name_number"];
		$time = $row["time"];
		$hr_mtr_reading = $row["hour_meter_reading"];
		$reading = $row["reading"];
		$reading_date = getDateFormate($row["reading_date"]);
	}
}
else if(!isset($_GET[$PageKey]))
{
	$sql="select max(EC_id) as EC_id from elec_energy_consumption";
	$res=mysql_query($sql);
	$row=mysql_fetch_array($res);
	$EC_id=($row['EC_id']+1);
}

if(isset($_POST["btn_submit"]))
{
	$PageKeyValue = $_POST[$PageKey];
	$department_id = $_POST["department_id"];
	$machine_name = $_POST["machine_name"];
	$time = $_POST["time"];
	$hr_mtr_reading = $_POST["hr_mtr_reading"];
	$reading = $_POST["reading"];
	$reading_date = getDateFormate($_POST["reading_date"]);	
	
	if($PageKeyValue == "")
	{
		$tableName="elec_energy_consumption";
		$tableData=array("''","'$department_id'","'$machine_name'","'$time'","'$hr_mtr_reading'","'$reading'","'$reading_date'","now()");
		//print_r($tableData);
	  addDataIntoTable($tableName,$tableData);
		$Message = "$PageFor Inserted";
		redirect("$Page?Message=$Message");
	}	
	else
	{
		if($mode == "edit")
		{
			$tableName="elec_energy_consumption";
			$tableColumns=array("EC_id","department_id","machine_name_number","time","hour_meter_reading","reading","reading_date");
			$tableData=array("'$PageKeyValue'","'$department_id'","'$machine_name'","'$time'","'$hr_mtr_reading'","'$reading'","'$reading_date'");
			//print_r($tableData);
		  updateDataIntoTable($tableName,$tableColumns,$tableData);
			$Message = "$PageFor Updated";
		}
	}
	redirect("elec_list_energy_consumption.php?Message=$Message");
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
			<? include ("inc/elec_snb.php"); ?>
		</td>
		<td style="padding-left:5px; padding-top:5px;" valign="top">
			<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
        <tr>
          <td align="center" class="gray_bg">
          	<img src="images/bullet.gif" width="15" height="22"/> &nbsp; Add/Edit Energy Consumption
          </td>
        </tr>
        <tr>
          <td valign="top" style="padding-top:10px;">
            <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td class="red"><?=$Message?></td>
              </tr>
              <tr>
                <td valign="top" class="border" bgcolor="#EAE3E1">
                  <form name="frm_add" id="frm_add" action="" method="post">
                  
                       <table align="center" width="100%" cellpadding="2" cellspacing="2" border="0" class="text_1">
                          <tr>
                            <td align="left"><b>EC Id</b></td>
                            <td align="left" colspan="3">
                              <input type="text" readonly="readonly" id="Sno" name="Sno" value="<?= $EC_id?>"/>
                            </td>
                          </tr>
                          <tr>
                            <td align="left"><b>Department</b></td>
                            <td align="left">
                              <?
                              $sql_D= "select * from elec_department order by name asc ";
                              $res_D = mysql_query ($sql_D) or die (mysql_error());
                              ?>
                              <select name="department_id" id="department_id" style="width:160px;">
                                <option value="0"></option>
                                <?
                                if(mysql_num_rows($res_D)>0)
                                {
                                while($row_D = mysql_fetch_array($res_D))
                                {
                                ?>
                              <option value="<?= $row_D['department_id']; ?>" <? if($row_D['department_id']==$department_id){ ?> selected="selected"<? }?> ><?= $row_D['name']; ?></option>
                                <?
                                }
                                }	
                                ?>
                              </select>
                            </td>
														<td align="left"><b>Machine Name And No.</b></td>
                            <td align="left">
                            	<input type="text" id="machine_name" name="machine_name" value="<?= $machine_name ?>"  />
                            </td>
                          
                          <tr>
                            <td align="left"><b>Time</b></td>
                            <td align="left">
                              <input type="text" id="time" name="time" value="<?= $time ?>"  />
                            </td>
                            <td align="left"><b>Hour Meter Reading</b></td>
                            <td align="left">
                              <input type="text" id="hr_mtr_reading" name="hr_mtr_reading" value="<?= $hr_mtr_reading ?>"  />
                            </td>
                          </tr> 
                          <tr>
                            <td align="left"><b>Reading</b></td>
                            <td align="left">
                              <input type="text" id="reading" name="reading" value="<?=$reading?>"  />
                            </td>
                            <td align="left"><b>Reading Date</b></td>
                            <td align="left">
                              <input type="text" id="reading_date" name="reading_date" value="<?= $reading_date ?>"  />
                               <a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.frm_add.reading_date);return false;" HIDEFOCUS>
                                <img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
                               </a> 
                            </td>
                          </tr>                           
                          <tr height="30px">
                            <td align="center" colspan="4" style="padding-top:10px">
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