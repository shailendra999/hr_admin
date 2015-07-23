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
		$IpAddress = $_SERVER['REMOTE_ADDR'];
		$field_counter = $_POST['field_counter'];
		for($i=0; $i<$field_counter; $i++)
		{
			$CountId = $_POST['CountId_'.$i];
			$StockInKgs = $_POST['StockInKgs_'.$i];
			$StockInBale = $_POST['StockInBale_'.$i];
			$Date = $_POST['Date'];
			if($StockInKgs!="")
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
			}
		}
		$Date = getDateFormate($Date,1);
		$msg = "Stock Successfully Inserted";
			
		$_SESSION['no_refresh'] = $_POST['no_refresh'];
	}
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
                                                        	<?
                                                            if(isset($_POST["button_check"]))
															{
																$Date = $_POST["Date"];
															}
                                                            ?>
                                                            <form name="frm_stock_check" id="frm_stock_check" action="" method="post">
                                                            
                                                            <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0" class="border">
                                                            	<tr>
                                                                	<td colspan="5">
                                                                    	<input type="text" name="Date" id="Date" value="<?=$Date?>" style="width:150px; height:22px;"/>
                                                                    	<a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.frm_stock_check.Date);return false;" HIDEFOCUS><img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt=""></a>
                                                                    	<input type="submit" id="button_check" name="button_check" value="Check">    
                                                                    </td>
                                                                    	
                                                                </tr>
															</table>
                                                            </form>
                                                            <?
                                                            if(isset($_POST["button_check"]))
															{
																$Date = getDateFormate($_POST["Date"],1);
                                                            ?>
															<form name="frm_addstock" id="frm_addstock" action="" method="post">
                                                            <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0" class="border">
                                                            	<tr>
                                                                    <td align="left" class="text_1" style="padding-left:5px;"><b>Count</b></td>
                                                                    <td align="left" class="text_1" style="padding-left:5px;"><b>Total Stock</b><span class="text_1">kg</span></td>
                                                                    <td align="left" class="text_1" style="padding-left:5px;"><b>Total Stock</b><span class="text_1">bale</span></td>
                                                                    <td align="left" class="text_1" style="padding-left:5px;"><b>Stock</b><span class="text_1">kg</span></td>
                                                                    <td align="left" class="text_1" style="padding-left:5px;"><b>Stock</b><span class="text_1">bale</span></td>
                                                                </tr>
                                                                
																<?
                                                                $sql_product = "select * from ".$mysql_adm_table_prefix."product_master";
                                                                $result_product = mysql_query($sql_product) or die("Error in Query:".$sql_product."<br>".mysql_errno().":".mysql_error());
                                                                if(mysql_num_rows($result_product)>0)	
                                                                { 
																	$i=0;  
																	while($row_product=mysql_fetch_array($result_product))
																	{
																		$sql_count = "select * from ".$mysql_adm_table_prefix."count_master where ProductId='".$row_product["rec_id"]."'";
																		$result_count = mysql_query($sql_count) or die("Error in Query:".$sql_count."<br>".mysql_errno().":".mysql_error());
																		if(mysql_num_rows($result_count)>0)	
																		{   
																			
																			while($row_count=mysql_fetch_array($result_count))
																			{
																				if(getStockDetailByDate("CountId", "CountId", $row_count["rec_id"], $Date)=="")
																				{
																				$IStockInKgs = $row_count['StockInKgs'] + getStockDetailWithFlag("StockInKgs", "CountId", $row_count["rec_id"], 0) - getStockDetailWithFlag("StockInKgs", "CountId", $row_count["rec_id"], 1);
																				$IStockInBale = $row_count['StockInBale'] + getStockDetailWithFlag("StockInBale", "CountId", $row_count["rec_id"], 0) - getStockDetailWithFlag("StockInBale", "CountId", $row_count["rec_id"], 1);
																		?>
																		
                                                                        
                                                                <tr>
                                                                	
                                                                    <td  style="padding-left:5px;">
                                                                    	<div class="snb_sublink"><img src="images/red_bullet.png"/>
																		<?=$row_count['Count']?>
                                                                        <input name="CountId_<?=$i?>" type="hidden" id="CountId_<?=$i?>" value="<?=$row_count["rec_id"]?>" />
                                                                        
                                                                        </div>
                                                                    </td>
                                                                    
                                                                	<td  style="padding-left:5px;">
                                                                    	<input type="text" name="IStockInKgs" id="IStockInKgs"  value="<?=$IStockInKgs?>" style="width:150px; height:20px;" readonly="readonly"/>
                                                                    </td>
                                                                    <td  style="padding-left:5px;">
                                                                    	<input type="text" name="IStockInBale" id="IStockInBale"  value="<?=$IStockInBale?>" style="width:150px; height:20px;" readonly="readonly"//>
                                                                    </td>
                                                                    
                                                                    <td align="left" style="padding-left:5px;"><input type="text" name="StockInKgs_<?=$i?>" id="StockInKgs_<?=$i?>"  value="" style="width:150px; height:20px;"/></td>
                                                                	
                                                                    
                                                                    <td align="left" style="padding-left:5px;"><input type="text" name="StockInBale_<?=$i?>" id="StockInBale_<?=$i?>"  value="" style="width:150px; height:20px;"/></td>
                                                                
                                                                	
                                                                    
                                                                
                                                                    
                                                                </tr>
																		
																		<?
																				$i++;
																				}
																			}
																		}
                                                                	}
                                                                }
                                                                ?>
                                                                <tr>
                                                                	<td colspan="2" align="center" style="padding-top:5px;">
                                                                        <input name="field_counter" type="hidden" id="field_counter" value="<?=$i;?>" />
                                                                        <input type="hidden" name="Date" id="Date" value="<?=$Date?>" style="width:150px; height:22px;"/>
                                                                        <input type="hidden" name="StockId" id="StockId" value="<?=$StockId?>" />
                                                                        <input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
                                                                        <input type="submit" name="btn_submit" id="btn_submit" value="submit" />
                                                                    </td>
                                                                </tr>
                                                                 
                                                            </table>
                                                            </form>
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