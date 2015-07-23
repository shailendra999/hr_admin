<?
include("inc/elec_header.php");
?>
<style>
.getDataInDiv
{
	background:#fff;
	border:1px solid #96A2BC;
	overflow:hidden;
}
</style>
<script type="text/javascript">
function overlay(id) {
  el = document.getElementById("overlay");
	document.getElementById("hidden_overlay").value=id;
	el.style.visibility = (el.style.visibility == "visible") ? "hidden" : "visible";	
}
function getDataInDiv(value,divId,page,byControl)
{
		var strURL1;
		var plant_id=document.getElementById('plant_id').value;
		if(plant_id==0)
		{
			alert("Select a Plant From List");
			return false;
		}
		else
		{
			if(value=="" && byControl=="ReadingDate")
			{
				var pump_id=document.getElementById('plant_transaction_id').value;
				var rd=document.getElementById('readingDate').value;
				var value=plant_id+','+pump_id+','+rd;
				strURL1=page+"?value="+value+"&byControl="+byControl+"&sid="+Math.random();
				
			}
			else if(value=="" && byControl=="DateFromTo")
			{
				var pump_id=document.getElementById('plant_transaction_id').value;
				var rdfrom=document.getElementById('RDFrom').value;
				var rdto=document.getElementById('RDTo').value;
				var value=plant_id+','+pump_id+','+rdfrom+','+rdto;
				strURL1=page+"?value="+value+"&byControl="+byControl+"&sid="+Math.random();
			}
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
function getPump(value,divId,page)
{
		var strURL1=page+"?plant_id="+value+"&sid="+Math.random();
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
$Page = "elec_list_HPS.php";
$PageTitle = "List Humidification Pump Status";
$PageFor = "Humidification Pump Status";
$PageKey = "HPS_id";
$PageKeyValue = "";
$Message = "";

?>
<?
if(isset($_GET["Message"]))
{
	$Message = $_GET["Message"];
}
/*if(isset($_POST["btn_del"]))
{
	$PageKeyValue  = $_POST["hidden_overlay"];
	$sql = "delete from elec_HPS_master where $PageKey = '".$PageKeyValue."'";
	$sqltrans= "delete from elec_HPS_transaction where $PageKey = '".$PageKeyValue."'";
	if(mysql_query ($sql))
	{
		if(mysql_query ($sqltrans))
		{
			$Message = "Record Sucessfully Deleted";
		}
	}
	//$Message = "Order Sucessfully Deleted";
	redirect("$Page?Message=$Message");
}*/

?>
<?
$sql="select * from elec_HPS_master order by reading_date asc";
$result=mysql_query($sql);

?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
  <tr>
    <td align="left" valign="top" width="230px" style="padding-top:5px;">
    <? include ("inc/elec_snb.php"); ?>
    </td>
    <td style="padding-left:5px; padding-top:5px;" valign="top">
      <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
          <td align="center" class="gray_bg">
          	<img src="images/bullet.gif" width="15" height="22"/>&nbsp; List Humidification Pump Status
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
                      <td align="center" colspan="10"><b>Search Items</b></td>
                    </tr>
                    <tr>
                    	<td align="left"><b>Plant Name</b></td>
                    	<td align="left">
                      <select name="plant_id" id="plant_id" style="width:160px" onchange="getPump(this.value,'getPumpInDiv','elec_get_pump.php')">
                      	<option value="0"></option>
												<?
                          $sql_pl="select * from elec_plant_master order by name asc";
                          $res_pl=mysql_query($sql_pl);
                          while($row_pl=mysql_fetch_array($res_pl))
                          {
                          ?>
                          <option value="<?=$row_pl['plant_id']?>"><?=$row_pl['name']?></option>
                          <?
                          }
                        ?>
                      </select>
                      </td>
                      <td align="left"><b>Pump Name</b></td>
                      <td><div id="getPumpInDiv" class="getDataInDiv" style="width:150px;height:20px"></div></td>
                      <td>
                      <input type="text" name="readingDate" id="readingDate" />
                      	<a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.getElementById('readingDate'));return false;" HIDEFOCUS>
                        	<img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
                        </a> 
                        <input type="button" id="btnOk" name="btnOk" value="Ok" onclick="getDataInDiv('','getDataInDiv','elec_get_list_HPS.php','ReadingDate')"/>
                       </td>
                    </tr>
                    <tr>
                    	<td><b>Date From</b></td>
                      <td>
                      <input type="text" name="RDFrom" id="RDFrom" />
                      	<a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.getElementById('RDFrom'));return false;" HIDEFOCUS>
                        	<img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
                        </a> 
                       </td>
                       <td><b>Date To</b></td>
                      <td>
                      <input type="text" name="RDTo" id="RDTo" />
                      	<a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.getElementById('RDTo'));return false;" HIDEFOCUS>
                        	<img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
                        </a> 
                        <input type="button" id="btnOk" name="btnOk" value="Ok" onclick="getDataInDiv('','getDataInDiv','elec_get_list_HPS.php','DateFromTo')"/>
                       </td>
                    </tr>
                  </table>
                  <div id="getDataInDiv" style="margin:0 auto;width:100%;overflow:auto;height:850px;"></div>
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