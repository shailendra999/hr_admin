<?
include("inc/store_header.php");
?>
<script>
function overlay(id) {
  el = document.getElementById("overlay");
	document.getElementById("hidden_overlay").value=id;
	el.style.visibility = (el.style.visibility == "visible") ? "hidden" : "visible";	
}

function checkData() {
  formDate = document.getElementById("formDate").value;
	formId = document.getElementById("formId").value;
	
	if(formDate=="" && formId=="")
	{
		alert("Select Date Or Supplier Or Item");
		return false;
	}
	else if(formDate!='')
	{
		document.getElementById("byControl").value="FormDate";return true;
	}
	else if(formId!='')
	{
		document.getElementById("byControl").value="FormId";return true;
	}
}
</script>

<?
$Page = "store_list_form.php";
$PageTitle = "List Form";
$PageFor = "Form";
$PageKey = "form_id";
$PageKeyValue = "";
$Message = "";
$byControl='';
$form_number = '';
if(date('m') > 03){	$gFinYear = date('Y').'-'.(date('Y')+1);	}else{	$gFinYear = (date('Y')-1).'-'.date('Y');	}
?>
<?
if(isset($_GET["Message"]))
{
	$Message = $_GET["Message"];
}
if(isset($_POST["btn_del"]))
{
	$PageKeyValue  = $_POST["hidden_overlay"];
	$sql = "delete from ms_form_master where $PageKey = '".$PageKeyValue."'";
	if(mysql_query($sql))
	{
	 	$sqltrans = "delete from ms_form_transaction where  $PageKey = '".$PageKeyValue."'";
	 	if(mysql_query($sqltrans))
			$Message = "Form Sucessfully Deleted";
	}
}

?>
<?
if(isset($_POST['btn_ok']))
{	
	$byControl=$_POST['byControl'];
	if($byControl=="FormDate")
	{
		$byControlValue=$_POST['formDate'];
		$formDate=getDateFormate($_POST['formDate']);
		$sql="select * from ms_form_master where form_date='".$formDate."'";
	}
	if($byControl=="FormId")
	{
		$byControlValue=$_POST['formId'];
		$formId=$_POST['formId'];
		$sql="select * from ms_form_master where form_id='".$formId."'";
	}
}
else
	$sql="select * from ms_form_master order by form_date asc";
	#$sql="select * from ms_form_master where finYear = '".$gFinYear."' order by form_date asc";
	$result=mysql_query($sql)or die("Error In : ".$sql."<br />".mysql_errno());
