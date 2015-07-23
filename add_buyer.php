<?
include("inc/adm0_header.php");
?>
<script type="text/javascript" src="javascript/form.js"></script>
<script type="text/javascript" src="javascript/popup.js"></script>
<script language="JavaScript1.2">
function validate_form(form)
{
	return(
				 checkString(form.elements["txt_buyername"],"Buyer Name",false) &&
				 checkString(form.elements["country"],"Country",false) &&
				 checkString(form.elements["txt_address"],"Address",false) &&
				 checkEmail(form.elements["txt_email"],"Email Address",false) &&
				 checkString(form.elements["txt_pan"],"PAN",false) &&
				 checkString(form.elements["txt_tin"],"TIN",false) &&
				 checkString(form.elements["txt_cst"],"CST",false)
		   );
}
</script>
<script type="text/javascript" src="ajax/common_function.js"></script>
<?
$msg = '';
$buyer = '';
$emailid = '';
$contact = '';
$add = '';
$state = '';
$city = '';
$editid = '';
$country = '';
$buyertype = '';
$tinno = '';
$panno = '';
$title = '';
$name = '';
$tel = '';
$desig = '';
$mobile = '';
$email = '';
$otherstate = '';
$othercity = '';
$cstno = '';
if(!session_is_registered("no_refresh"))
{
	$_SESSION['no_refresh'] = "";
}
if(isset($_POST['btn_submit_x']))
{
	if($_POST['no_refresh'] == $_SESSION['no_refresh'])
	{	
		//echo "WARNING: Do not try to refresh the page.";
	}
	else
	{
		//$special = array("\"","'");
		$buyername = addslashes($_POST['txt_buyername']);
		$address = addslashes($_POST['txt_address']);
		$state = isset($_POST['state']) ? $_POST['state'] : 0;
		$city = isset($_POST['city']) ? $_POST['city'] : 0;
		$other_state = isset($_POST['txt_other_state']) ? $_POST['txt_other_state'] : "";
		$other_city = isset($_POST['other_city']) ? $_POST['other_city'] : "";
		$email = $_POST['txt_email'];
		$txt_contact = $_POST['txt_contact'];
		$buyer_type = isset($_POST['buyer_type']) ? $_POST['buyer_type'] : 'Domestic';
		$countryid = $_POST['country'];
		$tin = $_POST['txt_tin'];
		$pan = $_POST['txt_pan'];
		$cst = $_POST['txt_cst'];
		
		$ip = $_SERVER['REMOTE_ADDR'];
		$edit_id = $_POST['edit_id'];
		if($edit_id == '')
		{
			$sql_ins = "insert into ".$mysql_adm_table_prefix."buyer_master set
																				BuyerName = '$buyername',
																				Email = '$email',
																				ContactNumber = '$txt_contact',
																				Address = '$address',
																				State = '$state',
																				OtherState = '$other_state',
																				City = '$city',
																				OtherCity = '$other_city',
																				CountryId = '$countryid',
																				BuyerType = '$buyer_type',
																				TinNumber = '$tin',
																				PanNumber = '$pan',
																				CstNumber = '$cst',
																				InsertBy = '$SessionUserType',
																				InsertDate = now(),
																				IpAddress = '$ip'";
			$result_ins = mysql_query($sql_ins) or die("Error in query:".$sql_ins."<br>".mysql_error().":".mysql_errno());
			
			$insert_id = mysql_insert_id();
				
			if(isset($_POST['name'])){$count=count($_POST['name']);}
			for($i=0; $i<$count; $i++)
			{
				$sel_title=$_POST['sel_title'][$i];
				$name=$_POST['name'][$i];	
				$office_tel=$_POST['office_tel'][$i];
				$designation=$_POST['designation'][$i];
				$mobile=$_POST['mobile'][$i];
				$email_address=$_POST['email_address'][$i];	
			
				 $sql_2 = "INSERT INTO ".$mysql_adm_table_prefix."buyer_contactinfo SET
																					   BuyerId = '$insert_id',		
																					   Title = '$sel_title',
																					   Name = '$name',
																					   OfficeTel = '$office_tel',
																					   Designation = '$designation',
																					   Mobile = '$mobile',
																					   Email = '$email_address'";
																					   
																					   
				mysql_query($sql_2) or die("Error in query".mysql_errno().":".mysql_error());
			}	
			
			$_SESSION['no_refresh'] = $_POST['no_refresh'];
			$msg = "Buyer Successfully Inserted";
		}
		else
		{
			$sql_up = "update ".$mysql_adm_table_prefix."buyer_master set
																			BuyerName = '$buyername',
																			Email = '$email',
																			ContactNumber = '$txt_contact',
																			Address = '$address',
																			State = '$state',
																			OtherState = '$other_state',
																			City = '$city',
																			OtherCity = '$other_city',
																			CountryId = '$countryid',
																			BuyerType = '$buyer_type',
																			TinNumber = '$tin',
																			PanNumber = '$pan',
																			CstNumber = '$cst'
																			where rec_id = '$edit_id'";
		   	$result_up = mysql_query($sql_up) or die("Error in : ".$sql_up."<br>".mysql_errno()." : ".mysql_error());
		   
		   	$sql_del = "delete from ".$mysql_adm_table_prefix."buyer_contactinfo where BuyerId = '$edit_id' ";
		   	$result_del = mysql_query($sql_del) or die("Error in Query: ".$sql_del."<br/>".mysql_error()."<br/>".mysql_errno());
		   
		   	if(isset($_POST['name'])){$count=count($_POST['name']);}
			for($k=0; $k<$count; $k++)
			{
				$sel_title=$_POST['sel_title'][$k];
				$name=$_POST['name'][$k];	
				$office_tel=$_POST['office_tel'][$k];
				$designation=$_POST['designation'][$k];
				$mobile=$_POST['mobile'][$k];
				$email_address=$_POST['email_address'][$k];	
		   		
				if($sel_title!='' and $name!='' and $office_tel!='' and $designation!='' and $mobile!='' and $email_address!='')
				{
					$sql_3 = "INSERT INTO ".$mysql_adm_table_prefix."buyer_contactinfo SET
																						   BuyerId = '$edit_id',		
																						   Title = '$sel_title',
																						   Name = '$name',
																						   OfficeTel = '$office_tel',
																						   Designation = '$designation',
																						   Mobile = '$mobile',
																						   Email = '$email_address'";
					mysql_query($sql_3) or die("Error in query".mysql_errno().":".mysql_error());
				}
		   }
		   
		   $_SESSION['no_refresh'] = $_POST['no_refresh'];
		   $msg = "Buyer Successfully Updated";
		}   		
		
	}
}	
?>
<?
/////////////////// ********************* Select For Buyer Edit *************** ///////////////

