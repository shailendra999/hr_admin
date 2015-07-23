<?
include("inc/elec_header.php");
?>
<script type="text/javascript">
function overlay(RecordId) 
{
	e1 = document.getElementById("overlay");
	document.getElementById("hidden_overlay").value=RecordId;
	e1.style.visibility = (e1.style.visibility == "visible") ? "hidden" : "visible";
}
function getMachineData() {
	var deptId = document.getElementById("department_id").value;
	document.getElementById("div_machine").style.border="none";
	//alert(deptId);
	document.getElementById("div_machine").style.padding="0";	
	get_frm("elec_get_machine.php",deptId,"div_machine",'');
}
</script>
<style>
.getDataInDiv
{
	border:1px solid #96A2BC;
	background:#fff;
	overflow:hidden;
}
.get_H_W_100
{
	width:100px;
}
</style>
<?
$Page = "elec_add_motor.php";
$PageTitle = "Add Motor";
$PageFor = "Motor ";
$PageKey = "motor_id";
$PageKeyValue = "";
$Message = "";
$motor_id = '';
$department_id = '';
$machine_id = '';
$name = '';	

$mode = "";
if(isset($_GET["mode"]))
{
	$mode = $_GET["mode"];
	$sql_idate="select * from elec_motor where insert_date='".date('Y-m-d')."' and $PageKey='".$_GET[$PageKey]."'";
	$res_idate=mysql_query($sql_idate);
	if(mysql_num_rows($res_idate)==0 && !($SessionUserType=='Administrator'))
	{
		echo "<script>alert('You Cant Update Here');location.href='elec_setting.php';</script>";
	}
}
if(isset($_POST["btn_submit"]))
{
	$PageKeyValue = $_POST[$PageKey];
	$department_id = $_POST["department_id"];
	$machine_id = $_POST["machine_id"];
	$name = $_POST["name"];	
	if($department_id!='0' && $machine_id!='0')
	{
		if($PageKeyValue == "")
		{
			$tableName="elec_motor";
			$tableData=array("''","'$department_id'","'$machine_id'","'$name'","now()");
			addDataIntoTable($tableName,$tableData);
			//print_r($tableData);
		}	
		else
		{
			if($mode == "edit")
			{
				$tableName="elec_motor";
				$tableColumns=array("motor_id","department_id","machine_id","name");
				$tableData=array("'$PageKeyValue'","'$department_id'","'$machine_id'","'$name'");
				updateDataIntoTable($tableName,$tableColumns,$tableData);
				$Message = "$PageFor Updated";
			}
		}
		redirect("elec_add_motor.php?Message=$Message");
	}
	else
	{
		$Message="Error While Adding Or Updating.";
		echo "<script>alert('Department or Machine Not Selected.Please Select It!!!');</script>";
	}
	//redirect("elec_add_motor.php?Message=$Message");
}
if(isset($_GET[$PageKey]))
{
	$sql = "select * from elec_motor where $PageKey = '".$_GET[$PageKey]."'";
	$result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row = mysql_fetch_array($result);
		$PageKeyValue = $row[$PageKey];
		$department_id = $row["department_id"];
		$machine_id = $row["machine_id"];
		$name = $row["name"];	
	}
}

?>
<?
if(isset($_GET["Message"]))
{
	$Message = $_GET["Message"];
}
if(isset($_GET["motor_id"]))
{
	$motor_id = $_GET["motor_id"];
}
else
{
	$sql="select max(motor_id) as motor_id from elec_motor";
	$res=mysql_query($sql);
	$row=mysql_fetch_array($res);
	$motor_id=($row['motor_id']+1);
}
if(isset($_POST["btn_delete"]))
{
	$PageKeyValue  = $_POST["hidden_overlay"];
	$sql = "delete from elec_motor where $PageKey = '".$PageKeyValue."'";
	mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	$Message = "$PageFor Sucessfully Deleted";
	redirect("$Page?Message=$Message");
}
?>

