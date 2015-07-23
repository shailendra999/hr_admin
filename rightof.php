<?
include("inc/adm0_header.php");
?>
<script language="javascript">
function openWin (url,w,h,scroll,pos)
{
	if(pos=="center"){LeftPosition=(screen.width)?(screen.width-w)/2:100;TopPosition=(screen.height)?(screen.height-h)/2:100;}

	else if((pos!="center" && pos!="random") || pos==null){LeftPosition=0;TopPosition=20}

	settings='width='+w+',height='+h+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=no';

	var mywin = window.open(url, "winImage", settings);
}
</script>
<script type="text/javascript" src="highslide/highslide-with-html.js"></script>
<link rel="stylesheet" type="text/css" href="highslide/highslide.css" />
<script type="text/javascript">
hs.graphicsDir = 'highslide/graphics/';
hs.outlineType = 'rounded-white';
hs.wrapperClassName = 'draggable-header';
</script>
<?
////////// ************************ Insert Right Off *******************/////////////////
$dispatch_id ='';
$msg='';
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
		$i = $_POST['count_hidden'];
		$right_off_amt = $_POST['txt_rightoff_'.$i];
		$dispatch_id = $_POST['hidden_dipatchid'];
		
		$sql = "update ".$mysql_adm_table_prefix."dispatch_master set RightOfAmount = '$right_off_amt' where rec_id = '$dispatch_id'";
		$result = mysql_query($sql) or die("Error in query:".$sql."<br>".mysql_error().":".mysql_errno());
		$msg = 'Right Off Successfullt Inserted';
		$_SESSION['no_refresh'] = $_POST['no_refresh'];	
	}
	
}
?>
<?
//////////////****************** Select For Dispatch Listing *****************//////////

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
	$sql_prj = "select * from ".$mysql_adm_table_prefix."dispatch_master";
	$query_count = "select count(*) as count from ".$mysql_adm_table_prefix."dispatch_master ";
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
                	<td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; Right Of</td>
                </tr>
                <tr>
                	<td align="center" class="red"><?=$msg?></td>
                </tr>    
                <tr>
                	<td valign="top" align="center">
                    	<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
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
                                                        //$test = 1;
                                                        ?>
                                                        	<table align="center" width="100%" border="0" class="border" cellpadding="2" cellspacing="2">
                                                                <tr>
                                                                    <td width="5%" class="gredBg">S.No</td>
                                                                    <td width="13%" class="gredBg">Invoice No</td>
                                                                    <td width="15%" class="gredBg">PI No</td>
                                                                    <td width="12%" class="gredBg">Product</td>
                                                                    <td width="17%" class="gredBg">Count</td>
                                                                  	<td width="12%" class="gredBg">Ordered Quantity</td>
                                                                    <td width="11%" class="gredBg">Now Sent Quantity</td>
                                                                    <td width="8%" class="gredBg">Quantity Left</td>
                                                                    <td width="7%" class="gredBg">Right Of</td>
                                                              </tr>
                                                     <?
                                                        while($row=mysql_fetch_array($result_prj))
                                                        {	
                                                    ?>
                                                    			<tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?> class="text_1">
                                                                    <td align="center"><?=$sno?></td>
                                                                    <td align="center"><?=getDispatchNumber('DispatchNumber','rec_id',$row['DispatchNumberId'])?></td>
                                                                    <td align="center"><?=getPINumber('PiNumber','rec_id',$row['PiId'])?></td>
                                                                    <td align="center"><?=getProduct('ProductName','rec_id',$row['ProductId'])?></td>
                                                                    <td align="center"><?=getCount('Count','rec_id',$row['CountId'])?></td>
                                                                    <td align="center"><?=$row['Quantity']?></td>
                                                                    <td align="center"><?=$row['NowOfferedQty']?></td>
                                                                    <td align="center">
																	<?
                                                                    	$a = $row['NowOfferedQty']+$row['PrevioslyAcceptedQty'];
																		$b = $row['Quantity'] - $a;
																		echo $b;
																    ?>		
                                                                    </td>
                                                                    <td align="center"><a href="javascript:;" onClick="return hs.htmlExpand(this, {headingText: 'Right Off', width: 400, height: 150 })"><span class="AddMore"><b>Right Off</b></span></a>
                                                                        <div class="highslide-maincontent">
                                                                        <?
																		$right_amt = '';
																		$sql_right = "select * from ".$mysql_adm_table_prefix."dispatch_master where rec_id = '".$row['rec_id']."'";		
																		$result_right = mysql_query($sql_right) or die("Error in query:".$sql_ight."<br>".mysql_error().":".mysql_errno());
																		$row_right = mysql_fetch_array($result_right);
																		$right_amt = $row_right['RightOfAmount'];
																			
																		?>
                                                                       		<form name="frm_rightoff" id="frm_rightoff" action="" method="post">
                                                                            	<table align="center" width="100%" style="vertical-align:top;" border="0">
                                                                                	<tr>
                                                                                    	<td valign="top" align="center">
                                                                                        <input type="text" name="txt_rightoff_<?=$sno?>" id="txt_rightoff_<?=$sno?>" value="<?=$right_amt?>" />
                                                                                        <input type="hidden" name="count_hidden" id="count_hidden" value="<?=$sno?>" />    		
 																						<input type="hidden" name="hidden_dipatchid" id="hidden_dipatchid" value="<?=$row['rec_id']?>"	 />	                                                                                              
                                                                                        </td>
                                                                                        <td valign="top">
                                                                                        	<input type="submit" name="btn_submit" id="btn_submit" value="Submit" />                                                                           
                                                                                         <input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>        
                                                                            </form> 
                                                                        </div>
                                                                    </td>
                                                    <?                                        
                                                            $sno++;
                                                         }
                                                       }
                                                    ?>  	 
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
<? 
include("inc/footer.php");
?>                                                    