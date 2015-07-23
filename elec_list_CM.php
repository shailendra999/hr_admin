<?
include("inc/elec_header.php");
?>
<style>
.getDataInDiv
{
	background:#fff;
	border:1px solid #96A2BC;
	overflow:hidden;
}
</style>

<script type="text/javascript">
function overlay(id) {
    el = document.getElementById("overlay");
	document.getElementById("hidden_overlay").value=id;
	el.style.visibility = (el.style.visibility == "visible") ? "hidden" : "visible";	
}
function getMachineData() {
	var deptId = document.getElementById("department_id").value;
	document.getElementById("div_machine").style.border="none";
	//alert(deptId);
	document.getElementById("div_machine").style.padding="0";	
	get_frm("elec_get_machine.php",deptId,"div_machine",'');
}
function getDataInDiv(divId,page)
{
		var strURL1;
		var department_id=document.getElementById('department_id').value;
		var machine_id=document.getElementById('machine_id').value;
		var dfrom=document.getElementById('DFrom').value;
		var dto=document.getElementById('DTo').value;
		if(department_id==0 || machine_id==0 || dfrom=='' ||dto==''  )
		{
			alert("Check All Fields");
			return false;
		}
		else
		{
			var value=department_id+','+machine_id+','+dfrom+','+dto;
			strURL1=page+"?value="+value+"&sid="+Math.random();
			//alert(strURL1);
			var req = getXMLHTTP();
			if (req)
			{																					
					req.onreadystatechange = function() {
							if (req.readyState == 4) {
									if (req.status == 200)                         
											document.getElementById(divId).innerHTML=req.responseText;
									 else 
											alert("There was a problem while using XMLHTTP:\n" + req.statusText);
							}                
					}            
					req.open("GET", strURL1, true);
					req.send(null);
			}
		}
}
</script>

<?
$Page = "elec_list_CM.php";
$PageTitle = "List Compressor Maintenance";
$PageFor = "Compressor Maintenance";
$PageKey = "CM_id";
$PageKeyValue = "";
$Message = "";

?>
<?
if(isset($_GET["Message"]))
{
	$Message = $_GET["Message"];
}
if(isset($_POST["btn_del"]))
{
	$id  = $_POST["hidden_overlay"];
	$sql = "delete from elec_CM_master where CM_id='".$id."'";
	if(mysql_query ($sql))
	{
		$Message = "Record Sucessfully Deleted";
	}
	//$Message = "Order Sucessfully Deleted";
	//redirect("$Page?Message=$Message");
}

?>
<?
$sql="select * from elec_CM order by CM_date";
$result=mysql_query($sql);

