<?
include("inc/maint_header.php");
?>
<style type="text/css" media="print">
#btn_print, form, .tnb_print, img, .top_tnb, .header_bg, .welcome_txt, .gray_bg, iframe, #overlay
{
	display:none;
}
#getItemsInDiv
{
	display:block;
	height:auto;
}
</style>
<script>
function overlay(id) {
  el = document.getElementById("overlay");
	document.getElementById("hidden_overlay").value=id;
	el.style.visibility = (el.style.visibility == "visible") ? "hidden" : "visible";	
}
function getDataInDiv(value,divId,page,byControl)
{
		var strURL1;
		strURL1=page+"?value="+value+"&byControl="+byControl;
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
</script>

<?
$Page = "maint_list_job.php";
$PageTitle = "List Job";
$PageFor = "Job";
$PageKey = "job_code";
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
	$PageKeyValue  = $_POST["hidden_overlay"];
	echo $sql = "delete from maint_job where job_code = '".$PageKeyValue."'";
	if(mysql_query ($sql))
	{
		$Message = "Record Sucessfully Deleted";
	}
	//$Message = "Order Sucessfully Deleted";
	redirect("$Page?Message=$Message");
}

?>
<?
$search = "";
if(isset($_POST["btn_submit"]))
{
	$department_code = $_POST["department_code"];
	
	$search .= ($department_code!="") ? " and maint_machine_master.department_code = '$department_code'" : "";
	
	$service_id = $_POST["service_id"];
	
	$search .= ($service_id!="") ? " and maint_job.service_id = '$service_id'" : "";
	
	
	$machine_id = $_POST["machine_id"];
	
	$search .= ($machine_id!="") ? " and maint_job.machine_id = '$machine_id'" : "";
	
	
}
$sql="select * from maint_job, maint_machine_master where maint_job.machine_id = maint_machine_master.machine_id $search order by schedule_date asc";
$result=mysql_query($sql);
?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
  <tr>
    <td align="left" valign="top" width="230px" style="padding-top:5px;" class="tnb_print">
    <? include ("inc/maint_snb.php"); ?>
    </td>
    <td style="padding-left:5px; padding-top:5px;" valign="top">
      <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
          <td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; List Job</td>
        </tr>
        <tr>
          <td valign="top">
            <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
                <td align="center" class="border" >
                	<div id="div_message" style="color:#399;font-size:16px;font-weight:bold;"><?=$Message?></div>
                    <form id="frm_search" name="frm_search" method="post" action="">
                    <table id="" align="center" width="100%" border="1" class="table1 text_1">
                    <tr>
                      <td align="center" colspan="7"><b>Search Items</b></td>
                    </tr>
                    <tr>
                      <td align="left"><b>Department</b></td>
                      <td align="left">
                      	<select id="department_code" name="department_code" style="width:150px">
                        	<option value="">-Select-</option>
                        <?
												$sql_d="select * from maint_department order by name";
                        $res_d=mysql_query($sql_d);
												while($row_d=mysql_fetch_array($res_d))
												{
												?>
                        	<option value="<?= $row_d['department_code']?>"><?= $row_d['name']?></option>
												<?	
                        }
												?>
                        </select>
                      </td>
                      <td align="left"><b>Service</b></td>
                      <td align="left">
                      	<select id="service_id" name="service_id" style="width:150px">
                        <option value="">-Select-</option>
													<?
                          $sql_S="select * from maint_services order by name";
                          $res_S=mysql_query($sql_S);
                          while($row_S=mysql_fetch_array($res_S))
                          {
                          ?>
                            <option value="<?= $row_S['service_id']?>"><?= $row_S['name']?></option>
                          <?	
                          }
                          ?>
                        </select>
                        
                       </td>
                       <td align="left"><b>Machine</b></td>
                      <td align="left">
                      	<select id="machine_id" name="machine_id" style="width:150px">
                        <option value="">-Select-</option>
													<?
                          $sql_S="select * from maint_machine_master order by name";
                          $res_S=mysql_query($sql_S);
                          while($row_S=mysql_fetch_array($res_S))
                          {
                          ?>
                            <option value="<?= $row_S['machine_id']?>"><?= $row_S['name']?></option>
                          <?	
                          }
                          ?>
                        </select>
                       </td>
                       <td>
                       	<input type="submit" id="btn_submit" name="btn_submit" value="Filter" />
                       </td>
                    </tr>
                  </table>
                  </form>
                    
                    <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0" class="tableborder">
                      <tr>
                        <td valign="top">
                         <div>
                         	<table align="center" id="tableEntry" width="100%" border="1" class="table1 text_1">
                            <tr>
                              <td class="gredBg" width="7%">S.No.</td>
                              <td class="gredBg" width="8%">Job Code</td>
                              <td class="gredBg" width="9%">Sch. Date</td>
                              <td class="gredBg" width="20%">M/C Name</td>
                              <td class="gredBg" width="35%">Service Name</td>
                              <td class="gredBg" width="9%">Status</td>
                              <td width="4%" class="gredBg tnb_print">View</td>
                              <td width="4%" class="gredBg tnb_print">Edit</td>
                              <td width="4%" class="gredBg tnb_print">Delete</td>
                            </tr>	
                            <?  
                            if(mysql_num_rows($result)>0 and isset($_POST["btn_submit"]))
                            {
                              $sno =1;
                              while($row=mysql_fetch_array($result))
                              {	
                                $sql_idate="select * from maint_job where insert_date='".date('Y-m-d')."' and job_id='".$row['job_id']."'";
                                $res_idate=mysql_query($sql_idate);
                                $row_idate=mysql_fetch_array($res_idate);
                                $insert_date=$row_idate['insert_date'];
                              ?>
                              <tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
                                <td align="center"><?=$sno?></td>
                                <td align="center"><?=$row['job_code']?></td>
                                <td align="center"><b><?=getDateFormate($row['schedule_date'])?></b></td>
                                <td align="left" style="padding-left:5px">
                                <?
                                  $sql_M = "select mmm.name from maint_machine_master mmm,maint_job mj where mmm.machine_code= '".$row['machine_id']."' and mj.job_code='".$row['job_code']."' and mmm.machine_code=mj.machine_id";
                                  $res_M = mysql_query($sql_M) or die ("Invalid query : ".$sql_M."<br>".mysql_errno().":".mysql_error());
                                  $row_M = mysql_fetch_array($res_M);
                                  echo $row_M['name'];
                                ?>
                                </td>
                                <td align="left" style="padding-left:5px">
                                <?
                                  $sql_S = "select ms.name from maint_services ms,maint_job mj where ms.s_code =mj.service_id and mj.job_code='".$row['job_code']."' and mj.service_id=ms.s_code";
                                  $res_S = mysql_query($sql_S) or die ("Invalid query : ".$sql_S."<br>".mysql_errno().":".mysql_error());
                                  $row_S = mysql_fetch_array($res_S);
                                  echo $row_S['name'];
                                ?>
                                </td>
                                <td align="center">
                                  <? 
                                    $status=$row['status'];
                                    $d_f='';
                                    if($status=="P")
                                      $d_t="Pending";
                                    else if($status=="F")
                                      $d_t="Finished";
                                    else if($status=="C")
                                      $d_t="Cancelled";
                                    echo $d_t;
                                  ?>
                                </td>
                                <td align="center" class="tnb_print">
                                  <a href="maint_view_job.php?job_code=<?=$row["job_code"]?>">
                                  <img src="images/search-icon.gif" alt="View" title="View" border="0" /></a>
                                </td> 
                               <?
                               if($SessionUserType=='Administrator' || (date('Y-m-d')==$insert_date))
                               {
                                ?>
                                <td align="center" class="tnb_print">
                                  <a href="maint_add_job.php?job_code=<?=$row["job_code"]?>&mode=edit">
                                    <img src="images/icon_edit.gif" alt="Edit" title="Edit" border="0" />
                                  </a>
                                </td>
                                <td align="center" class="tnb_print">
                                  <a href="javascript:;" onClick="overlay(<?=$row["job_code"]?>);">
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
                                 $sno++;
                                }	
                              }
                              else
                              {
                                  ?>
                                  <tr>
                                    <td colspan="9" align="center"><b>No Records Found</b></td>
                                  </tr> 
                                  <?
                              }
                            ?>        
                          </table>
                           <input type="button" id="btn_print" name="btn_print" value="Print" onclick="window.print();" />
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