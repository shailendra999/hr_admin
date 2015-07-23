<? include ("inc/store_header.php"); ?>
<script type="text/javascript">
function overlay(RecordId) 
{
	e1 = document.getElementById("overlay");
	document.getElementById("hidden_overlay").value=RecordId;
	e1.style.visibility = (e1.style.visibility == "visible") ? "hidden" : "visible";	
}
</script>
<script type="text/javascript">
function toggle_display_decimal_places() 
{
	var dec_req=document.getElementById("dec_req").value;
	if(dec_req=='Y')
		document.getElementById("tr_dec_places").style.display="block";
	else
		document.getElementById("tr_dec_places").style.display="none";
	
}
</script>
<?
$Page = "store_add_uom.php";
$PageTitle = "Add UOM";
$PageFor = "Unit Of Measurement";
$PageKey = "uom_id";
$PageKeyValue = "";
$Message = "";
$mode = "";
if(isset($_GET["mode"]))
{
	$mode = $_GET["mode"];
	$sql_idate="select * from ms_uom where insert_date='".date('Y-m-d')."' and uom_id='".$_GET[$PageKey]."'";
	$res_idate=mysql_query($sql_idate);
	if(mysql_num_rows($res_idate)==0 && !($SessionUserType=='Administrator'))
	{
		echo "<script>alert('You Cant Update Here');location.href='store_setting.php';</script>";
	}
}
if(isset($_POST["btn_submit"]))
{
	$PageKeyValue = $_POST[$PageKey];
	$uom_name = $_POST['uom_name'];
	$dec_req = $_POST['dec_req'];
	if($dec_req == "0" || $dec_req == "N")
	{
		$dec_req = "N";
		$dec_places=0;
	}
	else if($dec_req == "Y")
		$dec_places = $_POST['dec_places'];
	if($PageKeyValue == "")
	{
		$tableName="ms_uom";
		$tableData=array("''","'$uom_name'","'$dec_req'","'$dec_places'","now()");
		//print_r($tableData);
		addDataIntoTable($tableName,$tableData);
		$Message = "$PageFor Inserted";
	}	
	else
	{
		if(isset($_GET["mode"]))
		{					
			$tableName="ms_uom";
			$tableColumns=array("uom_id","name","decimal_required","decimal_places");
			$tableData=array("'$PageKeyValue'","'$uom_name'","'$dec_req'","'$dec_places'");print_r($tableData);
			updateDataIntoTable($tableName,$tableColumns,$tableData);
			
			$Message = "$PageFor Updated";
		}
		
	}
	redirect("$Page?Message=$Message");
}
?>
<?

if(isset($_GET["Message"]))
{
	$Message = $_GET["Message"];
}
if(isset($_POST["btn_delete"]))
{
	$PageKeyValue  = $_POST["hidden_overlay"];
	$sql = "delete from ms_uom where $PageKey = '".$PageKeyValue."'";
	mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	$Message = "UOM Sucessfully Deleted";
	redirect("$Page?Message=$Message");
}
$uom_name = '';
$dec_req = '';
$dec_places = '';	
if(isset($_GET[$PageKey]))
{
	$sql = "select * from ms_uom where $PageKey = '".$_GET[$PageKey]."'";
	$result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row = mysql_fetch_array($result);
		$PageKeyValue = $row[$PageKey];
		$uom_name = $row["name"];$uom_id = $row["uom_id"];
		$dec_req = $row["decimal_required"];
		$dec_places = $row["decimal_places"];		
	}
}
else
{
	$sql_code="select max(uom_id) as uom_id from ms_uom";
	$res_code=mysql_query($sql_code);
	$row_code=mysql_fetch_array($res_code);
	$uom_id=($row_code['uom_id']+1);
}
?>

