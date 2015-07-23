<?
include("inc/maint_header.php");
?>
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
function getMachinaryData() {
	var deptId = document.getElementById("department_id").value;
	document.getElementById("div_machinary").style.border="none";
	document.getElementById("div_machinary").style.padding="0";	
	get_frm("store_get_machinary.php",deptId,"div_machinary",'');
}
function validateItem(name,url,divID) {
	url+="?name="+name+"&sid="+Math.random();
	//var url=Page+"?order_id="+order_id+"&sid="+Math.random();
	//alert(url);
	var reg = getXMLHTTP();
	if (reg)
	{																					
			reg.onreadystatechange = function() {
					if (reg.readyState == 4) {
							if (reg.status == 200) 
							{                        
								if(reg.responseText!='')
								{
									alert("Item Already Exists.Change Item Name.");
									document.getElementById("btn_submit").disabled=true;
								}
								else
								{
									document.getElementById("btn_submit").disabled=false;
								}
								document.getElementById(divID).innerHTML=reg.responseText;
							}
							else 
									alert("There was a problem while using XMLHTTP:\n" + reg.statusText);
					}                
			}            
			reg.open("GET", url, true);
			reg.send(null);
	}
}
</script>
<?
$Page = "maint_add_item.php";
$PageTitle = "Add Item";
$PageFor = "Item";
$PageKey = "item_id";
$PageKeyValue = "";
$Message = "";
$item_id = '';$name = '';
$department_id = '';$machinary_id = '';$drawing_number = '';$catelog_number = '';
$uom_id = '';$location = '';$type_of_item = '';
$opening_quantity = '';$opening_rate = '';
$machinary_name = '';
$mode = "";
if(isset($_GET["mode"]))
{
	$mode = $_GET["mode"];
	$sql_idate="select * from ms_item_master where insert_date='".date('Y-m-d')."' and $PageKey='".$_GET[$PageKey]."'";
	$res_idate=mysql_query($sql_idate);
	if(mysql_num_rows($res_idate)==0 && !($SessionUserType=='Administrator'))
	{
		echo "<script>alert('You Cant Update Here');location.href='maint_homepage.php';</script>";
	}
}

if(isset($_POST["btn_submit"]))
{
	$PageKeyValue = $_POST[$PageKey];
	$name = $_POST['name'];
	$uom_id = $_POST['uom_id'];
	$department_id = $_POST['department_id'];
	$machinary_id = $_POST['machinary_id'];
	$drawing_number = $_POST['drawing_number'];
	$catelog_number = $_POST['catelog_number'];
	$location = $_POST['location'];
	$type_of_item = $_POST['type_of_item'];
	$opening_quantity = '';	$opening_rate = '';$closing_stock = '';
	
	if($PageKeyValue == "")
	{
		$tableName="ms_item_master";
		$tableData=array("''","'$name'","'$department_id'","'$machinary_id'","'$drawing_number'","'$catelog_number'","'$uom_id'","'$location'","'$opening_quantity'","'$opening_rate'","'$closing_stock'","'$type_of_item'","now()");
		//print_r($tableData);
		if(addDataIntoTable($tableName,$tableData))
			$Message = "$PageFor Inserted";
		else
			$Message = "Error In Inserting";
		redirect("$Page?Message=$Message");
	}	
	else
	{
		if($mode == "edit")
		{
			$tableName="ms_item_master";
			$tableColumns=array("item_id","name","department_id","machinary_id","drawing_number","catelog_number","uom_id","location","type_of_item");
			
			$tableData=array("'$PageKeyValue'","'$name'","'$department_id'","'$machinary_id'","'$drawing_number'","'$catelog_number'","'$uom_id'","'$location'","'$type_of_item'");
			//print_r($tableData);
			if(updateDataIntoTable($tableName,$tableColumns,$tableData))
				$Message = "$PageFor Updated";
			else
				$Message = "Error In Updating";
			redirect("maint_list_item.php");
		}
	}
}
?>
<?
$item_id = "";
if(isset($_GET["item_id"]))
{
	$item_id = $_GET["item_id"];
}
else
{
	$sql="select max(item_id) as item_id from ms_item_master";
	$res=mysql_query($sql);
	$row=mysql_fetch_array($res);
	$item_id=($row['item_id']+1);
}
if(isset($_GET["Message"]))
{
	$Message = $_GET["Message"];
}
if(isset($_GET[$PageKey]))
{
	$sql = "select * from ms_item_master where $PageKey = '".$_GET[$PageKey]."'";
	$result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row = mysql_fetch_array($result);
		$item_id= $row["item_id"];
		$PageKeyValue = $row[$PageKey];
		$name = $row["name"];
		$department_id = $row["department_id"];
		$machinary_id = $row["machinary_id"];
		$drawing_number = $row["drawing_number"];
		$catelog_number = $row["catelog_number"];
		$uom_id = $row["uom_id"];
		$location = $row["location"];	
		//$opening_quantity = $row["opening_quantity"];	
		//$opening_rate = $row["opening_rate"];
	}
}


