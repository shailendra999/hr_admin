<? include ("inc/purchase_header.php"); ?>
<script type="text/javascript">
function overlay(RecordId) 
{
	e1 = document.getElementById("overlay");
	document.getElementById("hidden_overlay").value=RecordId;
	e1.style.visibility = (e1.style.visibility == "visible") ? "hidden" : "visible";
	
}
</script>
<?
$Page = "purchase_add_company.php";
$PageTitle = "Add Company";
$PageFor = "Company";
$PageKey = "company_id";
$PageKeyValue = "";
$Message = "";
$mode = "";

$name = '';
$city = '';

if(isset($_GET["mode"]))
{
	$mode = $_GET["mode"];
}

if(isset($_POST["btn_submit"]))
{
	$PageKeyValue = $_POST[$PageKey];
	$name = $_POST['name'];	
	$city = $_POST['city'];
	$ip_add = $_SERVER['REMOTE_ADDR'];
	if($PageKeyValue == "")
	{
		$tablename="ms_purchase_company_master";
		$tableData=array("''","'$name'","'$city'","now()","$SessionLoginMasterId","'$ip_add'");
		addDataIntoTable($tablename,$tableData);
		$company_id = mysql_insert_id();
		$Message = "$PageFor Inserted";
		
		if(isset($_POST['product_id'])){$count=count($_POST['product_id']);}
		for($i=0; $i<$count; $i++)
		{
			$product_id=$_POST['product_id'][$i];
			$opening_stock=$_POST['opening_stock'][$i];	
			$opening_date=getdbDate($_POST['opening_date'][$i]);
		
			 if($product_id!="")
			 {
				 $sql_2= "INSERT INTO  ms_purchase_company_product_master SET
																			   company_id = '$company_id',	
																			   product_id = '$product_id',		
																			   opening_stock = '$opening_stock',
																			   opening_date = '$opening_date',
																			   InsertDate = now()";
				mysql_query($sql_2) or die("Error in query".mysql_errno().":".mysql_error());
		 	}
		 }
	}	
	else
	{
		if($mode == "edit")
		{					
			$tablename="ms_purchase_company_master";
			$tableColumns=array("company_id","name","city");
			$tableData=array("'$PageKeyValue'","'$name'","'$city'");
			updateDataIntoTable($tablename,$tableColumns,$tableData);	
			
			$sql_del = "delete from ms_purchase_company_product_master where company_id = '$PageKeyValue' ";
		   $result_del = mysql_query($sql_del) or die("Error in Query: ".$sql_del."<br/>".mysql_error()."<br/>".mysql_errno());
			
			if(isset($_POST['product_id'])){$count=count($_POST['product_id']);}
			for($i=0; $i<$count; $i++)
			{
				$product_id=$_POST['product_id'][$i];
				$opening_stock=$_POST['opening_stock'][$i];	
				$opening_date=getdbDate($_POST['opening_date'][$i]);
			
			if($product_id!="")
			 {
				$sql_2= "INSERT INTO  ms_purchase_company_product_master SET
																			   company_id = '$PageKeyValue',	
																			   product_id = '$product_id',		
																			   opening_stock = '$opening_stock',
																			   opening_date = '$opening_date',
																			   InsertDate = now()";
				mysql_query($sql_2) or die("Error in query".mysql_errno().":".mysql_error());
			 }
			 }
						
				$Message = "$PageFor Updated";
			}
		
	}
	//redirect("$Page?Message=$Message");
}
?>
<?
$ReferenceId = "";
$product_id="";
if(isset($_GET["Message"]))
{
	$Message = $_GET["Message"];
}

