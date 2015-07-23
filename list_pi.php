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
<script>
function overlay(id) {
	el = document.getElementById("overlay");
	document.getElementById("hidden_overlay").value=id;
	el.style.visibility = (el.style.visibility == "visible") ? "hidden" : "visible";
	
}
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
$msg = '';
//////////// *************** Delete PI ************** ///////////////

if(isset($_POST["btn_del"]))
{
	$rec_id  = $_POST["hidden_overlay"];
	$sql = "delete from ".$mysql_adm_table_prefix."pi_master where rec_id = '".$rec_id."'";
	mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	$msg = "Purchase Invoice Sucessfully Deleted";
}	
?>
<?
if(isset($_POST["btn_upload"]))
{
	$flag = "";
	$pi_id  = $_POST["h_pi_id"];
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
			$file=$pi_id.".".$file_ext;
			$up_file = "pi_attachment/".$file;   // upload directory path is set
			if(move_uploaded_file($_FILES['AttachedFile']['tmp_name'], $up_file))     //  upload the file to the server
			{
				$flag = 1;
				$sql_prj = "update ".$mysql_adm_table_prefix."pi_master set AttachedFile = '$file' where rec_id='$pi_id'";
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
		$sel_buyer = $_POST["sel_buyer"];
		
		if($txt_pi_number!="")
		{
			$search .= "and PiNumber = '$txt_pi_number' ";
		}
		if($sel_buyer!="")
		{
			$search .= "and BuyerId = '$sel_buyer'";
		}
		
		$_SESSION["session_search"] = $search;
	}
	$search = $_SESSION["session_search"];
	$sql_prj = "select * from ".$mysql_adm_table_prefix."pi_master where rec_id!='' $search order by InsertDate DESC";
	$query_count = "select count(*) as count from ".$mysql_adm_table_prefix."pi_master where rec_id!='' $search ";
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
                	<td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; List Purchase Invoice</td>
                </tr>
                <tr>
                	<td valign="top" style="padding-top:5px;">
                        <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td class="red"><?=$msg?></td>
                            </tr>
                            <tr>
                            	<td align="center">
                                	<form id="frm_pi_search" name="" method="post" action="list_pi.php">
                                    	<table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" style="border:1px solid #C6B4AE;" bgcolor="#EAE3E1">
                                        	<tr>
                                            	<td align="left" class="text_1">
                                                	<b>PI Number</b><br /><input type="text" class="inTxt" name="txt_pi_number" id="txt_pi_number" value="" style="width:120px;">
                                                </td>
                                                <td class="text_1">
                                                	<b>Buyer</b><br />
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
                                            </tr>
                                            <tr>
                                            	<td align="left" valign="bottom"><input type="image" src="images/btn_submit.png" id="btn_search" name="btn_search" value="Search"></td>
                                            </tr>
                                        </table>
                                    </form>
                                </td>
                            </tr>
                            <tr>
                                <td valign="top" align="center" style="padding-top:5px;">
                                    <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
                                        <tr>
                                            <td align="center" valign="top">
                                                <table align="center" width="100%" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td style="padding-top:5px;" align="left">
                                                        <?  
                                                        if(mysql_num_rows($result_prj)>0)
                                                        {
                                                            $sno = $start+1;
                                                        ?>
                                                            <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#F5F2F1">
                                                                <tr class="navigation_row">
                                                                    <td class="headingSmall" style="padding-left:5px;">
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
                                                        <td>
                                                        
                                                    <?  
                                                    if(mysql_num_rows($result_prj)>0)
                                                    {
                                                        $sno = $start+1;
                                                    ?>
                                                            <table align="center" width="100%" border="0" class="border">
                                                                <tr>
                                                                    <td width="6%" class="gredBg">S.No</td>
                                                                    <td width="27%" class="gredBg">Buyer</td>
                                                                    <td width="27%" class="gredBg">PI Number</td>
                                                                    <td width="20%" class="gredBg">PI Date</td>
                                                                    <td width="12%" class="gredBg">For</td>
                                                                    <td width="8%" class="gredBg">Despatch</td>
                                                                    <td width="6%" class="gredBg">Print</td>
                                                                    <!--<td width="6%" class="gredBg">PDF</td>-->
                                                                    <td width="6%" class="gredBg">Excel</td>
                                                                    <td width="6%" class="gredBg">Upload Excel</td>
                                                                    
                                                                    <td width="6%" class="gredBg">Edit</td>
                                                                    <td width="6%" class="gredBg">Delete</td>
                                                              	</tr>
																<?
                                                                    while($row=mysql_fetch_array($result_prj))
                                                                    {	
                                                                ?>
                                                                <tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?> class="text_1">
                                                                    <td align="center"><?=$sno?></td>
                                                                    <td align="center"><?=getBuyer('BuyerName','rec_id',$row['BuyerId'])?></td>
                                                                    <td align="center"><?=$row['PiNumber']?></td>
                                                                    <td align="center"><?=getDateFormate($row['PiDate'],1)?></td>
                                                                    <td align="center"><?=getBuyer('BuyerType','rec_id',$row['BuyerId'])?></td>
                                                                    <td align="center">
                                                                    <?
																	if($row['ConfirmFlag']==1)
																	{
																	?>	
                                                                    	<a href="dispatch.php?id=<?=$row["rec_id"]?>"><img src="images/Next.png" border="0" alt="Despatch" title="Despatch"/></a>
                                                                    <?
																	}
																	else
																	{
																		echo "PI Not Confirmed";
																	}	
																	?>
                                                                    </td>
                                                                    <td align="center">
                                                                   <?
																   if(getBuyer('BuyerType','rec_id',$row['BuyerId'])=='Export')
																   { 
																   ?>
                                                                    <a href="javascript:;" onClick="openWin('print_pi.php?id=<?=$row['rec_id']?>','850','800','yes','center');"><img src="images/print_icon.png" border="0" alt="Print PI" title="Print PI"/></a>
                                                                   <?
																   }
																   else if(getBuyer('BuyerType','rec_id',$row['BuyerId'])=='Domestic')
																   {
																   ?>
                                                                   <a href="javascript:;" onClick="openWin('print_domesticpi.php?id=<?=$row['rec_id']?>','850','800','yes','center');"><img src="images/print_icon.png" border="0" alt="Print PI" title="Print PI"/></a>
                                                                   <?
																   }
																   ?>
                                                                   	</td>
                                                                    
                                                                    <!--<td align="center"><a href="pi_pdf.php?pi_id=<?=$row['rec_id']?>&pdf=true"><img src="images/PDF_Icon.png" border="0" alt="PI PDF" title="PI PDF" /></a></td>-->
                                                                     <td align="center">
                                                                  <?
																  if($row['AttachedFile']!='')
																  {
																  	if(file_exists("pi_attachment/".$row['AttachedFile']))
																	{
																  ?>
                                                                  		<a href="download.php?file_id=<?=$row['AttachedFile']?>"><img src="images/Excel-icon.png" border="0" alt="PI Excel" title="PI Excel" /></a>
                                                                  <?	
																  	 }
																   }
																   else
																   {	 
																  
																	   if(getBuyer('BuyerType','rec_id',$row['BuyerId'])=='Export')
																	   { 
																	   ?>
																		 <a href="pi_exportexcel.php?pi_id=<?=$row['rec_id']?>"><img src="images/Excel-icon.png" border="0" alt="PI Excel" title="PI Excel" /></a>
																	   <?
																	   }
																	   else if(getBuyer('BuyerType','rec_id',$row['BuyerId'])=='Domestic')
																	   {
																	   ?>
																		  <a href="pi_domesticexcel.php?pi_id=<?=$row['rec_id']?>"><img src="images/Excel-icon.png" border="0" alt="PI Excel" title="PI Excel" /></a> 
																	   <?
																		}
																	}	
																		?>  
                                                                     </td>
                                                                     <td align="center">
                                                                        <a href="javascript:;" onClick="return hs.htmlExpand(this, {headingText: 'Upload XLS File', width: 400, height: 100 })"><img src="images/upload_icon.jpg" border="0" /></a>
                                                                        <div class="highslide-maincontent">
                                                                        	<form id="frm_upload" name="frm_upload" method="post" action="" style="display:inline" enctype="multipart/form-data">
                                                                                <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
                                                                                    <tr>
                                                                                        <td>
                                                                                            <input type="file" id="AttachedFile" name="AttachedFile" />
                                                                                        </td>
                                                                                        <td>
                                                                                            <input type="hidden" id="h_pi_id" name="h_pi_id" value="<?=$row["rec_id"]?>" />
                                                                                            <input type="submit" id="btn_upload" name="btn_upload" value="Upload" />
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                    	<td colspan="2" class="AddMore">
                                                                                        	<?
                                                                                            if($row['AttachedFile']!="")
                                                                                            {
                                                                                            	if(file_exists("pi_attachment/".$row['AttachedFile']))
																								{
																								?>
                                                                                                <a href="download.php?file_id=<?=$row['AttachedFile']?>">Download</a>
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
                                                                    <td align="center"><a href="add_pi.php?pi_id=<?=$row["rec_id"]?>"><img src="images/Modify.png" alt="Edit" title="Edit" border="0"></a></td>
                                                                    <td align="center">
                                                                      <a href="javascript:;" onClick="overlay(<?=$row["rec_id"]?>);"><img src="images/Delete.png" alt="Delete" title="Delete" border="0"></a>
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
          <p>Are you sure to delete this Puchase Invoice</p>
		  <form name="frm_del" action="<?=$_SERVER['PHP_SELF']?>" method="post">
		  <input type="hidden" name="hidden_overlay" id="hidden_overlay" value="" />
		  <input type="submit" name="btn_del" value="Yes" />
		  <input type="button" onClick="overlay();" name="btn_close" value="No" />
		  </form>
     </div>
</div>
<? 
include("inc/footer.php");
?>                          