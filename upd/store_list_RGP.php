<? include("inc/store_header.php");?>
<script type="text/javascript">
function overlay(id) {
  el = document.getElementById("overlay");
	document.getElementById("hidden_overlay").value=id;
	el.style.visibility = (el.style.visibility == "visible") ? "hidden" : "visible";	
}
function getDataInDiv(divId,page)
{
	var strURL=page;
	var params = "RGP_id="+document.getElementById("RGP_id").value;
	
	params +=  "&supplier_id="+document.getElementById("supplier_id").value;
	params +=  "&RGPDate="+document.getElementById("RGPDate").value;
	params +=  "&item_id="+document.getElementById("item_id").value;
	
	params +=  "&department_id="+document.getElementById("department_id").value;
	
	var req = getXMLHTTP();
	if (req)
	{																					
		req.onreadystatechange = function() 
		{
			if (req.readyState == 4) 
			{
				if (req.status == 200) 
				{
					document.getElementById(divId).innerHTML=req.responseText;
				} 
				else 
				{
					alert("There was a problem while using XMLHTTP:\n" + req.statusText);
				}
			}                
		}       
		req.open("POST",strURL,true);
		req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		req.setRequestHeader("Content-length", params.length);
		req.setRequestHeader("Connection", "close");
		req.send(params);
	}
}
</script>

<?
$Page = "store_list_RGP.php";
$PageTitle = "List RGP";
$PageFor = "RGP";
$PageKey = "RGP_id";
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
	$sql="select * from ms_RGP_GRN_master where RGP_id='".$PageKeyValue."'";
	$res=mysql_query($sql);
	if(mysql_num_rows($res)>0)
	{
		$Message="Not Deleted";
		echo "<script>alert('Sorry.RGP GRN is made for this Order.');location.href='$Page?Message=$Message';</script>";
	}
	else
	{
		$sql = "delete from ms_RGP_master where $PageKey = '".$PageKeyValue."'";
		if(mysql_query ($sql))
		{
			$sqltrans = "delete from ms_RGP_transaction where  $PageKey = '".$PageKeyValue."'";
			if(mysql_query($sqltrans))
				$Message = "Record Sucessfully Deleted";
		}
		$Message = "Record Sucessfully Deleted";
		redirect("$Page?Message=$Message");
	}
}

?>
<?
if(date('m') > 03){	$gFinYear = date('Y').'-'.(date('Y')+1);	}else{	$gFinYear = (date('Y')-1).'-'.date('Y');	}
$sql="select mm.RGP_id,mm.RGP_date,mm.supplier_id,mt.item_name,mt.quantity,mt.pend_qty, mm.finYear from ms_RGP_master mm,ms_RGP_transaction mt where mm.RGP_id=mt.RGP_id order by mm.RGP_id asc";
#$sql="select mm.RGP_id,mm.RGP_date,mm.supplier_id,mt.item_name,mt.quantity,mt.pend_qty from ms_RGP_master mm,ms_RGP_transaction mt where mm.RGP_id=mt.RGP_id and mm.finYear = '".$gFinYear."' order by mm.RGP_id asc";
$result=mysql_query($sql);
$rn=mysql_num_rows($result);

