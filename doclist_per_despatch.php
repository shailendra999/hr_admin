<?
include("inc/adm0_header.php");
?>
<?
$chk ='';
$docdate = '';
$doclist_id = '';
if(!session_is_registered("no_refresh"))
{
	$_SESSION['no_refresh'] = "";
}
if(isset($_POST['btn_submit']))
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
			
			if($update_id=="")
			{
				$sql_ins = "insert into ".$mysql_adm_table_prefix."despatch_doclist set
																						DispatchMasterId = '$dispatch_id',
																						DocId = '$doc_id',
																						DocStatus = '$chk_flag',
																						DocDate = '$doc_date'";
				$result_ins = mysql_query($sql_ins) or die("Error in Query :".$sql_ins."<br/>".mysql_error()."<br/>".mysql_errno());
				 $_SESSION['no_refresh'] = $_POST['no_refresh'];
		   }
		   else
		   {
		   		$sql_up = "update ".$mysql_adm_table_prefix."despatch_doclist set
																					DispatchMasterId = '$dispatch_id',
																					DocId = '$doc_id',
																					DocStatus = '$chk_flag',
																					DocDate = '$doc_date' where rec_id = '$update_id'";
				$result_up = mysql_query($sql_up) or die("Error in Query :".$sql_up."<br/>".mysql_error()."<br/>".mysql_errno());
				 $_SESSION['no_refresh'] = $_POST['no_refresh'];
		   }			 																		
		}	
	}
}	
?>
<?
if(isset($_GET['id']))
{
	$id = $_GET['id'];
	$sql_sel = "select * from ".$mysql_adm_table_prefix."dispatch_number where rec_id = '$id'";
	$result_sel = mysql_query($sql_sel) or die("Error in Query :".$sql_sel."<br>".mysql_error().":".mysql_errno());
	$row_sel = mysql_fetch_array($result_sel);
	$buyerid = $row_sel['BuyerId'];
	$dispatchid = getDispatchDetail('rec_id','DispatchNumberId',$row_sel['rec_id']);
	
	 $sql_type = "select * from ".$mysql_adm_table_prefix."buyer_master where rec_id = '$buyerid'";
     $result_type = mysql_query($sql_type) or die("Error in Query :".$sql_type."<br/>".mysql_error()."<br/>".mysql_errno());
	 $row_type = mysql_fetch_array($result_type);
	 $buyer_type = $row_type['BuyerType'];
}
?>	
<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
    	<td>
        	<table width="80%" cellpadding="0" cellspacing="0" align="center" border="0">
                <tr>
                    <td height="500px" align="center" valign="top" class="tableborder">
                        <table align="center" width="90%" cellpadding="0" cellspacing="0" border="0">
                        	<tr>
                            	<td class="heading">Document List</td>
                            </tr>
                            <tr>
                            	<td style="padding-top:20px;">
                                	<form name="frm_doclist" id="frm_doclist" action="" method="post">
                                	<table align="center" width="60%" cellpadding="0" cellspacing="0" style="border:#DFEAF7 solid 1px;">
                                    	<tr>
                                        	<td width="14%" align="center"></td>
                                            <td width="59%" align="center"><b>Document</b></td>
                                            <td width="27%" align="center"><b>Date</b></td>
                                        </tr>
						  <?
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
										if(mysql_num_rows($result_dlist)>0)
										{
											$row_dlist = mysql_fetch_array($result_dlist);
											
											  $doclist_id = $row_dlist['rec_id']; 
											  $chk = $row_dlist['DocStatus'];
											  $docdate = getDateFormate($row_dlist['DocDate'],1);
										}	  
                          ?>                  
                                        <tr>
                                        	<td align="center"><input type="checkbox" name="chk_flag_<?=$i?>" id="chk_flag_<?=$i?>" value="1" <? if($chk=='1'){?> checked="checked" <? }?> />
                                            <input type="hidden" name="update_id_<?=$i?>" id="update_id_<?=$i?>" value="<?=$doclist_id?>" />
                                            </td>     
                                            <td align="center"><?=$row_doc['DocumentName']?>
                                            	<input type="hidden" name="docid_hidden_<?=$i?>" id="docid_hidden_<?=$i?>" value="<?=$row_doc['rec_id']?>" />
                                            </td>
                                            <td align="center">
                                            <input type="text" name="txt_date_<?=$i?>" id="txt_date_<?=$i?>" value="<?=$docdate?>" size="10" />
                                            <a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.frm_doclist.txt_date_<?=$i?>);return false;" HIDEFOCUS><img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt=""></a>
                                            </td>
                                        </tr>
                           <?
						   					
											
						   			$i++;
									}
								}
						   ?>
                           				<tr>
                                        	<td colspan="3" align="center">
                                            	 <input type="hidden" name="dispatch_id" id="dispatch_id" value="<?=$dispatchid?>" />
                                            	 <input type="hidden" name="d_count" id="d_count" value="<?=mysql_num_rows($result_doc)?>" />
                                                 <input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
                                                 <input type="submit" name="btn_submit" id="btn_submit" value="Submit"/>
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
include("inc/footer.php");
?>                                                        