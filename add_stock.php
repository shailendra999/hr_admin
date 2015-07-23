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


<script type="text/javascript" src="ajax/sack.js"></script>
<script type="text/javascript">
var ajax = new sack();

function whenLoading(){
	var e = document.getElementById('replaceme'); 
	//e.innerHTML = "<p>Sending Data...</p>";
}

function whenLoaded(){
	var e = document.getElementById('replaceme'); 
	//e.innerHTML = "<p>Data Sent...</p>";
}

function whenInteractive(){
	var e = document.getElementById('replaceme'); 
	//e.innerHTML = "<p>getting data...</p>";
}

function whenCompleted(){
	var e = document.getElementById('sackdata'); 
	if (ajax.responseStatus){
		var string = "<p>Status Code: " + ajax.responseStatus[0] + "</p><p>Status Message: " + ajax.responseStatus[1] + "</p><p>URLString Sent: " + ajax.URLString + "</p>";
	} else {
		var string = "<p>URLString Sent: " + ajax.URLString + "</p>";
	}
	//e.innerHTML = string;	
}

function doit(){
	var form = document.getElementById('form');
	
	
	for (i=0; i<form.getElementsByTagName("input").length; i++) 
	{
		if (form.getElementsByTagName("input")[i].type == "text")
		{

			ajax.setVar(form.getElementsByTagName("input")[i].name , form.getElementsByTagName("input")[i].value); // recomended method of setting data to be parsed.
		}
		if (form.getElementsByTagName("input")[i].type == "hidden")
		{
			ajax.setVar(form.getElementsByTagName("input")[i].name , form.getElementsByTagName("input")[i].value);
		}
	}
	
	ajax.requestFile = "count_stock_detail.php";
	ajax.method = "POST";
	ajax.element = 'replaceme';
	ajax.onLoading = whenLoading;
	ajax.onLoaded = whenLoaded; 
	ajax.onInteractive = whenInteractive;
	ajax.onCompletion = whenCompleted;
	ajax.runAJAX();
}
</script>
<?
//////////////////////// ************************** INSERT / UPDATE COUNT ************************ /////////////////////////

