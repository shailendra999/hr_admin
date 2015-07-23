<?
include("inc/elec_header.php");
?>
<style>
.get_H_W_100
{
	width:100px;
}
</style>
<?
$Page = "elec_add_HPS.php";
$PageTitle = "Add HPS";
$PageFor = "HPS";
$PageKey = "HPS_id";
$PageKeyValue = "";
$Message = "";
$HPS_id = '';$reading = '';$power_failure ='';
$reading_date = '';

$mode = "";
if(isset($_GET["mode"]))
{
	$mode = $_GET["mode"];
	$sql_idate="select * from elec_HPS_master where insert_date='".date('Y-m-d')."' and $PageKey='".$_GET[$PageKey]."'";
	$res_idate=mysql_query($sql_idate);
	if(mysql_num_rows($res_idate)==0 && !($SessionUserType=='Administrator'))
	{
		echo "<script>alert('You Cant Update Here');location.href='elec_homepage.php';</script>";
	}
}
if(isset($_POST["btn_submit"]))
{
	$PageKeyValue = $_POST[$PageKey];
	$reading_date = getDateFormate($_POST['reading_date']);
	$power_failure = $_POST['power_failure'];
	if($PageKeyValue == "")
	{
		$tableName="elec_HPS_master";
		$tableData=array("''","'$reading_date'","'$power_failure'","now()");
		addDataIntoTable($tableName,$tableData);
		$insert_id = mysql_insert_id();
		//print_r($tableData);
		for($i=0; $i<sizeof($_POST['plant_trans_id']); $i++)
		{
			$plant_id=$_POST['plant_id'][$i];
			$plant_trans_id=$_POST['plant_trans_id'][$i];
			$reading=$_POST['reading'][$i];
			$tableName="elec_HPS_transaction";
			$tableData=array("''","'$insert_id'","'$plant_id'","'$plant_trans_id'","'$reading'","now()");
			//print_r($tableData);
			addDataIntoTable($tableName,$tableData);
			$Message = "$PageFor Inserted";
			//redirect("$Page?Message=$Message");
		}
	}	
	else
	{
		if($mode == "edit")
		{
			$tableName="elec_HPS_master";
			$tableColumns=array("HPS_id","reading_date","power_failure");
			$tableData=array("'$PageKeyValue'","'$reading_date'","'$power_failure'");
			updateDataIntoTable($tableName,$tableColumns,$tableData);
			//echo  'plant_TRANS_ID='.count($_POST['plant_trans_id']).',';
			//echo  'HPS_TRANS_ID='.sizeof($_POST['HPS_trans_id']);
			for($i=0; $i<sizeof($_POST['plant_trans_id']); $i++)
			{
				$HPS_transaction_id=$_POST['HPS_trans_id'][$i];
				$plant_id=$_POST['plant_id'][$i];
				$plant_trans_id=$_POST['plant_trans_id'][$i];
				$reading=$_POST['reading'][$i];
				$tableName="elec_HPS_transaction";
				$tableColumns=array("HPS_transaction_id","HPS_id","plant_id","plant_transaction_id","reading");
				//print_r($tableData);
				$tableData=array("'$HPS_transaction_id'","'$PageKeyValue'","'$plant_id'","'$plant_trans_id'","'$reading'");
				//print_r($tableData);
				updateDataIntoTable($tableName,$tableColumns,$tableData);
			}	
			$Message = "$PageFor Updated";
			redirect("elec_list_HPS.php?Message=$Message");
		}
	}
}
if(isset($_GET[$PageKey]))
{
	$sql = "select * from elec_HPS_master where $PageKey = '".$_GET[$PageKey]."'";
	$result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row = mysql_fetch_array($result);
		$PageKeyValue = $row[$PageKey];
		$reading_date = getDateFormate($row["reading_date"]);				
	}
}

?>
<?
if(isset($_GET["Message"]))
{
	$Message = $_GET["Message"];
}
if(isset($_GET["HPS_id"]))
{
	$HPS_id = $_GET["HPS_id"];
}
else
{
	$sql="select max(HPS_id) as HPS_id from elec_HPS_master";
	$res=mysql_query($sql);
	$row=mysql_fetch_array($res);
	$HPS_id=($row['HPS_id']+1);
}

?>

