<? include ("inc/purchase_header.php"); ?>
<script type="text/javascript" src="javascript/form.js"></script>
<script type="text/javascript" src="javascript/popup.js"></script>

<script language="JavaScript1.2">
function validate_form(form)
{
	return(
				  checkString(form.elements["company_id"],"Company",false) &&
				 checkString(form.elements["product_id"],"Product",false) &&
				 checkString(form.elements["quantity"],"Quantity",false) &&
				 checkString(form.elements["buysell_date"],"Date",false) &&
				 validate_seller(form) &&
				 validate_buyer(form)				 
		   );   
}
function validate_seller(form)
{	
	if(document.getElementById('fromstock').checked == false)
	{
		 if(checkString(form.elements["seller_id"],"Seller Company",false)  && checkString(form.elements["sell_form_id"],"Seller Form",false))
			{
				return true;
			}
			else
			{
				return false;
			}			 
	}
	else
	{
		return true;
	}
}	
function validate_buyer(form)
{
	if(document.getElementById('tostock').checked == false)
	{
		if(checkString(form.elements["purchaser_id"],"Buyer Company",false) && checkString(form.elements["buy_form_id"],"Buyer Form",false))
		{
			return true;
		}
		else
		{
			return false;
		}	 
	}
	else
	{
		return true;
	}	
}
</script>
<script type="text/javascript" src="ajax/common_function.js"></script>
<script language="javascript">
function sellstockChecked(check) 
{
	
	if(check==1)
	{
		document.getElementById('fromstock').checked = true
		alert("error");
		return false;
	}
	
	var sellstock=document.getElementById('fromstock');
	if(sellstock.checked==false)
	{
		document.getElementById('divsellRequired').style.display='block';
		document.getElementById('buy').style.display='block';
		document.getElementById('divfromstockRequired').style.display='none';
	}
	else
	{ 
		document.getElementById('divsellRequired').style.display='none';
		document.getElementById('buy').style.display='none';
		document.getElementById('divfromstockRequired').style.display='block';
	}
}
function buystockChecked(check) 
{
	
	if(check==1)
	{
		
		document.getElementById('tostock').checked = true
		alert("error");
		return false;
	}
	
	var buystock=document.getElementById('tostock');
	if(buystock.checked==false)
	{
		document.getElementById('divbuyRequired').style.display='block';
		document.getElementById('sell').style.display='block';
		document.getElementById('divtostockRequired').style.display='none';
	}
	else
	{ 
		document.getElementById('divbuyRequired').style.display='none';
		document.getElementById('sell').style.display='none';
		document.getElementById('divtostockRequired').style.display='block';
	}
}

</script>
<?
$Page = "purchase_add_buysell.php";
$PageTitle = "Add Buyer/Seller";
$PageFor = "Buyer/Seller";
$PageKey = "stock_id";
$PageKeyValue = "";
$Message = "";
$mode = "";

$company_id = '';
$purchaser_id = '';
$seller_id = '';
$product_id = '';
$quantity = '';
$buysell_date = '';
$form_id = '';
$previous_stock = '';
$next_stock = '';
$table_rec_id = '';
$seller_buyer = '';
$dtTransaction = '';
$name = '';

if(isset($_GET["mode"]))
{
	$mode = $_GET["mode"];
}