?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
  <tr>
    <td align="left" valign="top" width="230px" style="padding-top:5px;">
    <? include ("inc/elec_snb.php"); ?>
    </td>
    <td style="padding-left:5px; padding-top:5px;" valign="top">
      <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
          <td align="center" class="gray_bg">
          	<img src="images/bullet.gif" width="15" height="22"/> &nbsp; List Compressor Maintenance
          </td>
        </tr>
        <tr>
          <td valign="top">
            <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td class="AddMore">
                  <!--<a target="_blank" href="elec_printall_issue_entry.php" title="Print">Print All&nbsp;&nbsp;&nbsp;</a>-->
                </td>
              </tr>
              <tr>
                <td align="center" class="border" >
                	<div id="div_message" style="color:#399;font-size:16px;font-weight:bold;"><?=$Message?></div>
                  <table align="center" width="100%" border="1" class="table1 text_1">
                    <tr>
                      <td align="center" colspan="4"><b>Search Items</b></td>
                    </tr>
                    <tr>
                    	<td align="left"><b>Department</b></td>
                    	<td align="left">
                      	<?
						$sql_dept= "select * from elec_department order by name asc";
						$res_dept = mysql_query ($sql_dept) or die (mysql_error());
						?>
						<select name="department_id" id="department_id" onChange="getMachineData()" style="width:150px;">
							<option value="0"></option>
							<?
							if(mysql_num_rows($res_dept)>0)
							{
								while($row_dept = mysql_fetch_array($res_dept))
								{
								?>
								<option value="<?= $row_dept['department_id']; ?>" ><?= $row_dept['name']?></option>
								<?
								}
						}	
						?>
				  		</select>
                      </td>
                      <td align="left"><b>Machine</b></td>
                      <td align="left">
                        <div id="div_machine" style="height:20px;width:150px;" class="getAjaxDataInDiv"></div>
                       </td>
                    </tr>
                    <tr>
                    	<td><b>Date From</b></td>
                      <td>
                      <input type="text" name="DFrom" id="DFrom" />
                      	<a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.getElementById('DFrom'));return false;" HIDEFOCUS>
                        	<img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
                        </a> 
                       </td>
                       <td><b>Date To</b></td>
                      <td>
                      <input type="text" name="DTo" id="DTo" />
                      	<a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.getElementById('DTo'));return false;" HIDEFOCUS>
                        	<img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
                        </a> 
                        <input type="button" id="btnOk" name="btnOk" value="Ok" onclick="getDataInDiv('getDataInDiv','elec_get_list_CM.php')"/>
                       </td>
                    </tr>
                  </table>
                  <div id="getDataInDiv" style="margin:0 auto;width:100%;overflow:auto;height:850px;">
                    <table align="center" width="100%" border="1" class="table1 text_1">
                      <tr>
                        <td class="gredBg">S.No.</td>
                        <td class="gredBg">Date</td>
                        <td class="gredBg">Department</td>
                        <td class="gredBg">Machine</td>
                        <td class="gredBg">Details</td>
                        <td width="4%" class="gredBg">Edit</td>
                        <td width="4%" class="gredBg">Delete</td>
                      </tr>
                      <?
                        if(mysql_num_rows($result)>0)
                        {
                          $sno=1;
                          $count=1;
                          while($row=mysql_fetch_array($result))
                          {
                            $sql_idate="select * from elec_CM where insert_date='".date('Y-m-d')."' and CM_id='".$row['CM_id']."'";
                            $res_idate=mysql_query($sql_idate);
                            $row_idate=mysql_fetch_array($res_idate);
                            $insert_date=$row_idate['insert_date'];
                            ?>
                            <tr>
                              <td align="center"><?=$sno++?></td>
                              <td align="center"><?=getDateFormate($row['CM_date'])?></td>
<td align="left" style="padding-left:5px">
                                <?
																$sqlD="select name from elec_department where department_id='".$row['department_id']."'";
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
                                $sqlM="select name from elec_machine where machine_id='".$row['machine_id']."'";
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
                                <td align="left" style="padding-left:5px"><?=stripcslashes($row['details'])?></td>
																<?
                                if(1)
                                {
									//$SessionUserType=='Administrator' || (date('Y-m-d')==$insert_date)
                                  ?>
                                   <td align="center">
                                      <a href="elec_add_CM.php?CM_id=<?=$row["CM_id"]?>&mode=edit">
                                        <img src="images/icon_edit.gif" alt="Edit" title="Edit" border="0" />
                                      </a>
                                    </td>
                                    <td align="center">
                                      <a href="javascript:;" onClick="overlay(<?=$row["CM_id"]?>);">
                                        <img src="images/delete_icon.gif" alt="Delete" title="Delete" border="0">
                                      </a>
                                    </td>
                                    <?
                                  $count++;
                                }
                                else
                                {
                                ?>
                                  <td align="center" ></td>
                                  <td align="center" ></td>
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
                          <td colspan="7" align="center" style="font-weight:bold">No Records Found</td>
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
<iframe width=168 height=190 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="calendar/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
</iframe> 
<div id="overlay">
   <div class="form_msg">
      <p>Are you sure to delete this Record</p>
      <form name="frm_del" action="<?=$_SERVER['PHP_SELF']?>" method="post">
        <input type="hidden" name="hidden_overlay" id="hidden_overlay" value="" />
        <input type="submit" name="btn_del" value="Yes" />
        <input type="button" onClick="overlay();" name="btn_close" value="No" />
      </form>
   </div>
</div>

<? 
include("inc/hr_footer.php");
?>