if(isset($_POST["btn_delete"]))
{
	$PageKeyValue  = $_POST["hidden_overlay"];
	$sql = "delete from ms_purchase_company_master where $PageKey = '".$PageKeyValue."'";
	mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	$Message = "$PageFor Sucessfully Deleted";
	redirect("$Page?Message=$Message");
}
if(isset($_GET[$PageKey]))
{
	$sql = "select * from ms_purchase_company_master where $PageKey = '".$_GET[$PageKey]."'";
	$result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row = mysql_fetch_array($result);
		$PageKeyValue = $row[$PageKey];
		$name = $row["name"];	
		$city = $row["city"];		
	}
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
  newdiv.innerHTML = "<table align='center' width='100%' border='0' cellpadding='1' cellspacing='0'><tr><td align='left' style='padding-left:10px;'><?php $sql_item = "select * from ms_purchase_product_master";$sql_res = mysql_query($sql_item) or die(mysql_error()); ?> <select name='ProductId[]' id='ProductId[]'><option value=''>--Select Product--</option><?php if(mysql_num_rows($sql_res)){ while($row_item=mysql_fetch_array($sql_res)){?> <option value='<?php echo $row_item['product_id'];?>' <? if($row_item["product_id"]==$product_id){ echo 'selected="selected"';}?>><?php echo $row_item['product_name'];?></option> <?php }}?></select></td><td><input name='opening_stock[]' id='opening_stock[]' type='text' value='' style='width:100px; height:20px;'/></td><td align = 'left'><input name='opening_date[]' id='opening_date_"+(num)+"' type='text' value='' style='width:75px; height:20px;' readonly='readonly'/><a href='javascript:void(0)' onClick='gfPop.fPopCalendar(document.purchase_frm.opening_date_"+(num)+");return false;' HIDEFOCUS><img name='popcal' align='absbottom' src='calendar/calbtn.gif' width='34' height='22' border='0' alt=''></a></td><td class='delete' style='padding-right:10px;'><a href=\"javascript:;\" onclick=\"removeElement(\'"+divIdName+"\'\,'"+myDivName+"\')\"><img src='images/delete_icon.jpg' border='0'/></span></a></td></tr></table>";
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
			<? include ("inc/purchase_snb.php"); ?>
        </td>        
        <td style="padding-left:5px; padding-top:5px;">
        	<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
            	<tr>
                	<td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/>&nbsp; Add Company</td>
                </tr>
                <tr>
                	<td valign="top" style="padding-top:5px; padding-left:40px;">
                    	<table width="1000" align="center" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td align="center" class="border">
                                    <div align="center" style="min-height:470px; padding-top:15px;">
                                        <div id="div_message" style="color:#399;font-size:16px;font-weight:bold;padding:5 0 5 0"><?=$Message?></div>
                                        <form id="purchase_frm" name="purchase_frm" action="" method="post">
                                            <table align="center" cellpadding="1" cellspacing="1" border="0" width="60%" style="border:#CCCCCC solid 1px;">
                                                <tr>
                                                    <td class="paas_text" bgcolor="#E2EBF0" width="40%"  style="padding-left:10px;"><b>Company Name</b></td>
                                                    <td align="left" bgcolor="#F2F7F9" width="60%" style="padding-left:10px;">
                                                    <input type="text" id="name" name="name" value="<?= $name ?>" /></td>
                                                </tr>
                                                <tr>
                                                    <td class="paas_text" bgcolor="#E2EBF0" width="40%"  style="padding-left:10px;"><b>City</b></td>
                                                    <td align="left" bgcolor="#F2F7F9" width="60%" style="padding-left:10px;">
                                                    <input type="text" id="city" name="city" value="<?= $city ?>" /></td>
                                                </tr>
                                                <tr>
                                                	<td align="left" style="padding-top:3px;" colspan="3">
                                                            <table align="left" width="100%" cellpadding="1" cellspacing="0" class="border" border="0">
                                                                <tr class="text_2"> 
                                                                  	<td>Product Name</td>
                                                                  	<td>Opening Quanity</td>
                                                                  	<td>Opening Date</td>
                                                                </tr>
														 <? 
														 	$divNumber=0;                 
															if(isset($_GET['company_id']))
															{

																$sql_1 = "select * from ms_purchase_company_product_master where company_id = '".$_GET["company_id"]."' ";
																$result_1 = mysql_query($sql_1) or die("Error in sql : ".$sql_1." : ".mysql_errno()." : ".mysql_error());
																if(mysql_num_rows($result_1)>0)
																{
																	while($row_1 = mysql_fetch_array($result_1))
																	{
                                                                    $product_id = $row_1['product_id'];
                                                                    $opening_stock = $row_1['opening_stock'];
                                                                    $opening_date = getDatetime($row_1['opening_date']);
														 ?>	
                                                                <tr>
                                                                    <td align="left" style="padding-left:10px;">
																	<?php
                                                                        $sql_item = "select * from ms_purchase_product_master";
                                                                        $sql_res = mysql_query($sql_item) or die(mysql_error());                                                                
                                                                        ?>
                                                                        <select name="product_id[]" id="product_id[]">
                                                                            <option value="">--Select Product--</option>
                                                                        <?php
                                                                            if(mysql_num_rows($sql_res))
                                                                            {
                                                                                while($row_item=mysql_fetch_array($sql_res))
                                                                                {
                                                                        ?>
                                                                            <option value="<?php echo $row_item['product_id'];?>" <? if($row_item["product_id"]==$product_id){ echo 'selected="selected"';}?>><?php echo $row_item['product_name'];?></option>
                                                                        <?php
                                                                                }
                                                                               
                                                                             }
        ?>                                                              </select>
                                                                    </td>
                                                                    <td align="left">
                                                                    	<input name="opening_stock[]" id="opening_stock[]" type="text" value="<?=$opening_stock?>" style="width:100px; height:20px;"/>
                                                                    </td>
                                                                    <td align="left">
                                                                    	 <input name="opening_date[]" id="opening_date_<?=$divNumber?>" type="text" value="<?=$opening_date?>" style="width:75px; height:20px;" readonly="readonly"/>
                                                                         <a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.purchase_frm.opening_date_<?=$divNumber?>);return false;" HIDEFOCUS>
                                                                        <img name="popcal" align="absbottom" src="calendar/calbtn.gif" width="34" height="22" border="0" alt=""></a>
                                                                    </td>
                                                                </tr>
															 <?
																		 $divNumber++;
                                                                        }
                                                                    }
                                                                }		
                                                             
                                                             ?> 
                                                            <tr>
                                                                <td align="left" style="padding-left:10px;">
																<?php
                                                                $sql_item = "select * from ms_purchase_product_master";
                                                                $sql_res = mysql_query($sql_item) or die(mysql_error());                                                                
                                                                ?>
                                                                <select name="product_id[]" id="product_id[]">
                                                                    <option value="">--Select Product--</option>
                                                                <?php
                                                                    if(mysql_num_rows($sql_res))
                                                                    {
                                                                        while($row_item=mysql_fetch_array($sql_res))
                                                                        {
                                                                ?>
                                                                    <option value="<?php echo $row_item['product_id'];?>"><?php echo $row_item['product_name'];?></option>
                                                                <?php
                                                                        }
                                                                       
                                                                     }
