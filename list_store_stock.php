<?
include("inc/store_header.php");
?>
<script type="text/javascript" src="javascript/form.js"></script>
<script type="text/javascript" src="javascript/popup.js"></script>
<script type="text/javascript" src="highslide/highslide-with-html.js"></script>
<link rel="stylesheet" type="text/css" href="highslide/highslide.css" />
<script type="text/javascript">
hs.graphicsDir = 'highslide/graphics/';
hs.outlineType = 'rounded-white';
hs.wrapperClassName = 'draggable-header';
</script>
<script>
function overlay(id) {
	el = document.getElementById("overlay");
	document.getElementById("hidden_overlay").value=id;
	el.style.visibility = (el.style.visibility == "visible") ? "hidden" : "visible";
	
}
</script>
<script language="JavaScript1.2">
function valid_frm_user(frm_search)
{
	return(valid_selectBox(frm_search));
}
function valid_selectBox(frm_search)
{
	if(frm_search.sel_srchby.value == "")
	{
		Popup.showModal('modal',null,null,{'screenColor':'#99ff99','screenOpacity':.6},"Please Select Search By");return false;
	}
	return true;
}
</script>
<?
$msg = '';
//////////// *************** Delete Buyer ************** ///////////////

if(isset($_POST["btn_del"]))
{
	$rec_id  = $_POST["hidden_overlay"];
	
	$sql = "delete from ms_stock_master where rec_id = '".$rec_id."'";
	mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	
	
	$msg = "Stock Sucessfully Deleted";
}	
?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
    <tr>
    	<td align="left" valign="top" width="230px" style="padding-top:5px;">
			<? include ("inc/store_snb.php"); ?>
        </td>
        
        <td style="padding-left:5px; padding-top:5px;" valign="top">
        	<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
            	<tr>
                	<td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; List Stock</td>
                </tr>
                <?
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

						$sql_prj = "select * from ms_stock_master order by insert_date ";
						$query_count = "select count(*) as count from ms_stock_master";
						$sql_prj = $sql_prj ." LIMIT " . $start . ", $row_limit";
						
						$result_prj = mysql_query($sql_prj) or die("Error in Query :".$sql_prj."<br>".mysql_error().":".mysql_errno());
						
						$query_count = $query_count;
						$result = mysql_query($query_count);
						$row_count = mysql_fetch_array($result);
						$numrows = $row_count['count'];
						$count = ceil($numrows/$row_limit);	
                    ?>
                <tr>
                	<td class="heading" valign="top">
                    	<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td>
                                    <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
                                        <tr>
                                            <td class="red"><?=$msg?></td>
                                        </tr>
                                        <tr>
                                            <td align="center" style="padding-top:10px;">
                                                <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0" class="tableborder">
                                                    <tr>
                                                        <td align="left">
                                                        <?  
                                                        if(mysql_num_rows($result_prj)>0)
                                                        {
                                                            $sno = $start+1;
                                                        ?>
                                                            <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#F5F2F1">
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
                                                                        <a href="<?=$_SERVER['PHP_SELF']?>?start=0&sel_srchby=<?=$search_by?>&txt_srchkeyword=<?=$search_keyword?>" style="font-size:10px"><strong>First</strong></a>|
                                                                    <?
                                                                    }
                                                                    ?>
                                                                    <?
                                                                    if($start > 0)
                                                                    {
                                                                    ?>
                                                                        <a href="<?=$_SERVER['PHP_SELF']?>?start=<?=($start - $row_limit)?>&sel_srchby=<?=$search_by?>&txt_srchkeyword=<?=$search_keyword?>" style="font-size:10px"><strong>Previous</strong></a>|
                                                                    <?
                                                                    }
                                                                    if($numrows > ($start + $row_limit)) 
                                                                    {
                                                                    ?>
                                                                        <a href="<?=$_SERVER['PHP_SELF']?>?start=<?=($start + $row_limit)?>&sel_srchby=<?=$search_by?>&txt_srchkeyword=<?=$search_keyword?>" style="font-size:10px"><strong>Next</strong></a>|
                                                                    <?
                                                                    }
                                                                    ?>
                                                                    <?
                                                                    if(!$count==0)
                                                                    {
                                                                    ?>
                                                                        <a href="<?=$_SERVER['PHP_SELF']?>?start=<?=($count-1) * $row_limit?>&sel_srchby=<?=$search_by?>&txt_srchkeyword=<?=$search_keyword?>" style="font-size:10px"><strong>Last</strong></a>
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
                                              				<table align="center" width="100%" border="1" class="table1 text_1">
                                                                <tr>
                                                                  <td width="3%" class="gredBg">S.No.</td>
                                                                  <td width="13%" class="gredBg">Stock Item</td>
                                                                  <td width="13%"  class="gredBg">Quanity</td>
                                                                  <td width="13%"  class="gredBg">Description</td>
                                                                  <td width="13%"  class="gredBg">Issue</td>
                                                                  <td width="3%"  class="gredBg">Edit</td>
                                                                  <td width="15%" class="gredBg">Delete</td>
                                                              </tr>
                                                     <?
                                                        while($row=mysql_fetch_array($result_prj))
                                                        {	
                                                    ?>
                                                                <tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
                                                                    <td align="center" width="13%"><?=$sno?></td>
                                                                    <td align="center"><?=$row['item_name']?> </td>
                                                                    <td align="center"><?=$row['quantiy']?> <?=getunittDetail('unit_name','rec_id', $row['quantity_unit'])?></td>
                                                                    <td align="center"><?=$row['descriptions']?></td>
                                                                    <td align="center"><input type="text" name="quantity_<?=$row['rec_id']?>" id="quantity_<?=$row['rec_id']?>" size="3"/><a href="javascript:;get_frm('up_date.php','<?=$row["rec_id"]?>','file_message',document.getElementById('quantity_<?=$row['rec_id']?>').value);">Issue</a></td>
                                                                    <td align="center"><a href="store_request_stock.php?editid=<?=$row["rec_id"]?>">
                                                                    	<img src="images/Modify.png" alt="Edit" title="Edit" border="0"></a></td>
                                                                    <td align="center">
                                                                      <a href="javascript:;" onClick="overlay(<?=$row["rec_id"]?>);">
                                                                      	<img src="images/Delete.png" alt="Delete" title="Delete" border="0"></a>
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
          <p>Are you sure to delete this Request</p>
		  <form name="frm_del" action="<?=$_SERVER['PHP_SELF']?>" method="post">
		  <input type="hidden" name="hidden_overlay" id="hidden_overlay" value="" />
		  <input type="submit" name="btn_del" value="Yes" />
		  <input type="button" onClick="overlay();" name="btn_close" value="No" />
		  </form>
     </div>
</div>
<DIV id=modal style="DISPLAY: none;">
  <div style="padding: 0px; background-color: rgb(37, 100, 192); visibility: visible; position: relative; width: 222px; height: 202px; z-index: 10002; opacity: 1;">
    <div onClick="Popup.hide('modal')" style="padding: 0px; background: transparent url(./images/Delete1.png) no-repeat scroll 0%; visibility: visible; position: absolute; left: 201px; top: 1px; width: 20px; height: 20px; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; cursor: pointer; z-index: 10004;" id="adpModal_close"></div>
    <div style="padding: 0px; background: transparent url(resize.gif) no-repeat scroll 0%; visibility: visible; position: absolute; width: 9px; height: 9px; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; cursor: nw-resize; z-index: 10003;" id="adpModal_rsize"></div>
    <div style="padding: 0px; overflow: hidden; background-color: rgb(140, 183, 231); visibility: visible; position: absolute; left: 1px; top: 1px; width: 220px; height: 20px; font-family: arial; font-style: normal; font-variant: normal; font-weight: bold; font-size: 9pt; line-height: normal; font-size-adjust: none; font-stretch: normal; color: rgb(15, 15, 15); cursor: move;" id="adpModal_adpT"></div>
    <div style="border-style: inset; border-width: 0px; padding: 8px; overflow: hidden; background-color: rgb(118, 201, 238); visibility: visible; position: absolute; left: 1px; top: 21px; width: 204px; height: 164px; font-family: MS Sans Serif; font-style: normal; font-variant: normal; font-weight: bold; font-size: 11pt; line-height: normal; font-size-adjust: none; font-stretch: normal; color: rgb(28, 94, 162);" id="adpModal_adpC">
      <center>
        <p>
        <div id="div_message"></div>
        </p>
        <p style="font-size: 10px; color: rgb(253, 80, 0);">To gain access to the page behind the popup must be closed</p>
      </center>
    </div>
  </div>
</DIV> 
<? 
include("inc/footer.php");
?>                            