<?
	ob_start();
	include("../inc/dbconnection.php");
	include("../inc/store_function.php");
	set_time_limit(0);
	$SearchGRNDate='';
	$SearchIEDate='';
	$DateRange='';
	
	$from = $to = date('Y-m-d');
	$from=getDateFormate($_POST['FromDate']);
	$to=getDateFormate($_POST['ToDate']);
	$DateRange=$from.','.$to;
	//Query Part Start Here
	function OpeningValue($ItemId, $LeftQuantity){
		global $PurchaseValue;
		global $$ItemId;
		global $GRNLeftQuantity;
		$sql_purchase = "select * from ms_GRN_transaction where item_id = '".$ItemId."' order by GRN_transaction_id ASC limit ".$$ItemId.",1";
		$res_purchase=mysql_query($sql_purchase) or die("Error in : ".$sql_purchase."<br>".mysql_errno()." :".mysql_error());
		if(mysql_num_rows($res_purchase)>0){
			while($row_purchase=mysql_fetch_array($res_purchase)){
				if($LeftQuantity > $row_purchase["rec_qty"] && $GRNLeftQuantity<=0){
					$PurchaseValue += $row_purchase["rec_qty"] * $row_purchase["net_rate"];
					$LeftQuantity = $LeftQuantity - $row_purchase["rec_qty"];
					$$ItemId++;
					OpeningValue($ItemId,$LeftQuantity);
				}else if($GRNLeftQuantity>0 && $LeftQuantity>$GRNLeftQuantity){
					$PurchaseValue += $GRNLeftQuantity * $row_purchase["net_rate"];
					$LeftQuantity = $LeftQuantity - $GRNLeftQuantity;
					$$ItemId++;
					$GRNLeftQuantity = 0;
					if($LeftQuantity>0){
						OpeningValue($ItemId,$LeftQuantity);
					}
				}else if($GRNLeftQuantity>0 && $LeftQuantity<=$GRNLeftQuantity){
					$PurchaseValue += $LeftQuantity * $row_purchase["net_rate"];
					$GRNLeftQuantity = $GRNLeftQuantity - $LeftQuantity;
				}else{
					$PurchaseValue += $LeftQuantity * $row_purchase["net_rate"];
					$GRNLeftQuantity = $row_purchase["rec_qty"] - $LeftQuantity;
					if($GRNLeftQuantity==0){
						$$ItemId++;
					}
				}
			}
		}
		return $PurchaseValue;
	}
	$html_string='<table border="1">';
	$html_string.='<caption>'.$company_Fulladdress.'<br /> Stock Report '.$DateRange.'</caption>';

	$html_string.='<tr><td><strong>S.No.</strong></td><td><strong>Department</strong></td><td><strong>Opening Value</strong></td><td><strong>Purchase Value</strong></td><td><strong>Issue Value</strong></td><td><strong>Closing Value</strong></td></tr>';

