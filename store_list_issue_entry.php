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
	if(byControl=="IEDate")
	{
		value= document.getElementById('issueDate').value;
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
</script>

<?
$Page = "store_list_issue_entry.php";
$PageTitle = "List Issue Entry";
$PageFor = "Issue Entry";
$PageKey = "IE_id";
$PageKeyValue = "";
$Message = "";
if(date('m') > 03){	$gFinYear = date('Y').'-'.(date('Y')+1);	}else{	$gFinYear = (date('Y')-1).'-'.date('Y');	}

if(isset($_GET["Message"])){
	$Message = $_GET["Message"];
}
if(isset($_POST["btn_del"])){
	$PageKeyValueTrans  = $_POST["hidden_overlay"];
	$sql_I="select mim.closing_stock,mim.item_id,mit.iss_qty from ms_item_master mim,ms_IE_transaction mit where mit.IE_transaction_id='".$PageKeyValueTrans."' and mim.item_id=mit.item_id";
	$res_I=mysql_query($sql_I);
	$row_I=mysql_fetch_array($res_I);
	
	$total_qty=(float)$row_I['closing_stock']+(float)$row_I['iss_qty'];
	$sql_U="update ms_item_master set closing_stock='".$total_qty."' where item_id='".$row_I['item_id']."'";
	mysql_query($sql_U);
	$sql = "delete from ms_IE_transaction where IE_transaction_id = '".$PageKeyValueTrans."'";
	mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	$Message = "Issue Entry Transaction Row Sucessfully Deleted";
	$UrlPage=$Page."?Message=".$Message;
	redirect("$UrlPage");//redirect("$Page?Message=$Message");
}

$sql="select * from ms_IE_master miem,ms_IE_transaction miet where miem.IE_id=miet.IE_id order by miem.IE_id asc";
#$sql="select * from ms_IE_master miem,ms_IE_transaction miet where miem.IE_id=miet.IE_id and miem.finYear = '".$gFinYear."' order by miem.IE_id asc";
$result=mysql_query($sql);

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
            <img src="images/bullet.gif" width="15" height="22"/> &nbsp; List Issue Entry
          </td>
        </tr>
        <tr>
          <td valign="top">
            <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td align="center" class="border" >
                  <div id="div_message" style="color:#399;font-size:16px;font-weight:bold;"><?=$Message?></div>
                  <table align="center" width="100%" border="1" class="table1 text_1">
                  <tr>
                    <td align="center" colspan="4"><b>Search Items</b></td>
                  </tr>
                    <tr>
                      <td align="left"><b>Issue Entry No.</b></td>
                      <td align="left">
                        <input type="text" name="issueNo" id="issueNo" onKeyUp="getDataInDiv(this.value,'getItemsInDiv','store_get_list_issue_entry.php','IENo')" />
                      </td>
                      <td align="left"><b>Issue Entry Date</b></td>
                      <td align="left">
                        <input type="text" name="issueDate" id="issueDate"/>
                          <a href="javascript:void(0)" HIDEFOCUS
                            onClick="gfPop.fPopCalendar(document.getElementById('issueDate'));return false;">
                            <img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
                          </a> 
                        <input type="button" id="btnOk" name="btnOk" value="Ok" onClick="getDataInDiv('','getItemsInDiv','store_get_list_issue_entry.php','IEDate')"/>
                      </td>
                     </tr>
                    <tr>
                      <td align="left"><b>Department</b></td>
                      <td align="left">
                        <select name="department_id" id="department_id" style="width:150px;height:20px" onChange="getDataInDiv(this.value,'getItemsInDiv','store_get_list_issue_entry.php','Department')" >
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
                        <select name="item_id" id="item_id" style="width:150px;height:20px" onChange="getDataInDiv(this.value,'getItemsInDiv','store_get_list_issue_entry.php','Item')" >
                          <option value="0"></option>
													<? 
                          $sql_I= 'select * from ms_item_master order by name asc';
                            $res_I = mysql_query ($sql_I) or die (mysql_error());
                            if(mysql_num_rows($res_I)>0)
                            {
                              while($row_I = mysql_fetch_array($res_I))
                              {
                                ?>
                                <option value='<?= $row_I['item_id']?>'><?= $row_I['name'].' Drg No. '.$row_I['drawing_number'].' Cat. No.'.$row_I['catelog_number']?></option>
                                <? 
                              }
                            }
                            ?>
                        </select>
                    	</td>
                 		</tr>
            			</table>
                  <div id="getItemsInDiv" style="margin:0 auto;width:100%;overflow:auto;height:800px">
                    <table align="center" width="100%" border="1" cellpadding="0" class="table1 text_1">
                      <tr>
                        <td class="gredBg">S.No.</td>
                        <td class="gredBg">Issue No.</td>
                        <td class="gredBg">Issue Date</td>
                        <td class="gredBg">Item Name</td>
                        <td class="gredBg">Issue Qty.</td>
						<td class="gredBg">Finacial Year</td>
                        <td width="4%" class="gredBg">View</td> 
                        <td width="4%" class="gredBg">Edit</td>
                        <td width="4%" class="gredBg">Delete</td>
                      </tr>
                    <?  
                      if(mysql_num_rows($result)>0)
                      {
                        $sno = 1;$oldid = "";$count =1;                            
                        while($row=mysql_fetch_array($result))
                        {	
                          $sql_idate="select * from ms_IE_master where insert_date='".date('Y-m-d')."' and IE_id='".$row['IE_id']."'";
                          $res_idate=mysql_query($sql_idate);	
                          $row_idate=mysql_fetch_array($res_idate);
                          $insert_date=$row_idate['insert_date'];
                        ?>
                          <tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
                            <td align="center"><?=$sno?></td>
                            <td align="center"><?= $row['IE_id']?></td>
                            <td align="center"><?= getDateFormate($row['IE_date'])?></td>
                            <td align="left" style="padding-left:5px">
                            <?
                            $sql_I="select * from ms_item_master where item_id= '".$row['item_id']."' ";
                            $res_item=mysql_query($sql_I) or die(mysql_error());
                            $row_item=mysql_fetch_array($res_item);
                             echo $row_item['name'].';Drg No. '.$row_item['drawing_number'].';Cat No. '.$row_item['catelog_number'];
                            ?>
                            </td>
                            <td align="center"><?= $row['iss_qty']?></td>
							<td align="center"><?= $row['finYear']?></td>
                            <td align="center" rowspan="<?=$row_count?>">
                              <a href="store_view_issue_entry.php?IE_id=<?=$row["IE_id"]?>">
                              <img src="images/search-icon.gif" alt="View" title="View" border="0" /></a>
                            </td>
														<?
                              if($SessionUserType=='Administrator' || (date('Y-m-d')==$insert_date))
                              {
                              ?>
                              <td align="center">
                                <a href="store_add_issue_entry.php?IE_id=<?=$row["IE_id"]?>&mode=edit">
                                  <img src="images/icon_edit.gif" alt="Edit" title="Edit" border="0" />
                                </a>
                              </td>
                              <td align="center">
                                <a href="javascript:;" onClick="overlay(<?=$row["IE_transaction_id"]?>);">
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
                          <td colspan="8" align="center" style="font-weight:bold">No Records Found</td>
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