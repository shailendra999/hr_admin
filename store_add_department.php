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
$Page = "store_add_department.php";
$PageTitle = "Add Department";
$PageFor = "Department";
$PageKey = "department_id";
$PageKeyValue = "";
$Message = "";
$PageKeyValue = "";
$ReferenceId = "";
$mode = "";
if(isset($_GET["mode"]))
{
	$mode = $_GET["mode"];
	$sql_idate="select * from ms_department where insert_date='".date('Y-m-d')."' and $PageKey='".$_GET[$PageKey]."'";
	$res_idate=mysql_query($sql_idate);
	/*if(mysql_num_rows($res_idate)==0 && !($SessionUserType=='Administrator'))
	{
		echo "<script>alert('You Cant Update Here');location.href='store_setting.php';</script>";
	}*/
}
if(isset($_POST["btn_submit"]))
{
	$PageKeyValue = $_POST[$PageKey];
	$name = $_POST['dept_name'];
	if($PageKeyValue == "")
	{
		$tableName="ms_department";
		$tableData=array("''","'$name'","now()");
		addDataIntoTable($tableName,$tableData);
		$Message = "$PageFor Inserted";
	}	
	else
	{
		if($mode == "edit")
		{					
			$tableName="ms_department";
			$tableColumns=array("department_id","name");
			$tableData=array("'$PageKeyValue'","'$name'");
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
	$sql = "delete from ms_department where $PageKey = '".$PageKeyValue."'";
	mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	$Message = "$PageFor Sucessfully Deleted";
	redirect("$Page?Message=$Message");
}
$name = '';
if(isset($_GET[$PageKey]))
{
	$sql = "select * from ms_department where $PageKey = '".$_GET[$PageKey]."'";
	$result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row = mysql_fetch_array($result);
		$PageKeyValue = $row[$PageKey];
		$name = $row["name"];	
		$department_id=$row["department_id"];	
	}
}
else
{
	$sql_code="select max(department_id) as department_id from ms_department";
	$res_code=mysql_query($sql_code);
	$row_code=mysql_fetch_array($res_code);
	$department_id=($row_code['department_id']+1);
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
        	<td align="center" class="gray_bg">
          	<img src="images/bullet.gif" width="15" height="22"/>&nbsp; Welcome to Laxyo
          </td>
        </tr>
      <tr>
        <td valign="top" style="padding-top:5px; padding-left:40px;">
          <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
            <tr>
              <td align="center" class="border">
                <div id="div_message" style="color:#399;font-size:16px;font-weight:bold;padding:5 0 5 0"><?=$Message?></div>
                  <form id="frm_add" name="frm_add" method="post">
                    <table align="center" cellpadding="1" cellspacing="1" bgcolor="#EAE3E1" border="0" width="60%" class="text_1">
                      <tr>
                        <td align="left"><b>Department Id</b></td>
                        <td align="left">
                          <input type="text" id="department_id" name="department_id" value="<?=$department_id ?>" />
                        </td>
                      </tr>
                      <tr>
                        <td align="left"><b>Department Name</b></td>
                        <td align="left">
                          <input type="text" id="dept_name" name="dept_name" value="<?= $name ?>" />
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
                    <div id="div_category_list" style="overflow:auto;height:800px;margin-top:20px;">
                      <table align="center" width="100%"class="table1 text_1" cellpadding="2" cellspacing="1" border="1">
                        <tr>
                          <td class="gredBg"><b>S.No.</b></td>
                          <td class="gredBg"><b>Department Id</b></td>
                          <td class="gredBg"><b>Department Name</b></td>
                          <td class="gredBg"><b>Edit</b></td>
                          <td class="gredBg"><b>Delete</b></td>
                        </tr>
                        <?
                        $sql = "select * from ms_department order by name";
                        $result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
                        if(mysql_num_rows($result)>0)
                        {
                          $num = mysql_num_rows($result) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
                          $sno=1;
                          while($row = mysql_fetch_array($result)) 
                          { 
                            $sql_idate="select * from ms_department where insert_date='".date('Y-m-d')."' and department_id='".$row['department_id']."'";
                            $res_idate=mysql_query($sql_idate);
                            $row_idate=mysql_fetch_array($res_idate);
                            $insert_date=$row_idate['insert_date'];
                            ?>
                            <tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
                              <td align="center"><?= $sno++;?></td>
                              <td align="center"><?=$row["department_id"]?></td>
                              <td align="center"><?=$row["name"]?></td>
                              <?
                              if(1)
                              { //$SessionUserType=='Administrator' || (date('Y-m-d')==$insert_date)
                              ?>
                                <td align="center">
                                  <a href="store_add_department.php?department_id=<?=$row["department_id"]?>&mode=edit">
                                  	<img src="images/icon_edit.gif" alt="Edit" title="Edit" border="0" />
                                  </a>
                                </td>
                                <td align="center">
                                  <a href="javascript:;" onClick="overlay(<?=$row["department_id"]?>);">
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
                          <tr bgcolor="#f9f8f9">
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