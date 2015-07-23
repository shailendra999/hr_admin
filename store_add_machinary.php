<? include ("inc/store_header.php"); ?>
<script type="text/javascript">
function overlay(RecordId) 
{
	e1 = document.getElementById("overlay");
	document.getElementById("hidden_overlay").value=RecordId;
	e1.style.visibility = (e1.style.visibility == "visible") ? "hidden" : "visible";
}
</script>
<?
$Page = "store_add_machinary.php";
$PageTitle = "Add Machine";
$PageFor = "Machine";
$PageKey = "machinary_id";
$PageKeyValue = "";
$Message = "";
$mode = "";
if(isset($_GET["mode"]))
{
	$mode = $_GET["mode"];
	$sql_idate="select * from ms_machinary where insert_date='".date('Y-m-d')."' and machinary_id='".$_GET[$PageKey]."'";
	$res_idate=mysql_query($sql_idate);
	/*if(mysql_num_rows($res_idate)==0 && !($SessionUserType=='Administrator'))
	{
		echo "<script>alert('You Cant Update Here');location.href='store_setting.php';</script>";
	}*/
}
if(isset($_POST["btn_submit"]))
{
	$PageKeyValue = $_POST[$PageKey];
	$name = $_POST['name'];
	$department_id = $_POST['department_id'];
	$m_id = $_POST['machinary_id'];	
	if($PageKeyValue == "")
	{
		$tableName="ms_machinary";
		$tableData=array("''","'$department_id'","'$name'","now()");
		//print_r($tableData);
		addDataIntoTable($tableName,$tableData);
		$Message = "$PageFor Inserted";
	}	
	else
	{
		if($mode == "edit")
		{					
			$tableName="ms_machinary";
			$tableColumns=array("machinary_id","department_id","name");
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
$PageKeyValue = "";
$ReferenceId = "";

if(isset($_GET["Message"]))
{
	$Message = $_GET["Message"];
}
if(isset($_POST["btn_delete"]))
{
	$PageKeyValue  = $_POST["hidden_overlay"];
	$sql = "delete from ms_machinary where $PageKey = '".$PageKeyValue."'";
	mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	$Message = "$PageFor Sucessfully Deleted";
	redirect("$Page?Message=$Message");
}
$number = '';
$name = '';
$department_id = '';
if(isset($_GET[$PageKey]))
{
	$sql = "select * from ms_machinary where $PageKey = '".$_GET[$PageKey]."'";
	$result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row = mysql_fetch_array($result);
		$PageKeyValue = $row[$PageKey];
		$name = $row["name"];
		$department_id = $row["department_id"];
		$machinary_id = $row["machinary_id"];		
	}
}
else
{
	$sql_code="select max(machinary_id) as machinary_id from ms_machinary";
	$res_code=mysql_query($sql_code);
	$row_code=mysql_fetch_array($res_code);
	$machinary_id=($row_code['machinary_id']+1);
}
?>

<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
  <tr>
    <td align="left" valign="top" width="230px" style="padding-top:5px;">
    	<? include ("inc/store_setting_snb.php"); ?>
    </td>        
    <td style="padding-left:5px; padding-top:5px;">
      <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
      <tr>
      <td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/>&nbsp; Welcome to Laxyo</td>
      </tr>
        <tr>
          <td valign="top" style="padding-top:5px; padding-left:40px;">
            <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td align="center" class="border">
                	<div id="div_message" style="color:#399;font-size:16px;font-weight:bold;padding:5 0 5 0"><?=$Message?></div>
                    <form id="frm_add" name="frm_add"  method="post">
                      <table bgcolor="#EAE3E1" align="center" cellpadding="1" cellspacing="1" border="0" width="60%" class="text_1">
                        <tr>
                          <td align="left"><b>Machinary Id</b></td>
                          <td align="left">
                            <input type="text" id="machinary_id" name="machinary_id" value="<?= $machinary_id ?>" />
                          </td>
                        </tr>
                        <tr>
                          <td align="left"><b>Machinary Name</b></td>
                          <td align="left">
                            <input type="text" id="name" name="name" value="<?= $name ?>" />
                          </td>
                        </tr>
                        <tr>
                          <td align="left"><b>Department</b></td>
                          <td align="left">
                            <?php
                            $sql_dept = "select * from ms_department order by name asc";
                            $res_dept = mysql_query($sql_dept) or die ("Invalid query : ".$sql_dept."<br>".mysql_errno()." : ".mysql_error());
                            ?>
                            <select id="department_id" name="department_id">
                            <?php
                            if(mysql_num_rows($res_dept)>0)
                            {
                              while($row_dept = mysql_fetch_array($res_dept))
                              {
                              ?>
                              <option value="<?= $row_dept['department_id']?>" <? if($row_dept['department_id']==$department_id){ ?> selected="selected"<? }?>><?= $row_dept['name']?></option>
                                <?php
                              }
                            }
                            ?>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="2" align="center">
                            <input type="hidden" id="mode" name="mode" value="<?=$mode?>"/>
                            <input type="hidden" id="<?=$PageKey?>" name="<?=$PageKey?>" value="<?=$PageKeyValue?>" />
                            <input type="submit" id="btn_submit" name="btn_submit" value="Save" class="btn_bg" />
                          </td>
                        </tr>
                      </table>
                    </form>
                    <div id="div_category_list"  style="overflow:auto;height:800px;margin-top:20px;">
                      <table align="center" width="100%"class="table1 text_1" cellpadding="2" cellspacing="1" border="1">
                        <tr>
                          <td class="gredBg">S.No.</td>
                          <td class="gredBg">Machinary Id</td>
                          <td class="gredBg">Machinary Name</td>
                          <td class="gredBg">Department</td>
                          <td class="gredBg">Edit</td>
                          <td class="gredBg">Delete</td>
                        </tr>
												<?
                        $sql = "select * from  ms_machinary order by name";
                        $result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
                        if(mysql_num_rows($result)>0)
                        {
                        
													$num = mysql_num_rows($result) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
													$sno=1;
													while($row = mysql_fetch_array($result)) 
													{ 
														$sql_idate="select * from ms_machinary where insert_date='".date('Y-m-d')."' and machinary_id='".$row['machinary_id']."'";
                            $res_idate=mysql_query($sql_idate);
                            $row_idate=mysql_fetch_array($res_idate);
                            $insert_date=$row_idate['insert_date'];
													?>
                        		<tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
                              <td align="center"><?= $sno++;?></td>
                              <td align="center"><?=$row["machinary_id"]?></td>
                              <td align="center"><?=$row["name"]?></td>
                              <td align="center">
															<? 
                              $sql_D = "select * from ms_department where department_id = '".$row["department_id"]."' ";
                              $result_D = mysql_query ($sql_D) or die ("Invalid query : ".$sql_D."<br>".mysql_errno()." : ".mysql_error());
                              $row_select = mysql_fetch_array($result_D);
                              echo $row_select["name"];
                              ?>
                              </td>
                              <?
                              if(1)
                              { //$SessionUserType=='Administrator' || (date('Y-m-d')==$insert_date)
                              ?>
                              <td align="center">
                                <a href="store_add_machinary.php?machinary_id=<?=$row['machinary_id']?>&mode=edit">
                                  <img src="images/icon_edit.gif" alt="Edit" title="Edit" border="0" />
                                </a>
                              </td>
                              <td align="center">
                                <a href="javascript:;" onClick="overlay(<?=$row['machinary_id']?>);">
                                  <img src="images/delete_icon.gif" alt="Delete" title="Delete" border="0">
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
												 <tr>
													 <td align="center" colspan="6">No Records Entered Yet.</td>
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