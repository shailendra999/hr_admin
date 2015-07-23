<?
include("inc/elec_header.php");
?>
<link rel="stylesheet" type="text/css" href="highslide/highslide.css" />
<script type="text/javascript" src="javascript/popup.js"></script>
<script type="text/javascript" src="highslide/highslide-with-html.js"></script>
<script type="text/javascript">
function overlay(MasterId,RecordId) 
{
	e1 = document.getElementById("overlay");
	document.getElementById("hidden_overlay_master").value=MasterId;
	document.getElementById("hidden_overlay").value=RecordId;
	e1.style.visibility = (e1.style.visibility == "visible") ? "hidden" : "visible";	
}
</script>
<script type="text/javascript">
function addElement() {
	var ni = document.getElementById('myDiv1');
  var numi = document.getElementById('h_hidden');
  var num = (document.getElementById('h_hidden').value -1)+ 2;
  numi.value = num;
  var newdiv = document.createElement('div');
  var divIdName = 'my'+num+'Div1';
  var myDivName='myDiv1';
  newdiv.setAttribute('id',divIdName);
  if(num%2!==0)
		tableColor="#f8f1ef";
	else
		tableColor="#eedfdc";
	var myTable = "<table align='center' width='100%' cellpadding='1' cellspacing='1' class='border' border='0'>";
	myTable +="<input type='hidden' name='plant_transaction_id[]' id='plant_transaction_id[]' value=''/>";
	myTable +="<tr class='text_tr' bgcolor="+tableColor+"><td align='center' style='font-weight:bold;'>SNo.</td><td align='center' style='font-weight:bold;'>Pump Name</td><td align='center'></td></tr>";
	myTable += "<tr class='text_tr' bgcolor="+tableColor+">";
	myTable += "<td align='center'><input name='sno[]' type='text'  value="+(num)+" readonly='readonly' style='height:20px;width:50px;' /></td>";
	myTable += "<td align='center'><input type='text' name='pump_name[]' id='pump_name[]' style='height:20px;'/></td>";
	myTable += "<td class='delete' align='center'><a href=\"javascript:;\" onclick=\"removeElement(\'"+divIdName+"\'\,'"+myDivName+"\')\"><img src='images/delete_icon.jpg' border='0'/></a></td>";                                       
	myTable += "</tr></table>";
	newdiv.innerHTML=myTable;
	ni.appendChild(newdiv);
}
function removeElement(divNum,myDiv) 
{
	var d = document.getElementById(myDiv);
	var olddiv = document.getElementById(divNum);
	d.removeChild(olddiv);
}
</script>
<?
$Page = "elec_add_plant.php";
$PageTitle = "Add Plant";
$PageFor = "Plant";
$PageKey = "plant_id";
$PageKeyValue = "";
$Message = "";
$plant_id = '';
$name = '';
$pump_name = '';

