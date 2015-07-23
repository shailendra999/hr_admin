<?
include("inc/adm0_header.php");
?>
<?
$msg = "";
//////////////****************** Select For PI Listing *****************//////////

if(isset($_GET['start']))
{
	if($_GET['start']=='All')
	{
		$_SESSION["session_search"] = "";
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
	$search = "";
	if(isset($_POST["btn_search_x"]))
	{
		
		$txt_pi_number = $_POST["txt_pi_number"];
		$txt_pidate = getDateFormate($_POST["txt_pidate"],1);
		
		$sel_buyer = $_POST["sel_buyer"];
		 
		if($txt_pi_number!="")
		{
			$search .= "and dn.DispatchNumber = '$txt_pi_number'";
		}
		if($txt_pidate!="")
		{
			$search .= "and dn.DespatchDate = '$txt_pidate'";
		}
		if($sel_buyer!="")
		{
			$search .= "and bm.rec_id = '$sel_buyer'";
		}
		
		$_SESSION["session_search"] = $search;
	}
	$search = $_SESSION["session_search"];
	
	$sql_prj = "select * from ".$mysql_adm_table_prefix."dispatch_master dm, ".$mysql_adm_table_prefix."dispatch_number dn, ".$mysql_adm_table_prefix."buyer_master bm, ".$mysql_adm_table_prefix."pi_master pm where dm.rec_id!='' and dm.DispatchNumberId = dn.rec_id and dn.BuyerId = bm.rec_id and dm.PiId = pm.rec_id and bm.BuyerType = 'Domestic' $search";
	
	
	$query_count = "select count(*) as count from ".$mysql_adm_table_prefix."dispatch_master dm, ".$mysql_adm_table_prefix."dispatch_number dn, ".$mysql_adm_table_prefix."buyer_master bm, ".$mysql_adm_table_prefix."pi_master pm where dm.rec_id!='' and dm.DispatchNumberId = dn.rec_id and dn.BuyerId = bm.rec_id and dm.PiId = pm.rec_id and bm.BuyerType = 'Domestic' $search";
	$sql_prj = $sql_prj ." LIMIT " . $start . ", $row_limit";
	//echo $sql_prj;
	$result_prj = mysql_query($sql_prj) or die("Error in Query :".$sql_prj."<br>".mysql_error().":".mysql_errno());
	
	$query_count = $query_count;
	$result = mysql_query($query_count);
	$row_count = mysql_fetch_array($result);
	$numrows = $row_count['count'];
	$count = ceil($numrows/$row_limit);
?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
    <tr>
    	<td align="left" valign="top" width="230px" style="padding-top:5px;">
			<? include ("inc/adm0_snb.php"); ?>
        </td>
        
        <td style="padding-left:5px; padding-top:5px;" valign="top">
        	<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
            	<tr>
                	<td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp;Domestic Doc Report</td>
                </tr>
                <tr>
                	<td valign="top">
                        <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td class="red"><?=$msg?></td>
                            </tr>
                            
                            <tr>
                                <td valign="top" align="center" style="padding-top:5px;">
                                	<form id="frm_pi_search" name="" method="post" action="domestic_doc_report.php">
                                    	<table width="100%" cellpadding="0" cellspacing="0" border="0" style="border:1px solid #C6B4AE;" bgcolor="#EAE3E1" height="30">
                                        	<tr class="text_1">
                                            	<td align="center">
                                                	<b>I No.</b> <input type="text" name="txt_pi_number" id="txt_pi_number" value="">
                                                </td>
                                                <td align="center">
                                                	<b>Date</b> <input type="text" name="txt_pidate" id="txt_pidate" value="" style="width:150px; height:22px;"/>
                                                                    <a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.frm_pi_search.txt_pidate);return false;" HIDEFOCUS>
                                                                          <img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt=""></a>
                                                </td>
                                                <td align="center">
                                                	<b>Buyer</b>
                                                    <?
													$sql_buyer = "select * from  ".$mysql_adm_table_prefix."buyer_master order by BuyerName";
													$result_buyer = mysql_query($sql_buyer) or die("Error in Query :".$sql_buyer."<br>".mysql_error().":".mysql_errno());
													?> 
                                                    <select id="sel_buyer" name="sel_buyer" style="width:200px;">
                                                    	<option value="">Select</option>
                                                    	<?
                                                        if(mysql_num_rows($result_buyer)>0)
                                                        {
															while($row_buyer=mysql_fetch_array($result_buyer))
                                                        	{
														?>
                                                        	<option value="<?=$row_buyer["rec_id"]?>"><?=$row_buyer["BuyerName"]?></option>
                                                        <?
															}
                                                        }
														?>
                                                    </select>
                                                </td>
                                                
                                                <td align="center">
                                                	<input type="image" src="images/btn_submit.png" id="btn_search" name="btn_search" value="Search">
                                                </td>
                                            </tr>
                                        </table>
                                    </form>
                                    <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
                                        <tr>
                                            <td align="center" valign="top">
                                                <table align="center" width="100%" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td align="left">
                                                        <?  
                                                        if(mysql_num_rows($result_prj)>0)
                                                        {
                                                            $sno = $start+1;
                                                        ?>
                                                            <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
                                                                <tr class="navigation_row">
                                                                    <td class="headingSmall" style="padding-left:5px;">
                                                                    <div style="text-align:left;" >
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
                                                                    <div align="right">
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
                                                        <td>
                                                        
                                                    <?  
                                                    if(mysql_num_rows($result_prj)>0)
                                                    {
                                                        $sno = $start+1;
                                                    ?>
                                                            <table align="center" width="100%" border="0" class="border">
                                                                <tr>
                                                                    <td width="8%" class="gredBg">I. No.</td>
                                                                    <td width="7%" class="gredBg">I. Dt.</td>
                                                                    <td width="12%" class="gredBg">Buyer</td>
                                                                    <td width="6%" class="gredBg">port</td>
                                                                    <td width="7%" class="gredBg">Country</td>
                                                                    <td width="7%" class="gredBg">Item</td>
                                                                    <td width="10%" class="gredBg">Quantity Net in kg</td>
                                                                    <td width="12%" class="gredBg">Invoice Amt. in USD</td>
                                                                  	<?
																	$sql_doc = "select * from ".$mysql_adm_table_prefix."document_master where DocumentFor='Domestic'";
																	$result_doc = mysql_query($sql_doc) or die("Error in Query :".$sql_doc."<br>".mysql_error().":".mysql_errno());
																	
																	if(mysql_num_rows($result_doc)>0)
                                                    				{
																		while($row_doc=mysql_fetch_array($result_doc))
                                                        				{
																		?>
                                                                       	<td width="10%" class="gredBg"><?=$row_doc["DocumentName"]?></td>
                                                                        <?
																		}
																	}
																	?>
                                                              	</tr>
                                                     <?
                                                        while($row=mysql_fetch_array($result_prj))
                                                        {	
														
                                                    ?>
                                                                <tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?> class="text_1">
                                                                    <td align="center"><?=getDispatchNumber("DispatchNumber","rec_id",$row['DispatchNumberId'])?></td>
                                                                    <td align="center"><?=getDateFormate(getDispatchNumber("DespatchDate","rec_id",$row['DispatchNumberId']),1)?></td>
                                                                    <td align="center"><?=getBuyer('BuyerName','rec_id',getDispatchNumber("BuyerId","rec_id",$row['DispatchNumberId']))?></td>
                                                                    <td align="center"><?=$row['Port']?></td>
                                                                    <td align="center"><?=getCountry(getBuyer('CountryId','rec_id',$row['BuyerId']))?></td>
                                                                    <td align="center"><?=getProduct("ProductName","rec_id",$row['ProductId'])?></td>
                                                                    <td align="center"><?=$row['Quantity']?></td>
                                                                    <td align="center"><?=$row['Price']?></td>
                                                                   	<?
																	$sql_doc = "select * from ".$mysql_adm_table_prefix."document_master where DocumentFor='Domestic'";
																	$result_doc = mysql_query($sql_doc) or die("Error in Query :".$sql_doc."<br>".mysql_error().":".mysql_errno());
																	
																	if(mysql_num_rows($result_doc)>0)
                                                    				{
																		while($row_doc=mysql_fetch_array($result_doc))
                                                        				{
																			$OtherDetail = $row_doc["OtherDetail"];
																			$field_name = "";
																			if($OtherDetail== "Date")
																			{
																				$field_name = "DocDate";
																			}
																			if($OtherDetail== "Amount")
																			{
																				$field_name = "Amount";
																			}
																			if($OtherDetail== "Number")
																			{
																				$field_name = "Number";
																			}
																			
																			
																			
																			?>
                                                                            <td align="center">
                                                                            <?
																			$sql_dispatch_doc = "select * from ".$mysql_adm_table_prefix."despatch_doclist where DispatchMasterId='".$row[0]."' and DocId = '".$row_doc["rec_id"]."'";
																			$result_dispatch_doc = mysql_query($sql_dispatch_doc) or die("Error in Query :".$sql_dispatch_doc."<br>".mysql_error().":".mysql_errno());
																			
																			if(mysql_num_rows($result_dispatch_doc)>0)
																			{
																				while($row_dispatch_doc=mysql_fetch_array($result_dispatch_doc))
																				{
																					echo $row_dispatch_doc[$field_name];
																				}
																			}
																			?>
                                                                            &nbsp;
                                                                            </td>
                                                                            <?
																		}
																	}
																	?>
                                                                    
                                                                </tr>
                                                    <?
                                                         $sno++;
                                                        }	
                                                    ?>         
                                                            </table>
                                                        <?
                                                        }
                                                        ?>  
                                                            <div class="AddMore">
    	                                                        <a href="domestic_doc_report_xls.php">Export To XLS</a>  
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
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<iframe width=168 height=190 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="calendar/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
</iframe> 
<? 
include("inc/footer.php");
?>                          