$msg = '';
$StockId = '';
$ProductId = '';
$CountId = '';
$StockInKgs = '';
$StockInBale = '';
$Date = '';
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
		$CountId = $_POST['CountId'];

		$IpAddress = $_SERVER['REMOTE_ADDR'];
		
		$StockId = $_POST['StockId'];
		$StockInKgs = $_POST['StockInKgs'];
		$StockInBale = $_POST['StockInBale'];
		$Date = getDateFormate($_POST['Date'],1);
		
		if($StockId == '')
		{
			
			
			$sql_ins = "insert into ".$mysql_adm_table_prefix."stock_master  set
																				CountId = '$CountId',
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
																				StockInKgs = '$StockInKgs',
																				StockInBale = '$StockInBale',
																				Date = '$Date'
																			where rec_id = '$StockId'";
		   $result_up = mysql_query($sql_up) or die("Error in : ".$sql_up."<br>".mysql_errno()." : ".mysql_error());
		   
		   $msg = "Stock Successfully Updated";		
		}	
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
                                                            <form name="frm_addstock" id="frm_addstock" action="" method="post">
                                                            <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0" class="border">
                                                            	<tr>
                                                                	<td align="left" class="text_1" style="padding-left:15px;"><b>Product Name</b></td>
                                                                    <td align="left" class="text_1" style="padding-left:15px;"><b>Count</b></td>
                                                                    <td align="left" class="text_1" style="padding-left:15px;"><b>Stock</b><span class="text_1">kg</span></td>
                                                                    <td align="left" class="text_1" style="padding-left:15px;"><b>Stock</b><span class="text_1">bale</span></td>
                                                                    <td align="left" class="text_1" style="padding-left:15px;"><b>Date</b></td>
                                                                </tr>
                                                                <tr>
                                                                    
                                                                    <td align="left" style="padding-left:15px;">
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
                                                                        <option value="<?=$row_product['rec_id']?>" <? if($row_product['rec_id']==$ProductId){?> selected="selected"<? } ?>><?=$row_product['ProductName']?></option>
                                                                        <?
                                                                        }
                                                                        }
                                                                        ?>
                                                                        </select>
                                                                  </td>
                                                              	
                                                                    
                                                                    <td align="left" style="padding-left:15px;">
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
                                                                	
                                                                    
                                                                    <td align="left" style="padding-left:15px;"><input type="text" name="StockInKgs" id="StockInKgs"  value="<?=$StockInKgs?>" style="width:150px; height:20px;"/></td>
                                                                	
                                                                    
                                                                    <td align="left" style="padding-left:15px;"><input type="text" name="StockInBale" id="StockInBale"  value="<?=$StockInBale?>" style="width:150px; height:20px;"/></td>
                                                                
                                                                	
                                                                    <td align="left" style="padding-left:15px;"><input type="text" name="Date" id="Date" value="<?=$Date?>" style="width:150px; height:22px;"/>
                                                                    <a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.frm_addstock.Date);return false;" HIDEFOCUS>
                                                                          <img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt=""></a>    </td>
                                                                
                                                                    <td colspan="2" align="center" style="padding-top:5px;">
                                                                        <input type="submit" name="btn_submit" id="btn_submit" value="submit" />
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
                                        	<td width="40%" style="border-right:1px dashed #666666;" valign="top">
                                            	<script type="text/javascript" src="javascript/jquery.min.js"></script>
												<script type="text/javascript" src="javascript/ddaccordion.js">
                                                
                                                /***********************************************
                                                * Accordion Content script- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
                                                * Visit http://www.dynamicDrive.com for hundreds of DHTML scripts
                                                * This notice must stay intact for legal use
                                                ***********************************************/
                                                
                                                </script>
                                                
                                                <style type="text/css">
                                                .categoryitems{display: none}
                                                </style>
                                                <script type="text/javascript">
                                                
                                                
                                                ddaccordion.init({
                                                    headerclass: "expandable", //Shared CSS class name of headers group that are expandable
                                                    contentclass: "categoryitems", //Shared CSS class name of contents group
                                                    revealtype: "click", //Reveal content when user clicks or onmouseover the header? Valid value: "click", "clickgo", or "mouseover"
                                                    mouseoverdelay: 200, //if revealtype="mouseover", set delay in milliseconds before header expands onMouseover
                                                    collapseprev: true, //Collapse previous content (so only one open at any time)? true/false 
                                                    defaultexpanded: [], //index of content(s) open by default [index1, index2, etc]. [] denotes no content
                                                    onemustopen: false, //Specify whether at least one header should be open always (so never all headers closed)
                                                    animatedefault: false, //Should contents open by default be animated into view?
                                                    persiststate: false, //persist state of opened contents within browser session?
                                                    toggleclass: ["", "openheader"], //Two CSS classes to be applied to the header when it's collapsed and expanded, respectively ["class1", "class2"]
                                                    togglehtml: ["prefix", "", ""], //Additional HTML added to the header when it's collapsed and expanded, respectively  ["position", "html1", "html2"] (see docs)
                                                    animatespeed: "fast", //speed of animation: integer in milliseconds (ie: 200), or keywords "fast", "normal", or "slow"
                                                    oninit:function(headers, expandedindices){ //custom code to run when headers have initalized
                                                        //do nothing
                                                    },
                                                    onopenclose:function(header, index, state, isuseractivated){ //custom code to run whenever a header is opened or closed
                                                        //do nothing
                                                    }
                                                })
                                                
                                                
                                                </script>
                                            
                                            	<div id="emp_list" style="height:230px;">
												<?
                                                $sql_product = "select * from ".$mysql_adm_table_prefix."product_master";
                                                $result_product = mysql_query($sql_product) or die("Error in Query:".$sql_product."<br>".mysql_errno().":".mysql_error());
                                                if(mysql_num_rows($result_product)>0)	
                                                {   
                                                while($row_product=mysql_fetch_array($result_product))
                                                {
                                                ?>
                                            <div class="emp_snb expandable"><?=$row_product['ProductName']?></div>
                                            <div class="categoryitems subLinks"  style="overflow:auto; height:200px;">
                                            <?
                                            $sql_count = "select * from ".$mysql_adm_table_prefix."count_master where ProductId='".$row_product["rec_id"]."'";
											$result_count = mysql_query($sql_count) or die("Error in Query:".$sql_count."<br>".mysql_errno().":".mysql_error());
											if(mysql_num_rows($result_count)>0)	
											{   
											while($row_count=mysql_fetch_array($result_count))
											{
											?>
                                            <div class="snb_sublink"><img src="images/red_bullet.png"/>
                                            <a href="javascript:;" onclick="get_frm('count_stock_detail.php','<?=$row_count['rec_id']?>','div_detail','')"><?=$row_count['Count']?></a></div>
                                            
                                            <?
											}
											}
											?>
                                            </div>
                                                <?
                                                }
                                                }
                                                ?>
                                            </div>
                                            </td>
                                           
                                            <td valign="top" width="60%">
                                            	<div id="div_detail" style="height:230px; overflow:auto"></div>&nbsp;
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
                                                                      <td width="6%" class="gredBg">S. No.</td>
                                                                   	  <td width="16%" class="gredBg">Product</td>
                                                                   	  <td width="20%" class="gredBg">Count</td>
                                                                      <td width="17%" class="gredBg">Stock In Kg</td>
                                                                      <td width="18%" class="gredBg">Stock In Bale</td>
                                                                      <td width="18%" class="gredBg">Date</td>
                                                                      <td width="18%" class="gredBg">Type</td>
                                                                   	  <td width="11%" class="gredBg">Edit</td>
                                                                   	  <td width="12%" class="gredBg">Delete</td>
                                                                  </tr>
																	<?
                                                                        while($row=mysql_fetch_array($result_prj))
                                                                        {	
                                                                    ?>
                                                                    <tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
                                                                        <td align="center" class="tableText"><?=$sno?></td>
                                                                        <td align="center" class="tableText"><?=getProduct('ProductName','rec_id',getCount("ProductId","rec_id", $row["CountId"]))?></td>
                                                                        <td align="center" class="tableText"><?=getCount("Count","rec_id", $row["CountId"]);?></td>
                                                                        <td align="center" class="tableText"><?=$row['StockInKgs']?>&nbsp;Kg</td>
                                                                        <td align="center" class="tableText"><?=$row['StockInBale']?>&nbsp;Bale</td>
                                                                        <td align="center" class="tableText"><?=$row["Date"]?></td>
                                                                        <td align="center" class="tableText"><? if($row["Flag"]){?>-<? }else{?>+<? }?></td>
                                                                        <td align="center"><a href="add_stock.php?StockId=<?=$row["rec_id"]?>">
                                                                        	<img src="images/Modify.png" alt="Edit" title="Edit" border="0"></a>
                                                                        </td>
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