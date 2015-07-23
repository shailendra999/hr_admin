<?
include("inc/adm0_header.php");
$msg="";
?>
<script type="text/javascript" src="javascript/form.js"></script>
<script type="text/javascript" src="javascript/popup.js"></script>
<script language="JavaScript1.2">
function valid_form(form)
{
	return(
				 checkString(form.elements["txt_product"],"Select Product",false)										
		   );
}
</script>

<script type="text/javascript" src="highslide/highslide-with-html.js"></script>
<link rel="stylesheet" type="text/css" href="highslide/highslide.css" />
<script type="text/javascript">
hs.graphicsDir = 'highslide/graphics/';
hs.outlineType = 'rounded-white';
hs.wrapperClassName = 'draggable-header';
</script>
<script type="text/javascript" src="ajax/common_function.js"></script>
<script type="text/javascript" src="ajax/sack.js"></script>
<script type="text/javascript">
var ajax = new sack();
var ajax1 = new sack();
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
function whenCompleted1(){
	var e = document.getElementById('sackdata'); 
	if (ajax1.responseStatus){
		var string = "<p>Status Code: " + ajax1.responseStatus[0] + "</p><p>Status Message: " + ajax1.responseStatus[1] + "</p><p>URLString Sent: " + ajax1.URLString + "</p>";
	} else {
		var string = "<p>URLString Sent: " + ajax1.URLString + "</p>";
	}
	//e.innerHTML = string;	
	
}
function doit(count, mode){
	
	var form = document.getElementById('frm_add_stock_'+count);
	ajax1.setVar("count" , count);
	
	if(document.getElementById("LotNumber_"+count).value == "")
	{
		Popup.showModal('modal',null,null,{'screenColor':'#99ff99','screenOpacity':.6},"Please Enter LotNumber");return false;
		document.getElementById("LotNumber_"+count).focus();
		document.getElementById("LotNumber_"+count).value="";
		
		return false;
	}
	
	if(document.getElementById("NumberOfBags_"+count).value == "")
	{
		Popup.showModal('modal',null,null,{'screenColor':'#99ff99','screenOpacity':.6},"Please Enter NumberOfBags");return false;
		document.getElementById("NumberOfBags_"+count).focus();
		document.getElementById("NumberOfBags_"+count).value="";
		return false;
	}
	else
	{
		if(!checkInteger(document.getElementById("NumberOfBags_"+count), "Eneter Only Numeric Value", false))
		{
			document.getElementById("NumberOfBags_"+count).value="";
			return false;
		}
	}
	
	/*if(document.getElementById("StockInKgs_"+count).value == "")
	{
		Popup.showModal('modal',null,null,{'screenColor':'#99ff99','screenOpacity':.6},"Please Enter StockInKgs");return false;
		document.getElementById("StockInKgs_"+count).focus();
		document.getElementById("StockInKgs_"+count).value="";
		return false;
	}
	else
	{
		if(!checkInteger(document.getElementById("StockInKgs_"+count), "Eneter Only Numeric Value", false))
		{
			document.getElementById("StockInKgs_"+count).value="";
			return false;
		}
	}*/
	
	if(mode=="New")
	{
		ajax1.setVar("h_rec_id_"+count , "");
	}
	else
	{
		//alert(document.getElementById("h_rec_id_"+count).value);
		ajax1.setVar("h_rec_id_"+count , document.getElementById("h_rec_id_"+count).value);
		ajax1.setVar("StockId" , document.getElementById("h_rec_id_"+count).value);
		
	}
	
	
	
	
	ajax1.setVar("h_count_id_"+count , document.getElementById("h_count_id_"+count).value);
	ajax1.setVar("LotNumber_"+count , document.getElementById("LotNumber_"+count).value);
	ajax1.setVar("NumberOfBags_"+count , document.getElementById("NumberOfBags_"+count).value);
	//ajax.setVar("StockInKgs_"+count , document.getElementById("StockInKgs_"+count).value);
	ajax1.setVar("Date_"+count , document.getElementById("Date_"+count).value);
	ajax1.setVar("btn_upload_new_"+count , document.getElementById("btn_upload_new_"+count).value);
	
	ajax1.requestFile = "add_stock_detail.php";
	ajax1.method = "POST";
	ajax1.element = 'replaceme_'+count;
	ajax1.onLoading = whenLoading;
	ajax1.onLoaded = whenLoaded; 
	ajax1.onInteractive = whenInteractive;
	ajax1.onCompletion = whenCompleted;
	ajax1.runAJAX();
	
	
}
function getTotal1(count)
{	
		get_frm('get_new_stock.php',document.getElementById("h_count_id_"+count).value+'&Date='+document.getElementById("Date_"+count).value+'&count='+count,'div_stock_'+count);
}
function getTotal(count)
{
	
	
	document.getElementById('TotalStock_'+count).innerHTML = parseFloat(document.getElementById('IStockInKgs_'+count).value) + parseFloat(document.getElementById('div_stock_'+count).innerHTML);
	
}
function checkAll() 
{ 
	var count = 1;
	document.frm_dispatch.txtFromNumber.value = count;
	var varTotalKgs = 0;
	for(var i=0; i<document.frm_dispatch.cbNumberOfBags.length; i++)
	{
		if(document.frm_dispatch.cbAllNumberOfBags.checked)
		{
			document.frm_dispatch.cbNumberOfBags[i].checked = true;
			document.getElementById("NoOfPck").value = count;
			document.frm_dispatch.txtToNumber.value = count;

			varTotalKgs = varTotalKgs + parseFloat(document.frm_dispatch.txtNumberOfBags[i].value);
		}
		else
		{
			document.frm_dispatch.cbNumberOfBags[i].checked = false;
			document.getElementById("NoOfPck").value = "";
			document.getElementById("TotalKgs").value = "";
			document.frm_dispatch.txtFromNumber.value = "";
			document.frm_dispatch.txtToNumber.value = "";
		}
		
		count++;
	}
	document.getElementById("TotalKgs").value = varTotalKgs.toFixed(0);
}
function UpdateBoxKgs1()
{
	var varTotalKgs = 0;
	for(var i=0; i<document.frm_dispatch.txtNumberOfBags.length; i++)
	{
		varTotalKgs = varTotalKgs + parseFloat(document.frm_dispatch.txtNumberOfBags[i].value);
	}
	document.getElementById("TotalKgs").value = varTotalKgs.toFixed(0);
	var CalculateKgs = 0;
	for(var i=0; i< document.frm_dispatch.cbNumberOfBags.length; i++)
	{
		//if(document.frm_dispatch.cbNumberOfBags[i].checked)
		if(document.frm_dispatch.txtNumberOfBags[i].value!="0")
		{
			CalculateKgs = CalculateKgs +  parseFloat(document.frm_dispatch.txtNumberOfBags[i].value);
		}
		
	}
	document.getElementById("txtCalculateKgs").value = CalculateKgs.toFixed(0);
}
function UpdateBoxKgs()
{
	//if(document.getElementById("cbAutoCalculation").checked)
	{
		
		/*for(var i=0; i< document.frm_dispatch.cbNumberOfBags.length; i++)
		{
			//if(document.frm_dispatch.cbNumberOfBags[i].checked)
			{
				document.frm_dispatch.txtNumberOfBags[i].value = 0;
				document.frm_dispatch.cbNumberOfBags[i].checked = false;
			}
			
		}*/
		
		
		var count = 1;
	
		FromNumber = document.frm_dispatch.txtFromNumber.value;
		
		ToNumber = document.frm_dispatch.txtToNumber.value;
		
		if(FromNumber > document.frm_dispatch.cbNumberOfBags.length)
		{
			document.frm_dispatch.txtFromNumber.value = "";
			alert("Box Not Exist");
			return false;
		}
		if(ToNumber > document.frm_dispatch.cbNumberOfBags.length)
		{
			document.frm_dispatch.txtToNumber.value = "";
			alert("Box Not Exist");
			return false;
		}
		
		var NumberOfBags = 0;
		var TotalKgs = 0;
		for(var i=FromNumber-1; i<ToNumber; i++)
		{
			document.frm_dispatch.cbNumberOfBags[i].checked = true;
	
			if(document.frm_dispatch.cbNumberOfBags[i].checked)
			{
				document.frm_dispatch.txtNumberOfBags[i].value = document.getElementById("txtBoxKgs").value;
				NumberOfBags = NumberOfBags + parseFloat(document.getElementById("txtBoxKgs").value);
				TotalKgs = TotalKgs +  parseFloat(document.frm_dispatch.txtNumberOfBags[i].value);
				//document.getElementById("TotalKgs").value = (document.frm_dispatch.txtNumberOfBags[i].value * count).toFixed(2);
			}
			count++;
		}
		var count1 = 0;
		for(var i=0; i< document.frm_dispatch.cbNumberOfBags.length; i++)
		{
			
			if(!document.frm_dispatch.cbNumberOfBags[i].checked)
			{
				count1++;
			}
			
		}
		
		var StockInKgs = parseFloat(document.getElementById("StockInKgs").value)
		
		/*for(var i=0; i< document.frm_dispatch.cbNumberOfBags.length; i++)
		{
			if(!document.frm_dispatch.cbNumberOfBags[i].checked)
			{
				document.frm_dispatch.txtNumberOfBags[i].value = ((StockInKgs - NumberOfBags)/count1).toFixed(2);
				TotalKgs = TotalKgs +  parseFloat(document.frm_dispatch.txtNumberOfBags[i].value);
			}
			
		}*/
		
		document.getElementById("TotalKgs").value = TotalKgs.toFixed(0);
		var CalculateKgs = 0;
		for(var i=0; i< document.frm_dispatch.cbNumberOfBags.length; i++)
		{
			//if(document.frm_dispatch.cbNumberOfBags[i].checked)
			if(document.frm_dispatch.txtNumberOfBags[i].value!="0")
			{
				CalculateKgs = CalculateKgs +  parseFloat(document.frm_dispatch.txtNumberOfBags[i].value);
			}
			
		}
		document.getElementById("txtCalculateKgs").value = CalculateKgs.toFixed(0);
		
	}
}