if(isset($_GET['editid']))
{
	$editid = $_GET['editid'];
	$sql_esel = "select * from ".$mysql_adm_table_prefix."buyer_master where rec_id = '$editid'";
	$result_esel = mysql_query($sql_esel) or die("Error in query:".$sql_esel."<br>".mysql_error().":".mysql_errno());
	$row_esel = mysql_fetch_array($result_esel);
	$buyer = $row_esel['BuyerName'];
	$emailid = $row_esel['Email'];
	$contact = $row_esel['ContactNumber'];
	$add = $row_esel['Address'];
	$state = $row_esel['State'];
	$city = $row_esel['City'];	
	$country = $row_esel['CountryId'];
	$buyertype = $row_esel['BuyerType'];
	$tinno = $row_esel['TinNumber'];
	$panno = $row_esel['PanNumber'];
	$otherstate = $row_esel['OtherState'];
	$othercity = $row_esel['OtherCity'];
	$cstno = $row_esel['CstNumber'];
	
}
?>
<script>
function addElement() {
  var ni = document.getElementById('myDiv1');
  var numi = document.getElementById('h_hidden');
  var num = (document.getElementById('h_hidden').value -1)+ 2;
  numi.value = num;
  var newdiv = document.createElement('div');
  var divIdName = 'my'+num+'Div1';
  var myDivName='myDiv1';
  newdiv.setAttribute('id',divIdName);
  newdiv.innerHTML = "<table align='center' width='100%' border='0' cellpadding='1' cellspacing='0'><tr><td width='10%' align='left' style='padding-left:10px;'><select name='sel_title[]' style='width:50px; height:20px;'><option value=''>Title</option><option value='Mr.'>Mr.</option><option value='Dr.'>Dr.</option><option value='Ms.'>Ms.</option></select></td><td width='20%'><input name='name[]' type='text' value='' style='width:180px;height:20px;' /></td><td width='16%' align = 'left'><input name='office_tel[]' type='text' value='' style='width:150px;height:20px;' /></td><td width='18%' align='left'><input name='designation[]' type='text' value='' style='width:150px;height:20px;'/></td><td width='17%' align='left'><input name='mobile[]' type='text' value='' style='width:150px;height:20px;' /></td><td width = '16%' align = 'left'><input name='email_address[]' type='text' value='' style='width:180px;height:20px;' /></td><td class='delete' style='padding-right:10px;'><a href=\"javascript:;\" onclick=\"removeElement(\'"+divIdName+"\'\,'"+myDivName+"\')\"><img src='images/delete_icon.jpg' border='0'/></span></a></td></tr></table>";
  ni.appendChild(newdiv);

}
function removeElement(divNum,myDiv) 
{
	var d = document.getElementById(myDiv);
	var olddiv = document.getElementById(divNum);
	d.removeChild(olddiv);
}
</script>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
    <tr>
    	<td align="left" valign="top" width="230px" style="padding-top:5px;">
			<? include ("inc/adm0_snb.php"); ?>
        </td>
        
        <td style="padding-left:5px; padding-top:5px;">
        	<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
            	<tr>
                	<td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; Add Buyer</td>
                </tr>
                <tr>
                	<td valign="top" style="padding-top:10px;">
                    	<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td class="red"><?=$msg?></td>
                             </tr>
                            <tr>
                                <td valign="top" style="padding-bottom:5px;">
                                    <form name="frm_addbuyer" id="frm_addbuyer" action="" method="post" onsubmit="return validate_form(this);">
                                    <table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                                        <tr>
                                            <td align="center" valign="top" class="border" width="40%" bgcolor="#EAE3E1">
                                            	<table align="center" width="100%" cellpadding="2" cellspacing="2" border="0" class="text_1">
                                                	<tr>
                                                    	<td align="left"><b>Buyer Name</b></td>
                                                        <td align="left"><input type="text" name="txt_buyername" id="txt_buyername" value="<?=$buyer?>" /></td>
                                                    </tr>
                                                    <tr>
                                                    	<td align="left"><b>Country</b></td>
                                                        <td align="left">
															<?
                                                                 $sql = "SELECT * FROM mpc_countries order by countries_name";
                                                                 $result = mysql_query($sql) or die("Error in sql : ".$sql." : ".mysql_errno()." : ".mysql_error());
                                                            ?>
                                                            <select name="country" id="country" onChange="get_frm_state('get_state.php',this.value,'div_state','state','div_city','city','other_city','txt_other_state');">
                                                                <option value="">-select country-</option>
                                                            <? 
                                                            
                                                            while ($row=mysql_fetch_array($result))
                                                            {	?>
                                                                <option value="<?=$row['countries_id']?>" <? if($row['countries_id']==$country){?> selected="selected" <? } ?>><?=$row["countries_name"]?></option>
                                                            <?  }	?>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    	<td align="left"><b>State</b></td>
                                                        <td align="left">
                                                            <div id="div_state">
                                                            <? 
                                                                $sql = "SELECT * FROM mpc_state_master where country_id = '$country' order by state_name";
                                                                $result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
                                                            
                                                            if(mysql_num_rows($result)>0)
                                                            {
                                                            ?>
                                                                <select name="state" id="state" onChange="get_frm('get_city_reg.php',this.value,'div_city','city');">
                                                                <option value="">--select state--</option>
                                                           <?      
                                                                while ($row=mysql_fetch_array($result))
                                                                {
                                                           ?>
                                                                    <option value="<?=$row['rec_id']?>" <? if($row['rec_id']==$state){?> selected="selected" <? } ?>><?=$row["state_name"]?></option>
                                                           <?
                                                                }
                                                            ?>
                                                                </select>
                                                            <?    	
                                                            }
                                                            else
                                                            {
                                                            ?>
                                                                <input type="text" name="txt_other_state" id="txt_other_state" value="<?=$otherstate?>">
                                                            <?	
                                                            }
                                                            ?>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    	<td align="left"><b>City</b></td>
                                                        <td align="left">
                                                            <div id="div_city">
                                                            <? 
                                                                $sql = "SELECT * FROM mpc_city_master where state_id = '$state' order by city_name ";
                                                                $result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
                                                                if(mysql_num_rows($result)>0)
                                                                {
                                                            ?>
                                                                <select name="city" id="city">
                                                                <option value="">--select city--</option>
                                                                <? 
                                                                while ($row=mysql_fetch_array($result))
                                                                {
                                                                ?>
                                                                <option value="<?=$row['rec_id']?>" <? if($row['rec_id']==$city){?> selected="selected" <? } ?>><?=$row["city_name"]?></option>
                                                                <?
                                                                }
                                                                ?>
                                                                </select>
                                                            <?
                                                                }
                                                                else
                                                                {
                                                            ?>
                                                                <input type="text" name="other_city" id="other_city" value="<?=$othercity?>">	
                                                            <?	
                                                                }
                                                            ?>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td align="center" valign="top" class="border" width="32%" bgcolor="#EAE3E1">
                                       	  		<table align="center" width="100%" cellpadding="2" cellspacing="2" border="0" class="text_1">
                                                	<tr>
                                                    	<td align="left" valign="top"><b>Address</b></td>
                                                        <td align="left"><textarea name="txt_address" id="txt_address"><?=$add?></textarea></td>
                                                    </tr>
                                                    
                                                    <tr>
                                                    	<td align="left"><b>Contact Number</b></td>
                                                        <td align="left"><input type="text" name="txt_contact" id="txt_contact" value="<?=$contact?>" /></td>
                                                    </tr>
                                                    <tr>
                                                    	<td align="left"><b>Email Id</b></td>
                                                        <td align="left"><input type="text" name="txt_email" id="txt_email" value="<?=$emailid?>" /></td>
                                                    </tr>
                                                    <tr>
                                                    	<td align="left"><b>PAN Number</b></td>
                                                        <td align="left"><input type="text" name="txt_pan" id="txt_pan" value="<?=$panno?>" /></td>
                                                    </tr>
                                                </table>
                                            </td>
                                      		<td align="center" valign="top" class="border" width="28%" bgcolor="#EAE3E1">
                           	  					<table align="center" width="100%" cellpadding="2" cellspacing="2" border="0" class="text_1">
                                                	<tr>
                                                    	<td align="left"><b>Export</b></td>
                                                        <td>
                                                        <input type="checkbox" name="buyer_type" id="buyer_type" value="Export" <? if($buyertype == 'Export'){?> checked="checked"<? } ?>/>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    	<td align="left"><b>TIN Number</b></td>
                                                        <td align="left"><input type="text" name="txt_tin" id="txt_tin" value="<?=$tinno?>" /></td>
                                                    </tr>
                                                    <tr>
                                                    	<td align="left"><b>CST Number</b></td>
                                                        <td align="left"><input type="text" name="txt_cst" id="txt_cst" value="<?=$cstno?>" /></td>
                                                    </tr>    
                                                </table>
                                            </td>
                                      </tr>
                                        <tr>
                                        	<td align="center" valign="top" colspan="3">
                                                <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
                                                    <tr>
                                                        <td align="left" width="10px"><img src="images/tnb_left.jpg" width="10" height="35"/></td>
                                                        <td class="welcome_txt">
                                                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                <tr>
                                                                    <td align="left" width="15%" class="orange_head">Contact Information</td>
                                                                    <td align="center" width="5%"><img src="images/tnb_div_1.jpg" width="7" height="35"/></td>
                                                                    <td align="center" width="80%">&nbsp;</td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td align="right" width="10px"><img src="images/tnb_right.jpg" width="10" height="35"/></td>
                                                    </tr>
                                                    <tr>
                                                    	<td align="left" colspan="3" style="padding-top:3px;">
                                                            <table align="left" width="100%" cellpadding="1" cellspacing="1" class="border" border="0">
                                                                <tr class="text_1" bgcolor="#EAE3E1">
                                                                    <td width="10%" style="padding-left:10px;"><b>Title</b></td> 
                                                                  	<td width="20%"><b>Name</b></td>
                                                                  	<td width="16%"><b>Office Telephone</b></td>
                                                                  	<td width="18%"><b>Designation</b></td>
                                                                  	<td width="17%"><b>Mobile</b></td>
                                                                  	<td width="19%" colspan="2"><b>Email</b></td>
                                                                </tr>
																 <?                   
                                                                    if(isset($_GET['editid']))
                                                                    {
                                                                    $sql_1 = "select * from ".$mysql_adm_table_prefix."buyer_contactinfo where BuyerId = '".$_GET["editid"]."' ";
                                                                    $result_1 = mysql_query($sql_1) or die("Error in sql : ".$sql_1." : ".mysql_errno()." : ".mysql_error());
                                                                    if(mysql_num_rows($result_1)>0)
                                                                    {
                                                                    while($row_1 = mysql_fetch_array($result_1))
                                                                    {
                                                                    $title = $row_1['Title'];
                                                                    $name = $row_1['Name'];
                                                                    $tel = $row_1['OfficeTel'];
                                                                    $desig = $row_1['Designation'];
                                                                    $mobile = $row_1['Mobile'];
                                                                    $email = $row_1['Email'];
                                                                 ?>	
                                                                <tr>
                                                                    <td align="left" style="padding-left:10px;">
                                                                        <select name="sel_title[]" id="sel_title[]" style='width:50px; height:20px;'>
                                                                        <option value="">Title</option>
                                                                        <option value="Mr."<? if($title=='Mr.'){?> selected="selected"<? } ?>>Mr.</option>
                                                                        <option value="Dr."<? if($title=='Dr.'){?> selected="selected"<? } ?>>Dr.</option>
                                                                        <option value="Ms."<? if($title=='Ms.'){?> selected="selected"<? } ?>>Ms.</option>
                                                                        </select>
                                                                    </td>
                                                                    <td align="left">
                                                                    	<input name="name[]" id="name[]" type="text" value="<?=$name?>" style="width:180px; height:20px;"/>
                                                                    </td>
                                                                    <td align="left">
                                                                    	<input name="office_tel[]" id="office_tel[]" type="text" value="<?=$tel?>" style="width:150px; height:20px;"/>
                                                                    </td>
                                                                    <td align="left">
                                                                    	<input name="designation[]" id="designation[]" type="text" value="<?=$desig?>" style="width:150px; height:20px;"/>
                                                                    </td>
                                                                    <td align="left">
                                                                    	<input name="mobile[]" id="mobile[]" type="text" value="<?=$mobile?>" style="width:150px; height:20px;"/>
                                                                    </td>
                                                                    <td align="left">
                                                                    	<input name="email_address[]" id="email_address[]" type="text" value="<?=$email?>" style="width:180px; height:20px;"/>
                                                                    </td>
                                                                </tr>
                                                 <?
                                                            }
                                                        }
                                                    }		
                                                 
                                                 ?> 
                                                                <tr>
                                                                    <td align="left" style="padding-left:10px;">
                                                                        <select name="sel_title[]" id="sel_title[]" style='width:50px; height:20px;'>
                                                                        <option value="">Title</option>
                                                                        <option value="Mr.">Mr.</option>
                                                                        <option value="Dr.">Dr.</option>
                                                                        <option value="Ms.">Ms.</option>
                                                                        </select>
                                                                    </td>
                                                                    <td align="left">
                                                                    	<input name="name[]" id="name[]" type="text" value="" style="width:180px; height:20px;"/>
                                                                    </td>
                                                                    <td align="left">
                                                                    	<input name="office_tel[]" id="office_tel[]" type="text" value="" style="width:150px; height:20px;"/>
                                                                    </td>
                                                                    <td align="left">
                                                                    	<input name="designation[]" id="designation[]" type="text" value="" style="width:150px; height:20px;"/>
                                                                    </td>
                                                                    <td align="left">
                                                                    	<input name="mobile[]" id="mobile[]" type="text" value="" style="width:150px; height:20px;"/>
                                                                    </td>
                                                                    <td align="left">
                                                                    	<input name="email_address[]" id="email_address[]" type="text" value="" style="width:180px; height:20px;"/>
                                                                    </td>
                                                                    <td class="AddMore" style="padding-right:10px;">
                                                                     	<input type="hidden" name="h_hidden" id="h_hidden"/> 
                                                                    	<a href="javascript:;"  onclick="addElement();"><img src="images/add_icon.jpg" border="0"/></a>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="7">
                                                                        <div id="myDiv1"></div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="7" align="center" style="padding-top:5px;" bgcolor="#F7F3F2">
                                                                        <input type="image" src="images/btn_submit.png" name="btn_submit" id="btn_submit" value="submit" />
                                                                        <input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
                                                                        <input type="hidden" name="edit_id" id="edit_id" value="<?=$editid?>" />
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
                                    </form>
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