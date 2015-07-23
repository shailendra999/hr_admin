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
$Page = "maint_list_services.php";
$PageTitle = "List Services";
$PageFor = "Services";
$PageKey = "service_id";
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
	$sql = "delete from maint_services where $PageKey = '".$PageKeyValue."'";
	if(mysql_query ($sql))
	{
		$Message = "Record Sucessfully Deleted";
	}
	//$Message = "Order Sucessfully Deleted";
	redirect("$Page?Message=$Message");
}

?>
<?
$colspan=0;
?>
<?
$sql="select * from maint_services order by name asc";
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
          <td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; List Services</td>
        </tr>
        <tr>
          <td valign="top">
            <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td align="center" class="border" >
                	<div id="div_message" style="color:#399;font-size:16px;font-weight:bold;"><?=$Message?></div>
                    <div class="tnb_print">
                  <table id="" align="center" width="100%" border="1" class="table1 text_1">
                    <tr>
                      <td align="center" colspan="4"><b>Search Items</b></td>
                    </tr>
                    <tr>
                      <td align="left"><b>Department</b></td>
                      <td align="left">
                      	<select id="department_code" name="department_code" style="width:150px" onchange="getDataInDiv(this.value,'getDataInDiv','maint_get_list_services.php','Department')">
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
                      	<select id="service_id" name="service_id" style="width:150px" onchange="getDataInDiv(this.value,'getDataInDiv','maint_get_list_services.php','Services')">
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
                    </tr>
                  </table>
                  </div>
                  <div id="getDataInDiv" style="margin:0 auto;width:100%;">
                    <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0" class="tableborder">
                      <tr>
                        <td valign="top">
                        	<table align="center" id="tableEntry" width="100%" border="1" class="table1 text_1">
                            <tr>
                              <td class="gredBg">S.No.</td>
                              <td class="gredBg">Department</td>
                              <td class="gredBg">Name</td>
                              <td class="gredBg">Duration</td>
                              <td width="4%" class="gredBg tnb_print">View</td>
                              <td width="4%" class="gredBg tnb_print">Edit</td>
                              <td width="4%" class="gredBg tnb_print">Delete</td>
                            </tr>	
														<?  
														if(mysql_num_rows($result)>0)
														{
															$sno =1;
															while($row=mysql_fetch_array($result))
															{	
																$sql_idate="select * from maint_services where insert_date='".date('Y-m-d')."' and service_id='".$row['service_id']."'";
																$res_idate=mysql_query($sql_idate);
																$row_idate=mysql_fetch_array($res_idate);
																$insert_date=$row_idate['insert_date'];
															?>
                              <tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
                                <td align="center"><?=$sno?></td>
                                <td align="left" style="padding-left:5px">
                                <?
                                  $sql_dep = "select * from maint_department where department_code = '".$row['department_code']."' ";
                                  $res_dep = mysql_query($sql_dep) or die ("Invalid query : ".$sql_dep."<br>".mysql_errno().":".mysql_error());
                                  $row_dep = mysql_fetch_array($res_dep);
                                  echo $row_dep['name'];
                                ?>	
                                </td>
                                <td align="left" style="padding-left:5px"><?= $row['name']?></td>
                                <td align="center">
                                  <? 
                                    $duration=$row['duration'];
                                    $duration_type=$row['duration_type'];
                                    $d_f='';
                                    if($duration_type=="M")
                                      $d_t="Month(s)";
                                    else if($duration_type=="D")
                                      $d_t="Day(s)";
                                    echo $duration.' '.$d_t;
                                  ?>
                                </td>
                                <td align="center" class="tnb_print">
                                  <a href="maint_view_services.php?service_id=<?=$row["service_id"]?>">
                                  <img src="images/search-icon.gif" alt="View" title="View" border="0" /></a>
                                </td> 
															 <?
                               if($SessionUserType=='Administrator' || (date('Y-m-d')==$insert_date))
                               {
                                 $colspan=6;
                                ?>
                                <td align="center" class="tnb_print">
                                  <a href="maint_add_services.php?service_id=<?=$row["service_id"]?>&mode=edit">
                                    <img src="images/icon_edit.gif" alt="Edit" title="Edit" border="0" />
                                  </a>
                                </td>
                                <td align="center" class="tnb_print">
                                  <a href="javascript:;" onClick="overlay(<?=$row["service_id"]?>);">
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
                                    <td colspan="7" align="center"><b>No Records Found</b></td>
                                  </tr> 
                                  <?
															}
                          	?>        
                          </table>
                      	</td>
                   		</tr>
                 		</table>
                        
                	</div>
                    <input type="button" id="btn_print" name="btn_print" value="Print" onclick="window.print();" />
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
      <p>Are you sure to delete this Item</p>
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