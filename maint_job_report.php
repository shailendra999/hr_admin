<?
include("inc/maint_header.php");
?>
<style>
.getDataInDiv{
	background:#fff;
	border:1px solid #96A2BC;
	overflow:hidden;
}
</style>
<script type="text/javascript">
	function getDataInDiv(divId,page)
	{
		var strURL1;
		var dept_id=document.getElementById('department_id').value;
		var report=document.getElementsByName('reportFor');
		var reportFor='';
		for(var i=0;i<report.length;i++)
		{
			if(report[i].checked==true)
				reportFor=report[i].value;
		}
		var From=document.getElementById('From').value;
		var To=document.getElementById('To').value;
		var value=dept_id+','+reportFor+','+From+','+To;
		strURL1=page+"?value="+value+"&sid="+Math.random();
		//alert(strURL1);
		if(From=='' || To=='')
			alert("Date Should Not Be Empty");
		else
		{
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
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
	<tr>
		<td align="left" valign="top" width="230px" style="padding-top:5px;">
			<? include ("inc/maint_snb.php"); ?>
		</td>
		<td style="padding-left:5px; padding-top:5px;" valign="top">
			<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
        <tr>
          <td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; Maintenance Report</td>
        </tr>
        <tr>
          <td valign="top" style="padding-top:10px;">
            <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td valign="top" style="padding-bottom:5px;" width="100%" bgcolor="#EAE3E1">
                  <table align="center" width="100%" border="1" class="text_1">
                    <tr>
                      <td align="center" colspan="7"><b>Report</b></td>
                    </tr>
                    <tr>
                      <td align="left"><input type="radio" name="reportFor" value="All" checked="checked"/>All</td>
                      <td align="left"><input type="radio" name="reportFor" value="Pending" />Pending</td>
                      <td align="left" colspan="5"><input type="radio" name="reportFor" value="Finished" />Finished</td>
                    </tr>
                    <tr>
                    	<td align="left"><b>Department</b></td>
                    	<td align="left">
                      <?
												$sql_d= "select * from maint_department order by name asc";
												$res_d = mysql_query ($sql_d) or die ("Invalid query : ".$sql_d."<br>".mysql_errno()." : ".mysql_error());
											?>
                      <select name="department_id" id="department_id" style="width:125px;">
                        <option value="">All</option>
                        <?
                        if(mysql_num_rows($res_d)>0)
                        {
                          while($row_d = mysql_fetch_array($res_d))
                          {
                          ?>
                        		<option value="<?=$row_d['department_code']?>" ><?=$row_d['name']?></option>
                          <?
                          }
                        }	
                        ?>
                      </select>
                      </td>
                    	<td><b>From</b></td>
                      <td>
                      	<input type="text" name="From" id="From" />
                      	<a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.getElementById('From'));return false;" HIDEFOCUS>
                        	<img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
                        </a> 
                      </td>
                      <td><b>To</b></td>
                      <td>
                      	<input type="text" name="To" id="To" />
                      	<a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.getElementById('To'));return false;" HIDEFOCUS>
                        	<img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
                        </a> 
                        
                      </td>
                      <td>
                      	<input type="button" id="btnOk" name="btnOk" value="Ok" onclick="getDataInDiv('getDataInDiv','maint_get_list_report.php')"/>
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
   
<? 
include("inc/hr_footer.php");
?>