function doit1(count, mode){
	
	var form = document.getElementById('frm_dispatch');
	ajax.setVar("count1" , count);
	ajax.setVar("Date_"+count , document.getElementById("Date_"+count).value);
	ajax.setVar("h_count_id_"+count , document.getElementById("h_count_id_"+count).value);
	ajax.setVar("btn_bag_submit" , document.getElementById("btn_bag_submit").value);
	ajax.setVar("NoOfPck" , document.getElementById("NoOfPck").value);
	ajax.setVar("BoxKgs" , document.getElementById("BoxKgs").value);
	ajax.setVar("TotalKgs" , document.getElementById("TotalKgs").value);
	ajax.setVar("StockInKgs" , document.getElementById("StockInKgs").value);
	ajax.setVar("txtBoxKgs" , document.getElementById("txtBoxKgs").value);
	
	
	
	for(var i=0; i<document.frm_dispatch.BagNumber.length; i++)
	{
		ajax.setVar("BagNumber["+i+"]" , document.frm_dispatch.BagNumber[i].value);
		//ajax.setVar("BagWeight["+i+"]" , document.frm_dispatch.cbNumberOfBags[i].value);
		ajax.setVar("txtNumberOfBags["+i+"]" , document.frm_dispatch.txtNumberOfBags[i].value);
	}
	//alert(document.getElementById("TotalKgs").value);
	//alert(document.getElementById("StockInKgs").value);
	
	for(var i=0; i< document.frm_dispatch.txtNumberOfBags.length; i++)
	{
		if(document.frm_dispatch.txtNumberOfBags[i].value == "")
		{
			alert( "Box " + (i + 1) +  " Can Not Be 0");
			document.frm_dispatch.txtNumberOfBags[i].focus();
			return false;
			break;
		}
		else if(document.frm_dispatch.txtNumberOfBags[i].value == "0")
		{
			alert( "Box " + (i + 1) +  " Can Not Be 0");
			document.frm_dispatch.txtNumberOfBags[i].focus();
			return false;
			break;
		}
	}
	
	ajax.setVar("StockId" , document.getElementById("StockId").value);
	ajax.requestFile = "add_stock_detail.php";
	ajax.method = "POST";
	ajax.element = 'replaceme_'+count;
	ajax.onLoading = whenLoading;
	ajax.onLoaded = whenLoaded; 
	ajax.onInteractive = whenInteractive;
	ajax.onCompletion = whenCompleted;
	ajax.runAJAX();
	

	setTimeout('getTotal1('+count+')',1000);
	
	setTimeout('getTotal('+count+')',1500);
	hs.close();
}
</script>

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
                                                <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
                                                    <tr>
                                                        <td valign="middle" style="padding-top:10px;">
                                                            <?
                                                            $prdid = "";
                                                            if(isset($_POST["button_check_x"]))
                                                            {
                                                                $Date = $_POST["Date"];
                                                                $prdid = $_POST["txt_product"];
                                                            }
                                                            else
                                                            {
                                                                $Date = date('d-m-Y');
                                                            }
                                                            ?>
                                                            <form name="frm_stock_check" id="frm_stock_check" action="" method="post" onsubmit="return valid_form(this)">
                                                            <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0" style="border:1px solid #C6B4AE;" bgcolor="#EAE3E1">
                                                                <tr height="50" class="text_1">
                                                                    <td align="center"><B>Product</B>&nbsp;&nbsp;
                                                                        <?    
                                                                        $sql_prd = "select * from ".$mysql_adm_table_prefix."product_master order by ProductName";
                                                                        $result_prd = mysql_query ($sql_prd) or die ("Error in : ".$sql_prd."<br>".mysql_errno()." : ".mysql_error());
                                                                        ?>    
                                                                        <select name="txt_product" id="txt_product" style="width:150px;">
                                                                            <option value="">--select--</option>
                                                                            <?
																			if(mysql_num_rows($result_prd)>0)
																			{ 
																				while ($row_prd = mysql_fetch_array($result_prd))
																				{
                                                                            ?>
                                                                            <option value="<?=$row_prd['rec_id']?>"<? if($row_prd['rec_id']==$prdid){?> selected="selected"<? }?>><?=$row_prd["ProductName"]?></option>
                                                                            <?
																				}
                                                                            }
                                                                            ?>
                                                                        </select>
																	</td>
                                                                    <td>
                                                                        <input type="text" name="Date" id="Date" value="<?=$Date?>" style="width:150px; height:22px;"/>
                                                                        <a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.frm_stock_check.Date);return false;" HIDEFOCUS><img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt=""></a>
                                                                    </td>
                                                                    <td>
                                                                        <input type="image" src="images/btn_submit.png" name="button_check" id="button_check" value="submit" />    
                                                                    </td>
                                                              	</tr>
                                                            </table>
                                                            </form>
                                                            <?
                                                            if(isset($_POST["button_check_x"]))
                                                            {
                                                                $Date = getDateFormate($_POST["Date"],1);
                                                                $prdid = $_POST["txt_product"];
                                                            ?>
                                                            
                                                            <table align="center" width="100%" cellpadding="1" cellspacing="1" border="0" class="border">
                                                                <tr class="text_1" bgcolor="#EAE3E1">
                                                                    <td align="center"><b>Count</b></td>
                                                                    <td align="center"><b>Opening Stock</b>&nbsp;Kg</td>
                                                                  	<!--<td align="center"><b>Opening Stock</b>Packs</td>-->
                                                                    <td align="center"><b>Today Stock</b>&nbsp;Kg</td>
                                                                    <td align="center"><b>Closing Stock</b>&nbsp;kg</td>
                                                                  <td align="center"><b>Lot Detail</b></td>
                                                                </tr>
                                                                <?
                                                                $sql_product = "select * from ".$mysql_adm_table_prefix."product_master where rec_id = '$prdid'";
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
                                                                            $j=0;
                                                                            while($row_count=mysql_fetch_array($result_count))
                                                                            {
																				$IStockInKgs = getOpeningStock("CountId", $row_count["rec_id"], $Date);	
																?>
                                                                <tr <? if ($i%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
                                                                    <td class="snb_sublink">
                                                                        <div ><img src="images/red_bullet.png"/>
                                                                        <?=$row_count['Count']?>
                                                                        <input name="CountId_<?=$i?>" type="hidden" id="CountId_<?=$i?>" value="<?=$row_count["rec_id"]?>" />
                                                                        
                                                                        </div>
                                                                    </td>
                                                                    
                                                                    <td align="center" style="padding-left:75px; vertical-align:top">
                                                                        <div class="text_1"><input type="hidden" name="IStockInKgs_<?=$i?>" id="IStockInKgs_<?=$i?>" value="<?=$IStockInKgs?>" style="width:150px; height:20px;" readonly="readonly"/><?=$IStockInKgs?>
                                                                        
                                                                        </div>
                                                                    </td>
                                                                    <!--<td  style="padding-left:5px;">
                                                                        <input type="hidden" name="IStockInBale" id="IStockInBale"  value="" style="width:150px; height:20px;" readonly="readonly"/>
                                                                    </td>-->
                                                                    <td align="center"class="text_1">
                                                                        <div id="div_stock_<?=$i?>" style="text-align:center; vertical-align:top">
                                                                        <?
                                                                        $sql_stock = "SELECT SUM(StockInKgs) as TotalNewStock FROM  ".$mysql_adm_table_prefix."stock_master where CountId = '".$row_count["rec_id"]."' and Date = '$Date' order by Date ";
                                                                        $result_stock = mysql_query($sql_stock) or die("Error in Query:".$sql_stock."<br>".mysql_errno().":".mysql_error());
                                                                        if(mysql_num_rows($result_stock)>0)	
                                                                        {
																			$row_stock=mysql_fetch_array($result_stock);
																			
																			if($row_stock["TotalNewStock"]=="")
																			{
																				echo "0";
																			}
																			else
																			{
																				echo $row_stock["TotalNewStock"];
																			}
																			$IStockInKgs = $IStockInKgs + $row_stock["TotalNewStock"];
                                                                        }
																		
                                                                        ?>
                                                                        </div>
                                                                    </td>
                                                                    <td align="center">                                                   	
                                                                        <!--<input type="text" name="TotalStock_<?=$i?>" id="TotalStock_<?=$i?>"  value="<?=$IStockInKgs?>" style="width:150px; height:20px;" readonly="readonly"//>-->
                                                                        <span id="TotalStock_<?=$i?>" class="text_1"><?=$IStockInKgs?></span>
                                                                    </td>
                                                                    <td align="center">
                                                                        <a href="javascript:;" onClick="return hs.htmlExpand(this, {headingText: 'Lot Detail', width: 750, height: 500 })"><img src="images/lot_number_icon.png" border="0" /></a> 
                                                                        <div class="highslide-maincontent">
                                                                            <form id="frm_add_stock_<?=$i?>" name="frm_add_stock_<?=$i?>" method="post" action="add_stock_detail.php" style="display:inline">
                                                                                <div id="div_<?=$i?>" style="background-color:#EAE3E1; border:1px solid #C6B4AE;">
                                                                                    <table align="center" width="40%" cellpadding="2" cellspacing="2">
                                                                                        <tr class="text_1">
                                                                                            <td align="center"><b>Lot Number</b></td>
                                                                                            <td align="center">
                                                                                                <input type="text" id="LotNumber_<?=$i?>" name="LotNumber_<?=$i?>" value="">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="text_1">
                                                                                            <td align="center"><b>Number Of Bags</b></td>
                                                                                            <td align="center">
                                                                                                <input type="text" id="NumberOfBags_<?=$i?>" name="NumberOfBags_<?=$i?>" value="">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <!--<tr class="text_1">
                                                                                            <td align="center"><b>Stock In Kgs</b></td>
                                                                                            <td align="center">
                                                                                                <input type="text" id="StockInKgs_<?=$i?>" name="StockInKgs_<?=$i?>" value="">
                                                                                            </td>
                                                                                        </tr>-->
                                                                                        <tr>
                                                                                            <td colspan="2" align="center">
                                                                                                <input type="hidden" id="h_count_id_<?=$i?>" name="h_count_id_<?=$i?>" value="<?=$row_count["rec_id"]?>" />
                                                                                                <input type="hidden" id="h_rec_id_<?=$i?>" name="h_rec_id_<?=$i?>" value="" />
                                                                                                
                                                                                                <input type="hidden" id="Date_<?=$i?>" name="Date_<?=$i?>" value="<?=$Date?>" />
                                                                                                
                                                                                                <!--<input type="submit" id="btn_upload_<?=$i?>" name="btn_upload_<?=$i?>" value="Update" onClick="doit(<?=$i?>,'Update'); return false;" />-->
                                                                                                <input type="submit" id="btn_upload_new_<?=$i?>" name="btn_upload_new_<?=$i?>" value="New" onClick="doit(<?=$i?>,'New'); return false;" />
                                                                                            </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </div>
                                                                            </form>
                                                                            <div id="replaceme_<?=$i?>" style="vertical-align:top;">
                                                                                <?
                                                                                $CountId = $row_count["rec_id"];
                                                                                $sql_stock = "SELECT * FROM  ".$mysql_adm_table_prefix."stock_master where CountId = '$CountId' and Date = '$Date' order by Date ";
                                                                                $result_stock = mysql_query($sql_stock) or die("Error in Query:".$sql_stock."<br>".mysql_errno().":".mysql_error());
                                                                                if(mysql_num_rows($result_stock)>0)	
                                                                                {
                                                                                ?>
                                                                                    <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0" class="border">
                                                                                        <tr>
                                                                                            <td colspan="7" class="blackHead">Stock Detail</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td align="center">
                                                                                            <span class="text_1"><b>Lot Number</b></span>
                                                                                            </td>
                                                                                            <td align="center">
                                                                                            <span class="text_1"><b>Number Of Bags</b></span>
                                                                                            </td>
                                                                                            <td align="center">
                                                                                            <span class="text_1"><b>Stock In Kgs</b></span>
                                                                                            </td>
                                                                                            <td>
                                                                                                <span class="text_1"><b>Edit</b></span>
                                                                                            </td>
                                                                                            <!--<td align="center">
                                                                                                <span class="text_1"><b>Copy</b></span>
                                                                                            </td>-->
                                                                                            <td align="center">
                                                                                                <span class="text_1"><b>Switch</b></span>
                                                                                            	
                                                                                            </td>
                                                                                        </tr>
                                                                                        <?
																						
                                                                                        while($row_stock=mysql_fetch_array($result_stock))
                                                                                        {
                                                                                        ?>
                                                                                        <tr>
                                                                                            <td align="center">
        	                                                                                    <span class="text_1"><?=$row_stock["LotNumber"]?></span>
                                                                                            </td>
                                                                                            <td align="center">
    	                                                                                        <span class="text_1"><?=$row_stock["NumberOfBags"]?></span>
                                                                                            </td>
                                                                                            <td align="center">
	                                                                                            <span class="text_1"><?=$row_stock["StockInKgs"]?></span>
                                                                                            </td>
                                                                                            <td align="center">
                                                                                                <a href="javascript:;" onclick="get_frm('get_lot_detail.php','<?=$row_stock["rec_id"]?>&i=<?=$i?>&CountId=<?=$CountId?>&Date=<?=$Date?>','div_<?=$i?>'); get_frm2('get_stock_list.php','<?=$row_stock["rec_id"]?>&i=<?=$i?>&CountId=<?=$CountId?>&Date=<?=$Date?>','replaceme_<?=$i?>');"><img src="images/Modify.png" alt="Update" title="Update" border="0"></a>
                                                                                            </td>
                                                                                            
                                                                                            <!--<td align="center">
                                                                                            	<?
																								if($row_stock["SwitchedFrom"]=="")
																								{
																								?>
                                                                                            
                                                                                                <img src="images/Next.png" border="0" onclick="return hs.htmlExpand(this, {headingText: 'Switch Category', width: 500, height: 400 })" />
                                                                                                
                                                                                                <div class="highslide-maincontent">
                                                                                                    <table align="center" class="border" width="100%">
                                                                                                        <tr>
                                                                                                            <td class="text_1">Switch Category</td>
                                                                                                            <td class="text_1">
                                                                                                            <?    
                                                                                                            $sql_prd = "select * from ".$mysql_adm_table_prefix."product_master order by ProductName";
                                                                                                            $result_prd = mysql_query ($sql_prd) or die ("Error in : ".$sql_prd."<br>".mysql_errno()." : ".mysql_error());
                                                                                                            ?>    
                                                                                                                <select name="txt_product" id="txt_product" style="width:150px;">
                                                                                                                    <option value="">--select--</option>
                                                                                                                <? 
                                                                                                                while ($row_prd = mysql_fetch_array($result_prd))
                                                                                                                {
                                                                                                                ?>
                                                                                                                    <option value="<?=$row_prd['rec_id']?>"<? if($row_prd['rec_id']==$prdid){?> selected="selected"<? }?>>
                                                                                                                    <?=$row_prd["ProductName"]?>
                                                                                                                    </option>
                                                                                                                <?
                                                                                                                }
                                                                                                                ?>
                                                                                                                </select>
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                <input type="image" src="images/Next.png" id="btn_switch_category" name="btn_switch_category" value="Switch Category" onclick="get_frm('get_switch_stock.php','<?=$row_stock["rec_id"]?>', 'div_switch_<?=$j?>');" />
	                                                                                                            
                                                                                                            </td>
                                                                                                            <td>
                                                                                                            	<div id="div_switch_<?=$j?>"></div>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                     </table>       
                                                                                                </div>
                                                                                                <?
																								$j++;
																								}
																								?>
                                                                                            </td>-->
                                                                                            <td align="center" style="text-align:center">
                                                                                            	<a href="javascript:;" onclick="get_frm('get_switched_stock.php', '<?=$row_stock["rec_id"]?>&i=<?=$i?>&CountId=<?=$CountId?>&Date=<?=$Date?>', 'replaceme_<?=$i?>','');"><img src="images/icon_switch.jpg" border="0" /></a>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <?
																							
                                                                                        }
                                                                                        ?>
                                                                                    </table>
                                                                                <?
                                                                                }
                                                                                ?>
                                                                            </div>                                                                        	
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                        			<?
                                                                                    $i++;
                                                                               
                                                                            }
                                                                        }
                                                                    }
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
<DIV id=modal style="DISPLAY: none;">
  <div style="padding: 0px; background-color: rgb(37, 100, 192); visibility: visible; position: relative; width: 222px; height: 202px; z-index: 10002; opacity: 1;">
    <div onClick="Popup.hide('modal')" style="padding: 0px; background: transparent url(./images/close.gif) no-repeat scroll 0%; visibility: visible; position: absolute; left: 201px; top: 1px; width: 20px; height: 20px; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; cursor: pointer; z-index: 10004;" id="adpModal_close"></div>
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
<iframe width=168 height=190 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="calendar/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
</iframe> 
<? include("inc/footer.php");?>