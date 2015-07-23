<?
include("inc/adm0_header.php");
?>
<script type="text/javascript" src="highslide/highslide-with-html.js"></script>
<link rel="stylesheet" type="text/css" href="highslide/highslide.css" />
<script type="text/javascript">
hs.graphicsDir = 'highslide/graphics/';
hs.outlineType = 'rounded-white';
hs.wrapperClassName = 'draggable-header';
</script>
<script language="javascript">
function openWin (url,w,h,scroll,pos)
{
	if(pos=="center"){LeftPosition=(screen.width)?(screen.width-w)/2:100;TopPosition=(screen.height)?(screen.height-h)/2:100;}

	else if((pos!="center" && pos!="random") || pos==null){LeftPosition=0;TopPosition=20}

	settings='width='+w+',height='+h+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=no';

	var mywin = window.open(url, "winImage", settings);
}
</script>
<?
///////////////////*********************** Insert And Update Document List ***************** ///////////////////////

$msg = '';
if(!session_is_registered("no_refresh"))
{
	$_SESSION['no_refresh'] = "";
}
if(isset($_POST['btn_docsubmit_x']))
{
	
	if($_POST['no_refresh'] == $_SESSION['no_refresh'])
	{	
		//echo "WARNING: Do not try to refresh the page.";
	}
	else
	{
		$dispatch_id = $_POST['dispatch_id'];
		if(isset($_POST['d_count'])){ $count = $_POST['d_count'];}
		for($j=1;$j<=$count;$j++)
		{
			
			if(isset($_POST["chk_flag_$j"])){ $chk_flag = $_POST["chk_flag_$j"];} else{ $chk_flag = '0';}
			if(isset($_POST["docid_hidden_$j"])){  $doc_id = $_POST["docid_hidden_$j"];}
			if(isset($_POST["txt_date_$j"])){ $doc_date = getDateFormate($_POST["txt_date_$j"],1);} else{ $doc_date = '';}
			if(isset($_POST["update_id_$j"])){ $update_id = $_POST["update_id_$j"];}
			if(isset($_POST["sel_currency_$j"])) { $sel_currency = $_POST["sel_currency_$j"];} else{ $sel_currency = '';}
			if(isset($_POST["txt_amount_$j"])){ $txt_amount = $_POST["txt_amount_$j"];}
			if(isset($_POST["txt_number_$j"])){ $txt_number = $_POST["txt_number_$j"]; }
			
			if($update_id=="")
			{
				$sql_ins = "insert into ".$mysql_adm_table_prefix."despatch_doclist set
																						DispatchMasterId = '$dispatch_id',
																						DocId = '$doc_id',
																						DocStatus = '$chk_flag',
																						DocDate = '$doc_date',
																						Currency = '$sel_currency',
																						Amount = '$txt_amount',
																						Number = '$txt_number'";
				$result_ins = mysql_query($sql_ins) or die("Error in Query :".$sql_ins."<br/>".mysql_error()."<br/>".mysql_errno());
				 $_SESSION['no_refresh'] = $_POST['no_refresh'];
		   }
		   else
		   {
		   		$sql_up = "update ".$mysql_adm_table_prefix."despatch_doclist set
																					DispatchMasterId = '$dispatch_id',
																					DocId = '$doc_id',
																					DocStatus = '$chk_flag',
																					DocDate = '$doc_date',
																					Currency = '$sel_currency',
																					Amount = '$txt_amount',
																					Number = '$txt_number' where rec_id = '$update_id'";
				$result_up = mysql_query($sql_up) or die("Error in Query :".$sql_up."<br/>".mysql_error()."<br/>".mysql_errno());
				 $_SESSION['no_refresh'] = $_POST['no_refresh'];
		   }			 																		
		}	
	}
}	
?>
<?
/////////////// ******************** UPLOAD EXCEL ************************ /////////////////////

