<?
include("inc/adm0_header.php");
?>
<script type="text/javascript" src="ajax/common_function.js"></script>
<script>
function overlay(id) {
	el = document.getElementById("overlay");
	document.getElementById("hidden_overlay").value=id;
	el.style.visibility = (el.style.visibility == "visible") ? "hidden" : "visible";
	
}
</script>
<?
//////////////////////// ************************** INSERT / UPDATE COUNT ************************ /////////////////////////

$msg = '';
$StockId = '';
$ProductId = '';
$CountId = '';
$StockId = '';
$LotNumber = '';
$NumberOfBags = '';
$StockInKgs = '';
$StockInBale = '';
$Date = '';
if(!session_is_registered("no_refresh"))
{
	$_SESSION['no_refresh'] = "";
}
if(isset($_POST['btn_submit_x']))
{
	if($_POST['no_refresh'] == $_SESSION['no_refresh'])
	{	
		//echo "WARNING: Do not try to refresh the page.";
	}
	else
	{
		$CountId = $_POST['CountId'];

		$IpAddress = $_SERVER['REMOTE_ADDR'];
		
		$StockId = $_POST['StockId'];
		$LotNumber = $_POST['LotNumber'];
		$NumberOfBags = $_POST['NumberOfBags'];
		$StockInKgs = $_POST['StockInKgs'];
		//$StockInBale = $_POST['StockInBale'];
		$Date = getDateFormate($_POST['Date'],1);
		
		if($StockId == '')
		{
			
			
			$sql_ins = "insert into ".$mysql_adm_table_prefix."stock_master  set
																				CountId = '$CountId',
																				LotNumber = '$LotNumber',
																				NumberOfBags = '$NumberOfBags',
																				StockInKgs = '$StockInKgs',
																				StockInBale = '$StockInBale',
																				
																				Date = '$Date',
																				
																				InsertBy = '$SessionUserType',
																				InsertDate = now(),
																				IpAddress = '$IpAddress'";
			$result_ins = mysql_query($sql_ins) or die("Error in query:".$sql_ins."<br>".mysql_error().":".mysql_errno());
			
			$msg = "Stock Successfully Inserted";
			
			
		}
		else
		{
			$sql_up = "update ".$mysql_adm_table_prefix."stock_master  set
																			CountId = '$CountId',
																				LotNumber = '$LotNumber',
																				NumberOfBags = '$NumberOfBags',
																				StockInKgs = '$StockInKgs',
																				StockInBale = '$StockInBale',
																				Date = '$Date'
																			where rec_id = '$StockId'";
		   $result_up = mysql_query($sql_up) or die("Error in : ".$sql_up."<br>".mysql_errno()." : ".mysql_error());
		   
		   $msg = "Stock Successfully Updated";		
		}	
		$StockId = '';
		$ProductId = '';
		$CountId = '';
		$StockId = '';
		$LotNumber = '';
		$NumberOfBags = '';
		$StockInKgs = '';
		$StockInBale = '';
		$Date = '';
		$_SESSION['no_refresh'] = $_POST['no_refresh'];
		
	
	}
}
?>
<?
//////////// *************** Delete Product ************** ///////////////

if(isset($_POST["btn_del"]))
{
	$StockId  = $_POST["hidden_overlay"];
	$sql = "delete from ".$mysql_adm_table_prefix."stock_master where rec_id = '".$StockId."'";
	mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	$msg = "Stock Sucessfully Deleted";
	$StockId = "";
}	
?>
<?
//////////////****************** Select For Count Listing *****************//////////

if(isset($_GET['start']))
{
	if($_GET['start']=='All')
	{
		$start = 0;
	}
	else
	{
		$start = $_GET['start'];
	}
}
else
{
	$start = 0;
}				
?>
<?
	$sql_prj = "select * from ".$mysql_adm_table_prefix."stock_master order by Date";
	$query_count = "select count(*) as count from ".$mysql_adm_table_prefix."stock_master";
	$sql_prj = $sql_prj ." LIMIT " . $start . ", $row_limit";
	
	$result_prj = mysql_query($sql_prj) or die("Error in Query :".$sql_prj."<br>".mysql_error().":".mysql_errno());
	
	$query_count = $query_count;
	$result = mysql_query($query_count);
	$row_count = mysql_fetch_array($result);
	$numrows = $row_count['count'];
	$count = ceil($numrows/$row_limit);
	
	