if(isset($_POST["btn_submit"]))
{
	//$PageKeyValue = $_POST[$PageKey];
	$company_id = $_POST['company_id'];	

	$seller_id = $_POST['seller_id'];
	$purchaser_id = $_POST['purchaser_id'];
	
	$sell_form_id = $_POST['buy_form_id'];
	
	$buy_form_id = $_POST['sell_form_id'];
	
	$product_id = $_POST['product_id'];
	$quantity = $_POST['quantity'];
	
	$IsEntryChecked = isset($_POST['IsEntryChecked']) ? $_POST['IsEntryChecked'] : 0;
	
	
	$buysell_date = getDateFormate($_POST['buysell_date']);
	$ip_add = $_SERVER['REMOTE_ADDR'];
	
	if(isset($_POST['fromstock']))
	{
		$buyer_id = $_POST['buyer_id'];
		if($buyer_id=="")
		{
			$sql_buy = "insert into ms_buyer_master set
														company_id = '$company_id',
														purchaser_id = '$purchaser_id',
														product_id = '$product_id',
														form_id = '$sell_form_id',
														quantity = '$quantity',
														buyer_date = '$buysell_date',
														insert_date = now(),
														login_id = '$SessionLoginMasterId',
														IP = '$ip_add',
														fromWhat = '0',
														seller_id = '0',
														IsEntryChecked = '$IsEntryChecked'";
			
			
			mysql_query($sql_buy) or die("Error in : ".$sql_buy."<br>".mysql_errno()." : ".mysql_error());
			
			$insert_id = mysql_insert_id();
			
			$sql_stock = "insert into ms_purchase_stock_master set
																	 table_rec_id = '$insert_id',
																	 company_id = '$company_id', 
																	 product_id = '$product_id', 
																	 stock_quantity = 'Buyer', 
																	 seller_buyer = '0', 
																	 dtTransaction = '$buysell_date', 
																	 insert_date = now(), 
																	 login_id = '$SessionLoginMasterId', 
																	 ip = '$ip_add'";
			
			
			mysql_query($sql_stock) or die("Error in : ".$sql_stock."<br>".mysql_errno()." : ".mysql_error());
	
			$seller_id = mysql_insert_id();
	
			$sql_update = "update ms_buyer_master set seller_id = '$seller_id' where buyer_id = '$insert_id'";
			
			mysql_query($sql_update) or die("Error in : ".$sql_update ."<br>".mysql_errno()." : ".mysql_error());
			
			$sql_check_stock = "select * from ms_purchase_company_product_master where product_id='".$product_id."' and company_id = '".$company_id."'";
			
			$sql_check_stock = mysql_query($sql_check_stock) or die("Error in : ".$sql_check_stock."<br>".mysql_errno()." : ".mysql_error());
			
			if(mysql_num_rows($sql_check_stock)>0)
			{
				$row_check_stock = mysql_fetch_array($sql_check_stock);
				
				$previous_stock = $row_check_stock['existing_quantity'];
				
				$company_product_id=$row_check_stock['company_product_id'];
				
				$next_stock =  $previous_stock - $quantity ;	
				
				$tablename="ms_purchase_company_product_master";
				
				$tableColumns=array("company_product_id","existing_quantity");
				
				$tableData=array("'$company_product_id'","'$next_stock'");
				
				updateDataIntoTable($tablename,$tableColumns,$tableData);
				
			}
			$Message = "Inserted";
		}
		else
		{
			
			$sql_buy = "update ms_buyer_master set
													company_id = '$company_id',
													purchaser_id = '$purchaser_id', 
													product_id = '$product_id', 
													form_id = '$sell_form_id', 
													quantity = '$quantity', 
													buyer_date = '$buysell_date', 
													login_id = '$SessionLoginMasterId', 
													IP = '$ip_add', 
													IsEntryChecked = '$IsEntryChecked'
													where buyer_id = '$buyer_id'";
			
			
			mysql_query($sql_buy) or die("Error in : ".$sql_buy."<br>".mysql_errno()." : ".mysql_error());
			
			
			$sql_stock = "update ms_purchase_stock_master set
															company_id = '$company_id', 
															product_id = '$product_id', 
															stock_quantity = '$quantity', 
															dtTransaction = '$buysell_date', 
															
															login_id = '$SessionLoginMasterId', 
															ip = '$ip_add'
															where table_rec_id = '$buyer_id' and seller_buyer = 'Buyer'";
			
			mysql_query($sql_stock) or die("Error in : ".$sql_stock."<br>".mysql_errno()." : ".mysql_error());
	
			$previous_quantity = $_POST["previous_quantity"];
			
			$sql_check_stock = "select * from ms_purchase_company_product_master where product_id='".$product_id."' and company_id = '".$company_id."'";
			
			$sql_check_stock = mysql_query($sql_check_stock) or die("Error in : ".$sql_check_stock."<br>".mysql_errno()." : ".mysql_error());
			
			if(mysql_num_rows($sql_check_stock)>0)
			{
			
				$row_check_stock = mysql_fetch_array($sql_check_stock);

				$previous_stock = $row_check_stock['existing_quantity'];
				
				$company_product_id=$row_check_stock['company_product_id'];

				$next_stock =  $previous_stock + $quantity - $previous_quantity;
				
				$tablename="ms_purchase_company_product_master";
				
				$tableColumns=array("company_product_id","existing_quantity");
				
				$tableData=array("'$company_product_id'","'$next_stock'");
				
				updateDataIntoTable($tablename,$tableColumns,$tableData);
				
			}
			$Message = "Updated";
		}
			
	}
	else if(isset($_POST['tostock']))
	{
		$sell_id = $_POST['sell_id'];
	
		if($sell_id=="")
		{
			$sql_sell = "insert into ms_sell_master set
															company_id = '$company_id',
															seller_id = '$seller_id', 
															form_id = '$buy_form_id', 
															product_id = '$product_id',  
															quantity = '$quantity', 
															sell_date = '$buysell_date', 
															insert_date = now(), 
															login_id = '$SessionLoginMasterId', 
															IP = '$ip_add', 
															toWhat = '0', 
															IsEntryChecked = '$IsEntryChecked'";
			mysql_query($sql_sell) or die("Error in : ".$sql_sell."<br>".mysql_errno()." : ".mysql_error());					
			
			$insert_id = mysql_insert_id();
			
			$sql_stock = "insert into ms_purchase_stock_master set
																table_rec_id = '$insert_id', 
																company_id = '$company_id', 
																product_id = '$product_id', 
																stock_quantity = '$quantity', 
																seller_buyer = 'Seller', 
																dtTransaction = '$buysell_date', 
																insert_date = now(), 
																login_id = '$SessionLoginMasterId', 
																ip = '$ip_add'";
			
			mysql_query($sql_stock) or die("Error in : ".$sql_stock."<br>".mysql_errno()." : ".mysql_error());	
	
			$buyer_id = mysql_insert_id();
	
			$sql_update = "update ms_sell_master set buyer_id = '$buyer_id' where sell_id = '$insert_id'";
			
			mysql_query($sql_update) or die("Error in : ".$sql_update ."<br>".mysql_errno()." : ".mysql_error());
			
			$sql_check_stock = "select * from ms_purchase_company_product_master where product_id='".$product_id."' and company_id = '".$company_id."'";
			
			$sql_check_stock = mysql_query($sql_check_stock) or die("Error in : ".$sql_check_stock."<br>".mysql_errno()." : ".mysql_error());
			
			if(mysql_num_rows($sql_check_stock)>0)
			{
				$row_check_stock = mysql_fetch_array($sql_check_stock);
				
				$previous_stock = $row_check_stock['existing_quantity'];
				
				$company_product_id=$row_check_stock['company_product_id'];
				
				$next_stock =  $previous_stock + $quantity ;	
				
				$tablename="ms_purchase_company_product_master";
				
				$tableColumns=array("company_product_id","existing_quantity");
				
				$tableData=array("'$company_product_id'","'$next_stock'");
				
				updateDataIntoTable($tablename,$tableColumns,$tableData);
				
			}
			$Message = "Inserted";
		}
		else
		{
			$sql_sell = "update ms_sell_master set
													company_id = '$company_id',
													seller_id = '$seller_id', 
													form_id = '$buy_form_id', 
													product_id = '$product_id',
													quantity = '$quantity', 
													sell_date = '$buysell_date', 
													login_id = '$SessionLoginMasterId', 
													IP = '$ip_add', 
													IsEntryChecked = '$IsEntryChecked' where sell_id = '$sell_id'";
													
								
			mysql_query($sql_sell) or die("Error in : ".$sql_sell."<br>".mysql_errno()." : ".mysql_error());
			
			$sql_stock = "update ms_purchase_stock_master set
																company_id = '$company_id', 
																product_id = '$product_id', 
																stock_quantity = '$quantity', 
																dtTransaction = '$buysell_date', 
																login_id = '$SessionLoginMasterId', 
																ip = '$ip_add'
																where table_rec_id = '$sell_id' and seller_buyer = 'Seller'";
			
			mysql_query($sql_stock) or die("Error in : ".$sql_stock."<br>".mysql_errno()." : ".mysql_error());
	
			$previous_quantity = $_POST["previous_quantity"];
			
			
			$sql_check_stock = "select * from ms_purchase_company_product_master where product_id='".$product_id."' and company_id = '".$company_id."'";
			
			$sql_check_stock = mysql_query($sql_check_stock) or die("Error in : ".$sql_check_stock."<br>".mysql_errno()." : ".mysql_error());
			
			if(mysql_num_rows($sql_check_stock)>0)
			{
				$row_check_stock = mysql_fetch_array($sql_check_stock);
				
				$previous_stock = $row_check_stock['existing_quantity'];
				
				$company_product_id=$row_check_stock['company_product_id'];
	
				$next_stock =  $previous_stock - $quantity + $previous_quantity;	
					
				$tablename="ms_purchase_company_product_master";
				
				$tableColumns=array("company_product_id","existing_quantity");
				
				$tableData=array("'$company_product_id'","'$next_stock'");

				updateDataIntoTable($tablename,$tableColumns,$tableData);
			}
			$Message = "Updated";
		}
		
	}
	else
	if(!isset($_POST['fromstock']) && !isset($_POST['tostock']))
	{
		$sell_id = $_POST['sell_id'];
		$buyer_id = $_POST['buyer_id'];
		
		if($buyer_id=="" and $sell_id=="")
		{
			$sql_sell = "insert into ms_sell_master set
													company_id = '$company_id',
													seller_id = '$seller_id', 
													form_id = '$buy_form_id', 
													product_id = '$product_id',  
													quantity = '$quantity', 
													sell_date = '$buysell_date', 
													insert_date = now(), 
													login_id = '$SessionLoginMasterId', 
													IP = '$ip_add', 
													toWhat = '1', 
													IsEntryChecked = '$IsEntryChecked'";
			
			mysql_query($sql_sell) or die("Error in : ".$sql_sell ."<br>".mysql_errno()." : ".mysql_error());
							
			$seller_id = mysql_insert_id();
			
			$sql_buy = "insert into  ms_buyer_master set
														company_id = '$company_id',
														purchaser_id = '$purchaser_id', 
														product_id = '$product_id', 
														form_id = '$sell_form_id', 
														quantity = '$quantity', 
														buyer_date = '$buysell_date', 
														insert_date = now(), 
														login_id = '$SessionLoginMasterId', 
														IP = '$ip_add', 
														fromWhat = '1', 
														seller_id = '$seller_id', 
														IsEntryChecked = '$IsEntryChecked'";
				
			mysql_query($sql_buy) or die("Error in : ".$sql_buy ."<br>".mysql_errno()." : ".mysql_error());
						
			$buyer_id = mysql_insert_id();
			
			$sql_update = "update ms_sell_master set buyer_id = '$buyer_id' where sell_id = '$seller_id'";
			
			
			mysql_query($sql_update) or die("Error in : ".$sql_update ."<br>".mysql_errno()." : ".mysql_error());
			$Message = "Inserted";
		}
		else
		{
			$sql_sell = "update ms_sell_master set
							company_id = '$company_id',
							seller_id = '$seller_id', 
							form_id = '$buy_form_id', 
							product_id = '$product_id',  
							quantity = '$quantity', 
							sell_date = '$buysell_date', 
							login_id = '$SessionLoginMasterId',
							IP = '$ip_add', 
							IsEntryChecked = '$IsEntryChecked' where sell_id = '$sell_id'";
			
			mysql_query($sql_sell) or die("Error in : ".$sql_sell ."<br>".mysql_errno()." : ".mysql_error());
			
			//echo $sql_sell."<br><br>";
			
			$sql_buy = "update ms_buyer_master set
							company_id = '$company_id',
							purchaser_id = '$purchaser_id', 
							product_id = '$product_id', 
							form_id = '$sell_form_id', 
							quantity = '$quantity', 
							buyer_date = '$buysell_date', 
							login_id = '$SessionLoginMasterId', 
							IP = '$ip_add', 
							IsEntryChecked = '$IsEntryChecked' where buyer_id = '$buyer_id'";
							
			mysql_query($sql_buy) or die("Error in : ".$sql_buy ."<br>".mysql_errno()." : ".mysql_error());
			
			//echo $sql_buy."<br><br>";
			
			$Message = "Updated";
		}
	}

	$Message = $Message;
	redirect("$Page?Message=$Message");
}
?>
<?
if(isset($_GET["Message"]))
{
	$Message = $_GET["Message"];
}
?>
<?
$buyer_id = "";
$sell_id = "";

