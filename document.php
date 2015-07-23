<?
include("inc/adm0_header.php");
?>
<script type="text/javascript" src="javascript/form.js"></script>
<script type="text/javascript" src="javascript/popup.js"></script>
<script language="JavaScript1.2">
function validate_form(form)
{
	return(
				checkString(form.elements["sel_docfor"],"Select User Type",false)&&
				checkString(form.elements["txt_document"],"Enter Document Name",false) &&
					
				CheckRadioButtonValue(form.elements["txt_detail"])
		   );
}
function CheckRadioButtonValue (radio) 
{
	var radio_choice = false;

	for (var i = 0; i < radio.length; i++) 
	{
    	if (radio[i].checked) 
		{
			radio_choice = true;
			break
		}
  	}
	if (!radio_choice)
	{
		// If there were no selections made display an alert box 
		Popup.showModal('modal',null,null,{'screenColor':'#99ff99','screenOpacity':.6}, 'Please Select Document Type');
		return (false);
	}
	return (true);
}
</script>
<script type="text/javascript" src="ajax/common_function.js"></script>
<script>
function show_div(str,str1,hid)
{	
	document.getElementById(hid).value = str1;
	document.getElementById(str).style.display='block';
}
</script>
<script>
function overlay(id) {
	el = document.getElementById("overlay");
	document.getElementById("hidden_overlay").value=id;
	el.style.visibility = (el.style.visibility == "visible") ? "hidden" : "visible";
	
}
</script>
<script language="javascript1.2">
function delete_div(div_id)
{
	var id= div_id;
	
	document.getElementById(id).innerHTML='';
}
function edit_div(div_id, value)
{
	var id= div_id;
	
	document.getElementById(id).innerHTML=value;
}
function close_div(a)
{
	var id= a;
	
	document.getElementById(id).style.display='none';
}
</script>
<?
$id= '';
$docfor = '';
if(isset($_GET['id']))
{
	$id = $_GET['id'];
    $docfor = getDocumentDetail('DocumentFor','rec_id',$id);
}
?>
<?
$msg = '';
if(!session_is_registered("no_refresh"))
{
	$_SESSION['no_refresh'] = "";
}
if(isset($_POST['hidden_docfor']))
{
	if($_POST['no_refresh'] == $_SESSION['no_refresh'])
	{	
		//echo "WARNING: Do not try to refresh the page.";
	}
	else
	{
		 $document = $_POST['txt_document'];	
		 $hidden_docfor = $_POST['hidden_docfor'];
		 $ip = $_SERVER['REMOTE_ADDR'];
		 $other_detail = (isset($_POST['txt_detail'])) ? $_POST['txt_detail'] : "";
		 
		 $sql_ins = "insert into ".$mysql_adm_table_prefix."document_master set
		 																		DocumentFor = '$hidden_docfor',
																				DocumentName = '$document',
																				OtherDetail = '$other_detail',
																				InsertBy = '$SessionUserType',
																				InsertDate = now(),
																				IpAddress = '$ip' ";
		$result_ins = mysql_query($sql_ins) or die("Error in query:".$sql_ins."<br>".mysql_error().":".mysql_errno());
		$_SESSION['no_refresh'] = $_POST['no_refresh'];
		$msg = "Document Successfully Inserted";		
		$docfor	= $_POST['hidden_docfor'];													 
	}
}	
?>
<?
//////******************** Edit Document **************///////
if(isset($_POST['doc_id']))
{
	$doc_id = $_POST["doc_id"];
	$txt_docname = $_POST["txt_docname"];
	
	$sql_up = "update ".$mysql_adm_table_prefix."document_master set DocumentName = '$txt_docname' where rec_id= '$doc_id'";
	$result_up = mysql_query($sql_up) or die ("Query Failed ".mysql_error());
	if($result_up)
	{
		$msg="Document Name Updated!!";
	}
	else
	{
		$msg="Error In Updating Document!!";
	}
}
?>
<?
////////**************** Delete Document ********************* /////////
if(isset($_POST['docid']))
{
	$sql_del = "delete from ".$mysql_adm_table_prefix."document_master where rec_id='".$_POST["docid"]."'";
	$result_del = mysql_query($sql_del) or die ("Query Failed ".mysql_error());
	if($result_del)
	{
		$msg="Document Name Deleted!!";
	}
	else
	{
		$msg="Error In  Deleteting Document!!";
	}
}
?>

