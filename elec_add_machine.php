<? include ("inc/elec_header.php"); ?>
<script type="text/javascript">
function overlay(RecordId) 
{
	e1 = document.getElementById("overlay");
	document.getElementById("hidden_overlay").value=RecordId;
	e1.style.visibility = (e1.style.visibility == "visible") ? "hidden" : "visible";
}
</script>
<?
$Page = "elec_add_machine.php";
$PageTitle = "Add Machine";
$PageFor = "Machine";
$PageKey = "machine_id";
$PageKeyValue = "";
$Message = "";
$mode = "";
$PageKeyValue = "";
$name = '';
$department_id = '';
if(isset($_GET["mode"]))
{
	$mode = $_GET["mode"];
	$sql_idate="select * from elec_machine where insert_date='".date('Y-m-d')."' and $PageKey='".$_GET[$PageKey]."'";
	$res_idate=mysql_query($sql_idate);
	if(mysql_num_rows($res_idate)==0 && !($SessionUserType=='Administrator'))
	{
		echo "<script>alert('You Cant Update Here');location.href='elec_setting.php';</script>";
	}
}
if(isset($_POST["btn_submit"]))
{
	$PageKeyValue = $_POST[$PageKey];
	$name = $_POST['name'];
	$department_id = $_POST['department_id'];
	if($PageKeyValue == "")
	{
		$tableName="elec_machine";
		$tableData=array("''","'$department_id'","'$name'","now()");
		//print_r($tableData);
		addDataIntoTable($tableName,$tableData);
		$Message = "$PageFor Inserted";
	}	
	else
	{
		if($mode == "edit")
		{					
			$tableName="elec_machine";
			$tableColumns=array("machine_id","department_id","name");
			$tableData=array("'$PageKeyValue'","'$department_id'","'$name'");
			//print_r($tableData);
			updateDataIntoTable($tableName,$tableColumns,$tableData);			
			$Message = "$PageFor Updated";
		}
		
	}
	redirect("$Page?Message=$Message");
}
?>
<?
if(isset($_GET["Message"]))
{
	$Message = $_GET["Message"];
}
if(isset($_POST["btn_delete"]))
{
	$PageKeyValue  = $_POST["hidden_overlay"];
	$sql = "delete from elec_machine where $PageKey = '".$PageKeyValue."'";
	mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	$Message = "$PageFor Sucessfully Deleted";
	redirect("$Page?Message=$Message");
}

if(isset($_GET[$PageKey]))
{
	$sql = "select * from elec_machine where $PageKey = '".$_GET[$PageKey]."'";
	$result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row = mysql_fetch_array($result);
		$PageKeyValue = $row[$PageKey];
		$name = $row["name"];
		$department_id = $row["department_id"];
		$machine_id = $row["machine_id"];
	}
}
else
{
	$sql_code="select max(machine_id) as machine_id from elec_machine";
	$res_code=mysql_query($sql_code);
	$row_code=mysql_fetch_array($res_code);
	$machine_id=($row_code['machine_id']+1);
}
?>