?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
	<tr>
		<td align="left" valign="top" width="230px" style="padding-top:5px;">
			<? include ("inc/maint_snb.php"); ?>
		</td>
		<td style="padding-left:5px; padding-top:5px;" valign="top">
			<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
        <tr>
          <td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; Add/Edit Item</td>
        </tr>
        <tr>
          <td valign="top" style="padding-top:10px;">
            <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td class="red"><?=$Message?></td>
              </tr>
              <tr>
                <td valign="top" style="padding-bottom:5px;">
                  <form name="frm_add" id="frm_add" action="" method="post">
                  <table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                    <tr>
                      <td align="center" valign="top" class="border" width="100%" bgcolor="#EAE3E1">
                        <table align="center" width="100%" cellpadding="2" cellspacing="2" border="0" class="text_1">
                          <tr>
                            <td align="left"><b>Item Id</b></td>
                            <td align="left" colspan="3">
                              <input type="text" readonly="readonly" id="item_id" name="item_id" value="<?= $item_id ?>" />
                            </td>
                          </tr>
                          <tr>
                            <td align="left"><b>Name</b></td>
                            <td align="left">
                              <input type="text" id="name" name="name" value="<?= $name ?>" onkeyup="validateItem(this.value,'store_validate_item_name.php','divItemValidate')" />
                            </td>
                            <td colspan="2" align="left">
                            	<div id="divItemValidate" style="color:red;text-decoration:blink;font-size:14px"></div>
                            </td>
                          <tr>
                            <td align="left"><b>Location</b></td>
                            <td align="left">
                              <input type="text" id="location" name="location" value="<?= $location ?>" />
                            </td>
                            <td align="left"><b>UOM</b></td>
                            <td align="left">
														<?
                            $sql_UOM= "select * from ms_uom order by name";
                            $res_UOM = mysql_query ($sql_UOM) or die (mysql_error());
                            ?>
                            <select name="uom_id" id="uom_id" style="width:145px;">
                              <option value="0"></option>
                              <?
                              if(mysql_num_rows($res_UOM)>0)
                              {
																while($row_UOM = mysql_fetch_array($res_UOM))
																{
																?>
																	<option value="<?= $row_UOM['uom_id']?>" <? if($row_UOM['uom_id']==$uom_id){ ?> selected="selected"<? }?>><?= $row_UOM['name']?></option>
																<?
																}
                              }	
                              ?>
                              </select>
                          	</td>
                          </tr>
                          <tr>
                            <td align="left"><b>Department</b></td>
                            <td align="left">
                              <?
                              $sql_D= "select * from ms_department order by name asc";
                              $res_D = mysql_query ($sql_D) or die (mysql_error());
                              ?>
                              <select name="department_id" id="department_id" onChange="getMachinaryData()" style="width:145px;">
                                <option value="0"></option>
                                <?
                                if(mysql_num_rows($res_D)>0)
                                {
                                	while($row_D = mysql_fetch_array($res_D))
                                	{
																	?>
																	<option value="<?= $row_D['department_id']; ?>" <? if($row_D['department_id']==$department_id){ ?> selected="selected"<? }?>><?= $row_D['name']?></option>
																	<?
																	}
                                }	
                                ?>
                              </select></td>
                            <td align="left"><b>Machinary</b></td>
                            <td align="left">
                              <? 
                              if($mode == "edit")
                              {
																$sql_M="select * from ms_machinary where machinary_id='".$machinary_id."'";
																$res_M = mysql_query ($sql_M) or die (mysql_error());
																$row_M = mysql_fetch_array($res_M);
																if(mysql_num_rows($res_M)>0)
																	$machinary_name = $row_M['name'];
																else
																	$machinary_name = '';
																?>
																<input type="hidden" name="machinary_id" id="machinary_id" value="<?=$machinary_id?>" />
																<?
                              }		
                              ?>
                              <div id="div_machinary" class="getAjaxDataInDiv" style="height:20px;width:145px;"><?= $machinary_name ?></div>
                            </td>
                          </tr>
                          <tr>
                            <td align="left"><b>Drawing Number</b></td>
                            <td align="left">
                              <input type="text" id="drawing_number" name="drawing_number" value="<?= $drawing_number ?>" />
                            </td>
                            <td align="left"><b>Catelog Number</b></td>
                            <td align="left">
                              <input type="text" id="catelog_number" name="catelog_number" value="<?= $catelog_number ?>" />
                            </td>
                          </tr>
                          <tr>
                            <td align="left"><b>Store/Packing</b></td>
                            <td align="left" colspan="3">
                              <select id="type_of_item" name="type_of_item" style="width:150px">
                              	<option value="S" <? if($type_of_item=='S'){?> selected="selected" <? }?>>Store</option>
                                <option value="P" <? if($type_of_item=='P'){?> selected="selected" <? }?>>Packing</option>
                              </select>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                    <tr>
                      <td align="center">
                        <input type="hidden" id="mode" name="mode" value="<?=$mode?>"/>
                        <input type="hidden" id="<?=$PageKey?>" name="<?=$PageKey?>" value="<?=$PageKeyValue?>" />
                        <input type="submit" id="btn_submit" name="btn_submit" value="Save" class="btn_bg" />
                      </td>
                    </tr>
                  </table>
                  </form>
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