<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
  <tr>
    <td align="left" valign="top" width="230px" style="padding-top:5px;">
    	<? include ("inc/elec_snb.php"); ?>
    </td>
    <td style="padding-left:5px; padding-top:5px;"  valign="top">
      <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
        <tr>
        	<td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; Add Humidification Pump Status</td>
        </tr>
        <tr>
          <td valign="top" style="padding-top:10px;">
            <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td class="red"><?=$Message?></td>
              </tr>
              <tr>
                <td valign="top" style="padding-bottom:5px;" bgcolor="#EAE3E1">
                  <form name="frm_add" id="frm_add" method="post">
                    <table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border text_1">
                      <tr>
                      	<td align="left"><b>HDS No.</b></td>
                        <td align="left">
                        	<input type="text" name="HPS_id" id="HPS_id" readonly="readonly" value="<?= $HPS_id?>" />
                        </td>
                        <td align="left"><b>HDS Reading Date</b></td>
                        <td align="left">
                        	<input type="text" name="reading_date" id="reading_date" readonly="readonly" value="<?=$reading_date?>" />
                          <a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.frm_add.reading_date);return false;" HIDEFOCUS>
                            <img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
                          </a> 
                        </td>
                      </tr>
                      <tr>
                      	<td align="left"><b>Power Failure</b></td>
                        <td align="left" colspan="3">
                        	<input type="text" name="power_failure" id="power_failure" value="<?= $power_failure?>" />
                        </td>  
                      </tr>    
                      <tr>
                        <td colspan="4" align="center">
												<?
                          if($mode!='edit')
                          {
													?>
                           <table width="100%" cellpadding="2" cellspacing="2" align="center" border="1" class="tabel text_1">
                            <tr>
                              <td class="gredBg"><b>Plant Name</b></td>
                              <td class="gredBg"><b>Pump Name</b></td>
                              <td class="gredBg"><b>Reading</b></td>
                            </tr>
                            <?
                            $sql_pl="select * from elec_plant_master";
                            $res_pl=mysql_query($sql_pl);
                            if(mysql_num_rows($res_pl)>0)
                            {
                              $countSno=1;
                              while($row_pl=mysql_fetch_array($res_pl))
                              {
                              ?>
                              <tr>
                                <td align="left" valign="top" style="padding-left:5px"><b><?= $row_pl['name']?></b></td>
                                <td align="center">
                                  <table border="0" cellpadding="2" cellspacing="0" class="border text_1">
                                    <?
                                    $sql_pt="select * from elec_plant_transaction where plant_id='".$row_pl['plant_id']."'";
                                    $res_pt=mysql_query($sql_pt);
                                    while($row_pt=mysql_fetch_array($res_pt))
                                    {
                                    ?>
                                    <input type="hidden" name="plant_id[]" id="plant_id[]" value="<?= $row_pl['plant_id']?>" />
                                    <input type="hidden" name="plant_trans_id[]" id="plant_trans_id[]" value="<?= $row_pt['plant_transaction_id']?>" />
                                      <tr>
                                        <td align="left"><?= $row_pt['name']?></td>
                                      </tr>
                                    <?
                                    }
                                    ?>
                                  </table>
                                </td>
                                <td align="center">
                                  <table border="0" cellpadding="2" cellspacing="0" class="border text_1">
                                  <?
                                    $sql_pt='';
                                    $sql_pt="select * from elec_plant_transaction where plant_id='".$row_pl['plant_id']."'";
                                    $res_pt=mysql_query($sql_pt);
                                    while($row_pt=mysql_fetch_array($res_pt))
                                    {
                                      //$reading=$row_pt['reading'];
                                      ?>
                                      <tr>
                                        <td align="left">
                                          <input type="text" name="reading[]" id="reading[]" class="get_W_18_100"/>
                                        </td>
                                      </tr>
                                      <?
                                    }
                                    ?>
                                  </table>
                                </td>
                              </tr>
                              <?
                                $countSno++;
                              }
                            }
                            ?>
                          </table>
													<?
                          }
                          else
                          {
                          ?>
                        	<table width="100%" cellpadding="2" cellspacing="2" align="center" border="1" class="tabel text_1">
                          	<tr>
                            	<td class="gredBg"><b>Plant Name</b></td>
                              <td class="gredBg"><b>Pump Name</b></td>
                              <td class="gredBg"><b>Reading</b></td>
                            </tr>
                            <?
														$sql_tr="select * from elec_HPS_master em,elec_HPS_transaction et where em.HPS_id=et.HPS_id and et.HPS_id='".$PageKeyValue."'";
														$res_tr=mysql_query($sql_tr);
														while($row_tr=mysql_fetch_array($res_tr))
														{
															//echo mysql_num_rows($res_pl);
															$HPS_trans_id=$row_tr['HPS_transaction_id'];
														?>
                            <input type="hidden" name="HPS_trans_id[]" id="HPS_trans_id[]" value="<?=$HPS_trans_id?>"/>
                            <input type="hidden" name="plant_id[]" id="plant_id[]" value="<?= $row_tr['plant_id']?>" />
                            <input type="hidden" name="plant_trans_id[]" id="plant_trans_id[]" value="<?= $row_tr['plant_transaction_id']?>" />
                          		<tr>
                                <td align="left" style="padding-left:5px">
                                	<?
																	$sql_p="select pl.name as plname from elec_plant_master pl,elec_HPS_transaction et where pl.plant_id=et.plant_id and et.plant_id='".$row_tr['plant_id']."'";
																	$res_p=mysql_query($sql_p);
																	if(mysql_num_rows($res_p))
																	{
																		$row_p=mysql_fetch_array($res_p);
																		echo '<b>'.$row_p['plname'].'</b>';
																	}
																	?>
                                </td>
                                <td align="left" style="padding-left:5px">
                                	<?
																		$sql_pu="select pu.name as puname from elec_plant_transaction pu,elec_HPS_transaction et  where pu.plant_transaction_id=et.plant_transaction_id and et.plant_transaction_id='".$row_tr['plant_transaction_id']."'";
																		$res_pu=mysql_query($sql_pu);
																		if(mysql_num_rows($res_pu))
																		{
																			$row_pu=mysql_fetch_array($res_pu);
																			echo '<b>'.$row_pu['puname'].'</b>';
																		}
																	?>
                                </td>
                                <td align="left" style="padding-left:5px">
                                 <input type="text" name="reading[]" id="reading[]" class="get_W_18_100" value="<?= $row_tr['reading']?>"/>
                                </td>
															</tr>
														<?
                            }
														?>
                          </table>
                          <?
													}
													?>
                        </td>
                      </tr>
                      <tr>
                        <td align="center" bgcolor="#EAE3E1" colspan="4">
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
<iframe width=168 height=190 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="calendar/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
</iframe>                                        
<? 
include("inc/hr_footer.php");
?>