$company_id = "";
$product_id = "";
$quantity = "";
$buysell_date = "";
$IsEntryChecked = "";
$buy_company_id = "";
$purchaser_id = "";
$buy_form_id = "";
$buy_product_id = "";
$buy_quantity = "";
$buy_buyer_date = "";
$buy_fromWhat = 0;

$sell_company_id = "";
$seller_id = "";
$sell_form_id = "";
$sell_product_id = "";
$sell_quantity = "";
$sell_buyer_date = "";
$sell_fromWhat = 0;
$buy_fromWhatVisible = 0;
$sell_fromWhatVisible = 0;
if(isset($_GET["buyer_id"]) or isset($_GET["sell_id"]))
{
	if(isset($_GET["buyer_id"]))
	{
		$buyer_id = $_GET["buyer_id"];
		$sql_buy = "select * from ms_buyer_master where buyer_id = '$buyer_id'";
		
		$result_buy = mysql_query($sql_buy) or die("Error in : ".$sql_buy."<br>".mysql_errno()." : ".mysql_error());
		
		if(mysql_num_rows($result_buy)>0)
		{
			$row_buy = mysql_fetch_array($result_buy);
			
			$buy_company_id = $row_buy["company_id"];
			$purchaser_id = $row_buy["purchaser_id"];
			$buy_form_id = $row_buy["form_id"];
			$buy_product_id = $row_buy["product_id"];
			$buy_quantity = $row_buy["quantity"];
			$buy_buyer_date = getDateFormate($row_buy["buyer_date"],1);
			$buy_fromWhat = ($row_buy["fromWhat"]) ? 0 : 1;
			$buy_fromWhatVisible = ($row_buy["fromWhat"]) ? 0 : 1;
			
			$buy_IsEntryChecked = $row_buy["IsEntryChecked"];
			
			$sell_id = $row_buy["seller_id"];
			
			if($buy_fromWhat==0)
			{
				$sql_sell = "select * from ms_sell_master where sell_id = '$sell_id' and toWhat = '1' ";
			
				$result_sell = mysql_query($sql_sell) or die("Error in : ".$sql_sell."<br>".mysql_errno()." : ".mysql_error());
				
				if(mysql_num_rows($result_sell)>0)
				{
					$row_sell = mysql_fetch_array($result_sell);
					$seller_id = $row_sell["seller_id"];
					$sell_form_id = $row_sell["form_id"];
					$sell_fromWhat = ($row_sell["toWhat"]) ? 0 : 1;
					$sell_fromWhatVisible = ($row_sell["toWhat"]) ? 1 : 0;
					$buy_fromWhatVisible = ($row_buy["fromWhat"]) ? 1 : 0;
					
				}
			}
		}
	}
	if(isset($_GET["sell_id"]))
	{
		$sell_id = $_GET["sell_id"];
		$sql_sell = "select * from ms_sell_master where sell_id = '$sell_id'";
		
		$result_sell = mysql_query($sql_sell) or die("Error in : ".$sql_sell."<br>".mysql_errno()." : ".mysql_error());
		
		if(mysql_num_rows($result_sell)>0)
		{
			$row_sell = mysql_fetch_array($result_sell);
			
			$sell_company_id = $row_sell["company_id"];
			$seller_id = $row_sell["seller_id"];
			$sell_form_id = $row_sell["form_id"];
			$sell_product_id = $row_sell["product_id"];
			$sell_quantity = $row_sell["quantity"];
			$sell_buyer_date = getDateFormate($row_sell["sell_date"],1);
			$sell_fromWhat = ($row_sell["toWhat"]) ? 0 : 1;
			$sell_fromWhatVisible = ($row_sell["toWhat"]) ? 0 : 1;
			$sell_IsEntryChecked = $row_sell["IsEntryChecked"];
			
			$buyer_id = $row_sell["buyer_id"];
			
			if($sell_fromWhat==0)
			{
				$sql_buy = "select * from ms_buyer_master where buyer_id = '$buyer_id' and fromWhat = '1' ";
			
				$result_buy = mysql_query($sql_buy) or die("Error in : ".$sql_buy."<br>".mysql_errno()." : ".mysql_error());
				
				if(mysql_num_rows($result_buy)>0)
				{
					$row_buy = mysql_fetch_array($result_buy);
					
					$buy_form_id = $row_buy["form_id"];
					$purchaser_id = $row_buy["purchaser_id"];
					$buy_fromWhat = ($row_buy["fromWhat"]) ? 0 : 1;
					$sell_fromWhatVisible = ($row_sell["toWhat"]) ? 1 : 0;
					$buy_fromWhatVisible = ($row_buy["fromWhat"]) ? 1 : 0;
				}
			}
		}
		
	}
	$company_id = isset($_GET["buyer_id"]) ? $buy_company_id : $sell_company_id;
	$product_id = isset($_GET["buyer_id"]) ? $buy_product_id : $sell_product_id;
	$quantity = isset($_GET["buyer_id"]) ? $buy_quantity : $sell_quantity;
	$buysell_date = isset($_GET["buyer_id"]) ? $buy_buyer_date : $sell_buyer_date;
	$IsEntryChecked = isset($_GET["buyer_id"]) ? $buy_IsEntryChecked : $sell_IsEntryChecked;
}
?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
    <tr>
    	<td align="left" valign="top" width="230px" style="padding-top:5px;">
			<? include ("inc/purchase_snb.php"); ?>
        </td>        
        <td style="padding-left:5px;" valign="top">
        	<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
            	<tr>
                	<td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/>&nbsp; Add Buyer/Seller</td>
                </tr>
                <tr>
                	<td valign="top" style="padding-top:5px; padding-left:40px;">
                    	<table width="1000" align="center" cellpadding="0" cellspacing="0" border="0" style="border:#CCCCCC solid 1px;">
                            <tr>
                                <td align="center" class="border">
                                    <div align="center" >
                                        <div id="div_message_1" style="color:#399;font-size:16px;font-weight:bold;padding:0 0 5 0"><?=$Message?></div>
                                        <form id="purchase_frm_buysell" name="purchase_frm_buysell" action="" method="post"onSubmit="return validate_form(this);">
                                            <table align="center" cellpadding="1" cellspacing="1" border="0" width="100%" style="border:#CCCCCC solid 1px;">
                                                <tr class="paas_text" bgcolor="#E2EBF0" >
                                                    <td align="center"><b>Company Name</b></td>
                                                    <td align="center"><b>Product</b></td>
                                                    <td align="center"><b>Quantity</b></td>
                                                    <td align="center"><b>Date</b></td>
                                                </tr>
                                                <tr bgcolor="#F2F7F9">
                                                    <td align="center">
                                                        <?
                                                        $sql_company = "select * from ms_purchase_company_master";
                                                        $sql_res = mysql_query($sql_company) or die(mysql_error());
                                                        ?>
                                                        <select name="company_id" id="company_id" style="width:140px;">
                                                            <option value=""></option>
                                                            <?
                                                            if(mysql_num_rows($sql_res)>0)
                                                            {
																while($row_comp = mysql_fetch_array($sql_res))
																{
                                                            ?>
                                                            <option value="<?= $row_comp['company_id'] ?>" <? if($company_id==$row_comp['company_id']){ ?> selected="selected"<? }?>><?= $row_comp['name'].",".$row_comp['city'] ?></option>
                                                            <?
																}
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                    <td align="center">
                                                        <?
                                                        $sql_prod = "select * from ms_purchase_product_master";
                                                        $sql_res = mysql_query($sql_prod) or die(mysql_error());
                                                        ?>
                                                        <select name="product_id" id="product_id" style="width:140px;">
                                                            <option value=""></option>
                                                            <?
                                                            if(mysql_num_rows($sql_res)>0)
                                                            {
																while($row_prod = mysql_fetch_array($sql_res))
																{
                                                            ?>
                                                            <option value="<?=$row_prod['product_id']?>" <? if($buy_product_id==$row_comp['product_id']){ ?> selected="selected"<? }?>><?=$row_prod['product_name'] ?></option>
                                                            <?
																}
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                    <td align="center">
                                                        <input type="text" id="quantity" name="quantity" value="<?=$quantity?>"  />
                                                    </td>
                                                    <td align="center">
                                                        <input type="text" id="buysell_date" name="buysell_date" value="<?=$buysell_date?>"  />
                                                        <a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.purchase_frm_buysell.buysell_date);return false;" HIDEFOCUS>
                                                        <img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
                                                        </a> 
                                                    </td>
                                                </tr>
                                                <tr> 
                                                    <td align="left" colspan="2">
                                                        <div style="display:block" id="sell">
                                                            <b>From Stock</b> 
                                              
                                                            <input type="checkbox" id="fromstock" name="fromstock" <? if($buy_fromWhat){?> checked="checked" readonly="readonly" <? }?> onClick="get_frm('get_exiting_stock.php',document.getElementById('company_id').value,'current_stock_buy',document.getElementById('product_id').value); sellstockChecked(<? if($buy_fromWhat){?>1<? }?>);" style="visibility: <? if($sell_fromWhatVisible == 1){?>hidden<? }else{?>visible<? } ?>" />
                                                        </div>
                                                    </td>
                                                    <td align="right" colspan="2">
                                                        <div style="display:block" id="buy">
                                                            <b>To Stock</b> 
                                              
                                                            <input type="checkbox" id="tostock" name="tostock" <? if($sell_fromWhat){?> checked="checked" <? }?> onClick="get_frm('get_exiting_stock.php',document.getElementById('company_id').value,'current_stock_sell',document.getElementById('product_id').value);buystockChecked(<? if($sell_fromWhat){?>1<? }?>);" style="visibility: <? if($buy_fromWhatVisible == 1){?>hidden<? }else{?>visible<? } ?>"/>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="50%" colspan="2">
                                                        <div style="display:<? if($buy_fromWhat==1){?>none<? }else{?>block<? } ?>" id="divsellRequired"> 
                                                            <table align="center" cellpadding="1" cellspacing="1" border="0" width="90%" style="border:#CCCCCC solid 1px;">
                                                                <tr>
                                                                    <td colspan="2" class="paas_text" bgcolor="#E2EBF0" ><b>Seller</b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="paas_text" bgcolor="#E2EBF0" width="40%">Seller</td>
                                                                    <td align="left" bgcolor="#F2F7F9" width="60%" style="padding-left:10px;">
                                                                        <?
                                                                        $sql_sell = "select * from ms_seller_master";
                                                                        $sql_res = mysql_query($sql_sell) or die(mysql_error());
                                                                        ?>
                                                                        <select name="seller_id" id="seller_id" style="width:140px;">
                                                                            <option value=""></option>
                                                                            <?
                                                                            if(mysql_num_rows($sql_res)>0)
                                                                            {
                                                                                while($row_sell = mysql_fetch_array($sql_res))
                                                                                {
                                                                            ?>
                                                                        <option value="<?=  $row_sell['seller_id'] ?>" <? if($seller_id==$row_sell['seller_id']){ ?> selected="selected"<? }?>><?= $row_sell['name'] ?></option>
                                                                            <?
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="paas_text" bgcolor="#E2EBF0" width="40%" valign="top">Form</td>
                                                                    <td align="left" bgcolor="#F2F7F9" width="60%" style="padding-left:10px;">
                                                                        <?
                                                                        $sql_frm = "select * from ms_purchase_form_master";
                                                                        $sql_res = mysql_query($sql_frm) or die(mysql_error());
                                                                        ?>
                                                                        <select name="sell_form_id" id="form_id" style="width:140px">
                                                                            <option value=""></option>
                                                                            <?
                                                                            if(mysql_num_rows($sql_res)>0)
                                                                            {
                                                                                while($row_frm = mysql_fetch_array($sql_res))
                                                                                {
                                                                            ?>
                                                                            <option value="<?=  $row_frm['form_id'] ?>" <? if($sell_form_id==$row_frm['form_id']){ ?> selected="selected"<? }?>><?= $row_frm['form_name'] ?></option>
                                                                            <?
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        	<input type="hidden" id="sell_id" name="sell_id" value="<?=$sell_id?>" />
                                                        	<input type="hidden" id="previous_quantity" name="previous_quantity" value="<?=$quantity?>"  />
                                                        </div>
                                                        <div style="display:<? if($buy_fromWhat==1){?>block<? }else{?>none<? } ?>" id="divfromstockRequired"> 
                                                            <table align="center" cellpadding="1" cellspacing="1" border="0" width="90%" style="border:#CCCCCC solid 1px;">
                                                                <tr>
                                                                    <td colspan="2" class="paas_text" bgcolor="#E2EBF0" ><b>Stock</b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="paas_text" bgcolor="#E2EBF0" width="40%">Existing Stock Quantity</td>
                                                                    <td align="left" bgcolor="#F2F7F9" width="60%" style="padding-left:10px;">
                                                                    <div id="current_stock_buy">
																	
                                                                    </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                	</td>
                                                    <td width="50%" colspan="2">
                                                        <div style="display:<? if($sell_fromWhat==1){?>none<? }else{?>block<? } ?>" id="divbuyRequired"> 
                                                            <table align="center" cellpadding="1" cellspacing="1" border="0" width="90%" style="border:#CCCCCC solid 1px;">
                                                                <tr>
                                                                    <td colspan="2" class="paas_text" bgcolor="#E2EBF0"><b>Buyer</b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="paas_text" bgcolor="#E2EBF0" width="40%">Buyer</td>
                                                                    <td align="left" bgcolor="#F2F7F9" width="60%" style="padding-left:10px;">
                                                                        <?
                                                                        $sql_pur = "select * from ms_purchaser_master";
                                                                        $sql_res = mysql_query($sql_pur) or die(mysql_error());
                                                                        ?>
                                                                        <select name="purchaser_id" id="purchaser_id" style="width:145px;">
                                                                            <option value=""></option>
                                                                            <?
                                                                            if(mysql_num_rows($sql_res)>0)
                                                                            {
                                                                                while($row_pur = mysql_fetch_array($sql_res))
                                                                                {
                                                                            ?>
                                                                            <option value="<?=  $row_pur['purchaser_id'] ?>" <? if($purchaser_id==$row_pur['purchaser_id']){ ?> selected="selected"<? }?>><?= $row_pur['name'] ?></option>
                                                                            <?
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="paas_text" bgcolor="#E2EBF0" width="40%" valign="top">Form</td>
                                                                    <td align="left" bgcolor="#F2F7F9" width="60%" style="padding-left:10px;">
                                                                        <?
                                                                        $sql_frm = "select * from ms_purchase_form_master";
                                                                        $sql_res = mysql_query($sql_frm) or die(mysql_error());
                                                                        ?>
                                                                        <select name="buy_form_id" id="buy_form_id" style="width:145px">
                                                                            <option value=""></option>
                                                                            <?
                                                                            if(mysql_num_rows($sql_res)>0)
                                                                            {
                                                                                while($row_frm = mysql_fetch_array($sql_res))
                                                                                {
                                                                            ?>
                                                                            <option value="<?=  $row_frm['form_id'] ?>" <? if($buy_form_id==$row_frm['form_id']){ ?> selected="selected"<? }?>><?= $row_frm['form_name'] ?></option>
                                                                            <?
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <input type="hidden" id="buyer_id" name="buyer_id" value="<?=$buyer_id?>" />
                                                            <input type="hidden" id="previous_quantity" name="previous_quantity" value="<?=$quantity?>"  />
                                                        </div>
                                                        <div style="display:<? if($sell_fromWhat==1){?>block<? }else{?>none<? } ?>" id="divtostockRequired"> 
                                                            <table align="center" cellpadding="1" cellspacing="1" border="0" width="90%" style="border:#CCCCCC solid 1px;">
                                                                <tr>
                                                                    <td colspan="2" class="paas_text" bgcolor="#E2EBF0" ><b>To Stock</b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="paas_text" bgcolor="#E2EBF0" width="40%">Existing Stock Quantity</td>
                                                                    <td align="left" bgcolor="#F2F7F9" width="60%" style="padding-left:10px;">
																	<div id="current_stock_sell">	

                                                                    </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </td>
                                        		</tr>
                                                <tr height="20px"><td colspan="4"></td></tr>
                                                <tr>
                                                    <td colspan="4" align="center" bgcolor="#E2EBF0" height="25">
                                                        Is Entry Confirmed <input type="checkbox" id="IsEntryChecked" <? if($IsEntryChecked){?> checked="checked"<? } ?> name="IsEntryChecked" value="1" />
                                                        <input type="hidden" id="mode" name="mode" value="<?=$mode?>"/>
                                                        <input type="hidden" id="<?=$PageKey?>" name="<?=$PageKey?>" value="<?=$PageKeyValue?>" />
                                                        <input type="submit" id="btn_submit" name="btn_submit" value="Submit" class="btn_bg" />
                                                    </td>
                                                </tr>
                                    		</table>
                           				</form>
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
<? include ("inc/hr_footer.php"); ?>