if(isset($_POST["btn_upload"]))
{
	$flag = "";
	$dispatch_id  = $_POST["h_dispatch_id"];
	$AttachedFile  = $_FILES["AttachedFile"]["name"];
	
	if($_FILES["AttachedFile"]["name"] <> "")
	{
		$filename = $_FILES["AttachedFile"]["name"];
		$file_arr = explode(".", $filename);
		$file_ext = strtolower($file_arr[sizeof($file_arr)-1]);
		if($file_ext=='xls' || $file_ext=='xlsx')
		{	 
			$filename=str_replace(" ","_",$filename);// Add _ inplace of blank space in file name, you can remove this line
			$time=time();
			$file=$dispatch_id.".".$file_ext;
			$up_file = "dispatch_attachments/".$file;   // upload directory path is set
			if(move_uploaded_file($_FILES['AttachedFile']['tmp_name'], $up_file))     //  upload the file to the server
			{
				$flag = 1;
				$sql_prj = "update ".$mysql_adm_table_prefix."dispatch_number set AttachedFile = '$file' where rec_id='$dispatch_id'";
				mysql_query ($sql_prj) or die ("Invalid query : ".$sql_prj."<br>".mysql_errno()." : ".mysql_error());
				$msg = "File Uploaded";
			}
			else
			{
				$flag = 0;
				$msg ='error in upload Excel file';
			}
		}
		else
		{
			$flag = 0;
			$msg ='Please upload Excel file not '.$file_ext;
		}	
	}
}
?>
<?
//////////////****************** Select For Dispatch Listing *****************//////////

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
		
		$txt_invoice_no = $_POST["txt_invoice_no"];
		$sel_buyer = $_POST["sel_buyer"];
		
		if($txt_invoice_no!="")
		{
			$search .= "and DispatchNumber = '$txt_invoice_no' ";
		}
		if($sel_buyer!="")
		{
			$search .= "and BuyerId = '$sel_buyer'";
		}
		
		$_SESSION["session_search"] = $search;
	}
	
	$sql_prj = "select * from ".$mysql_adm_table_prefix."dispatch_number where rec_id!='' $search order by InsertDate DESC";
	$query_count = "select count(*) as count from ".$mysql_adm_table_prefix."dispatch_number where rec_id!='' $search";
	$sql_prj = $sql_prj ." LIMIT " . $start . ", $row_limit";
	
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
                	<td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; List Despatch</td>
                </tr>
                <tr>
                	<td valign="top" align="center">
                    	<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td class="red"><?=$msg?></td>
                            </tr>
                            <tr>
                            	<td align="center" style="border:1px solid #C6B4AE; padding-top:10px;" bgcolor="#EAE3E1">
                                	<form id="frm_dispatch_search" name="" method="post" action="list_dispatch.php">
                                    	<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
                                        	<tr class="text_1">
                                            	<td align="center">
                                                	<b>Invoice No.</b> <input type="text" name="txt_invoice_no" id="txt_invoice_no" value="">
                                                </td>
                                                <td align="center">
                                                	<b>Buyer</b>
                                                    <?
													$sql_buyer = "select * from  ".$mysql_adm_table_prefix."buyer_master order by BuyerName";
													$result_buyer = mysql_query($sql_buyer) or die("Error in Query :".$sql_buyer."<br>".mysql_error().":".mysql_errno());
													?> 
                                                    <select id="sel_buyer" name="sel_buyer">
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
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
                                        <tr>
                                            <td align="center" valign="top">
                                                <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
                                                    <tr>
                                                        <td style="padding-top:5px;" align="left">
                                                        <?  
                                                        if(mysql_num_rows($result_prj)>0)
                                                        {
                                                            $sno = $start+1;
                                                        ?>
                                                            <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#F5F2F1">
                                                                <tr class="navigation_row">
                                                                    <td class="headingSmall">
                                                                    <div style="margin:1px;text-align:left; padding-left:5px;">
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
                                                                        <a href="<?=$_SERVER['PHP_SELF']?>?start=0&session_search=<?=$search?>" style="font-size:10px"><strong>First</strong></a>|
                                                                    <?
                                                                    }
                                                                    ?>
                                                                    <?
                                                                    if($start > 0)
                                                                    {
                                                                    ?>
                                                                        <a href="<?=$_SERVER['PHP_SELF']?>?start=<?=($start - $row_limit)?>&session_search=<?=$search?>" style="font-size:10px"><strong>Previous</strong></a>|
                                                                    <?
                                                                    }
                                                                    if($numrows > ($start + $row_limit)) 
                                                                    {
                                                                    ?>
                                                                        <a href="<?=$_SERVER['PHP_SELF']?>?start=<?=($start + $row_limit)?>&session_search=<?=$search?>" style="font-size:10px"><strong>Next</strong></a>|
                                                                    <?
                                                                    }
                                                                    ?>
                                                                    <?
                                                                    if(!$count==0)
                                                                    {
                                                                    ?>
                                                                        <a href="<?=$_SERVER['PHP_SELF']?>?start=<?=($count-1) * $row_limit?>&session_search=<?=$search?>" style="font-size:10px"><strong>Last</strong></a>
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
                                                        //$test = 1;
                                                        ?>
                                                            <table align="center" width="100%" border="0" class="border" cellpadding="2" cellspacing="2">
                                                                <tr>
                                                                    <td width="5%" class="gredBg">S.No</td>
                                                                    <td width="20%" class="gredBg">Invoice No</td>
                                                                    <td width="20%" class="gredBg">Purchase Invoice No</td>
                                                                    <td width="18%" class="gredBg">Buyer</td>
                                                                    <td width="12%" class="gredBg">For</td>
                                                                    <td width="13%" class="gredBg">Other Detail</td>
                                                                    <td width="14%" class="gredBg">Documents</td>
                                                                    <td width="14%" class="gredBg">Excel</td>
                                                                    <td width="14%" class="gredBg">Upload Excel</td>
                                                              </tr>
                                                     <?
                                                        while($row=mysql_fetch_array($result_prj))
                                                        {	
                                                    ?>
                                                                <tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?> class="text_1">
                                                                    <td align="center"><?=$sno?></td>
                                                                    <td align="center"><?=$row['DispatchNumber']?></td>
                                                                    <td align="center">
                                                    <?
                                                            $sql_pi = "select * from ".$mysql_adm_table_prefix."dispatch_master where DispatchNumberId = '".$row['rec_id']."' group by DispatchNumberId ";
                                                            $result_pi = mysql_query($sql_pi) or die("Error in Query :".$sql_pi."<br>".mysql_error().":".mysql_errno());
                                                            $row_pi = mysql_fetch_array($result_pi);
                                                            echo getPINumber('PiNumber','rec_id',$row_pi['PiId']);
                                                    ?>
                                                                    </td>
                                                                    <td align="center"><?=getBuyer('BuyerName','rec_id',$row['BuyerId'])?></td>
                                                                    <td align="center"><?=getBuyer('BuyerType','rec_id',$row['BuyerId'])?></td>
                                                                    <td align="center"><a href="javascript:;" onClick="return hs.htmlExpand(this,{headingText: 'Other Detail', width: 500, height: 300 })"><img src="images/Find-icon.png" border="0" width="24" height="24" /></a>
                                                                        <div class="highslide-maincontent">
                                                                            <table align="center" width="100%" cellpadding="1" cellspacing="1" class="border">
                                                                                <tr>
                                                                                    <td class="gredBg">Product</td>
                                                                                    <td class="gredBg">Count</td>
                                                                                    <td class="gredBg">Ordered Quantity</td>
                                                                                    <td class="gredBg">Now Sent Quantity</td>
                                                                                    <td class="gredBg">Quantity Left</td>
                                                                                    <td class="gredBg">Price</td>
                                                                                </tr>   
                                                   <?
                                                        $sql_detail = "select * from ".$mysql_adm_table_prefix."dispatch_master where DispatchNumberId = '".$row['rec_id']."'";
                                                        $result_detail = mysql_query($sql_detail) or die("Error in Query :".$sql_detail."<br>".mysql_error().":".mysql_errno());
                                                            $s = 1;
                                                        while($row_detail = mysql_fetch_array($result_detail))
                                                        {	
                                                   ?> 		
                                                                                <tr <? if ($s%2==1) { ?> bgcolor="#F5F2F1" <? } ?> class="text_1">
                                                                                    <td align="center"><?=getProduct('ProductName','rec_id',$row_detail['ProductId'])?></td>
                                                                                    <td align="center"><?=getCount('Count','rec_id',$row_detail['CountId'])?></td>
                                                                                    <td align="center"><?=$row_detail['Quantity']?></td>
                                                                                    <td align="center"><?=$row_detail['NowOfferedQty']?></td>
                                                                                    <td align="center">
                                                                                    <?
                                                                                        $a = $row_detail['NowOfferedQty']+$row_detail['PrevioslyAcceptedQty'];
                                                                                        $b = $row_detail['Quantity'] - $a;
                                                                                        echo $b;
                                                                                    ?>	
                                                                                    </td>
                                                                                    <td align="center"><?=$row_detail['Price']?></td>
                                                                                </tr>
																				   <?
                                                                                            $s++;
                                                                                        }
                                                                                   ?>		                                         	         
                                                                            </table>
                                                                        </div>                                            
                                                                    </td>
                                                                    <td align="center">
                                                                    <a href="javascript:;" onClick="return hs.htmlExpand(this,{headingText: 'Document', width: 600, height: 250 })"><img src="images/document-icon.png" border="0" width="24" height="24" /></a>
                                                                        <div class="highslide-maincontent">
                                                                            <form name="frm_doclist_<?=$sno?>" id="frm_doclist_<?=$sno?>" action="" method="post">
                                                                            
                                                                            <table align="center" width="100%" cellpadding="1" cellspacing="1" class="border" style="vertical-align:top;">
                                                                                <tr>
                                                                                    <td class="gredBg"></td>
                                                                                    <td class="gredBg"><b>Document</b></td>
                                                                                    <td class="gredBg"><b>Date</b></td>
                                                                                    <td class="gredBg"><b>Currency</b></td>
                                                                                    <td class="gredBg"><b>Amount</b></td>
                                                                                    <td class="gredBg"><b>Number</b></td>
                                                                                </tr>
                                                                  <?
                                                                    $sql_sel = "select * from ".$mysql_adm_table_prefix."dispatch_number where rec_id = '".$row['rec_id']."'";
                                                                    $result_sel = mysql_query($sql_sel) or die("Error in Query :".$sql_sel."<br>".mysql_error().":".mysql_errno());
                                                                    $row_sel = mysql_fetch_array($result_sel);
                                                                    $buyerid = $row_sel['BuyerId'];
                                                                    $dispatchid = getDispatchDetail('rec_id','DispatchNumberId',$row_sel['rec_id']);
                                                                    
                                                                     $sql_type = "select * from ".$mysql_adm_table_prefix."buyer_master where rec_id = '$buyerid'";
                                                                     $result_type = mysql_query($sql_type) or die("Error in Query :".$sql_type."<br/>".mysql_error()."<br/>".mysql_errno());
                                                                     $row_type = mysql_fetch_array($result_type);
                                                                     $buyer_type = $row_type['BuyerType'];
                                                                        
                                                                        $sql_doc = "select * from ".$mysql_adm_table_prefix."document_master where DocumentFor = '$buyer_type'";
                                                                        $result_doc = mysql_query($sql_doc) or die("Error in Query :".$sql_doc."<br/>".mysql_error()."<br/>".mysql_errno());								
                                                                        if(mysql_num_rows($result_doc)>0)
                                                                        {
                                                                            $i = 1;
                                                                            while($row_doc = mysql_fetch_array($result_doc))
                                                                            {
                                                                                 $dm_id = $row_doc['rec_id'];
                                                                                 $sql_dlist = "select * from ".$mysql_adm_table_prefix."despatch_doclist where DispatchMasterId = '$dispatchid' and DocId = '$dm_id'";
                                                                                 $result_dlist = mysql_query($sql_dlist) or die("Error in Query :".$sql_dlist."<br/>".mysql_error()."<br/>".mysql_errno());
                                                                                 $chk ='';
                                                                                 $docdate = '';
                                                                                 $doclist_id = '';
																				 $currency = '';
																				 $amount = '';
																				 $number = '';
                                                                                if(mysql_num_rows($result_dlist)>0)
                                                                                {
                                                                                    $row_dlist = mysql_fetch_array($result_dlist);
                                                                                    
                                                                                      $doclist_id = $row_dlist['rec_id']; 
                                                                                      $chk = $row_dlist['DocStatus'];
                                                                                      $docdate = getDateFormate($row_dlist['DocDate'],1);
																					  $currency = $row_dlist['Currency'];
																					  $amount = $row_dlist['Amount'];
																					  $number = $row_dlist['Number'];
                                                                                }	  
                                                                 ?>                  
                                                                                <tr <? if ($i%2==1) { ?> bgcolor="#F5F2F1" <? } ?> class="text_1">
                                                                                    <td align="center"><input type="checkbox" name="chk_flag_<?=$i?>" id="chk_flag_<?=$i?>" value="1" <? if($chk=='1'){?> checked="checked" <? }?> />
                                                                                    <input type="hidden" name="update_id_<?=$i?>" id="update_id_<?=$i?>" value="<?=$doclist_id?>" />
                                                                                    </td>     
                                                                                    <td align="center"><?=$row_doc['DocumentName']?>
																					<? $other_detail = $row_doc['OtherDetail'];?>
                                                                                        <input type="hidden" name="docid_hidden_<?=$i?>" id="docid_hidden_<?=$i?>" value="<?=$row_doc['rec_id']?>" />
                                                                                    </td>
                                                                                    <td align="center">
                                                                                    <input type="text" name="txt_date_<?=$i?>" id="txt_date_<?=$i?>" value="<?=$docdate?>" size="10" />
                                                                                    <a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.frm_doclist_<?=$sno?>.txt_date_<?=$i?>);" HIDEFOCUS><img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt=""></a>
                                                                                    <!--document.frm_doclist.txt_date_1-->
                                                                                    
                                                                                    </td>
                                                                                    <td align="center">
                                                                                      <select name="sel_currency_<?=$i?>" id="sel_currency_<?=$i?>" <? if($other_detail!='Amount'){?> disabled="disabled"<? } ?>>
                                                                                        <option value="">--Select--</option>
                                                                                        <?
                                                                                        $sqlcurrency = "select * from ".$mysql_adm_table_prefix."currency_master order by Currency";
                                                                                        $result_currency = mysql_query($sqlcurrency) or die("Error in Query : ".$sqlprd."<br/>".mysql_error()."<br/>".mysql_errno());
                                                                                        if(mysql_num_rows($result_currency)>0)
                                                                                        {
                                                                                        while($row_currency = mysql_fetch_array($result_currency))
                                                                                        {
                                                                                        ?>       
                                                                                        <option value="<?=$row_currency['rec_id']?>" <? if($row_currency['rec_id']==$currency){?> selected="selected"<? }?>><?=$row_currency['Currency']?></option>
                                                                                        <?
                                                                                        }
                                                                                        }
                                                                                        ?>
                                                                                        </select>             
                                                                                    </td>
                                                                                    <td align="center"><input type="text" name="txt_amount_<?=$i?>" id="txt_amount_<?=$i?>" style="width:70px;" value="<?=$amount?>" <? if($other_detail!='Amount'){?> readonly="readonly"<? } ?> /></td>
                                                                                    <td align="center"><input type="text" name="txt_number_<?=$i?>" id="txt_number_<?=$i?>" style="width:70px;" value="<?=$number?>" <? if($other_detail!='Number'){?> readonly="readonly"<? } ?>/></td>
                                                                                </tr>
                                                                   <?
                                                                              
                                                                                    
                                                                            $i++;
                                                                            }
                                                                        }
                                                                   ?>
                                                                                <tr>
                                                                                    <td colspan="6" align="center">
                                                                                         <input type="hidden" name="dispatch_id" id="dispatch_id" value="<?=$dispatchid?>" />
                                                                                         <input type="hidden" name="d_count" id="d_count" value="<?=mysql_num_rows($result_doc)?>" />
                                                                                         <input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
                                                                                         <input type="image" src="images/btn_submit.png" name="btn_docsubmit" id="btn_docsubmit" onClick="frm_doclist_<?=$sno?>.submit();" value="Submit"/>
                                                                                    </td>
                                                                                </tr>    		             
                                                                            </table>
                                                                            </form>                                                    
                                                                        </div>
                                                                        
                                                                <!--   <a href="doclist_per_despatch.php?id=<?=$row['rec_id']?>"><img src="images/document-icon.png" border="0" /></a>-->
                                                                    </td>
                                                                    <td align="center">
                                                                   <?
																  if($row['AttachedFile']!='')
																  {
																  	if(file_exists("dispatch_attachments/".$row['AttachedFile']))
																	{
																  ?>
                                                                  		<a href="download_dispatch.php?file_id=<?=$row['AttachedFile']?>"><img src="images/Excel-icon.png" border="0" alt="PI Excel" title="PI Excel" /></a>
                                                                  <?	
																  	 }
																   }
																   else
																   { 
                                                                   
																	   if(getBuyer('BuyerType','rec_id',$row['BuyerId'])=='Export')
																	   { 
																	   ?>
																	   <a href="export_dispatch_excel.php?id=<?=$row['rec_id']?>"><img src="images/Excel-icon.png" border="0" alt="Excel Dispatch" title="Excel Dispatch"/></a>
																	   <?
																	   }
																	   else if(getBuyer('BuyerType','rec_id',$row['BuyerId'])=='Domestic')
																	   {
																	   ?>
																	   <a href="export_dispatch_domestic_excel.php?id=<?=$row['rec_id']?>"><img src="images/Excel-icon.png" border="0" alt="Excel Dispatch" title="Excel Dispatch"/></a>
																	   <?
																	   }
																	 }  
																	   ?>
                                                                    </td>
                                                                    <td align="center">
                                                                    	<a href="javascript:;" onClick="return hs.htmlExpand(this, {headingText: 'Upload XLS File', width: 400, height: 100 })"><img src="images/upload_icon.jpg" border="0" /></a>
                                                                        <div class="highslide-maincontent">
                                                                        	<form id="frm_upload" name="frm_upload" method="post" action="" style="display:inline" enctype="multipart/form-data">
                                                                                <table>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <input type="file" id="AttachedFile" name="AttachedFile" />
                                                                                        </td>
                                                                                        <td>
                                                                                            <input type="hidden" id="h_dispatch_id" name="h_dispatch_id" value="<?=$row["rec_id"]?>" />
                                                                                            <input type="submit" id="btn_upload" name="btn_upload" value="Upload" />
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                    	<td colspan="2" class="AddMore">
                                                                                        	<?
                                                                                            if($row['AttachedFile']!="")
                                                                                            {
                                                                                            	if(file_exists("dispatch_attachments/".$row['AttachedFile']))
																								{
																								?>
                                                                                                <a href="download_dispatch.php?file_id=<?=$row['AttachedFile']?>">Download</a>
                                                                                                <?
																								}
                                                                                            }
																							?>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </form>
                                                                        </div>
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

<iframe width=168 height=190 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="calendar/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:5000; position:absolute; left:-500px; top:0px;">
</iframe> 
<? 
include("inc/footer.php");
?>                            