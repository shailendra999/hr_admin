<? include ("inc/elec_header.php"); ?>
<?
$Page = "elec_add_max_demand.php";
$PageTitle = "Add Maximum Demand";
$PageFor = "Maximum Demand";
$PageKey = "HT_md_id";
$PageKeyValue = "";
$Message = "";
$mode = "";
$PageKeyValue = "";
$name = '';
if(isset($_GET["mode"]))
{
	$mode = $_GET["mode"];
	$sql_idate="select * from elec_HT_max_demand where insert_date='".date('Y-m-d')."' and $PageKey='".$_GET[$PageKey]."'";
	$res_idate=mysql_query($sql_idate);
	if(mysql_num_rows($res_idate)==0 && !($SessionUserType=='Administrator'))
	{
		echo "<script>alert('You Cant Update Here');location.href='elec_setting.php';</script>";
	}
}
if(isset($_POST["btn_submit"]))
{
	$PageKeyValue = $_POST[$PageKey];
	$demand = $_POST['demand'];
	if($mode == "edit")
	{					
		$tableName="elec_HT_max_demand";
		$tableColumns=array("HT_md_id","demand");
		$tableData=array("'$PageKeyValue'","'$demand'");
		//print_r($tableData);
		updateDataIntoTable($tableName,$tableColumns,$tableData);			
		$Message = "$PageFor Updated";
	}
	redirect("$Page?Message=$Message");
}
?>
<?
if(isset($_GET["Message"]))
{
	$Message = $_GET["Message"];
}
if(isset($_GET[$PageKey]))
{
	$sql = "select * from elec_HT_max_demand where $PageKey = '".$_GET[$PageKey]."'";
	$result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row = mysql_fetch_array($result);
		$PageKeyValue = $row[$PageKey];
		$demand = $row["demand"];
		$HT_md_id=$row[$PageKey];
	}
}
?>

<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
  <tr>
    <td align="left" valign="top" width="230px" style="padding-top:5px;">
    	<? include ("inc/elec_setting_snb.php"); ?>
    </td>        
    <td style="padding-left:5px; padding-top:5px;">
      <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
      <tr>
      <td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/>&nbsp; Welcome to Laxyo</td>
      </tr>
        <tr>
          <td valign="top" style="padding-top:5px; padding-left:40px;">
            <table width="1000" align="center" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td align="center" class="border">
                  <div align="center" style="min-height:470px;padding-bottom:15px; padding-top:15px;">
                  	<div id="div_message" style="color:#399;font-size:16px;font-weight:bold;padding:5 0 5 0"><?=$Message?></div>
                      <form id="frm_add" name="frm_add" method="post">
                        <table align="center" cellpadding="1" cellspacing="1" bgcolor="#EAE3E1" border="0" width="60%" class="text_1">
                          <tr>
                            <td align="left"><b>HT Demand Id</b></td>
                            <td align="left">
                            	<input type="text" id="HT_md_code" name="HT_md_code" value="<?= $HT_md_id ?>" />
                            </td>
                          </tr>
                          <tr>
                            <td align="left"><b>Demand</b></td>
                            <td align="left">
                            	<input type="text" id="demand" name="demand" value="<?= $demand ?>" />
                          	</td>
                          </tr>
                          <tr>
                            <td colspan="2" align="center" height="25">
                              <input type="hidden" id="mode" name="mode" value="<?=$mode?>"/>
                              <input type="hidden" id="<?=$PageKey?>" name="<?=$PageKey?>" value="<?=$PageKeyValue?>" />
                              <input type="submit" id="btn_submit" name="btn_submit" value="Save" class="btn_bg" />
                            </td>
                          </tr>
                        </table>
                      </form>
                    <div id="div_category_list"  style="overflow:auto;height:400px;width:550px;margin-top:20px;">
                    <table align="left" width="100%" border="1" class="table1 text_1">
                      <tr>
                        <td class="gredBg">S.No.</td>
                        <td class="gredBg">Demand</td>
                        <td class="gredBg">Edit</td>
                      </tr>
                    <?
                    $sql = "select * from elec_HT_max_demand order by HT_md_id";
                    $result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
                    if(mysql_num_rows($result)>0)
                    {
                    	$sno=1;
											while($row = mysql_fetch_array($result)) 
											{ 
											$sql_idate="select * from elec_HT_max_demand where insert_date='".date('Y-m-d')."' and HT_md_id='".$row['HT_md_id']."'";
											$res_idate=mysql_query($sql_idate);
											$row_idate=mysql_fetch_array($res_idate);
											$insert_date=$row_idate['insert_date'];
											?>
											<tr>
												<td align="center"><?= $sno++;?></td>
												<td align="center"><?= $row['demand']?></td>
                        <?
												if($SessionUserType=='Administrator' || (date('Y-m-d')==$insert_date))
												{
												?>
													<td align="center">
														<a href="elec_add_max_demand.php?HT_md_id=<?=$row['HT_md_id']?>&mode=edit"title="Edit" >
															<img src="images/icon_edit.gif" alt="Edit" border="0" />
														</a>
													</td>
												<?
												}
												else
												{
												?>
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
                    <tr bgcolor="#f9f8f9">
                    <td colspan="3" align="center">No Records Entered Yet.</td>
                    </tr>
                    <? 
                    }
                    ?>
                    </table>
                    </div>
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
<? include ("inc/hr_footer.php"); ?>	