<?
include("inc/store_header.php");
?>
<script>
function overlay(id) {
  el = document.getElementById("overlay");
	document.getElementById("hidden_overlay").value=id;
	el.style.visibility = (el.style.visibility == "visible") ? "hidden" : "visible";	
}
function getDataInDiv(value,divId,page,byControl){
	var	monthNameFrom= document.getElementById('monthNameFrom').value;
	var	yearNameFrom= document.getElementById('yearNameFrom').value;
	var	monthNameTo= document.getElementById('monthNameTo').value;
	var	yearNameTo= document.getElementById('yearNameTo').value;
	var flag = true;
	if(monthNameFrom=="" || yearNameFrom==""||monthNameTo=="" || yearNameTo==""){
		alert("Select Month and Year");
		flag=false;
	}else{
		if(parseInt(yearNameFrom)>parseInt(yearNameTo)){
			alert("Select Correct Year.");
			flag=false;
		}
		else if(parseInt(yearNameFrom)<=parseInt(yearNameTo)){
			if(yearNameFrom==yearNameTo && (parseInt(monthNameFrom)>parseInt(monthNameTo))){
				alert("Select Correct Month.");
				flag=false;
			}
		}
	}
	if(flag==true){
		value+=monthNameFrom+','+yearNameFrom+','+monthNameTo+','+yearNameTo;
		var strURL1=page+"?str="+value+"&sid="+Math.random();
		//alert(strURL1);
		var req = getXMLHTTP();
		if (req){																					
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

<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
  <tr>
    <td align="left" valign="top" width="230px" style="padding-top:5px;">
			<? include ("inc/store_snb.php"); ?>
    </td>
    <td style="padding-left:5px; padding-top:5px;" valign="top">
      <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
          <td align="center" class="gray_bg">
            <img src="images/bullet.gif" width="15" height="22"/> &nbsp; Monthly Stock Report
          </td>
        </tr>
        <tr>
          <td valign="top">
            <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
              <!--<tr>
                <td class="AddMore">
                  <a target="_blank" href="#" title="Print">Print&nbsp;&nbsp;&nbsp;</a>
                </td>
              </tr>-->
              <tr>
                <td align="center" class="border" >
                  <table align="center" width="100%" border="1" class="table1 text_1">
                    <tr>
                      <td align="center" colspan="4"><b>Search Items</b></td>
                    </tr>
                    <tr>
                      <td align="left"><b>From</b></td>
                      <td align="left">
                        <select name="monthNameFrom" id="monthNameFrom">
                        	<option value="">-Select-</option>
                          <option value="1">January</option><option value="2">February</option>
                          <option value="3">March</option><option value="4">April</option>
                          <option value="5">May</option><option value="6">June</option>
                          <option value="7">July</option><option value="8">August</option>
                          <option value="9">September</option><option value="10">October</option>
                          <option value="11">November</option><option value="12">December</option>
                        </select>
                        <select name="yearNameFrom" id="yearNameFrom">
                        	<option value="">-Select-</option>
                          <option value="2010">2010</option><option value="2011">2011</option>
                          <option value="2012">2012</option><option value="2013">2013</option>
                          <option value="2014">2014</option><option value="2015">2015</option>
                          <option value="2016">2016</option><option value="2017">2017</option>
                          <option value="2018">2018</option><option value="2019">2019</option>
                          <option value="2020">2020</option><option value="2021">2021</option>
                        </select>
                      </td>
                      <td align="left"><b>To</b></td>
                      <td align="left">
                         <select name="monthNameTo" id="monthNameTo">
                        	<option value="">-Select-</option>
                          <option value="1">January</option><option value="2">February</option>
                          <option value="3">March</option><option value="4">April</option>
                          <option value="5">May</option><option value="6">June</option>
                          <option value="7">July</option><option value="8">August</option>
                          <option value="9">September</option><option value="10">October</option>
                          <option value="11">November</option><option value="12">December</option>
                        </select>
                        <select name="yearNameTo" id="yearNameTo">
                        	<option value="">-Select-</option>
                          <option value="2010">2010</option><option value="2011">2011</option>
                          <option value="2012">2012</option><option value="2013">2013</option>
                          <option value="2014">2014</option><option value="2015">2015</option>
                          <option value="2016">2016</option><option value="2017">2017</option>
                          <option value="2018">2018</option><option value="2019">2019</option>
                          <option value="2020">2020</option><option value="2021">2021</option>
                        </select>
                        <input type="button" id="btnOk" name="btnOk" value="Ok" onClick="getDataInDiv('','getItemsInDiv','store_get_report_monthly_stock.php','')"/>
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
<iframe width=168 height=190 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="calendar/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
</iframe>  
<? 
include("inc/hr_footer.php");
?>