<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
  <tr>
    <td align="left" valign="top" width="230px" style="padding-top:5px;">
    	<? include ("inc/elec_setting_snb.php"); ?>
    </td>
    <td style="padding-left:5px; padding-top:5px;"  valign="top">
      <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
        <tr>
        	<td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; Add Motor </td>
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
                      	<td align="left"><b>Motor No.</b></td>
                        <td align="left">
                        	<input type="text" name="motor_id" id="motor_id" readonly="readonly" value="<?= $motor_id?>" />
                        </td>
                      </tr>
                      <tr>
                      	<td align="left"><b>Department</b></td>
                        <td align="left">
                        	<?
														$sql_dept= "select * from elec_department order by name asc";
														$res_dept = mysql_query ($sql_dept) or die ("Invalid query : ".$sql_dept."<br>".mysql_errno()." : ".mysql_error());
														?>
														<select name="department_id" id="department_id" onChange="getMachineData()" style="width:145px;">
															<option value="0"></option>
															<?
															if(mysql_num_rows($res_dept)>0)
															{
																while($row_dept = mysql_fetch_array($res_dept))
																{
																?>
																<option value="<?= $row_dept['department_id']; ?>" <? if($row_dept['department_id']==$department_id){ ?> selected="selected"<? }?> ><?php echo $row_dept['name']; ?></option>
																<?
																}
														}	
														?>
											   </select>
                       	</td>
                      </tr>
                      <tr>
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
                            <div id="div_machine" style="height:22px;width:150px;" class="getDataInDiv">
                            	<input type="hidden" name="machine_id" id="machine_id" value="<?= $machine_id ?>" /><?= $machine_name ?>
                            </div>
                         </td>
                      </tr>
                      <tr>
                       	<td align="left"><b>Motor Name</b></td>
                      	<td align="left">
                        	<input type="text" name="name" id="name" value="<?=$name?>" />
                        </td>
                      </tr>
                      <tr>
                        <td align="center" colspan="2">
                          <input type="hidden" id="mode" name="mode" value="<?=$mode?>"/>
                          <input type="hidden" id="<?=$PageKey?>" name="<?=$PageKey?>" value="<?=$PageKeyValue?>" />
                          <input type="submit" id="btn_submit" name="btn_submit" value="Save" class="btn_bg" />
                        </td>
                      </tr>
                    </table>
                  </form>
                  <div id="div_category_list" style="overflow:auto;height:400px;width:850px;margin:20px auto">
                    <table align="left" width="100%" border="1" class="table1 text_1">
                      <tr>
                        <td class="gredBg">S.No.</td>
                        <td class="gredBg">Department</td>
                        <td class="gredBg">Machine</td>
                        <td class="gredBg">Motor Name</td>
                        <td class="gredBg">Edit</td>
                        <td class="gredBg">Delete</td>
                      </tr>
											<?
                      $sql = "select * from elec_motor order by name";
                      $result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
                      if(mysql_num_rows($result)>0)
                      {
                        $sno=1;
                        while($row = mysql_fetch_array($result)) 
                        { 
												$sql_idate="select * from elec_motor where insert_date='".date('Y-m-d')."' and motor_id='".$row['motor_id']."'";
												$res_idate=mysql_query($sql_idate);
												$row_idate=mysql_fetch_array($res_idate);
												$insert_date=$row_idate['insert_date'];
                        ?>
                          <tr bgcolor="#F2F7F9">
                            <td align="center"><?= $sno++;?></td>
                            <td align="left" style="padding-left:5px">
														<?
															$sqlD="select * from elec_department where department_id='".$row['department_id']."'";
															$resD=mysql_query($sqlD);
															$dname='';
															if(mysql_num_rows($resD)>0)
															{
																$rowD=mysql_fetch_array($resD);
																$dname=$rowD['name'];
															}
															echo $dname;
                            ?>
                            </td>
                            <td align="left" style="padding-left:5px">
														<?
															$sqlM="select * from elec_machine where machine_id='".$row['machine_id']."'";
															$resM=mysql_query($sqlM);
															$mname='';
															if(mysql_num_rows($resM)>0)
															{
																$rowM=mysql_fetch_array($resM);
																$mname=$rowM['name'];
															}
															echo $mname;
                            ?>
                            </td>
                            <td align="left" style="padding-left:5px"><?=$row["name"]?></td>
                            <?
														if($SessionUserType=='Administrator' || (date('Y-m-d')==$insert_date))
														{
														?>
															<td align="center">
																<a href="elec_add_motor.php?motor_id=<?=$row['motor_id']?>&mode=edit"title="Edit" >
																	<img src="images/icon_edit.gif" alt="Edit" border="0" />
																</a>
															</td>
															<td align="center">
																<a href="javascript:;" onClick="overlay(<?=$row["motor_id"]?>);" title="Delete" >
																	<img src="images/delete_icon.gif" alt="Delete"border="0">
																</a>
															</td>
														<?
														}
														else
														{
														?>
															<td align="center"></td><td align="center"></td>
														<?
														}
													 ?>
                          </tr>
												<?												
                        }
                      }
                      else
                      {
                      ?>
                        <tr bgcolor="#f9f8f9">
                            <td colspan="6" align="center">No Records Entered Yet.</td>
                        </tr>
                    	<? 
                      }
     									?>
                    </table>
                  </div>
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