<?
include("inc/elec_header.php");
?>
<script>
function overlay(id) {
    el = document.getElementById("overlay");
	document.getElementById("hidden_overlay").value=id;
	el.style.visibility = (el.style.visibility == "visible") ? "hidden" : "visible";	
}
function getDataInDiv(value,divId,page,byControl)
{
		var strURL1;
		var did=document.getElementById('department_id').value;
		var mname=document.getElementById('machine_name').value;
			//alert("Select Sub Department");
	//	else
		if(value=='' && byControl=='MachineName')
		{   }
		else
		{
			if(byControl=="DateFromTo")
			{
				var from=document.getElementById('RDFrom').value;
				var to=document.getElementById('RDTo').value;
				var str=did+','+mname+','+from+','+to;
				strURL1=page+"?str="+str+"&byControl="+byControl;
			}
			if(byControl=="MachineName")
			{
				strURL1=page+"?str="+value+"&byControl="+byControl;
			}
			//strURL1=page+"?str="+value+"&byControl="+byControl;
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
$Page = "elec_list_energy_consumption.php";
$PageTitle = "List Energy Consumption";
$PageFor = "Energy Consumption";
$PageKey = "EC_id";
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
	$sql = "delete from elec_energy_consumption where $PageKey = '".$PageKeyValue."'";
	if(mysql_query ($sql))
	{
		$Message = "Record Sucessfully Deleted";
	}
	//$Message = "Order Sucessfully Deleted";
	redirect("$Page?Message=$Message");
}

?>
<?
$sql="select * from elec_energy_consumption order by reading_date asc";
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
          	<img src="images/bullet.gif" width="15" height="22"/> &nbsp; List Energy Consumption
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
                      <td align="left">
                      	<select id="department_id" name="department_id" style="width:160px;height:20px">
                        <option value=""></option>
                        <?
												$sql_d="select * from elec_department order by name";
                        $res_d=mysql_query($sql_d);
												while($row_d=mysql_fetch_array($res_d))
												{
												?>
                        	<option value="<?= $row_d['department_id']?>"><?= $row_d['name']?></option>
												<?	
                        }
												?>
                        </select>
                      </td>
                      <td align="left"><b>Machine Name</b></td>
                      <td align="left">
                      <input type="text" name="machine_name" id="machine_name" onkeyup="getDataInDiv(this.value,'getDataInDiv','elec_get_list_energy_consumption.php','MachineName')" autocomplete="off"/>
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
                        <input type="button" id="btnOk" name="btnOk" value="Ok" onclick="getDataInDiv('','getDataInDiv','elec_get_list_energy_consumption.php','DateFromTo')"/>
                       </td>
                    </tr>
                    <tr bgcolor="#dddddd">
                    	<td align="left"><b>Multiflying Factor</b></td>
                      <td colspan="3">
												<?
													$factor=0;
													$sqlmf = "select * from elec_EnergyCons_MF";
													$resmf = mysql_query($sqlmf);
													$rowmf = mysql_fetch_array($resmf);
													echo $factor=(double)$rowmf['factor'];
												?>
                      </td>
                     </tr>
                  </table>
                  <div id="getDataInDiv" style="margin:0 auto;width:100%;overflow:auto;height:600px">
                    <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0" class="tableborder">
                      <tr>
                        <td valign="top">	
                            <table align="center" id="tableEntry" width="100%" border="1" class="table1 text_1">
                              <tr>
                                <td class="gredBg" width="4%">S.No.</td>
                                <td class="gredBg" width="22%">Department</td>
                                <td class="gredBg" width="22%">Machine</td>
                                <td class="gredBg" width="7%">Time</td>
                                <td class="gredBg" width="8%">Hrs Reading</td>
                                <td class="gredBg" width="7%">Reading</td>
                                <td class="gredBg" width="10%">Unit Cons/Hrs.</td>
                                <td class="gredBg" width="10%">Reading Date</td>
                                <td width="5%" class="gredBg">Edit</td>
                                <td width="5%" class="gredBg">Delete</td>
                              </tr>
                              <?  
                              if(mysql_num_rows($result)>0)
                              {
                                $sno =1;$n=1;
                                while($row=mysql_fetch_array($result))
                                {	
                                  $n=1;
                                  $sql_idate="select * from elec_energy_consumption where insert_date='".date('Y-m-d')."' and EC_id='".$row['EC_id']."'";
                                  $res_idate=mysql_query($sql_idate);
                                  $row_idate=mysql_fetch_array($res_idate);
                                  $insert_date=$row_idate['insert_date'];
                                  
                                  $da=explode('-',$row['reading_date']);//$da=explode('-','2011-03-01');
                                  $early_date= date("Y-m-d", mktime(0, 0, 0,$da[1] ,$da[2]+1 , $da[0]));
                                  $sql_u="select * from elec_energy_consumption where reading_date ='".$early_date."'";
                                  $res_u=mysql_query($sql_u);		
                                  $early_reading=0;$early_hr_reading=0;
                                  if(mysql_num_rows($res_u)>0)
                                  {
                                    $row_u=mysql_fetch_array($res_u);
                                    $early_reading=(double)$row_u['reading'];
                                    $early_hr_reading=(double)$row_u['hour_meter_reading'];$n=1;
                                  }
                                  else
                                  {
                                    $sql_u="select * from elec_energy_consumption where reading_date ='".$row['reading_date']."' limit 1,$n";
                                    $res_u=mysql_query($sql_u);		
                                    if(mysql_num_rows($res_u)>0)
                                    {
                                      $row_u=mysql_fetch_array($res_u);
                                      $early_reading=(double)$row_u['reading'];
                                      $early_hr_reading=(double)$row_u['hour_meter_reading'];
                                      $n++;
                                    }
                                  }
                                ?>
                                <tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
                                  <td align="center"><?=$sno?></td>
                                  <td align="left" style="padding-left:2px">
                                  <?
                                    $sql_dep = "select * from elec_department where department_id = '".$row['department_id']."' ";
                                    $res_dep = mysql_query($sql_dep) or die ("Invalid query : ".$sql_dep."<br>".mysql_errno().":".mysql_error());
                                    $row_dep = mysql_fetch_array($res_dep);
                                    echo $row_dep['name'];
                                  ?>	
                                  </td>
                                  <td align="left" style="padding-left:2px">
                                    <?=$row['machine_name_number']?>
                                  </td>
                                  <td align="center"><?= $row['time']?></td>
                                  <td align="center"><?= $row['hour_meter_reading']?></td>
                                  <td align="center"><?= $row['reading']?></td>
                                  <td align="right" style="padding-right:2px">
                                  <?
                                    if($early_reading>=$row['reading'])
                                    {
                                      $diff=$early_hr_reading-$row['hour_meter_reading'];
                                      if($diff!=0)
                                      {
                                        $unit=(($early_reading-$row['reading'])*$factor)/$diff;
                                        echo number_format($unit,2,'.','');
                                      }
                                      else
                                        echo 0.00;
                                    }
                                    else
                                      echo '0.00';
                                  ?>
                                  </td>
                                  <td align="center"><?= getDateFormate($row['reading_date'])?></td>
                                  <?
                                  if(1)
                                  {
									 //$SessionUserType=='Administrator' || (date('Y-m-d')==$insert_date)
                                  ?>
                                    <td align="center">
                                      <a href="elec_add_energy_consumption.php?EC_id=<?=$row["EC_id"]?>&mode=edit">
                                        <img src="images/icon_edit.gif" alt="Edit" title="Edit" border="0" />
                                      </a>
                                    </td>
                                    <td align="center">
                                      <a href="javascript:;" onClick="overlay(<?=$row["EC_id"]?>);">
                                        <img src="images/delete_icon.gif" alt="Delete" title="Delete" border="0">
                                      </a>
                                    </td>
                                  <?
                                  }
                                  else
                                  {
                                  ?>
                                    <td align="center"></td>
                                    <td align="center"></td>
                                  <?
                                  }
                                  ?>
                                </tr>
                                  <?
                                   $sno++;
                                  }	
                              }
                              else
                              {
                              ?>
                                <tr><td align="center" colspan="10"><b>No Records Found</b></td></tr>
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