$mode = "";
if(isset($_GET["mode"]))
{
	$mode = $_GET["mode"];
	$sql_idate="select * from elec_plant_master where insert_date='".date('Y-m-d')."' and $PageKey='".$_GET[$PageKey]."'";
	$res_idate=mysql_query($sql_idate);
	if(mysql_num_rows($res_idate)==0 && !($SessionUserType=='Administrator'))
	{
		echo "<script>alert('You Cant Update Here');location.href='elec_setting.php';</script>";
	}
}
if(isset($_POST["btn_delete"]))
{
	
	$PageKeyValueTrans  = $_POST["hidden_overlay"];
	if($PageKeyValueTrans!="")
	{
		$PageKeyValue = $_POST["hidden_overlay_master"];
		$sql = "delete from elec_plant_transaction where plant_transaction_id = '".$PageKeyValueTrans."'";
		mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
		$Message = "Record Sucessfully Deleted";
		$UrlPage=$Page."?".$PageKey."=".$PageKeyValue."&mode=edit";
		redirect("$UrlPage");//redirect("$Page?Message=$Message");
	}
	else
	{
		$PageKeyValue = $_POST["hidden_overlay_master"];
		$sql = "delete from elec_plant_master where plant_id = '".$PageKeyValue."'";
		mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
		$Message = "Record Sucessfully Deleted";
		$UrlPage=$Page."?Message=".$Message;
		redirect("$UrlPage");//redirect("$Page?Message=$Message");
	}
}
if(isset($_POST["btn_submit"]))
{
	$PageKeyValue = $_POST[$PageKey];
	$name = $_POST['name'];
	if($PageKeyValue == "")
	{
		$tableName="elec_plant_master";
		$tableData=array("''","'$name'","now()");
		addDataIntoTable($tableName,$tableData);
		echo $insert_id = mysql_insert_id();
		print_r($tableData);
		for($i=0; $i<sizeof($_POST['sno']); $i++)
		{
			$plant_transaction_id=$_POST['plant_transaction_id'][$i];
			$pump_name=$_POST['pump_name'][$i];
			if($pump_name!="")
			{
				$tableName="elec_plant_transaction";
				$tableData=array("''","'$insert_id'","'$pump_name'","now()");
				//print_r($tableData);
				addDataIntoTable($tableName,$tableData);
				$Message = "$PageFor Inserted";
			}
		}
		redirect("$Page?Message=$Message");
	}	
	else
	{
		if($mode == "edit")
		{
			$tableName="elec_plant_master";
			$tableColumns=array("plant_id","name");
			$tableData=array("'$PageKeyValue'","'$name'");
			updateDataIntoTable($tableName,$tableColumns,$tableData);
			//echo sizeof($_POST['sno']);
			for($i=0; $i<sizeof($_POST['sno']); $i++)
			{
				echo $plant_transaction_id=$_POST['plant_transaction_id'][$i];
				$pump_name=$_POST['pump_name'][$i];
				if($pump_name!="")
				{
					if($plant_transaction_id!="")
					{
						$tableName="elec_plant_transaction";
						$tableColumns=array("plant_transaction_id","plant_id","name");
						$tableData=array("'$plant_transaction_id'","'$PageKeyValue'","'$pump_name'");
						print_r($tableData);
						updateDataIntoTable($tableName,$tableColumns,$tableData);
					} 
					else
					{
						$tableName="elec_plant_transaction";
						$tableData=array("''","'$PageKeyValue'","'$pump_name'","now()");
						//print_r($tableData);
						addDataIntoTable($tableName,$tableData);
					}
					$Message = "$PageFor Updated";
				}
			}	
			$Message = "$PageFor Updated";
			redirect("$Page?Message=$Message");
		}
	}
}
if(isset($_GET[$PageKey]))
{
	$sql = "select * from elec_plant_master where $PageKey = '".$_GET[$PageKey]."'";
	$result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row = mysql_fetch_array($result);
		$PageKeyValue = $row[$PageKey];
		$name = $row["name"];				
	}
}

?>
<?
if(isset($_GET["Message"]))
{
	$Message = $_GET["Message"];
}
if(isset($_GET["plant_id"]))
{
	$plant_id = $_GET["plant_id"];
}
else
{
	$sql="select max(plant_id) as plant_id from elec_plant_master";
	$res=mysql_query($sql);
	$row=mysql_fetch_array($res);
	$plant_id=($row['plant_id']+1);
}