<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
  <tr>
    <td align="left" valign="top" width="230px" style="padding-top:5px;">
    	<? include ("inc/elec_setting_snb.php"); ?>
    </td>        
    <td style="padding-left:5px; padding-top:5px;">
      <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
      <tr>
      <td align="center" class="gray_bg">
      	<img src="images/bullet.gif" width="15" height="22"/>&nbsp; Welcome to Laxyo
      </td>
      </tr>
        <tr>
          <td valign="top" style="padding-top:5px;padding-left:40px;">
            <table width="1000" align="center" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td align="center" class="border">
                	<div id="div_message" style="color:#399;font-size:16px;font-weight:bold;padding:5 0 5 0"><?=$Message?></div>
                  <form id="frm_add" name="frm_add"  method="post">
                    <table align="center" cellpadding="1" cellspacing="1" bgcolor="#EAE3E1" border="0" width="60%" class="text_1">
                      <tr>
                        <td align="left"><b>Machine Id</b></td>
                        <td align="left">
                          <input type="text" id="machine_id" name="machine_id" value="<?= $machine_id ?>" />
                        </td>
                      </tr>
                      <tr>
                        <td align="left"><b>Department</b></td>
                        <td align="left">
                          <?
                          $sql_dept = "select * from elec_department order by name asc";
                          $res_dept = mysql_query($sql_dept) or die (mysql_error());
                          ?>
                          <select id="department_id" name="department_id" style="width:200px;height:20px">
                          <?
                          if(mysql_num_rows($res_dept)>0)
                          {
                            while($row_dept = mysql_fetch_array($res_dept))
                            {
                            ?>
                            <option value="<?= $row_dept['department_id']?>" <? if($row_dept['department_id']==$department_id){ ?> selected="selected"<? }?>><?= $row_dept['name']?></option>
                            <?
                            }
                          }
                          ?>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td align="left"><b>Machine Name</b></td>
                        <td align="left">
                          <input type="text" id="name" name="name" value="<?= $name ?>" />
                        </td>
                      </tr>
                      <tr>
                        <td colspan="2" align="center" height="25">
                          <input type="hidden" id="mode" name="mode" value="<?=$mode?>"/>
                          <input type="hidden" id="<?=$PageKey?>" name="<?=$PageKey?>" value="<?=$PageKeyValue?>" />
                          <input type="submit" id="btn_submit" name="btn_submit" value="Save" class="btn_bg" />
                        </td>
                      </tr>
                    </table>
                  </form>
                  <div id="div_category_list"  style="overflow:auto;height:800px;margin-top:20px;">
                    <table align="left" width="100%" border="1" class="table1 text_1">
                      <tr>
                        <td class="gredBg">S.No.</td>
                        <td class="gredBg">Machine Name</td>
                        <td class="gredBg">Department</td>
                        <td class="gredBg">Edit</td>
                        <td class="gredBg">Delete</td>
                      </tr>
                    <?
                    $sql = "select * from  elec_machine order by name";
                    $result = mysql_query ($sql) or die (mysql_error());
                    if(mysql_num_rows($result)>0)
                    {
                      $sno=1;
												while($row = mysql_fetch_array($result)) 
												{ 
												$sql_idate="select * from elec_machine where insert_date='".date('Y-m-d')."' and machine_id='".$row['machine_id']."'";
												$res_idate=mysql_query($sql_idate);
												$row_idate=mysql_fetch_array($res_idate);
												$insert_date=$row_idate['insert_date'];
												?>
												<tr bgcolor="#F2F7F9">
													<td align="center"><?= $sno++;?></td>
													<td align="left" style="padding-left:5px"><?=$row["name"]?></td>
													<td align="left" style="padding-left:5px">
													<? 
													$sql_D = "select * from elec_department where department_id='".$row["department_id"]."'";
													$result_D = mysql_query ($sql_D) or die (mysql_error());
													$row_select = mysql_fetch_array($result_D);
													echo $row_select["name"];
													?>
													</td>
													<?
													if($SessionUserType=='Administrator' || (date('Y-m-d')==$insert_date))
													{
													?>
														<td align="center">
															<a href="elec_add_machine.php?machine_id=<?=$row['machine_id']?>&mode=edit"title="Edit" >
																<img src="images/icon_edit.gif" alt="Edit" border="0" />
															</a>
														</td>
														<td align="center">
															<a href="javascript:;" onClick="overlay(<?=$row["machine_id"]?>);" title="Delete" >
																<img src="images/delete_icon.gif" alt="Delete"border="0">
															</a>
														</td>
													<?
													}
													else
													{
													?>
														<td align="center"></td>
														<td align="center"></td>
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
                      <tr align="center">
                      	<td colspan="5" align="center">No Records Entered Yet.</td>
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
<? include ("inc/hr_footer.php"); ?>	