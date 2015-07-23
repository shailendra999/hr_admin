<?
include("inc/maint_header.php");
?>
<script>
function overlay(id) {
    el = document.getElementById("overlay");
	document.getElementById("hidden_overlay").value=id;
	el.style.visibility = (el.style.visibility == "visible") ? "hidden" : "visible";	
}
function getDataInDiv(value,divId,page,byControl)
{
		var strURL1;
		if(value=="" && byControl=="DateFromTo")
		{
			var from=document.getElementById('RDFrom').value;
			var to=document.getElementById('RDTo').value;
			var value=from+','+to;
			strURL1=page+"?value="+value+"&byControl="+byControl;

		}
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
$PageKey = "services_id";
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
$sql_idate="select max(insert_date) from maint_services";
$res_idate=mysql_query($sql_idate);
$row_idate=mysql_fetch_array($res_idate);
$insert_date=$row_idate['insert_date'];
$colspan=0;
?>
<?
$sql="select * from maint_services order by name asc";
$result=mysql_query($sql);
?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
  <tr>
    <td align="left" valign="top" width="230px" style="padding-top:5px;">
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
                <td class="AddMore">
                  <!--<a target="_blank" href="maint_printall_issue_entry.php" title="Print">Print All&nbsp;&nbsp;&nbsp;</a>-->
                </td>
              </tr>
              <tr>
                <td align="center" class="border" >
                	<div id="div_message" style="color:#399;font-size:16px;font-weight:bold;"><?=$Message?></div>
                  <table id="" align="center" width="100%" border="1" class="table1 text_1">
                    <tr>
                      <td align="center" colspan="10"><b>Search Items</b></td>
                    </tr>
                    <tr>
                      <td width="15%"><b>Department</b></td>
                      <td width="20%">
                      	<select id="department_code" name="department_code" style="width:100%" onchange="getDataInDiv(this.value,'getDataInDiv','maint_get_list_LT.php','Department')">
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
                      <td width="20%"><b>Reading Date(Format dd-mm-yyyy)</b></td>
                      <td width="20%">
                      <input type="text" name="readingDate" id="readingDate" />
                      	<a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.getElementById('readingDate'));return false;" HIDEFOCUS>
                        	<img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
                        </a> 
                        <input type="button" id="btnOk" name="btnOk" value="Ok" onclick="getDataInDiv(document.getElementById('readingDate').value,'getDataInDiv','maint_get_list_LT.php','ReadingDate')"/>
                       </td>
                    </tr>
                    <tr>
                    	<td><b>Date From</b></td>
                      <td width="20%">
                      <input type="text" name="RDFrom" id="RDFrom" />
                      	<a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.getElementById('RDFrom'));return false;" HIDEFOCUS>
                        	<img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
                        </a> 
                       </td>
                       <td><b>Date To</b></td>
                      <td width="20%">
                      <input type="text" name="RDTo" id="RDTo" />
                      	<a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.getElementById('RDTo'));return false;" HIDEFOCUS>
                        	<img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
                        </a> 
                        <input type="button" id="btnOk" name="btnOk" value="Ok" onclick="getDataInDiv('','getDataInDiv','maint_get_list_LT.php','DateFromTo')"/>
                       </td>
                    </tr>
                  </table>
                  <div id="getDataInDiv" style="margin:0 auto;width:100%;overflow:auto;height:600px">
                    <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0" class="tableborder">
                      <tr>
                        <td valign="top">	
                          <?  
                            if(mysql_num_rows($result)>0)
                            {
                                $sno =1;
                            ?>
                            <table align="center" id="tableEntry" width="100%" border="1" class="table1 text_1">
                              <tr>
                                <td class="gredBg">S.No.</td>
                                <td class="gredBg">Department</td>
                                <td class="gredBg">Name</td>
                                <td class="gredBg">Duration</td>
                                <?
																 if($SessionUserType=='Administrator' || (date('Y-m-d')==$insert_date))
																 {
																	 $colspan=6;
																	?>
																		<td width="4%" class="gredBg">Edit</td>
                                		<td width="4%" class="gredBg">Delete</td>
																	<?
																 }
																 else
																 	$colspan=4;
																?>
                                
                              </tr>
                              <?
                                while($row=mysql_fetch_array($result))
                                {	
                              ?>
                              <tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
                                <td align="center"><?=$sno?></td>
                                <td align="center">
                                <?
                                  $sql_dep = "select * from maint_department where department_code = '".$row['department_code']."' ";
                                  $res_dep = mysql_query($sql_dep) or die ("Invalid query : ".$sql_dep."<br>".mysql_errno().":".mysql_error());
                                  $row_dep = mysql_fetch_array($res_dep);
                                  echo $row_dep['name'];
                                ?>	
                                </td>
                                <td align="center"><?= $row['reading']?></td>
                                <td align="center"><?= getDateFormate($row['reading_date'])?></td>
                                <td align="center">
                                  <a href="maint_add_services.php?services_id=<?=$row["services_id"]?>&mode=edit">
                                    <img src="images/icon_edit.gif" alt="Edit" title="Edit" border="0" />
                                  </a>
                                </td>
                                <td align="center">
                                  <a href="javascript:;" onClick="overlay(<?=$row["services_id"]?>);">
                                    <img src="images/delete_icon.gif" alt="Delete" title="Delete" border="0">
                                  </a>
                                </td>
                              </tr>
                                <?
                                   $sno++;
                                  }	
                              ?>  
                              <tr>
                              	<td colspan="<?=$colspan?>" align="center">No Records Found</td>
                              </tr>       
                          </table>
                          <?
                          }
                          ?>        
                      	</td>
                   		</tr>
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