?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
  <tr>
    <td align="left" valign="top" width="230px" style="padding-top:5px;">
    	<? include ("inc/elec_setting_snb.php"); ?>
    </td>
    <td style="padding-left:5px; padding-top:5px;"  valign="top">
      <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
        <tr>
        	<td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; Welcome to Laxyo</td>
        </tr>
        <tr>
          <td valign="top" style="padding-top:10px;">
            <table align="center" width="50%" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td class="red"><?=$Message?></td>
              </tr>
              <tr>
                <td valign="top" style="padding-bottom:5px;" bgcolor="#EAE3E1">
                  <form name="frm_add" id="frm_add" method="post">
                    <table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border text_1">
                      <tr>
                      	<td align="left"><b>Plant No.</b></td>
                        <td align="left">
                        	<input type="text" name="plant_id" id="plant_id" readonly="readonly" value="<?=$plant_id?>" />
                        </td>
                      </tr>       
                      <tr>
                        <td align="left"><b>Plant Name</b></td>
                        <td align="left">
                        	<input type="text" name="name" id="name" value="<?=$name?>" />
                        </td>
                      </tr>
                      <tr>
                        <td colspan="3">
                        <div id="myDataBaseDiv">
                        <?
                        $sql_form_trans="SELECT * FROM elec_plant_master mim, elec_plant_transaction mit WHERE mim.plant_id = mit.plant_id AND mit.plant_id ='".$PageKeyValue."'";
                        $res_form_trans=mysql_query($sql_form_trans) or die(mysql_error());
                        $countTrans=1;
                        $rc_trans=mysql_num_rows($res_form_trans);
                        if($rc_trans>0)
                        {
                        while($row_i_t=mysql_fetch_array($res_form_trans))
                        {
													if($countTrans%2==0)
														$tableColor="#eedfdc";
													else
														$tableColor="#f8f1ef";
                        ?>
                        <div id="myDiv_<?=$countTrans?>">
                        <table width="100%" border="0" cellspacing="1" cellpadding="1" class="border">
                          <tr bgcolor="#eedfdc" class="text_tr">
                            <td align="center" style="font-weight:bold;">SNo.</td>
                            <td align="center" style="font-weight:bold;">Pump Name</td>
                            <td align="center"></td>
                          </tr>
                          <tr class="text_tr" bgcolor="<?=$tableColor?>">
                            <input type="	hidden" name="plant_transaction_id[]" id="plant_transaction_id[]" value="<?= $row_i_t['plant_transaction_id']?>"/>
                            <td align="center">
                              <input type="text" name="sno[]" id="sno[]" readonly="readonly" value="<?= $countTrans?>" style="height:20px; width:50px;"/>
                            </td>
                            <td align="center">
                              <input type="text" name="pump_name[]" id="pump_name[]" value="<?= $row_i_t['name']?>" style="height:20px;"/>
                            </td>
                            <td class='delete'>
                              <a href="javascript:;" onClick="overlay(<?= $PageKeyValue?>,<?= $row_i_t['plant_transaction_id'] ?>);">
                              <img src="images/delete_icon.jpg" border="0"/></a>
                            </td>
                          </tr>
                        </table>
                        </div>
                        <?			
                        $countTrans++; 													 
                        } // end of while
                        }// end if	
                        ?>
                        </div>
                        <table width="100%" border="0" cellspacing="1" cellpadding="1" class="border">
                          <input type="hidden" name="plant_transaction_id[]" id="plant_transaction_id[]" value=""/>
                          <tr class="text_tr" bgcolor="#f0e6e4"> 
                            <td align="center" style="font-weight:bold;">SNo.</td>
                            <td align="center" style="font-weight:bold;">Pump Name</td>
                            <td align="center"></td>
                          </tr>
                          <tr class="text_tr" bgcolor="#f0e6e4">
                            <td align="center">
                              <input type="text" name="sno[]" id="sno[]" readonly="readonly" value="<?=$countTrans ?>" style="height:20px;width:50px;"/>
                            </td>
                            <td align="center">
                              <input type="text" name="pump_name[]" id="pump_name[]" style="height:20px;" />
                            </td>
                            <td class="AddMore" align="center">
                              <input type="hidden" name="h_hidden" id="h_hidden" value="<?= $countTrans ?>"/> 
                              <a href="javascript:;" onClick="addElement();" title="Add More Rows">
                              <img src="images/add_icon.jpg" alt="Add" border="0" align="absmiddle"/></a>
                            </td>
                          </tr>
                          <tr>
                            <td colspan="3" align="center">
                            	<div id="myDiv1"></div>
                            </td>
                          </tr>
                        </table>
                        </td>
                      </tr>
                      <tr>
                        <td align="center" bgcolor="#EAE3E1" colspan="3">
                          <input type="hidden" id="mode" name="mode" value="<?=$mode?>"/>
                          <input type="hidden" id="<?=$PageKey?>" name="<?=$PageKey?>" value="<?=$PageKeyValue?>" />
                          <input type="submit" id="btn_submit" name="btn_submit" value="Save" class="btn_bg" />
                        </td>
                      </tr>
                    </table>
                  </form>
                  <div id="div_category_list"  style="overflow:auto;height:400px;width:850px;margin-top:20px;">
                    <table align="left" width="100%" border="1" class="table1 text_1">
                      <tr>
                        <td class="gredBg">S.No.</td>
                        <td class="gredBg">Plant Name</td>
                        <td class="gredBg">Details</td>
                        <td class="gredBg">Edit</td>
                        <td class="gredBg">Delete</td>
                      </tr>
											<?
                      $sql = "select * from  elec_plant_master order by name";
                      $result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
                      if(mysql_num_rows($result)>0)
                      {
												$sno=1;
												while($row = mysql_fetch_array($result)) 
												{ 
												$sql_idate="select * from elec_plant_master where insert_date='".date('Y-m-d')."' and plant_id='".$row['plant_id']."'";
												$res_idate=mysql_query($sql_idate);
												$row_idate=mysql_fetch_array($res_idate);
												$insert_date=$row_idate['insert_date'];
												?>
												<tr bgcolor="#F2F7F9">
                          <td align="center"><?= $sno++;?></td>
                          <td align="left" style="padding-left:5px"><?=$row["name"]?></td>
                          <td align="center">
                            <a href="javascript:;" onClick="return hs.htmlExpand(this,{width:450})">
                            <img src="images/icon_detail.gif" alt="" border="0"/></a>
                            <div class="highslide-maincontent" style="">
                              <table align="center" width="100%" cellpadding="1" cellspacing="1" border="0">
                                <tr class="gredBg">
                                  <td class="gredBg">SNo.</td>
                                  <td class="gredBg">Pump Name</td>
                                </tr>	
                                <?
                                  $sql_trans="select * from elec_plant_transaction where plant_id = '".$row['plant_id']."' ";
                                  $result_trans=mysql_query($sql_trans) or die(mysql_error());
                                  if($rn_trans=mysql_num_rows($result_trans))
                                  {
                                  	$sno_sup=1;
                                  	while($row_trans=mysql_fetch_array($result_trans))
                                    {
																		 ?>
																		 <tr class="text_1">
																			<td align="center"><?= $sno_sup++?></td>
																			<td align="left" style="padding-left:5px"><?=$row_trans['name']?></td>
																		 </tr>
																		<?
																		}	
																	}
                                	?>  
                             </table>
                            </div>
                         </td>
                         <?
													if($SessionUserType=='Administrator' || (date('Y-m-d')==$insert_date))
													{
													?>
														<td align="center">
															<a href="elec_add_plant.php?plant_id=<?=$row['plant_id']?>&mode=edit"title="Edit" >
																<img src="images/icon_edit.gif" alt="Edit" border="0" />
															</a>
														</td>
														<td align="center">
															<a href="javascript:;" onClick="overlay(<?=$row["plant_id"]?>,'');" title="Delete" >
																<img src="images/delete_icon.gif" alt="Delete"border="0">
															</a>
														</td>
													<?
													}
													else
													{
													?>
														<td align="center"></td><td align="center"></td>
													<?
													}
												 ?>
                    		</tr>
												<?												
                      	}
                      }
                      else
                      {
                      ?>
                    		<tr bgcolor="#f9f8f9">
                    			<td colspan="5" align="center">No Records Entered Yet.</td>
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
<div id="overlay">
	<div>
    <p class="form_msg">Are you sure to delete this Record</p>
		<form name="frm_del" action="<?=$_SERVER['PHP_SELF']?>" method="post">
          <input type="hidden" name="hidden_overlay_master" id="hidden_overlay_master" value="" />
          <input type="hidden" name="hidden_overlay" id="hidden_overlay" value="" />
          <input type="submit" class="submit" name="btn_delete" id="btn_delete" value="Yes" />
          <input type="button" class="submit" onClick="overlay();" name="btn_close" id="btn_close" value="No" />
		</form>
	</div>
</div>
<iframe width=168 height=190 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="calendar/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
</iframe>                                        
<? 
include("inc/hr_footer.php");
?>