<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
    <tr>
    	<td align="left" valign="top" width="230px" style="padding-top:5px;">
			<? include ("inc/adm0_snb.php"); ?>
        </td>
        <td style="padding-left:5px; padding-top:5px;">
        	<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
            	<tr>
                	<td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; Documents</td>
                </tr>
                <tr>
                	<td valign="top">
                        <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td>
                                    <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
                                        <tr>
                                            <td align="center" valign="top" style="padding-top:5px;">
                                                <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
                                                    <tr>
                                                        <td class="red"><?=$msg?></td>
                                                     </tr>
                                                     <tr>
                                                        <td style="padding-top:10px;" align="center">
                                                            <form name="frm_adddocument" id="frm_adddocument" action="" method="post" onsubmit="return validate_form(this);">
                                                                <div style="padding-bottom:10px;">
                                                                    <table align="center" width="40%" cellpadding="0" cellspacing="0">
                                                                        <tr>
                                                                            <td align="left" width="10px"><img src="images/tnb_left.jpg" width="10" height="35"/></td>
                                                                            <td class="welcome_txt" align="left">
                                                                                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                                    <tr>
                                                                                        <td align="left" width="27%" class="orange_head">User Type</td>
                                                                                        <td align="left" width="9%"><img src="images/tnb_div_1.jpg" width="7" height="35"/></td>
                                                                                        <td width="64%" align="left">
                                                                                        <select name="sel_docfor" id="sel_docfor" onchange="get_frm_new('get_documentlist.php',this.value,'div_document','add_doc','hidden_docfor');" style="width:150px; height:20px;">
                                                                                          <option value="">--Select--</option>
                                                                                          <option value="Export" <? if($docfor=='Export'){?> selected="selected"<? } ?>>Export</option>
                                                                                          <option value="Domestic" <? if($docfor=='Domestic'){?> selected="selected"<? } ?>>Domestic</option>
                                                                                        </select>
                                                                                      </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                            <td align="right" width="10px"><img src="images/tnb_right.jpg" width="10" height="35"/></td>
                                                                        </tr>
                                                                     </table>
                                                                </div>
                                                                <div id="add_doc" <? if(!isset($_POST['hidden_docfor']) or $docfor==""){ ?>style="display:none;padding-bottom:10px;"<? } ?>>
                                                                     <table align="center" width="40%" cellpadding="0" cellspacing="0">
                                                                        <tr>
                                                                            <td align="left" width="10px" valign="top"><img src="images/tnb_left.jpg" width="10" height="35"/></td>
                                                                            <td class="welcome_txt" align="left">
                                                                                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                                    <tr>
                                                                                        <td align="left" width="35%" class="loginTxt" style="padding-left:0px;">Document Name</td>
                                                                                        <td align="left" width="10%"><img src="images/tnb_div_1.jpg" width="7" height="35"/></td>
                                                                                        <td width="55%" align="left">
                                                                                            <input type="text" name="txt_document" id="txt_document" value="" style="width:180px; height:20px;"/>
                                                                                            <input type="hidden" name="hidden_docfor" id="hidden_docfor" value="" />
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="loginTxt" colspan="3" align="center">
                                                                                            <input type="radio" name="txt_detail" id="txt_detail" value="Date" />&nbsp;Date&nbsp;&nbsp;<input type="radio" name="txt_detail" id="txt_detail" value="Amount" />&nbsp;Amount&nbsp;&nbsp;<input type="radio" name="txt_detail" id="txt_detail" value="Number" />Number
                                                                                        </td>
                                                                                    </tr>    
                                                                                    <tr>    
                                                                                        <td colspan="3" align="center">
                                                                                            <input type="image" name="btn_submit" src="images/btn_submit.png" id="btn_submit" value="submit" />
                                                                                            <input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                            <td align="right" width="10px" valign="top"><img src="images/tnb_right.jpg" width="10" height="35"/></td>
                                                                            <td align="right" style="padding:5px;" valign="top"><img src="images/Exit.png" onclick="close_div('add_doc')" /></td>
                                                                        </tr>
                                                                     </table>
                                                            	</div>
                                                            </form>
                                                            <div id="div_document" style="height:200px;overflow:auto;width:100%;padding-top:10px;"align="center"></div>
															<?
															if($docfor!='')
															{
															?>	
																<script language="javascript">
                                                                    get_frm_new('get_documentlist.php','<?=$docfor?>','div_document','add_doc','hidden_docfor');
                                                                </script>	
															<?	
															}
															?>		
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
        </td>
    </tr>
</table>
<DIV id=modal style="DISPLAY: none;">
  <div style="padding: 0px; background-color: rgb(37, 100, 192); visibility: visible; position: relative; width: 222px; height: 202px; z-index: 10002; opacity: 1;">
    <div onClick="Popup.hide('modal')" style="padding: 0px; background: transparent url(./images/close.gif) no-repeat scroll 0%; visibility: visible; position: absolute; left: 201px; top: 1px; width: 20px; height: 20px; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; cursor: pointer; z-index: 10004;" id="adpModal_close"></div>
    <div style="padding: 0px; background: transparent url(resize.gif) no-repeat scroll 0%; visibility: visible; position: absolute; width: 9px; height: 9px; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; cursor: nw-resize; z-index: 10003;" id="adpModal_rsize"></div>
    <div style="padding: 0px; overflow: hidden; background-color: rgb(140, 183, 231); visibility: visible; position: absolute; left: 1px; top: 1px; width: 220px; height: 20px; font-family: arial; font-style: normal; font-variant: normal; font-weight: bold; font-size: 9pt; line-height: normal; font-size-adjust: none; font-stretch: normal; color: rgb(15, 15, 15); cursor: move;" id="adpModal_adpT"></div>
    <div style="border-style: inset; border-width: 0px; padding: 8px; overflow: hidden; background-color: rgb(118, 201, 238); visibility: visible; position: absolute; left: 1px; top: 21px; width: 204px; height: 164px; font-family: MS Sans Serif; font-style: normal; font-variant: normal; font-weight: bold; font-size: 11pt; line-height: normal; font-size-adjust: none; font-stretch: normal; color: rgb(28, 94, 162);" id="adpModal_adpC">
      <center>
        <p>
        <div id="div_message"></div>
        </p>
        <p style="font-size: 10px; color: rgb(253, 80, 0);">To gain access to the page behind the popup must be closed</p>
      </center>
    </div>
  </div>
</DIV>                                  
<? 
include("inc/footer.php");
?>