<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
  <tr>
    <td align="left" valign="top" width="230px" style="padding-top:5px;">
    	<? include ("inc/store_setting_snb.php"); ?>
    </td>        
    <td style="padding-left:5px; padding-top:5px;">
      <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
        <tr>
          <td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/>&nbsp; Welcome to Laxyo</td>
        </tr>
        <tr>
          <td valign="top" style="padding-top:5px; padding-left:40px;">
            <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td align="center" class="border">
                  <div id="div_message" style="color:#399;font-size:16px;font-weight:bold;padding:5 0 5 0"><?=$Message?></div>
                  <form id="frm_add" name="frm_add" method="post">
                    <table bgcolor="#EAE3E1" align="center" cellpadding="1" cellspacing="1" border="0" width="60%" class="text_1">
                      <tr>
                        <td align="left"><b>UOM Id</b></td>
                        <td align="left" >
                          <input type="text" id="uom_id" name="uom_id" value="<?= $uom_id ?>" />
                        </td>
                      </tr>
                      <tr>
                        <td align="left"><b>Name</b></td>
                        <td align="left" >
                          <input type="text" id="uom_name" name="uom_name" value="<?= $uom_name ?>" />
                        </td>
                      </tr>
                      <tr>
                        <td align="left"><b>Decimal Required</b></td>
                        <td align="left" >
                          <select id="dec_req" name="dec_req" style="width:70px" onChange="toggle_display_decimal_places();">
                            <option value="N" <? if($dec_req=='N') {?> selected="selected"<? }?>>No</option>
                            <option value="Y" <? if($dec_req=='Y') {?> selected="selected"<? }?>>Yes</option>															
                        </select>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="2">
                        <?
                        if($dec_req=='Y')
                        {
                        ?>
                        <div id="tr_dec_places" style="display:block">
                          <table border="0" cellpadding="0" cellspacing="0" width="100%" class="text_1">
                            <tr>
                              <td align="left"><b>Decimal Places</b></td>
                              <td align="left">
                                <input type="text" id="dec_places" name="dec_places" value="<?= $dec_places?>" />
                              </td>
                            </tr>
                          </table>
                        </div>
                        <?
                        }
                        else
                        {
                        ?>  
                          <div id="tr_dec_places" style="display:none">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" class="text_1">
                              <tr>
                                <td align="left"><b>Decimal Places</b></td>
                                <td align="left">
                                  <input type="text" id="dec_places" name="dec_places" value=""/>
                                </td>
                              </tr>
                            </table>
                          </div>
                        <?
                        }
                        ?>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="2" align="center">
                          <input type="hidden" id="mode" name="mode" value="<?=$mode?>"/>
                          <input type="hidden" id="<?=$PageKey?>" name="<?=$PageKey?>" value="<?=$PageKeyValue?>" />
                          <input type="submit" id="btn_submit" name="btn_submit" value="Save" class="btn_bg" />
                        </td>
                      </tr>
                    </table>
                  </form>
                  <div id="div_category_list"  style="overflow:auto;height:400px;width:750px;margin-top:20px;">
                    <table align="center" width="100%"class="table1 text_1" cellpadding="2" cellspacing="1" border="1">
                      <tr>
                        <td class="gredBg">S.No.</td>
                        <td class="gredBg">UOM Id</td>
                        <td class="gredBg">Name</td>
                        <td class="gredBg">Decimal Required</td>
                        <td class="gredBg">Decimal Places</td>
                        <td class="gredBg">Edit</td>
                        <td class="gredBg">Delete</td>
                      </tr>
                      <?
                      $sql = "select * from  ms_uom order by name";
                      $result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
                      if(mysql_num_rows($result)>0)
                      {
                      $num = mysql_num_rows($result) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
                      $sno=1;
                        while($row = mysql_fetch_array($result)) 
                        { 
                        $sql_idate="select * from ms_uom where insert_date='".date('Y-m-d')."' and uom_id='".$row['uom_id']."'";
                        $res_idate=mysql_query($sql_idate);
                        $row_idate=mysql_fetch_array($res_idate);
                        $insert_date=$row_idate['insert_date'];
                        ?>
                          <tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? }?>>
                            <td align="center"><?= $sno++;?></td>
                            <td align="center"><?=$row["uom_id"]?></td>
                            <td align="center"><?=$row["name"]?></td>
                            <td align="center"><?=$row["decimal_required"]?></td>
                            <td align="center"><?=$row["decimal_places"]?></td>
                            <?
                            if($SessionUserType=='Administrator' || (date('Y-m-d')==$insert_date))
                            {
                            ?>
                            <td align="center">
                              <a href="store_add_uom.php?uom_id=<?=$row['uom_id']?>&mode=edit">
                                <img src="images/icon_edit.gif" alt="Edit" title="Edit" border="0" />
                              </a>
                            </td>
                            <td align="center">
                              <a href="javascript:;" onClick="overlay(<?=$row['uom_id']?>);">
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
                        }
                      }
                      else
                      {
                      ?>
                        <tr>
                          <td colspan="7" align="center">No Records Entered Yet.</td>
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
        <p class="form_msg">Are you sure to delete this UOM</p>
		<form name="frm_del" action="<?=$_SERVER['PHP_SELF']?>" method="post">
            <input type="hidden" name="hidden_overlay" id="hidden_overlay" value="" />
            <input type="submit" class="submit" name="btn_delete" id="btn_delete" value="Yes" />
            <input type="button" class="submit" onClick="overlay();" name="btn_close" id="btn_close" value="No" />
		</form>
	</div>
</div>
<? include ("inc/hr_footer.php"); ?>	