?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
  <tr>
    	<td align="left" valign="top" width="230px" style="padding-top:5px;" >
			<? include ("inc/store_snb.php"); ?>
      </td>
        
      <td style="padding-left:5px; padding-top:5px;" valign="top">
      	<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
        	<tr>
          	<td align="center" class="gray_bg">
            	<img src="images/bullet.gif" width="15" height="22"/> &nbsp; List RGP
            </td>
          </tr>
          <tr>
          	<td valign="top">
              <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
              	<tr>
                  <td align="center" class="border">
                     <div id="div_message" style="color:#399;font-size:16px;font-weight:bold;"><?=$Message?></div>
                      <table align="center" width="100%" border="1" class="table1 text_1">
                        <tr>
                          <td align="center" colspan="4"><b>Search Items</b></td>
                        </tr>
                        <tr>
                          <td align="left"><b>RGP No.</b></td>
                          <td align="left">
                            <input type="text" name="RGP_id" id="RGP_id" onkeyup="getDataInDiv('getItemsInDiv','store_get_list_RGP.php')" />
                          </td>
                          <td align="left"><b>Supplier</b></td>
                          <td align="left">
                          <select name="supplier_id" id="supplier_id" style="width:145px;" onchange="getDataInDiv('getItemsInDiv','store_get_list_RGP.php')">
                              <option value="">-Select-</option>
                              <?
                              $sql_sup= "select * from ms_supplier order by name asc";
                              $res_sup = mysql_query ($sql_sup) or die ("Invalid query : ".$sql_sup."<br>".mysql_errno()." : ".mysql_error());
                              if(mysql_num_rows($res_sup)>0)
                              {
                                while($row_sup = mysql_fetch_array($res_sup))
                                {
                                ?>
                                  <option value="<?= $row_sup['supplier_id']?>"><?= $row_sup['name']?></option>
                                <?
                                }
                              }	
                              ?>
                            </select>
                          </td>
                         </tr>
                         <tr>
                          <td align="left"><b>RGP Date</b></td>
                          <td align="left">
                            <input type="text" name="RGPDate" id="RGPDate"/>
                              <a href="javascript:void(0)" HIDEFOCUS
                                onClick="gfPop.fPopCalendar(document.getElementById('RGPDate'));return false;">
                                <img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
                              </a> 
                            
                          </td>
                          <td align="left"><b>Item Name</b></td>
                          <td align="left">
                          <input name="item_id" id="item_id" type="text" style="width:145px;" onkeyup="getDataInDiv('getItemsInDiv','store_get_list_RGP.php')"/>
                          </td>
                        </tr>
                        <tr>
                        	<td align="left"><b>Department</b></td>
                          <td align="left" colspan="3">
                          <select name="department_id" id="department_id" style="width:145px;" onchange="getDataInDiv('getItemsInDiv','store_get_list_RGP.php')">
                              <option value="">-Select-</option>
                              <?
                              $sql_D= "select * from ms_department order by name asc";
                              $res_D = mysql_query ($sql_D) or die ("Invalid query : ".$sql_D."<br>".mysql_errno()." : ".mysql_error());
                              if(mysql_num_rows($res_D)>0)
                              {
                                while($row_D = mysql_fetch_array($res_D))
                                {
                                ?>
                                  <option value="<?= $row_D['department_id']?>"><?= $row_D['name']?></option>
                                <?
                                }
                              }	
                              ?>
                            </select>
                          </td>
                        </tr>
                        <tr>
                        	<td colspan="4" align="center">
                            	<input type="button" id="btnOk" name="btnOk" value="Ok" onclick="getDataInDiv('getItemsInDiv','store_get_list_RGP.php')"/>
                            </td>
                        </tr>
                      </table>
                      <div id="getItemsInDiv" style="margin:0 auto;width:100%;overflow:auto;height:800px">
                        <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0" class="tableborder">
                          <tr>
                            <td valign="top">
                              <table align="center" width="100%" border="1" class="table1 text_1">
                                <tr>
                                  <td class="gredBg">S.No.</td>
                                  <td class="gredBg">RGP No.</td>
                                  <td class="gredBg">RGP Date</td>
                                  <td class="gredBg">Supplier</td>
                                  <td class="gredBg">Item Name</td>
                                  <td class="gredBg">RGP Qty.</td>
                                  <td class="gredBg">Pend. Qty.</td>
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
                                    $sql_idate="select * from ms_RGP_master where insert_date='".date('Y-m-d')."' and RGP_id='".$row['RGP_id']."'";
                                    $res_idate=mysql_query($sql_idate);	
                                    $row_idate=mysql_fetch_array($res_idate);
                                    $insert_date=$row_idate['insert_date'];
                                    ?>
                                    <tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
                                      <td align="center"><?=$sno?></td>
                                      <td align="center"><?= $row['RGP_id']?></td>
                                      <td align="center"><?=getDateFormate($row['RGP_date']);?></td>
                                      <td align="left" style="padding-left:5px">
                                      <?
                                        $sql_sup= "select * from ms_supplier where supplier_id='".$row['supplier_id']."' ";
                                        $res_sup = mysql_query ($sql_sup) or die ("Invalid query : ".$sql_sup."<br>".mysql_errno()." : ".mysql_error());
                                        $row_sup = mysql_fetch_array($res_sup);
                                        echo $row_sup['name'];
                                       ?>
                                      </td>
                                      <td align="left" style="padding-left:5px"><?= $row['item_name']?></td>
                                      <td align="center"><?= $row['quantity']?></td>
                                      <td align="center"><?= $row['pend_qty']?></td>
									  <td align="center"><?= $row['finYear']?></td>
                                      <?
																			if($row['RGP_id']!=$oldid)
																			{
																				$oldid = $row['RGP_id'];
																				$count=1;
																			}
																			$sql_tr="select * from ms_RGP_transaction where RGP_id='".$oldid."'";
																			$res_tr=mysql_query($sql_tr);
																			$row_count=mysql_num_rows($res_tr);
																			if($count==1)
																			{
																				?>
                                         <td align="center" rowspan="<?=$row_count?>">
                                           <a href="store_view_RGP.php?RGP_id=<?=$row["RGP_id"]?>">
                                            <img src="images/search-icon.gif" alt="View" title="View" border="0" />
                                           </a>
                                          </td> 
                                        <?
																				if(1)
																				{
																				//$SessionUserType=='Administrator' || (date('Y-m-d')==$insert_date)
																				?>
                                        <td align="center" rowspan="<?=$row_count?>">
                                          <a href="store_add_RGP.php?RGP_id=<?=$row["RGP_id"]?>&mode=edit">
                                            <img src="images/icon_edit.gif" alt="Edit" title="Edit" border="0" />
                                          </a>
                                        </td>
                                        <td align="center" rowspan="<?=$row_count?>">
                                          <a href="javascript:;" onClick="overlay(<?=$row["RGP_id"]?>);">
                                          <img src="images/delete_icon.gif" alt="Delete" title="Delete" border="0">
                                          </a>
                                        </td>
																					<?
																				}
																				else
																				{
																				?>
																				 <td rowspan="<?=$row_count?>"></td>
																				 <td rowspan="<?=$row_count?>"></td>   
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
																		<tr><td align="center" colspan="10"><b>No Record Found.</b></td></tr>
																	<?
																}
                              	?>
                            	</table>      
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
          <p>Are you sure to delete this Record</p>
          <form name="frm_del" action="<?=$_SERVER['PHP_SELF']?>" method="post">
          <input type="hidden" name="hidden_overlay" id="hidden_overlay" value="" />
          <input type="submit" name="btn_del" value="Yes" />
          <input type="button" onClick="overlay();" name="btn_close" value="No" />
          </form>
     </div>
</div>
<? include("inc/hr_footer.php"); ?>