?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
  <tr>
    <td align="left" valign="top" width="230px" style=" padding-top:5px;">
    	<? include ("inc/store_snb.php"); ?>
    </td>
    <td style="padding-left:5px; padding-top:5px;" valign="top">
    	<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
          <td align="center" class="gray_bg">
            <img src="images/bullet.gif" width="15" height="22"/> &nbsp; List Form
          </td>
        </tr>
        <tr>
          <td>
            <form method="post" action="" onsubmit="return checkData();">
              <table width="80%" align="center" border="1" cellspacing="2" cellpadding="2" class="table1 text_1">
                <tr>
                  <td align="center" colspan="4"><b>Search Items</b></td>
                </tr>
                <tr>
                  <td align="left"><b>Form Id</b></td>
                  <td align="left">
                    <input type="text" name="formId" id="formId"/>
                  </td>
                  <td align="left"><b>Form Date</b></td>
                  <td align="left">
                    <input type="text" name="formDate" id="formDate" readonly="readonly"/>
                    <a hidefocus="" onclick="gfPop.fPopCalendar(document.getElementById('formDate'));return false;" href="javascript:void(0)">
                      <img height="22" border="0" align="absbottom" width="34" alt="" src="./calendar/calbtn.gif" name="popcal">
                    </a>
                    <input type="hidden" name="byControl" id="byControl" value="<?=$byControl ?>" />
                    <input type="submit" name="btn_ok" id="btn_ok" value="Ok"/>
                    <input type="button" name="btn_reset" id="btn_reset" value="Reset" onclick="location.href='store_list_form.php';"/>
                    </td>
                </tr>
              </table>
            </form>
          </td>
        </tr>
        <tr>
          <td valign="top">
          				
            <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td align="center" class="border" valign="top">
                	<div id="div_message" style="color:#399;font-size:16px;font-weight:bold;"><?=$Message?></div>
                  <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0" class="tableborder">
                    <tr>
                      <td valign="top">	
                      	<div id="getItemsInDiv" style="margin:0 auto;width:100%;overflow:auto;height:800px">
                        <?
													if($byControl!='')
													{
													?>
														<div class="AddMore" style="padding-top:10px">
														<form action="store_print_form.php" name="test" id="test" method="post" target="_blank"> 
															<input type="hidden" name="byControl" id="byControl" value="<?=$byControl ?>" />
															<input type="hidden" name="byControlValue" id="byControlValue" value="<?=$byControlValue ?>" />
																<a href="#" onclick="test.submit();">Print&nbsp;&nbsp;&nbsp;</a>
														 </form>
														</div>
													<?
													}
													?>
                          <table align="center" id="tableForm" width="100%" border="1" class="table1 text_1">
                            <tr>
                              <td class="gredBg">S.No.</td>
                              <td class="gredBg">Form Id.</td>
                              <td class="gredBg">Form Date.</td>
                              <td class="gredBg">Form No.</td>
                              <td class="gredBg">Supplier Name</td>
							  <td class="gredBg">Finacial Year</td>
                              <td class="gredBg">View</td>
                              <td class="gredBg">Edit</td>
                              <td class="gredBg">Delete</td>
                            </tr>
                            <?  
                            if(mysql_num_rows($result)>0)
                            {
                              $sno = 1;
                              while($row=mysql_fetch_array($result))
                              {	
																$sql_idate="select * from ms_form_master where insert_date='".date('Y-m-d')."' and form_id='".$row['form_id']."'";
																$res_idate=mysql_query($sql_idate);	
																$row_idate=mysql_fetch_array($res_idate);
																$insert_date=$row_idate['insert_date'];
                              ?>
                                <tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
                                  <td align="center"><?=$sno?></td>
                                  <td align="center"><?=$row['form_number']?></td>
                                  <td align="center"><?=getDateFormate($row['form_date'])?></td>
                                  <td align="left" style="padding-left:2px"><?=$row['form_no']?></td>
                                  <td align="left" style="padding-left:2px">
                                    <?
                                    $select_supp= "select * from ms_supplier where supplier_id='".$row['supplier_id']."' ";
                                    $result_supp = mysql_query ($select_supp) or die (mysql_error());
                                    $row_supp = mysql_fetch_array($result_supp);
                                    echo $row_supp['name'];
                                    ?>
                                  </td>
								  <td align="center"><?= $row['finYear']?></td>
                                  <td align="center">
                                    <a href="store_view_form.php?form_id=<?=$row["form_id"]?>">
                                    <img src="images/search-icon.gif" alt="View" title="View" border="0" />
                                    </a>
                                  </td> 
                                  <?
																	if($SessionUserType=='Administrator' || (date('Y-m-d')==$insert_date))
																	{
																	?>
                                  <td align="center">
                                    <a href="store_add_form.php?form_id=<?=$row["form_id"]?>&mode=edit">
                                    <img src="images/icon_edit.gif" alt="Edit" title="Edit" border="0" />
                                    </a>
                                  </td>
                                  <td align="center">
                                    <a href="javascript:;" onClick="overlay(<?=$row["form_id"]?>);">
                                    <img src="images/delete_icon.gif" alt="Delete" title="Delete" border="0">
                                    </a>
                                  </td>
                                   <?
																	}
																	else
																	{
																	?>
																	 <td></td>
																	 <td></td>   
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
																<tr><td align="center" colspan="7"><b>No Record Found.</b></td></tr>
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
    </td>
  </tr>
</table> 
<div id="overlay">
     <div class="form_msg">
          <p>Are you sure to delete this Form</p>
          <form name="frm_del" action="<?=$_SERVER['PHP_SELF']?>" method="post">
          <input type="hidden" name="hidden_overlay" id="hidden_overlay" value="" />
          <input type="submit" name="btn_del" value="Yes" />
          <input type="button" onClick="overlay();" name="btn_close" value="No" />
          </form>
     </div>
</div>
<iframe scrolling="no" height="172" frameborder="0" width="168" style="border: 2px ridge; visibility: hidden; z-index: 999; position: absolute; left: 502px; top: 216px;" src="calendar/ipopeng.htm" id="gToday:normal:agenda.js" name="gToday:normal:agenda.js">
</iframe>
<? 
include("inc/hr_footer.php");
?>