<?
include("inc/store_header.php");
?>

<script>
function overlay(id) {
  el = document.getElementById("overlay");
	document.getElementById("hidden_overlay").value=id;
	el.style.visibility = (el.style.visibility == "visible") ? "hidden" : "visible";	
}
function getDataInDiv(value,divId,page,byControl)
{
	if(byControl=="IndentDate")
	{
		value= document.getElementById('indentDate').value;
	}
	else if(byControl=="Department")
	{
		if(value=='0')
			alert("Please Select Department");
	}
	else if(byControl=="Item")
	{
		if(value=='0')
			alert("Please Select Item");
	}
	if(value!='')
	{
		var strURL1=page+"?value="+value+"&byControl="+byControl;
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
$Page = "store_list_purchase_indent.php";
$PageTitle = "List Indent";
$PageFor = "Indent";
$PageKey = "indent_id";
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
	$sql="select ms_order_master.order_id,ms_GRN_master.GRN_id,ms_indent_master.indent_id from ms_order_master,ms_GRN_master,ms_indent_master where ms_indent_master.indent_id='".$PageKeyValue."' and (ms_order_master.indent_id='".$PageKeyValue."' or ms_GRN_master.indent_id='".$PageKeyValue."')";
	$res=mysql_query($sql);
	if(mysql_num_rows($res)>0)
	{
		$Message="Not Deleted";
		echo "<script>alert('Sorry!PO or GRN is made for this Indent.');location.href='$Page?Message=$Message';</script>";
	}
	else
	{
		$sql = "delete from ms_indent_master where $PageKey = '".$PageKeyValue."'";
		if(mysql_query($sql))
		{
			$sql_IT = "delete from ms_indent_transaction where $PageKey = '".$PageKeyValue."'";
			if(mysql_query ($sql_IT))
			{
				$Message = "Indent Sucessfully Deleted";
			}
		}
		redirect("$Page?Message=$Message");
	}
}

?>
<?

$sql="select * from ms_indent_master mim,ms_indent_transaction mit where mim.indent_id=mit.indent_id order by mim.indent_date asc";
//$sql = $sql ." LIMIT " . $start . ", $row_limit";
$result=mysql_query($sql) or die(mysql_error());


?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
  <tr>
    <td align="left" valign="top" width="230px" style="padding-top:5px;">
    	<? include ("inc/store_snb.php"); ?>
    </td>
    <td style="padding-left:5px; padding-top:5px;" valign="top">
      <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
        	<td align="center" class="gray_bg">
          	<img src="images/bullet.gif" width="15" height="22"/> &nbsp; List Purchase Indent
          </td>
        </tr>
        <tr>
          <td valign="top">
            <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
              <!--<tr>
                <td class="AddMore">
                	<a target="_blank" href="store_printall_purchase_indent.php" title="Print">Print All&nbsp;&nbsp;&nbsp;</a>
                </td>
              </tr>-->
              <tr>
                <td align="center" class="border">
                  <div id="div_message" style="color:#399;font-size:16px;font-weight:bold;"><?=$Message?></div>
                  <table align="center" width="100%" border="1" class="table1 text_1">
                    <tr>
                      <td align="center" colspan="4"><b>Search Items</b></td>
                    </tr>
                    <tr>
                      <td align="left"><b>Indent No.</b></td>
                      <td align="left">
                        <input type="text" name="itemIndentSearch" id="itemIndentSearch" onKeyUp="getDataInDiv(this.value,'getItemsInDiv','store_get_list_indent.php','IndentNo')" />
                      </td>
                      <td align="left"><b>Indent Date</b></td>
                      <td align="left">
                        <input type="text" name="indentDate" id="indentDate"/>
                          <a href="javascript:void(0)" HIDEFOCUS
                          	onClick="gfPop.fPopCalendar(document.getElementById('indentDate'));return false;">
                            <img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
                          </a> 
                        <input type="button" id="btnOk" name="btnOk" value="Ok" onClick="getDataInDiv('','getItemsInDiv','store_get_list_indent.php','IndentDate')"/>
                      </td>
                     </tr>
                      <td align="left"><b>Department</b></td>
                      <td align="left">
                      	<select name="department_id" id="department_id" style="width:150px;height:20px" onChange="getDataInDiv(this.value,'getItemsInDiv','store_get_list_indent.php','Department')" >
                          <option value="0"></option>
                          <? $sql_dept= 'select * from ms_department order by name asc';
                            $res_dept = mysql_query ($sql_dept) or die (mysql_error());
                            if(mysql_num_rows($res_dept)>0)
                            {
                              while($row_dept = mysql_fetch_array($res_dept))
                              {
                                ?>
                                <option value='<?= $row_dept['department_id'];?>'><?= $row_dept['name'];?></option>
                                <? 
                              }
                            }
                            ?>
                          </select>
                      </td>
                      <td align="left"><b>Item</b></td>
                      <td align="left">
                      	<select name="item_id" id="item_id" style="width:50px; font-size:10px;" onChange="getDataInDiv(this.value,'getItemsInDiv','store_get_list_indent.php','Item')" >
                          <option value="0"></option>
                          <? 
													$sql_I= 'select * from ms_item_master order by name asc';
                            $res_I = mysql_query ($sql_I) or die (mysql_error());
                            if(mysql_num_rows($res_I)>0)
                            {
                              while($row_I = mysql_fetch_array($res_I))
                              {
                                ?>
                        	<option value="<?= $row_I['item_id']?>"><?= $row_I['name'].' | Drg No. '.$row_I['drawing_number'].'  | Cat. No.'.$row_I['catelog_number']?></option>
	                            		                   	
                                <? 
								
                              }
                            }
                            ?>
                          </select>
                      </td>
                    </tr>
                    </table>
                  	<div id="getItemsInDiv" style="margin:0 auto;width:100%;overflow:auto;height:800px">
                    	<table align="center" width="100%" border="1" cellpadding="0" cellspacing="0" class="table1 text_1">
                        <tr>
                          <td class="gredBg" width="5%">S.No.</td>
                          <td class="gredBg" width="5%">Ind. No.</td>
                          <td class="gredBg" width="8%">Ind. Date</td>
                          <td class="gredBg" width="15%">Department</td>
                          <td class="gredBg" width="35%">Item Name</td>
                          <td class="gredBg" width="8%">UOM</td>
                          <td class="gredBg" width="6%">Req. Qty</td>
                          <td class="gredBg" width="6%">Pend. Qty</td>
						  <td class="gredBg">Finacial Year</td>
                          <td width="4%" class="gredBg">View</td>
                          <td width="4%" class="gredBg">Edit</td>
                          <td width="4%" class="gredBg">Delete</td>
                        </tr>
												<?  
                          if(mysql_num_rows($result)>0)
                          {
                            $sno =1;$oldid = "";$count =1;
                            while($row=mysql_fetch_array($result))
                            {
                            //$flag1= false;
                            $sql_idate="select * from ms_indent_master where insert_date='".date('Y-m-d')."' and indent_id='".$row['indent_id']."'";
                            $res_idate=mysql_query($sql_idate);	
                            $row_idate=mysql_fetch_array($res_idate);
                            $insert_date=$row_idate['insert_date'];
                            ?>
                              <tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
                               <td align="center"><?=$sno?></td>
                               <td align="center"><? if($row["indent_number"]=="") echo $row["indent_id"]; else echo $row["indent_number"]; ?></td>
                               <td align="center"><?=getDateFormate($row["indent_date"])?></td>
                               <td align="center">
                               <?
                                $sql_dept="select * from ms_department where department_id='".$row['department_id']."'";
                                $res_dept = mysql_query ($sql_dept) or die (mysql_error());
                                if(mysql_num_rows($res_dept)>0)
                                {
                                  $row_dept = mysql_fetch_array($res_dept);
                                  echo $row_dept['name'];
                                }
                                ?>
                               </td>
                               <?
                                $sql_item="select * from ms_item_master where item_id='".$row['item_id']."'";
                                $res_item = mysql_query($sql_item) or die (mysql_error());;
                                $row_item = mysql_fetch_array($res_item);
                               ?>
                               <td align="left" style="padding-left:5px"><?=$row_item['name'].';Drg No. '.$row_item['drawing_number'].';Cat No. '.$row_item['catelog_number']?></td>
                               <td align="center">
                               <?
                               $sql_uom = "select * from ms_uom where uom_id = '".$row_item['uom_id']."' ";
                               $result_uom =mysql_query($sql_uom) or die (mysql_error());;
                               $row_uom = mysql_fetch_array($result_uom);
                               echo $row_uom['name'];
                               ?>
                               </td>
                               <td align="center"><?=$row['required_quantity']?></td>
                               <td align="center"><?=$row['pend_qty']?></td>
							   <td align="center"><?= $row['finYear']?></td>
                               <?
                                if($row['indent_id']!=$oldid)
                                {
                                  $oldid = $row['indent_id'];
                                  $count=1;
                                }
                                $sql_tr="select * from ms_indent_transaction where indent_id='".$oldid."'";
                                $res_tr=mysql_query($sql_tr);
                                $row_count=mysql_num_rows($res_tr);
                                //if($count==1)
                                {
                                  ?>
                                  <td align="center">
                                    <a href="store_view_purchase_indent.php?indent_id=<?=$row["indent_id"]?>">
                                      <img src="images/search-icon.gif" alt="View" title="View" border="0" />
                                     </a>       
                                   </td>
                                  <?
                                  if(1)
                                  {//$SessionUserType=='Administrator' || (date('Y-m-d')==$insert_date)
                                  ?>
                                  <td align="center">
                                    <a href="store_add_purchase_indent.php?indent_id=<?=$row["indent_id"]?>&mode=edit">
                                      <img src="images/icon_edit.gif" alt="Edit" title="Edit" border="0" />
                                    </a>
                                  </td>
                                  <td align="center">
                                    <a href="javascript:;" onClick="overlay(<?=$row["indent_id"]?>);">
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
                                }
                                $count++;
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
                              <td colspan="11" align="center" style="font-weight:bold">No Records Found</td>
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