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
</script>
<?
$Page = "maint_view_item.php";
$PageTitle = "View Item";
$PageFor = "Item";
$PageKey = "item_id";
$PageKeyValue = "";
$Message = "";
$item_id = '';$name = '';
$department_id = '';$machinary_id = '';$drawing_number = '';$catelog_number = '';
$uom_id = '';$location = '';
$opening_quantity = '';$opening_rate = '';
$machinary_name = '';

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
		$opening_quantity = $row["opening_quantity"];	
		$opening_rate = $row["opening_rate"];
		$type_of_item = $row["type_of_item"];
		if($type_of_item=='S')
			$type_of_item='Store';
		else
			$type_of_item='Packing';
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
          <td align="center" class="gray_bg">
          	<img src="images/bullet.gif" width="15" height="22"/> &nbsp; View Item
          </td>
        </tr>
        <tr>
          <td valign="top" style="padding-top:10px;">
            <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td class="red"><?=$Message?></td>
              </tr>
              <tr>
                <td valign="top" style="padding-bottom:5px;" class="border" bgcolor="#EAE3E1">
                  <table align="center" width="100%" cellpadding="2" cellspacing="2" border="0" class="text_1">
                    <tr style="line-height:22px;background:#EAE3E1;">
                      <td align="left"><b>Item Id</b></td>
                      <td align="left" colspan="3"><?= $item_id ?></td>
                    </tr>
                    <tr style="line-height:22px;background:#FFFFFF;">
                      <td align="left"><b>Name</b></td>
                      <td align="left"><?= $name ?></td>
                      <td align="left"><b>UOM</b></td>
                      <td align="left">
                        <?
                        $sql_UOM= "select * from ms_uom where uom_id=$uom_id";
                        $res_UOM = mysql_query ($sql_UOM) or die (mysql_error());
                        if(mysql_num_rows($res_UOM)>0)
                        {
                          $row_UOM = mysql_fetch_array($res_UOM);
                          echo $row_UOM['name'];
                        }	
                        ?>
                      </td>
                    </tr>
                    <tr style="line-height:22px;background:#EAE3E1;">
                      <td align="left"><b>Department</b></td>
                      <td align="left">
                        <?
                        $sql_D= "select * from ms_department where department_id=$department_id";
                        $res_D = mysql_query ($sql_D) or die (mysql_error());
                        if(mysql_num_rows($res_D)>0)
                        {
                          $row_D = mysql_fetch_array($res_D);
                          echo $row_D['name'];
                        }	
                        ?>
                      </td>
                      <td align="left"><b>Machinary</b></td>
                      <td align="left">
                        <? 
                          $sql_M="select * from ms_machinary where machinary_id='".$machinary_id."'";
                          $res_M = mysql_query ($sql_M) or die (mysql_error());
                          if(mysql_num_rows($res_M)>0)
                          {
                            $row_M = mysql_fetch_array($res_M);
                            echo $row_M['name'];
                          }
                         ?>
                      </td>
                    </tr>
                    <tr style="line-height:22px;background:#FFFFFF;">
                      <td align="left"><b>Drawing Number</b></td>
                      <td align="left"><?= $drawing_number ?></td>
                      <td align="left"><b>Catelog Number</b></td>
                      <td align="left"><?= $catelog_number ?></td>
                    </tr>
                    <tr style="line-height:22px;background:#EAE3E1;">
                      <td align="left"><b>Opening Quantity</b></td>
                      <td align="left"><?= $opening_quantity ?></td>
                      <td align="left"><b>Opening Rate</b></td>
                      <td align="left"><?= $opening_rate ?></td>
                    </tr>
                    <tr style="line-height:22px;background:#FFFFFF;">
                      <td align="left"><b>Location</b></td>
                      <td align="left"><?= $location ?></td>
                      <td align="left"><b>Item Type</b></td>
                      <td align="left"><?= $type_of_item ?></td>
                    </tr>
                  </table>
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