?>                                                              </select>
                                                                </td>
                                                                <td align="left">
                                                                <input name="opening_stock[]" id="opening_stock[]" type="text" value="" style="width:100px; height:20px;"/>
                                                                </td>
                                                                <td align="left">
                                                                <input name="opening_date[]" id="opening_date1" type="text" value="" style="width:75px; height:20px;" readonly="readonly"/>
                                                                <a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.purchase_frm.opening_date1);return false;" HIDEFOCUS>
                                                                <img name="popcal" align="absbottom" src="calendar/calbtn.gif" width="34" height="22" border="0" alt=""></a>
                                                                </td>
                                                                <td class="AddMore" style="padding-right:10px;">
                                                                 <input type="hidden" name="h_hidden" id="h_hidden" value="<?=$divNumber?>"/> 
                                                                <a href="javascript:;"  onclick="addElement();"><img src="images/add_icon.jpg" border="0"/></a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="7">
                                                                    <div id="myDiv1"></div>
                                                                </td>
                                                            </tr>
                                                         </table>            
 													</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" align="center" bgcolor="#E2EBF0" height="25">
                                                        <input type="hidden" id="mode" name="mode" value="<?=$mode?>"/>
                                                        <input type="hidden" id="<?=$PageKey?>" name="<?=$PageKey?>" value="<?=$PageKeyValue?>" />
                                                        <input type="submit" id="btn_submit" name="btn_submit" value="Submit" class="btn_bg" />
                                                    </td>
                                                </tr>
                               			   </table>
                           				 </form>
                                        <div id="div_category_list"  style="overflow:auto;height:400px;width:750px;margin-top:20px;">
                                          <table align="center" width="100%" style="border:#CCCCCC solid 1px;" cellpadding="2" cellspacing="1">
                                            <tr style="background:#F4F2F7" height="30px">
                                            	<td class="h_text"><b>S.No.</b></td>
                                                <td class="h_text"><b>Company Name</b></td>
                                                <td class="h_text"><b>City</b></td>
                                                <td class="h_text"><b>Product Detail</b></td>
                                                <td class="h_text"><b>Edit</b></td>
                                                <td class="h_text"><b>Delete</b></td>
                                            </tr>
                                            <?
											$sql = "select * from  ms_purchase_company_master order by name";
											$result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
											if(mysql_num_rows($result)>0)
											{
												
												$num = mysql_num_rows($result) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
												$sno=1;
												while($row = mysql_fetch_array($result)) 
												{ 
													?>
													<tr bgcolor="#F2F7F9">
														<td class="Text01"><?= $sno++;?></td>
														<td class="Text01"><?=$row["name"]?></td>
                                                        <td class="Text01"><?=$row["city"]?></td>
                                                        <td>
                                                        	<table align="center" cellpadding="0" cellspacing="0" border="1" width="100%">
                                                        	<?
																$sql_1 = "select * from ms_purchase_company_product_master where company_id = '".$row["company_id"]."' ";
																$result_1 = mysql_query($sql_1) or die("Error in sql : ".$sql_1." : ".mysql_errno()." : ".mysql_error());
																if(mysql_num_rows($result_1)>0)
																{
																	while($row_1 = mysql_fetch_array($result_1))
																	{
																		$product_id = $row_1['product_id'];
																		$sql_item = "select * from ms_purchase_product_master where product_id='$product_id'";
                                                               			$sql_res = mysql_query($sql_item) or die(mysql_error());
																		$row_item = mysql_fetch_array($sql_res);
																		
																		$product_name = $row_item['product_name'];
																		$opening_stock = $row_1['opening_stock'];
                                                                    	$opening_date = getDatetime($row_1['opening_date']);
                                                                    	?>
                                                                        <tr>
                                                                        	<td>
																				<?=$product_name?>
                                                                            </td>
                                                                            <td>
																				<?=$opening_stock?>
                                                                            </td>
                                                                            <td>
																				<?=$opening_date?>
                                                                            </td>
                                                                        </tr>	
                                                                        <?
																	}
																}
															?>
                                                            </table>
                                                        </td>
                                                        <td class="Text01">
                                                          <a href="purchase_add_company.php?company_id=<?=$row['company_id']?>&mode=edit">
                                                          <img src="images/icon_edit.gif" alt="Edit" title="Edit" border="0" />
                                                          </a>
                                                        </td>
                                                        <td class="Text01">
                                                        <a href="javascript:;" onClick="overlay(<?=$row['company_id']?>);">
                                                        <img src="images/delete_icon.gif" alt="Delete" title="Delete" border="0">
                                                        </a>
                                                      </td>
													</tr>
												<?												
												}
											 }
											 else
											 {
											 ?>
											 	<tr bgcolor="#f9f8f9">
														<td class="Text01" colspan="4" align="center">No Records Entered Yet.</td>
												</tr>
											 <? 
											 }
											 ?>
										</table>
										
									</div>
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
<iframe width=168 height=190 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="calendar/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
</iframe>
<? include ("inc/hr_footer.php"); ?>	