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
	var	dateFrom= document.getElementById('dateFrom').value;
	var	dateTo= document.getElementById('dateTo').value;
	
	str=dateFrom+','+dateTo+','+value;
	var strURL1=page+"?str="+str+"&byControl="+byControl+"&sid="+Math.random();
	
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
<iframe width=168 height=190 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="calendar/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
</iframe> 

<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
  <tr>
    <td align="left" valign="top" width="230px" style="padding-top:5px;">
			<? include ("inc/store_snb.php"); ?>
    </td>
    <td style="padding-left:5px; padding-top:5px;" valign="top">
      <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
          <td align="center" class="gray_bg">
            <img src="images/bullet.gif" width="15" height="22"/> &nbsp; Consumption Report
          </td>
        </tr>
        <tr>
          <td valign="top">
            <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td align="center" class="border" >
                  <table align="center" width="100%" border="1" class="table1 text_1">
                    <tr>
                      <td align="center" colspan="4"><b>Search Items</b></td>
                    </tr>
                    <tr>
                      <td align="left"><b>From</b></td>
                      <td align="left">
                        <input type="text" name="dateFrom" id="dateFrom"/>
                        <a href="javascript:void(0)" HIDEFOCUS
                            onClick="gfPop.fPopCalendar(document.getElementById('dateFrom'));return false;">
                            <img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
                        </a> 
                      </td>
                      <td align="left"><b>To</b></td>
                      <td align="left">
                        <input type="text" name="dateTo" id="dateTo"/>
                          <a href="javascript:void(0)" HIDEFOCUS
                            onClick="gfPop.fPopCalendar(document.getElementById('dateTo'));return false;">
                            <img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
                          </a> 
                      </td>
                     </tr>
                     
                     <tr>
                      <td align="left"><b>Department</b></td>
                      <td align="left">
                        <select name="department_id" id="department_id" style="width:150px;height:20px" onChange="getDataInDiv(this.value,'getItemsInDiv','store_get_report_consumption.php','Department')" >
                          <option value="">-Select-</option>
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
                      <td align="left"><b>Machinary</b></td>
                      <td align="left">
                        <select name="machinary_id" id="machinary_id" style="width:150px;height:20px" onChange="getDataInDiv(this.value,'getItemsInDiv','store_get_report_consumption.php','Machinary')" >
                          <option value="">-Select-</option>
													<? 
                          $sql_I= 'select * from ms_machinary order by name asc';
                            $res_I = mysql_query ($sql_I) or die (mysql_error());
                            if(mysql_num_rows($res_I)>0)
                            {
                              while($row_I = mysql_fetch_array($res_I))
                              {
                                ?>
                                <option value='<?= $row_I['machinary_id']?>'><?= $row_I['name']?></option>
                                <? 
                              }
                            }
                            ?>
                        </select>
                    	</td>
                 		</tr>
                    <tr>
                      <td align="left"><b>Item Name</b></td>
                      <td align="left" colspan="3">
                        <select name="item_id" id="item_id" style="width:250px;height:20px" onChange="getDataInDiv(this.value,'getItemsInDiv','store_get_report_consumption.php','ItemId')" >
                          <option value="">-Select-</option>
													<? 
                          	$sql_I= 'select * from ms_item_master order by name asc';
                            $res_I = mysql_query ($sql_I) or die (mysql_error());
                            if(mysql_num_rows($res_I)>0)
                            {
                              while($row_I = mysql_fetch_array($res_I))
                              {
                                ?>
                                <option value='<?= $row_I['item_id']?>'><?= $row_I['name']?></option>
                                <? 
                              }
                            }
                           ?>
                        </select>
                    	</td>
                 		 </tr>
            			</table>
                  <div id="getItemsInDiv" style="margin:0 auto;width:100%;overflow:auto;height:800px">
                    
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