<? include("inc/elec_header.php"); ?>
<script>
function overlay(id) {
    el = document.getElementById("overlay");
	document.getElementById("hidden_overlay").value=id;
	el.style.visibility = (el.style.visibility == "visible") ? "hidden" : "visible";	
}
/*function getDataInDiv(divId,page,byControl){
		var strURL1;var value='';
		var sdid=document.getElementById('sub_department_id').value;
		var did=document.getElementById('department_id').value;
		if(byControl=="ReadingDate"){
			var RD=document.getElementById('readingDate').value;
			if(sdid=='')
				value='D'+','+did+','+RD;
			if(did=='')
				value='S'+','+sdid+','+RD;
			strURL1=page+"?value="+value+"&byControl="+byControl;
		}
		if(byControl=="DateFromTo"){
			var from=document.getElementById('RDFrom').value;
			var to=document.getElementById('RDTo').value;
			if(sdid=='')
				value='D'+','+did+','+from+','+to;
			if(did=='')
				value='S'+','+sdid+','+from+','+to;
			strURL1=page+"?value="+value+"&byControl="+byControl;
			//alert(strURL1);
		}
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
}*/
function getDataInDiv(divId, page, byControl){
	var strURL1;
	var sdep = document.getElementById('sub_department_id').value;
	var dep = document.getElementById('department_id').value;
	var fromDate = document.getElementById('RDFrom').value;
	var toDate = document.getElementById('RDTo').value;
	var readingDate = document.getElementById('readingDate').value;
	strURL1=page+"?subDEp="+sdep+"&dep="+dep+"&fDate="+fromDate+"&tDate="+toDate+"&rDate="+readingDate;

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
</script>

<?
$Page = "elec_list_LT.php";
$PageTitle = "List Low Tension";
$PageFor = "Low Tension";
$PageKey = "LT_id";
$PageKeyValue = "";
$Message = "";

if(isset($_GET["Message"])){
	$Message = $_GET["Message"];
}
if(isset($_POST["btn_del"])){
	$PageKeyValue  = $_POST["hidden_overlay"];
	$sql = "delete from elec_LT where $PageKey = '".$PageKeyValue."'";
	if(mysql_query ($sql)){
		$Message = "Record Sucessfully Deleted";
	}
	//$Message = "Order Sucessfully Deleted";
	redirect("$Page?Message=$Message");
}

$sql="select * from elec_LT order by reading_date asc";
$result=mysql_query($sql) or die ("Query Failed ".mysql_error());;

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
          	<img src="images/bullet.gif" width="15" height="22"/> &nbsp; List Low Tension
          </td>
        </tr>
        <tr>
          <td valign="top">
            <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td align="center" class="border" >
                	<div id="div_message" style="color:#399;font-size:16px;font-weight:bold;"><?=$Message?></div>
                  <table id="" align="center" width="100%" border="1" class="table1 text_1">
                    <tr>
                      <td align="center" colspan="4"><b>Search Items</b></td>
                    </tr>
                    <tr>
                      <td align="left"><b>Department</b></td>
                      <td align="left" colspan="3">
                      <select id="department_id" name="department_id" style="width:250px;height:20px" onchange="get_frm('elec_get_sub_department.php',this.value,'SubDepartment','');">
<!--<select id="department_id" name="department_id" style="width:250px;height:20px" onchange="document.getElementById('sub_department_id').selectedIndex=0;">-->
                        <option value="selectAll">-- All Department --</option>
<? $sql_d="select * from elec_department order by name";
$res_d=mysql_query($sql_d) or die ("Query Failed ".mysql_error());
while($row_d=mysql_fetch_array($res_d)){ ?>
<option value="<?= $row_d['department_id']?>"><?= $row_d['name']?></option>
<?	} ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td align="left"><b>Sub Department</b></td>
                      <td align="left">
<div id="SubDepartment">
    <select id="sub_department_id" name="sub_department_id" style="width:150px;height:20px">
    <option value="0"></option>
    <? $sql_d="select * from elec_sub_department order by name";
    $res_d=mysql_query($sql_d) or die ("Query Failed ".mysql_error());
    while($row_d=mysql_fetch_array($res_d)){ ?>
        <option value="<?=$row_d['sub_department_id']?>"><?= $row_d['name']?></option>
<?	} ?>
    </select>
</div>
                      </td>
                      <td align="left"><b>Reading Date(Format dd-mm-yyyy)</b></td>
                      <td align="left">
                      <input type="text" name="readingDate" id="readingDate" />
                      	<a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.getElementById('readingDate'));return false;" HIDEFOCUS>
                        	<img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
                        </a> 
                        <input type="button" id="btnOk" name="btnOk" value="Ok" onclick="getDataInDiv('getDataInDiv','elec_get_list_LT.php','ReadingDate')"/>
                       </td>
                    </tr>
                    <tr>
                    	<td align="left"><b>Date From</b></td>
                      <td align="left">
                      <input type="text" name="RDFrom" id="RDFrom" />
                      	<a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.getElementById('RDFrom'));return false;" HIDEFOCUS>
                        	<img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
                        </a> 
                       </td>
                       <td align="left"><b>Date To</b></td>
                      <td align="left">
                      <input type="text" name="RDTo" id="RDTo" />
                      	<a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.getElementById('RDTo'));return false;" HIDEFOCUS>
                        	<img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
                        </a> 
                        <input type="button" id="btnOk" name="btnOk" value="Ok" onclick="getDataInDiv('getDataInDiv','elec_get_list_LT.php','DateFromTo')"/>
                       </td>
                    </tr>
                  </table>
                  <div id="getDataInDiv" style="margin:0 auto;width:100%;overflow:auto;height:600px">
                    <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0" class="tableborder">
                      <tr>
                        <td valign="top">	
                          <? if(mysql_num_rows($result)>0){
                                $sno =1;
                            ?>
                            <table align="center" id="tableEntry" width="100%" border="1" class="table1 text_1">
                              <tr>
                                <td class="gredBg">S.No.</td>
                                <td class="gredBg">Department</td>
                                <td class="gredBg">Sub Department</td>
                                <td class="gredBg">Reading</td>
                                <td class="gredBg">Reading Date</td>
                                <td width="4%" class="gredBg">Edit</td>
                                <td width="4%" class="gredBg">Delete</td>
                              </tr>
	  <? while($row=mysql_fetch_array($result)){
            $sql_idate="select * from elec_LT where insert_date='".date('Y-m-d')."' and LT_id='".$row['LT_id']."'";
            $res_idate=mysql_query($sql_idate);
            $row_idate=mysql_fetch_array($res_idate);
            $insert_date=$row_idate['insert_date']; ?>
      <tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
        <td align="center"><?=$sno?></td>
        <td align="left" style="padding-left:5px">
        <? $sql_dep = "select * from elec_department where department_id = '".$row['department_id']."' ";
          $res_dep = mysql_query($sql_dep) or die ("Invalid query : ".$sql_dep."<br>".mysql_errno().":".mysql_error());
          $row_dep = mysql_fetch_array($res_dep);
          echo $row_dep['name']; ?>	
        </td>
        <td align="left" style="padding-left:5px">
        <? $sql_SD = "select * from elec_sub_department where sub_department_id = '".$row['sub_department_id']."'";
          $res_SD= mysql_query($sql_SD) or die (mysql_error());
          $row_SD = mysql_fetch_array($res_SD);
          echo $row_SD['name']; ?>	
        </td>
        <td align="center"><?=$row['reading']?></td>
        <td align="center"><?=getDateFormate($row['reading_date'])?></td>
        <? if(1){//$SessionUserType=='Administrator' || (date('Y-m-d')==$insert_date) ?>
                                            <td align="center">
            <a href="elec_add_LT.php?LT_id=<?=$row["LT_id"]?>&mode=edit">
              <img src="images/icon_edit.gif" alt="Edit" title="Edit" border="0" />
            </a>
                                            </td>
          <td align="center">
            <a href="javascript:;" onClick="overlay(<?=$row["LT_id"]?>);">
              <img src="images/delete_icon.gif" alt="Delete" title="Delete" border="0">
            </a>
          </td>
			<? }else{ ?>
                <td align="center"></td>
                <td align="center"></td>
            <? } ?>
      </tr>
        <? $sno++;
          }	?>         
  </table>
    <? } ?>        
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
      <p>Are you sure to delete this Item</p>
      <form name="frm_del" action="<?=$_SERVER['PHP_SELF']?>" method="post">
        <input type="hidden" name="hidden_overlay" id="hidden_overlay" value="" />
        <input type="submit" name="btn_del" value="Yes" />
        <input type="button" onClick="overlay();" name="btn_close" value="No" />
      </form>
   </div>
</div>

<? include("inc/hr_footer.php"); ?>