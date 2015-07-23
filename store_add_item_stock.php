<?
include("inc/store_header.php");
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
</script>
<?
$Page = "store_add_item_atock.php";
$PageTitle = "Add Item Stock";
$PageFor = "Item Stock";
$PageKey = "item_id";
$PageKeyValue = "";
$Message = "";
$item_id = '';$name = '';
$opening_stock = '';$opening_rate = '';$closing_stock = '';

if(isset($_POST["btn_submit"]))
{
	$PageKeyValue = $_POST[$PageKey];
	$item_id = $_POST["item_id1"];
	if($item_id=='')
	{
		echo "<script>alert('No Item Selected.');location.href='store_add_item_stock.php';</script>";
	}
	else
	{
		$sql="select opening_quantity,opening_rate,closing_stock from ms_item_master where item_id='".$item_id."'";
		$result=mysql_query($sql) or die("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
		//echo mysql_num_rows($result);
		if(mysql_num_rows($result)>0)
		{
			$row=mysql_fetch_array($result);
			$opening_stock = $_POST["opening_stock"];
			if($_POST["opening_rate"]=="")
				$opening_rate = $row["opening_rate"];
			else
				$opening_rate = $_POST["opening_rate"];
			$closing_stock = $_POST["closing_stock"];
			
				$tableName="ms_item_master";
				$tableColumns=array("item_id","opening_quantity","opening_rate","closing_stock");
				$tableData=array("'$item_id'","'$opening_stock'","'$opening_rate'","'$closing_stock'");
				////print_r($tableData);
				updateDataIntoTable($tableName,$tableColumns,$tableData);
			redirect("store_add_item_stock.php?Message=Stock Updated");/**/
		}
	}
}
?>
<?
//$item_id = "";
if(isset($_GET["Message"]))
{
	$Message = $_GET["Message"];
}

?>
<script type="text/javascript">
function showData()
{
	var status=true;
	var item_id=document.getElementById('item_id1').value;
	if(item_id=='')
	{
		alert('Item Not Selected.');
		status=false;
	}
	return status;
}
</script>
<script type="text/javascript">

function stopRKey(evt) {
  var evt = (evt) ? evt : ((event) ? event : null);
  var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
  if ((evt.keyCode == 13) && (node.type=="text"))  {return false;}
}

document.onkeypress = stopRKey;

</script> 
<?
$sql="select * from ms_item_master where opening_quantity!=0 OR opening_rate!=0 OR closing_stock!=0 order by name asc";
$result=mysql_query($sql) or die("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());


?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
	<tr>
		<td align="left" valign="top" width="230px" style="padding-top:5px;">
			<? include ("inc/store_snb.php"); ?>
		</td>
		<td style="padding-left:5px; padding-top:5px;" valign="top">
			<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
        <tr>
          <td align="center" class="gray_bg">
          	<img src="images/bullet.gif" width="15" height="22"/> &nbsp; Add/Edit Item
          Stock</td>
        </tr>
        <tr>
          <td valign="top" style="padding-top:10px;">
            <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td class="red"><?=$Message?></td>
              </tr>
              <tr>
                <td valign="top" style="padding-bottom:5px;" bgcolor="#EAE3E1" width="100%">
                 <form name="frm_add" id="frm_add" method="post" onsubmit="return (showData() && confirm('Are You Sure You Want To Update This Item'));">
                  <table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border text_1">
                    <tr>
                      <td align="left"><b>Name</b></td>
                      <td align="left" colspan="3">
                        <input type="text" name="item_name1" id="item_name1" onKeyUp="ajax_showOptions(this.value,'1','store_ajax_list_item.php',event,0)" onfocus="ajax_showOptions(this.value,'1','store_ajax_list_item.php',event,0)" autocomplete="off" class="itemText" value="" style="width:300px"/>
                        <div id="ajax_listOfOptions_1" class="ajax_listOfOptions"></div>
                        <input type="hidden" id="item_id1" name="item_id1" value="" />
                      </td>
                    </tr>
                    <tr>
                      <td align="left"><b>Opening Stock</b></td>
                      <td align="left">
                      <input type="text" id="opening_stock" name="opening_stock" value="<?=$opening_stock?>" autocomplete="off"/>
                      </td>
                      <td align="left"><b>Opening Rate</b></td>
                      <td align="left">
                        <input type="text" id="opening_rate" name="opening_rate" value="<?=$opening_rate?>" autocomplete="off"/>
                      </td>
                    </tr>
                    <tr>
                      <td align="left"><b>Closing Stock</b></td>
                      <td align="left" colspan="3">
                      <input type="text" id="closing_stock" name="closing_stock" value="<?=$closing_stock?>" autocomplete="off"/>
                      </td>
                    </tr>
                    <tr>
                      <td align="center" colspan="4">
                        <input type="hidden" id="mode" name="mode" value="<?=$mode?>"/>
                        <input type="hidden" id="<?=$PageKey?>" name="<?=$PageKey?>" value="<?=$PageKeyValue?>" />
                        <input type="submit" id="btn_submit" name="btn_submit" value="Save" class="btn_bg" />
                      </td>
                    </tr>
                  </table>
                  </form>
                  <div id="getItemsInDiv" style="margin:0 auto;width:100%;overflow:auto;height:800px">
                    <table align="center" width="100%" border="1" cellpadding="0" class="table1 text_1">
                      <tr>
                        <td class="gredBg" width="6%">S.No.</td>
                        <td class="gredBg" width="7%">Item Id</td>
                        <td class="gredBg" width="58%">Description</td>
                        <td class="gredBg" width="7%">Op.StkQty.</td>
                        <td class="gredBg" width="7%">C.StkQty.</td>
                        <td class="gredBg" width="7%">Unit Rate</td> 
                        <td class="gredBg" width="8%">Value</td>
                      </tr>
                      <?
											if(mysql_num_rows($result)>0)
											{
												$sno=1;
												while($row=mysql_fetch_array($result))
												{
												?>
                        	<tr class="text_tr">
                          	<td align="center"><?=$sno++?></td>
                            <td align="center"><?=$row['item_id']?></td>
                            <td align="left" style="padding-left:2px"><?=$row['name'].' Drg No.'.$row['drawing_number'].' Cat No.'.$row['catelog_number']?></td>
                            <td align="right" style="padding-right:1px"><?=$row['opening_quantity']?></td>
                            <td align="right" style="padding-right:1px"><?=$row['closing_stock']?></td>
                            <td align="right" style="padding-right:1px"><?=$row['opening_rate']?></td> 
                            <td align="right" style="padding-right:1px">
                            <?
                            	$value=$row['closing_stock']*$row['opening_rate'];
															echo number_format($value,2,'.','');
													  ?>
                            </td>
                          </tr>
                        <?
												}
											}
											else
											{
											?>
                      	<tr><td colspan="7" align="center"><b>No Records Found</b></td></tr>
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
<? 
include("inc/hr_footer.php");
?>