?>
<?
/////////////////// ********************* Select For Count Edit *************** ///////////////

if(isset($_GET['StockId']))
{
	$StockId = $_GET['StockId'];
	$sql = "select * from ".$mysql_adm_table_prefix."stock_master where rec_id = '$StockId'";
	$result = mysql_query($sql) or die("Error in query:".$sql."<br>".mysql_error().":".mysql_errno());
	$row = mysql_fetch_array($result);
	$CountId = $row['CountId'];
	$LotNumber = $row['LotNumber'];
	$NumberOfBags = $row['NumberOfBags'];
	$StockInKgs = $row['StockInKgs'];
	$StockInBale = $row['StockInBale'];
	
	
	$ProductId = getCount("ProductId","rec_id", $CountId);
	$Date = getDateFormate ($row['Date'],1);
}
?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
  <tr>
    	<td align="left" valign="top" width="230px" style="padding-top:5px;">
			<? include ("inc/adm0_snb.php"); ?>
        </td>
        
        <td style="padding-left:5px; padding-top:5px;" valign="top">
        	<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
            	<tr>
                	<td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; Add Stock</td>
                </tr>
                
                <tr>
               	  <td valign="top">
                        <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                              <td style="padding-top:5px;" valign="top">
                                    <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
                                        <tr colspan="2">
                                        	<td class="red"><?=$msg?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" align="center" valign="top">
                                                <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0" style="border:1px solid #C6B4AE;" bgcolor="#EAE3E1">
                                                    <tr>
                                                        <td valign="middle" style="padding-top:10px;">
                                                            <form name="frm_addstock" id="frm_addstock" action="list_stock.php" method="post">
                                                            <table align="center" width="70%" cellpadding="1" cellspacing="1" border="0" class="border">
                                                                <tr class="text_1">
                                                                    <td align="left"><b>Product Name</b></td>
                                                                    <td align="left">
                                                                      <select name="sel_prd" id="sel_prd" style="width:180px; height:20px;" onChange="get_frm('get_count.php',this.value,'div_count','CountId');">
                                                                        <option value="">--Select--</option>
                                                                        <?
                                                                        $sql_product = "select * from ".$mysql_adm_table_prefix."product_master where IsCount = '1' order by ProductName";
                                                                        $result_product = mysql_query($sql_product) or die("Error in Query : ".$sql_product."<br/>".mysql_error()."<br/>".mysql_errno());
                                                                        if(mysql_num_rows($result_product)>0)
                                                                        {
																			while($row_product = mysql_fetch_array($result_product))
																			{
                                                                        ?>       
                                                                        <option value="<?=$row_product['rec_id']?>" <? if($row_product['rec_id']==$ProductId){?>selected="selected"<? } ?>><?=$row_product['ProductName']?></option>
                                                                        <?
                                                                        	}
                                                                        }
                                                                        ?>
                                                                        </select>
                                                                  	</td>
                                                              	
                                                                    <td align="left"><b>Count</b></td>
                                                                    <td align="left">
                                                                    	<div id="div_count">
                                                                        <?
																		$sql_count = "SELECT * FROM  ".$mysql_adm_table_prefix."count_master where ProductId = '$ProductId' order by Count ";
																		$result_count = mysql_query ($sql_count) or die ("Error in : ".$sql_count."<br>".mysql_errno()." : ".mysql_error());
																		
																			
																		?>
                                                                    	<select name="CountId" id="CountId" style="width:100px; height:20px;">
                                                                        	<option value="">--Select--</option>
																		<?
                                                                        if(mysql_num_rows($result_count)>0)
                                                                        {
																			while($row_count = mysql_fetch_array($result_count))
																			{
																			?>
                                                                            <option value="<?=$row_count['rec_id']?>" <? if($row_count['rec_id']==$CountId){?> selected="selected"<? } ?>><?=$row_count['Count']?></option>
                                                                            <?
																			}
																		}
																		?>
                                                                    	</select>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr class="text_1">
                                                                	<td align="left"><b>Lot Number</b></td>
                                                                    <td align="left"><input type="text" name="LotNumber" id="LotNumber"  value="<?=$LotNumber?>" style="width:150px; height:20px;"/></td>
                                                                    
                                                                    <td align="left"><b>Number Of Bags</b></td>
                                                                    <td align="left"><input type="text" name="NumberOfBags" id="NumberOfBags"  value="<?=$NumberOfBags?>" style="width:150px; height:20px;"/></td>
                                                                
                                                                 </tr>
                                                                <tr class="text_1">
                                                                	<td align="left"><b>Stock<span class="text_1"> kg</span></b></td>
                                                                    <td align="left"><input type="text" name="StockInKgs" id="StockInKgs"  value="<?=$StockInKgs?>" style="width:150px; height:20px;"/></td>
                                                                	<!--<td align="left"><b>Stock</b><span class="text_1">Packs</span></td>
                                                                    
                                                                    <td align="left"><input type="text" name="StockInBale" id="StockInBale"  value="<?=$StockInBale?>" style="width:150px; height:20px;"/></td>-->
                                                                
                                                                	<td align="left"><b>Date</b></td>
                                                                    <td align="left"><input type="text" name="Date" id="Date" value="<?=$Date?>" style="width:150px; height:22px;"/>
                                                                    <a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.frm_addstock.Date);return false;" HIDEFOCUS>
                                                                          <img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt=""></a>    </td>
                                                                </tr> 
                                                                <tr>
                                                                	<td colspan="4" align="center" style="padding-top:5px;">
                                                                        <input type="image" src="images/btn_submit.png" name="btn_submit" id="btn_submit" value="submit" />
                                                                        <input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
                                                                        <input type="hidden" name="StockId" id="StockId" value="<?=$StockId?>" />
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                       	  <td colspan="2" align="center" style="padding-top:5px;">
                                           	<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0" class="tableborder">
                                                    <tr>
                                                        <td align="left">
															<?  
                                                            if(mysql_num_rows($result_prj)>0)
                                                            {
                                                                $sno = $start+1;
                                                            ?>
                                                            <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#F5F2F1">
                                                                <tr class="navigation_row">
                                                                    <td class="headingSmall">
                                                                    <div style="margin:1px;text-align:left;" >
                                                                    <?
                                                                    if(!$count==0)
                                                                    {
                                                                    ?>
                                                                        <?=$numrows?> results found, page <?=($start/$row_limit)+1?> of <?=$count?>
                                                                    <?
                                                                    }
                                                                    ?>
                                                                    </div>
                                                                    </td>
                                                                    <td align="right">

                                                                    <div style="margin:1px;">
                                                                    <?
                                                                    if(!$count==0)
                                                                    {
                                                                    ?>
                                                                        <a href="<?=$_SERVER['PHP_SELF']?>?start=0" style="font-size:10px"><strong>First</strong></a>|
                                                                    <?
                                                                    }
                                                                    ?>
                                                                    <?
                                                                    if($start > 0)
                                                                    {
                                                                    ?>
                                                                        <a href="<?=$_SERVER['PHP_SELF']?>?start=<?=($start - $row_limit)?>" style="font-size:10px"><strong>Previous</strong></a>|
                                                                    <?
                                                                    }
                                                                    if($numrows > ($start + $row_limit)) 
                                                                    {
                                                                    ?>
                                                                        <a href="<?=$_SERVER['PHP_SELF']?>?start=<?=($start + $row_limit)?>" style="font-size:10px"><strong>Next</strong></a>|
                                                                    <?
                                                                    }
                                                                    ?>
                                                                    <?
                                                                    if(!$count==0)
                                                                    {
                                                                    ?>
                                                                        <a href="<?=$_SERVER['PHP_SELF']?>?start=<?=($count-1) * $row_limit?>" style="font-size:10px"><strong>Last</strong></a>
                                                                    <?
                                                                    }
                                                                    ?> 
                                                                    </div>
                                                                    </td>	 
                                                                </tr>
                                                            </table>
														   <?
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" align="center">
															<?  
                                                            if(mysql_num_rows($result_prj)>0)
                                                            {
                                                                $sno = $start+1;
                                                            ?>
                                                                <table align="center" width="100%" border="1" class="table1" cellpadding="0" cellspacing="0">
                                                                    <tr>
                                                                      <td width="5%" class="gredBg">S. No.</td>
                                                                   	  <td width="16%" class="gredBg">Product</td>
                                                                      <td width="26%" class="gredBg">Count</td>
                                                                      <td width="16%" class="gredBg">LotNumber</td>
                                                                      <td width="6%" class="gredBg"></td>
                                                                      <td width="6%" class="gredBg"></td>
                                                                   	</tr>
                                                                    
																	<?
                                                                        while($row=mysql_fetch_array($result_prj))
                                                                        {	
                                                                    ?>
                                                                    <tr <? if($sno%2==0){echo 'bgcolor="#f2f2f2"';}else{echo 'bgcolor="#E6E6E6"'; }?> class="tableText">
                                                                        <td align="center"><?=$sno?></td>
                                                                        <td align="center"><?=getProduct('ProductName','rec_id',getCount("ProductId","rec_id", $row["CountId"]))?></td>
                                                                        <td align="center"><?=getCount("Count","rec_id", $row["CountId"]);?></td>
                                                                        <td align="center" width="15%">LotNumber : <?=$row['LotNumber']?></td>
                                                                        <td align="center" rowspan="2">
                                                                        	<a href="list_stock.php?StockId=<?=$row["rec_id"]?>">
                                                                            <img src="images/Modify.png" alt="Edit" title="Edit" border="0"></a>
                                                                        </td>
                                                                        <td align="center" rowspan="2">
                                                                            <a href="javascript:;" onClick="overlay(<?=$row["rec_id"]?>);">
                                                                            <img src="images/Delete.png" alt="Delete" title="Delete" border="0"></a>
                                                                        </td>
                                                                   	</tr>
                                                                    <tr>
                                                                        <td colspan="4">
                                                                            <table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
                                                                                <tr <? if($sno%2==0){echo 'bgcolor="#f2f2f2"';}else{echo 'bgcolor="#E6E6E6"'; }?> class="tableText">
                                                                                    <td width="8%">&nbsp;</td>
                                                                                    <td align="center" width="25%"><b>Number Of Bags :</b> <?=$row['NumberOfBags']?></td>
                                                                                    <td align="center" width="42%"><b>Stock In Kgs :</b> <?=$row['StockInKgs']?>&nbsp;Kg</td>
                                                                                    <!--<td align="center" width="15%" class="tableText"><strong>StockInPacks : </strong><?=$row['StockInBale']?>&nbsp;Packs</td>-->
                                                                                    <td align="center"><b>Date :</b> <?=getDateFormate($row["Date"],1)?></td>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
															<?
                                                                 $sno++;
                                                                }	
                                                            ?>         
                                                            </table>
															<?
                                                            }
                                                            ?>        
                                                        </td>
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
        </td>
    </tr>
</table>
 
<div id="overlay">
     <div class="form_msg">
          <p>Are you sure to delete this Stock</p>
		  <form name="frm_del" action="<?=$_SERVER['PHP_SELF']?>" method="post">
		  <input type="hidden" name="hidden_overlay" id="hidden_overlay" value="" />
		  <input type="submit" name="btn_del" value="Yes" />
		  <input type="button" onClick="overlay();" name="btn_close" value="No" />
		  </form>
     </div>
</div>
<iframe width=168 height=190 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="calendar/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
</iframe> 
<? 
include("inc/footer.php");
?>