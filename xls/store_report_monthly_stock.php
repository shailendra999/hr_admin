<?
	ob_start();
	include("../inc/dbconnection.php");
	include("../inc/store_function.php");
	set_time_limit(0);
	//Query Part Start Here

	$value=(isset($_POST['value']))?$_POST['value'] : "";
	if($value!=''){
		$val=explode(",",$value);
		$MonthFrom=$val[0];
		$MF=$MonthFrom;
		$YearFrom=$val[1];
		$YF=$YearFrom;
		$MonthTo=$val[2];
		$YearTo=$val[3];
		$yearDiff=$YearTo-$YearFrom;
		if($yearDiff==0){
			$monthdiff=$MonthTo-$MonthFrom+1;
		}else if($yearDiff>0){
			$month1 = date('m',mktime(0, 0, 0,$MonthFrom, 1, $YearFrom));
			$month2 = date('m',mktime(0, 0, 0,$MonthTo+1, 0, $YearTo));
			$monthdiff=($month2+$yearDiff*12+1)-$month1;
		}
		$start_from=$MonthFrom.'-'.$YearFrom;
		$end=$MonthTo.'-'.$YearTo;
	}
	$query="SELECT ifnull(SELECT
			sum(ms_GRN_transaction.net_rate)
		FROM
			ms_GRN_transaction,
			ms_item_master
		WHERE
			ms_GRN_transaction.item_id = ms_item_master.item_id) , 0";

	function IssueRate($issueQuantity,$itemId){
		global $totalOpeningQuantity;
		global $totalOpeningRate;
		global $issueRate;
		global $grnQtyleftCheck;
		global $grntRateleft;
		global $startLimit;
		$leftQuanity=number_format($issueQuantity,2,'.','');//echo $issueQuantity.' : ';
		if($totalOpeningQuantity>0){
			if($totalOpeningQuantity>$issueQuantity){
				$issueRate=$totalOpeningRate*$issueQuantity;
				$totalOpeningQuantity=$totalOpeningQuantity-$issueQuantity;
				$leftQuanity=$leftQuanity-$issueQuantity;
			}else{
				$leftQuanity=$leftQuanity-$totalOpeningQuantity;
				$issueRate=$totalOpeningRate*$totalOpeningQuantity;
				$totalOpeningQuantity=0;
			}
		}else if($grnQtyleftCheck>0){
			if($grnQtyleftCheck < $leftQuanity){
				$leftQuanity=$leftQuanity-$grnQtyleftCheck;
				$issueRate=$grntRateleft*$grnQtyleftCheck;
				$grnQtyleftCheck=0;
			}else{
				$issueRate=$grntRateleft*$leftQuanity;
				$grnQtyleftCheck=$grnQtyleftCheck-$leftQuanity;
				$leftQuanity=0;
			}
		}else{
			$sql_func="select ms_GRN_master.GRN_id,ms_GRN_master.GRN_date,ms_GRN_transaction.rec_qty,ms_GRN_transaction.net_rate from ms_GRN_master,ms_GRN_transaction,ms_item_master where ms_GRN_master.GRN_id=ms_GRN_transaction.GRN_id and ms_GRN_transaction.item_id=ms_item_master.item_id and ms_GRN_transaction.item_id='".$itemId."' order by ms_GRN_transaction.GRN_transaction_id ASC limit $startLimit,1 ";
			$result_func=mysql_query($sql_func) or die("Error in : ".$sql_func."<br>".mysql_errno()." : ".mysql_error());	
			{
				$row_func=mysql_fetch_array($result_func);
				$grnQtyleft=$row_func['rec_qty'];
				$grntRateleft=$row_func['net_rate'];
				$grnQtyleftCheck=$row_func['rec_qty'];
			}
			if($leftQuanity<$grnQtyleft){
				$issueRate=$issueRate+$grntRateleft*$leftQuanity;
				$grnQtyleftCheck=$grnQtyleftCheck-$leftQuanity;
			}else{
				$issueRate=$issueRate+$grntRateleft*$grnQtyleft;
				$grnQtyleftCheck=0;
			}
			$leftQuanity=$leftQuanity-$grnQtyleft;
			$startLimit++;
		}
		if($leftQuanity>0 and $leftQuanity>$issueQuantity){
			IssueRate($leftQuanity,$itemId);
		}
		return $issueRate;
	}
	
	$html_string.='<table border="1">';
	$html_string='<caption>'.$company_Fulladdress.'<br /><strong>Report From '.$start_from.' To '.$end.'</strong></caption>';
	$html_string.='<tr><td></td>';
	
		$start=$start_from;
		for ($i=1;$i<=$monthdiff;$i++){
			$my=explode('-',$start);
			$m=$my[0];
			$y=$my[1];
			$xls_fd = date('F,Y',mktime(0,0,0,$m,1,$y));
			$m = date ("m-Y",mktime(0, 0, 0,$m+1, 1, $y));
			$start=$m;
			$html_string.='<td align="center">'.$xls_fd.'</td>';	
		}
		$html_string.='</tr><tr><td align="left"><strong>Opening Stock</strong></td>';  

		$start=$start_from;
		for ($i=1;$i<=$monthdiff;$i++){
			$my=explode('-',$start);
			$m=$my[0];
			$y=$my[1];//
			$sql_p = "SELECT ms_IE_master.IE_id, sum( ms_IE_transaction.iss_qty ) AS Qty , ms_IE_transaction.item_id AS ItemId,
								ms_item_master.opening_quantity AS OpeningQty , ms_item_master.opening_rate AS OpeningRate
								FROM ms_IE_master, ms_IE_transaction, ms_item_master
								WHERE ms_IE_master.IE_id = ms_IE_transaction.IE_Id
								AND ms_IE_transaction.item_id = ms_item_master.item_id
								AND ms_IE_master.IE_id = ms_IE_transaction.IE_id
								AND MONTH( IE_date ) < '$m'
								AND YEAR( IE_date ) = '$y'
								GROUP BY ms_item_master.item_id,MONTHNAME(ms_IE_master.IE_date)";
			
			$result_p = mysql_query($sql_p) or die("Error in : ".$sql_p."<br>".mysql_errno()." : ".mysql_error());
			
			if(mysql_num_rows($result_p)>0){
				$IssueQuantityValueTotal=0;
				while($row_p = mysql_fetch_array($result_p)){
					$totalOpeningQuantity=$row_p['OpeningQty'];
					$totalOpeningRate=$row_p['OpeningRate'];
					$leftQty=$row_p['OpeningQty'];
					$leftRate=$row_p['OpeningRate'];
					$startLimit=0;
					$grnQtyleftCheck=0;
					$issueRate=0;
					$qty=number_format($row_p['Qty'], 2, '.', '');
			 		$issueRate=IssueRate($qty,$row_p['ItemId']);
					$IssueQuantityValueTotal+=$issueRate;
					//echo "<br />";
				}
			}else
				$IssueQuantityValueTotal='0';
			//echo $IssueQuantityValueTotal.' : ';
			/*  End */
			 $sql_os = "select(
			 	select sum(opening_quantity*opening_rate) from  ms_item_master) + (
					select 
					 ifnull(sum(ms_GRN_transaction.rec_qty*ms_GRN_transaction.net_rate),0)
					from 
						ms_GRN_master,ms_GRN_transaction
					where
						ms_GRN_master.GRN_id = ms_GRN_transaction.GRN_Id
						and MONTH(GRN_date) < '$m' and YEAR(GRN_date)= '$y' ) as OpeningQuantity";
				$result_os = mysql_query($sql_os) or die("Error in : ".$sql_os."<br>".mysql_errno()." : ".mysql_error());
				if(mysql_num_rows($result_os)>0){
					$row_os = mysql_fetch_array($result_os);
					$OpeningQuantity=$row_os["OpeningQuantity"]-$IssueQuantityValueTotal;
				}else	
					$OpeningQuantity='0';
				$html_string.='<td align="right" style="padding-right:3px">'.number_format($OpeningQuantity,2,'.','').'</td>';  
				$m = date ("m-Y",mktime(0, 0, 0,$m+1, 1, $y));
				$start=$m;
			}
			$html_string.='</tr><tr><td align="left"><strong>Purchase Store</strong></td>';  
			$start=$start_from;
			for ($i=1;$i<=$monthdiff;$i++){
				$my=explode('-',$start);
				$m=$my[0];
				$y=$my[1];
				$PurchaseQuantityValueStore=0;
				
				$sql_p = "select 
				sum(ms_GRN_transaction.rec_qty*ms_GRN_transaction.net_rate) as PurchaseQuantity, MONTHNAME(ms_GRN_master.GRN_date) as GRNMonth		from 
				ms_GRN_master,ms_GRN_transaction,ms_item_master 
				where 
				ms_GRN_master.GRN_id = ms_GRN_transaction.GRN_Id 
				and ms_GRN_transaction.item_id=ms_item_master.item_id
				and ms_item_master.type_of_item='S'
				and MONTH(GRN_date) = '$m' and YEAR(GRN_date)= '$y' 
				group by MONTHNAME(GRN_date)";
				
				$result_p = mysql_query($sql_p) or die("Error in : ".$sql_p."<br>".mysql_errno()." : ".mysql_error());
				if(mysql_num_rows($result_p)>0){
					$row_p = mysql_fetch_array($result_p);
					$PurchaseQuantityValueStore=$row_p["PurchaseQuantity"];
				}else
					$PurchaseQuantityValueStore='0';

				$html_string.='<td align="right" style="padding-right:3px">'.number_format($PurchaseQuantityValueStore,2,'.','').'</td>';  
				$m = date ("m-Y",mktime(0, 0, 0,$m+1, 1, $y));
				$start=$m;
			}
			$html_string.='</tr><tr><td align="left"><strong>Purchase Packing</strong></td>';
			$start=$start_from;
			for ($i=1;$i<=$monthdiff;$i++){
				$my=explode('-',$start);
				$m=$my[0];
				$y=$my[1];
				$PurchaseQuantityValuePacking=0;
				$sql_p = "select 
					sum(ms_GRN_transaction.rec_qty*ms_GRN_transaction.net_rate) as PurchaseQuantity,
					MONTHNAME(ms_GRN_master.GRN_date) as GRNMonth
				from 
					ms_GRN_master,ms_GRN_transaction,ms_item_master 
				where 
					ms_GRN_master.GRN_id = ms_GRN_transaction.GRN_Id 
					and ms_GRN_transaction.item_id=ms_item_master.item_id
					and ms_item_master.type_of_item='P'
					and MONTH(GRN_date) = '$m' and YEAR(GRN_date)= '$y' 
				group by
					MONTHNAME(GRN_date)";
				
				$result_p = mysql_query($sql_p) or die("Error in : ".$sql_p."<br>".mysql_errno()." : ".mysql_error());
				if(mysql_num_rows($result_p)>0){
					$row_p = mysql_fetch_array($result_p);
					$PurchaseQuantityValuePacking=$row_p["PurchaseQuantity"];
				}else
					$PurchaseQuantityValuePacking='0';
				
				$html_string.='<td align="right" style="padding-right:3px">'.number_format($PurchaseQuantityValuePacking,2,'.','').'</td>';
				$m = date ("m-Y",mktime(0, 0, 0,$m+1, 1, $y));
				$start=$m;
			}
			$html_string.='</tr><tr><td align="left"><strong>Total Purchase</strong></td>';
			$start=$start_from;
			for ($i=1;$i<=$monthdiff;$i++){
				$my=explode('-',$start);
				$m=$my[0];
				$y=$my[1];
				$PurchaseQuantityTotalValue=0;
				$sql_p = "select 
					sum(ms_GRN_transaction.rec_qty*ms_GRN_transaction.net_rate) as PurchaseQuantity,
					MONTHNAME(ms_GRN_master.GRN_date) as GRNMonth
				from
					ms_GRN_master,ms_GRN_transaction,ms_item_master 
				where 
					ms_GRN_master.GRN_id = ms_GRN_transaction.GRN_Id 
					and ms_GRN_transaction.item_id=ms_item_master.item_id
					and MONTH(GRN_date) = '$m' and YEAR(GRN_date)= '$y' 
				group by
					MONTHNAME(GRN_date)";
				$result_p = mysql_query($sql_p) or die("Error in : ".$sql_p."<br>".mysql_errno()." : ".mysql_error());
				if(mysql_num_rows($result_p)>0){
					$row_p = mysql_fetch_array($result_p);
					$PurchaseQuantityTotalValue=$row_p["PurchaseQuantity"];
				}else
					$PurchaseQuantityTotalValue='0';
				$html_string.='<td align="right" style="padding-right:3px;font-weight:bold">'.number_format($PurchaseQuantityTotalValue,2,'.','').'</td>';
				$m = date ("m-Y",mktime(0, 0, 0,$m+1, 1, $y));
				$start=$m;
			}
			$html_string.='</tr><tr><td align="left"><strong>Issue Store</strong></td>';
			$start=$start_from;
			for ($i=1;$i<=$monthdiff;$i++){
				$my=explode('-',$start);
				$m=$my[0];
				$y=$my[1];
				$sql_p = "SELECT ms_IE_master.IE_id, sum( ms_IE_transaction.iss_qty ) AS Qty , ms_IE_transaction.item_id AS ItemId,
								ms_item_master.opening_quantity AS OpeningQty , ms_item_master.opening_rate AS OpeningRate
								FROM ms_IE_master, ms_IE_transaction, ms_item_master
								WHERE ms_IE_master.IE_id = ms_IE_transaction.IE_Id
								AND ms_IE_transaction.item_id = ms_item_master.item_id
								AND ms_item_master.type_of_item='S'
								AND MONTH( IE_date ) = '$m'
								AND YEAR( IE_date ) = '$y'
								GROUP BY ms_IE_transaction.item_id,MONTHNAME(ms_IE_master.IE_date)";
				$result_p = mysql_query($sql_p) or die("Error in : ".$sql_p."<br>".mysql_errno()." : ".mysql_error());
				if(mysql_num_rows($result_p)>0){
					$IssueQuantityValueStore=0;
					while($row_p = mysql_fetch_array($result_p)){
						$totalOpeningQuantity=$row_p['OpeningQty'];
						$totalOpeningRate=$row_p['OpeningRate'];
						$leftQty=$row_p['OpeningQty'];
						$leftRate=$row_p['OpeningRate'];
						$startLimit=0;
						$grnQtyleftCheck=0;
						$issueRate=0;
						$qty=number_format($row_p['Qty'], 2, '.', '');
						$issueRate=IssueRate($qty,$row_p['ItemId']);
						$IssueQuantityValueStore+=$issueRate;
					}
				}else
					$IssueQuantityValueStore='0';
					
				$html_string.='<td align="right" style="padding-right:3px">'.number_format($IssueQuantityValueStore,2,'.','').'</td>';
				$m = date ("m-Y",mktime(0, 0, 0,$m+1, 1, $y));
				$start=$m;
			}
			$html_string.='</tr><tr><td align="left"><b>Issue Packing</b></td>';
			$start=$start_from;
			for ($i=1;$i<=$monthdiff;$i++){
				$my=explode('-',$start);
				$m=$my[0];
				$y=$my[1];
				$sql_p = "SELECT ms_IE_master.IE_id, sum( ms_IE_transaction.iss_qty ) AS Qty , ms_IE_transaction.item_id AS ItemId,
								ms_item_master.opening_quantity AS OpeningQty , ms_item_master.opening_rate AS OpeningRate
								FROM ms_IE_master, ms_IE_transaction, ms_item_master
								WHERE ms_IE_master.IE_id = ms_IE_transaction.IE_Id
								AND ms_IE_transaction.item_id = ms_item_master.item_id
								AND ms_item_master.type_of_item='P'
								AND MONTH( IE_date ) = '$m'
								AND YEAR( IE_date ) = '$y'
								GROUP BY ms_IE_transaction.item_id,MONTHNAME(ms_IE_master.IE_date)";
				$result_p = mysql_query($sql_p) or die("Error in : ".$sql_p."<br>".mysql_errno()." : ".mysql_error());
				if(mysql_num_rows($result_p)>0){
					$IssueQuantityValuePacking=0;
					while($row_p = mysql_fetch_array($result_p)){
						$totalOpeningQuantity=$row_p['OpeningQty'];
						$totalOpeningRate=$row_p['OpeningRate'];
						$leftQty=$row_p['OpeningQty'];
						$leftRate=$row_p['OpeningRate'];
						$startLimit=0;
						$grnQtyleftCheck=0;
						$issueRate=0;
						$qty=number_format($row_p['Qty'], 2, '.', '');
						$issueRate=IssueRate($qty,$row_p['ItemId']);
						$IssueQuantityValuePacking+=$issueRate;
					}
				}else
					$IssueQuantityValuePacking='0';
					
				$html_string.='<td align="right" style="padding-right:3px">'.number_format($IssueQuantityValuePacking,2,'.','').'</td>';
				$m = date ("m-Y",mktime(0, 0, 0,$m+1, 1, $y));
				$start=$m;
			}
			$html_string.='</tr><tr><td align="left"><b>Total Issue</b></td>';
			$start=$start_from;
			for ($i=1;$i<=$monthdiff;$i++){
				$my=explode('-',$start);
				$m=$my[0];
				$y=$my[1];
				$sql_p = "SELECT ms_IE_master.IE_id, sum( ms_IE_transaction.iss_qty ) AS Qty , ms_IE_transaction.item_id AS ItemId,
								ms_item_master.opening_quantity AS OpeningQty , ms_item_master.opening_rate AS OpeningRate
								FROM ms_IE_master, ms_IE_transaction, ms_item_master
								WHERE ms_IE_master.IE_id = ms_IE_transaction.IE_Id
								AND ms_IE_transaction.item_id = ms_item_master.item_id
								AND MONTH( IE_date ) = '$m'
								AND YEAR( IE_date ) = '$y'
								GROUP BY ms_IE_transaction.item_id,MONTHNAME(ms_IE_master.IE_date)";
				$result_p = mysql_query($sql_p) or die("Error in : ".$sql_p."<br>".mysql_errno()." : ".mysql_error());
				if(mysql_num_rows($result_p)>0){
					$IssueQuantityTotalValue=0;
					while($row_p = mysql_fetch_array($result_p)){
						$totalOpeningQuantity=$row_p['OpeningQty'];
						$totalOpeningRate=$row_p['OpeningRate'];
						$leftQty=$row_p['OpeningQty'];
						$leftRate=$row_p['OpeningRate'];
						$startLimit=0;
						$grnQtyleftCheck=0;
						$issueRate=0;
						$qty=number_format($row_p['Qty'], 2, '.', '');
						$issueRate=IssueRate($qty,$row_p['ItemId']);
						$IssueQuantityTotalValue+=$issueRate;
					}
				}else
					$IssueQuantityTotalValue='0';
				$html_string.='<td align="right" style="padding-right:3px;font-weight:bold">'.number_format($IssueQuantityTotalValue,2,'.','').'</td>';
				$m = date ("m-Y",mktime(0, 0, 0,$m+1, 1, $y));
				$start=$m;
			}
			$html_string.='</tr><tr><td align="left"><b>Closing Stock</b></td>';
			$start=$start_from;
			for ($i=1;$i<=$monthdiff;$i++){
				$my=explode('-',$start);
				$m=$my[0];
				$y=$my[1];
				$PurchaseQuantityValueTotal='0';
				$sql_p = "select 
					sum(ms_GRN_transaction.rec_qty*ms_GRN_transaction.net_rate) as PurchaseQuantity,
					MONTHNAME(ms_GRN_master.GRN_date) as GRNMonth
				from
					ms_GRN_master,ms_GRN_transaction,ms_item_master
				where 
					ms_GRN_master.GRN_id = ms_GRN_transaction.GRN_Id 
					and ms_GRN_transaction.item_id=ms_item_master.item_id
					and MONTH(GRN_date) = '$m' and YEAR(GRN_date)= '$y' 
				group by
					MONTHNAME(GRN_date)";
				$result_p = mysql_query($sql_p) or die("Error in : ".$sql_p."<br>".mysql_errno()." : ".mysql_error());
				if(mysql_num_rows($result_p)>0){
					$row_p = mysql_fetch_array($result_p);
					$PurchaseQuantityValueTotal=$row_p["PurchaseQuantity"];
				}
				$sql_p = "SELECT ms_IE_master.IE_id, sum( ms_IE_transaction.iss_qty ) AS Qty , ms_IE_transaction.item_id AS ItemId,
								ms_item_master.opening_quantity AS OpeningQty , ms_item_master.opening_rate AS OpeningRate
								FROM ms_IE_master, ms_IE_transaction, ms_item_master
								WHERE ms_IE_master.IE_id = ms_IE_transaction.IE_Id
								AND ms_IE_transaction.item_id = ms_item_master.item_id
								AND MONTH( IE_date ) <= '$m'
								AND YEAR( IE_date ) = '$y'
								GROUP BY ms_IE_transaction.item_id,MONTHNAME(ms_IE_master.IE_date)";
				$result_p = mysql_query($sql_p) or die("Error in : ".$sql_p."<br>".mysql_errno()." : ".mysql_error());
				if(mysql_num_rows($result_p)>0){
					$IssueQuantityValueTotal=0;
					while($row_p = mysql_fetch_array($result_p)){
						$totalOpeningQuantity=$row_p['OpeningQty'];
						$totalOpeningRate=$row_p['OpeningRate'];
						$leftQty=$row_p['OpeningQty'];
						$leftRate=$row_p['OpeningRate'];
						$startLimit=0;
						$grnQtyleftCheck=0;
						$issueRate=0;
						$qty=number_format($row_p['Qty'], 2, '.', '');
						$issueRate=IssueRate($qty,$row_p['ItemId']);
						$IssueQuantityValueTotal+=$issueRate;
					}
				}else
					$IssueQuantityValueTotal='0';
					$sql_os = "select( select sum(opening_quantity*opening_rate) from  ms_item_master ) + ( select 
						ifnull(sum(ms_GRN_transaction.rec_qty*ms_GRN_transaction.net_rate),0)
					from 
						ms_GRN_master,ms_GRN_transaction
					where
						ms_GRN_master.GRN_id = ms_GRN_transaction.GRN_Id
						and  MONTH(GRN_date) <= '$m' and YEAR(GRN_date)= '$y' ) as OpeningQuantity";
						
					$result_os = mysql_query($sql_os) or die("Error in : ".$sql_os."<br>".mysql_errno()." : ".mysql_error());
					if(mysql_num_rows($result_os)>0){
						$row_os = mysql_fetch_array($result_os);
						$OpeningQuantity=$row_os["OpeningQuantity"]-$IssueQuantityValueTotal;
					}else
						$OpeningQuantity='0';
						
					$html_string.='<td align="right" style="padding-right:3px">'.number_format($OpeningQuantity,2,'.','').'</td>';
					$m = date ("m-Y",mktime(0, 0, 0,$m+1, 1, $y));
					$start=$m;
				}
				$html_string.='</tr>';
				
				$html_string.='</table>';
				
	$xlsfile = "Store_Report_Monthly_Stock".date("m-d-Y-hiA").".xls";
	//stop the browser displaying the HTML table displaying
	//force the browser to download as xcel document
	//if you make comment below two lines as php comments ,you see a simple HTML table
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition: attachment; filename=$xlsfile");
	print  $html_string;
?>