$tItemId = 3438;
$sql_department="SELECT department_id,name from ms_department where department_id in (select department_id from ms_item_master)   ORDER BY name";
$result_department=mysql_query($sql_department) or die("Error in : ".$sql_department."<br>".mysql_errno()." : ".mysql_error());
if(mysql_num_rows($result_department)>0){
	$sno = 1;
	$TotalOpeningValue = 0;
	$TotalPurchaseValue = 0;
	$TotalIssueValue = 0;
	$TotalClosingValue = 0;
	while($row_department = mysql_fetch_array($result_department)){
		$sql_opening_value="select 
			ms_item_master.item_id as ItemId,
			ms_item_master.name as ItemName,
			ms_item_master.opening_quantity as OpeningQuantity,
			ms_item_master.opening_rate as OpeningRate
		from
			ms_item_master 
		where 
			ms_item_master.department_id='".$row_department['department_id']."'";
		$TotalIValue = 0;
		$OpeningValue = 0;
		$IssueValue = 0;
		$OpneingIssueValue = 0;
		$res_opening_value=mysql_query($sql_opening_value) or die("Error in : ".$sql_opening_value."<br>".mysql_errno()." :".mysql_error());
		if(mysql_num_rows($res_opening_value)>0){
			while($row_opening_value=mysql_fetch_array($res_opening_value)){
				if(isset($$row_opening_value['ItemId'])){
					}else{
						$$row_opening_value['ItemId']=0;
						$GRNLeftQuantity = 0;
					}
					$OpeningQuantity = 0;
					$LeftQuantity = 0;
					$OpeningValue+=$row_opening_value['OpeningQuantity']*$row_opening_value['OpeningRate'];
					$sql_opening_issue="select 
						sum(ms_IE_transaction.iss_qty) as OpeningIssueQuantity,
						ms_item_master.item_id as ItemId,
						ms_item_master.name as ItemName,
						ms_item_master.opening_quantity as OpeningQuantity,
						ms_item_master.opening_rate as OpeningRate
					from 
						ms_IE_master,
						ms_IE_transaction,
						ms_item_master 
					where 
						ms_IE_master.IE_id=ms_IE_transaction.IE_id 
						and ms_IE_transaction.item_id=ms_item_master.item_id 
						and ms_IE_master.IE_date < '".$from."'
						and ms_item_master.department_id='".$row_department['department_id']."'
						and ms_item_master.item_id='".$row_opening_value['ItemId']."'
					group by
						ms_item_master.item_id";
					$result_opening_issue=mysql_query($sql_opening_issue) or die("Error in : ".$sql_opening_issue."<br>".mysql_errno()." :".mysql_error());
					$flag = 0;
					if(mysql_num_rows($result_opening_issue)>0){
						while($row_opening_issue=mysql_fetch_array($result_opening_issue)){
							$PurchaseValue = 0;
							$OpeningQuantity = $row_opening_issue["OpeningQuantity"];
							if($row_opening_issue["OpeningIssueQuantity"] > $row_opening_issue["OpeningQuantity"]){
								$OpneingIssueValue += $row_opening_issue["OpeningQuantity"]*$row_opening_issue["OpeningRate"];
								$LeftQuantity = $row_opening_issue["OpeningIssueQuantity"] - $row_opening_issue["OpeningQuantity"];
								$OpneingIssueValue += OpeningValue($row_opening_issue["ItemId"],$LeftQuantity);
								$OpeningQuantity = 0;
								$flag = 1;
							}else{
								$OpneingIssueValue += $row_opening_issue["OpeningIssueQuantity"]*$row_opening_issue["OpeningRate"]; 
								$OpeningQuantity = $row_opening_issue["OpeningQuantity"] - $row_opening_issue["OpeningIssueQuantity"];
								$flag = 1;
							}
						}
					}
					$sql_today_opening_issue="select 
						sum(ms_IE_transaction.iss_qty) as OpeningIssueQuantity,
						ms_item_master.item_id as ItemId,
						ms_item_master.name as ItemName,
						ms_item_master.opening_quantity as OpeningQuantity,
						ms_item_master.opening_rate as OpeningRate
					from
						ms_IE_master,
						ms_IE_transaction,
						ms_item_master 
					where 
						ms_IE_master.IE_id=ms_IE_transaction.IE_id 
						and ms_IE_transaction.item_id=ms_item_master.item_id 
						and ms_IE_master.IE_date between '".$from."' and '".$to."'
						and ms_item_master.department_id='".$row_department['department_id']."'
						and ms_item_master.item_id='".$row_opening_value['ItemId']."'
						group by ms_item_master.item_id";
					$result_today_opening_issue=mysql_query($sql_today_opening_issue) or die("Error in : ".$sql_today_opening_issue."<br>".mysql_errno()." :".mysql_error());
					if(mysql_num_rows($result_today_opening_issue)>0){
						while($row_today_opening_issue=mysql_fetch_array($result_today_opening_issue)){
							$PurchaseValue = 0;
							if($OpeningQuantity==0 && $flag == 0){
								$OpeningQuantity = $row_today_opening_issue["OpeningQuantity"];
							}
							if($row_today_opening_issue["OpeningIssueQuantity"] > $OpeningQuantity){
								$IssueValue += $OpeningQuantity*$row_today_opening_issue["OpeningRate"];
								$LeftQuantity = $row_today_opening_issue["OpeningIssueQuantity"] - $OpeningQuantity;
								$IssueValue += OpeningValue($row_today_opening_issue["ItemId"],$LeftQuantity);
							}else{
								$IssueValue += $row_today_opening_issue["OpeningIssueQuantity"]*$row_today_opening_issue["OpeningRate"];
							}
						}
					}
				}
			}
			$sql_purchase = "select
				(select 
					sum(ms_GRN_transaction.rec_qty*ms_GRN_transaction.net_rate) as OpeningPurchase 
				from 
					ms_GRN_master,
					ms_GRN_transaction,
					ms_item_master
				where
					ms_GRN_master.GRN_id = ms_GRN_transaction.GRN_id
					and ms_item_master.item_id = ms_GRN_transaction.item_id
					and ms_item_master.department_id = '".$row_department["department_id"]."'
					and ms_GRN_master.GRN_date < '".$from."') as OpeningPurchase ,
					(select 
						sum(ms_GRN_transaction.rec_qty*ms_GRN_transaction.net_rate) as PurchaseBetweenDates
					from 
						ms_GRN_master,
						ms_GRN_transaction,
						ms_item_master
					where
						ms_GRN_master.GRN_id = ms_GRN_transaction.GRN_id
						and ms_item_master.item_id = ms_GRN_transaction.item_id
						and ms_item_master.department_id = '".$row_department["department_id"]."'
						and ms_GRN_master.GRN_date between '".$from."' and '".$to."') as PurchaseBetweenDates";
			$result_purchase=mysql_query($sql_purchase) or die("Error in : ".$sql_purchase."<br>".mysql_errno()." : ".mysql_error());
			if(mysql_num_rows($result_purchase)>0){
				while($row_purchase = mysql_fetch_array($result_purchase)){
					$OpeningPurchase = ($row_purchase["OpeningPurchase"]=="") ? 0 : $row_purchase["OpeningPurchase"];
					$TotalPurchase = ($row_purchase["PurchaseBetweenDates"]=="") ? 0 : $row_purchase["PurchaseBetweenDates"];
					$OpeningValue1 = $OpeningValue + $OpeningPurchase - $OpneingIssueValue;
					
					$html_string.='<tr><td class="gredBg">'.$sno++.'</td><td class="gredBg">'.$row_department['name'].'</td><td class="gredBg">'.number_format($OpeningValue1,2).'</td><td class="gredBg">'.number_format($TotalPurchase,2).'</td><td class="gredBg">'.number_format($IssueValue,2).'</td><td class="gredBg">'.number_format($OpeningValue1+$TotalPurchase-$IssueValue,2).'</td></tr>';
					
					$TotalOpeningValue += $OpeningValue1;
					$TotalPurchaseValue += $TotalPurchase;
					$TotalIssueValue += $IssueValue;
					$TotalClosingValue += $OpeningValue1+$TotalPurchase-$IssueValue;	
				}
			}
		}
	}
	$html_string.='<tr><td></td><td class="gredBg"><strong>Total</strong></td><td class="gredBg">'.number_format($TotalOpeningValue,2).'</td><td class="gredBg">'.number_format($TotalPurchaseValue,2).'</td><td class="gredBg">'.number_format($TotalIssueValue,2).'</td><td class="gredBg">'.number_format($TotalClosingValue,2).'</td></tr>';
	$html_string.='</table>';
	//make time dependent xls name that is always unique
	$xlsfile = "Store_Report_Stock_Ledger".date("m-d-Y-hiA").".xls";
	//stop the browser displaying the HTML table displaying
	//force the browser to download as xcel document
	//if you make comment below two lines as php comments ,you see a simple HTML table
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition: attachment; filename=$xlsfile");
	print  $html_string;

?>
