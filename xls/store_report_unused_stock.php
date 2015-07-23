<?  ob_start();
	include("../inc/dbconnection.php");
	include("../inc/store_function.php");
	set_time_limit(0);
	$department_id ='';
	$SearchByDepartmentId='';
	$fromDate='';
	$toDate='';
	$SearchInGRNDate='and ms_GRN_master.GRN_date < CAST(now() as DATE)';
	$department_id=$_POST['department_name'];
	$fromDate=getDateFormate($_POST['FromDate']);
	$toDate=getDateFormate($_POST['ToDate']);
	if($department_id != ''){
		$SearchByDepartmentId=" and ms_department.department_id= ".$department_id;
	}
	if($fromDate != '' && $toDate !=''){
		$SearchInGRNDate="and ms_GRN_master.GRN_date  between '".$fromDate."' and '".$toDate."'";
	}
	$sql="SELECT
		ms_department.department_id as DeptId,
		ms_department.name as Department,
		ms_item_master.item_id as ItemId,
		ms_item_master.opening_quantity as opening_quantity,
		CONCAT(ms_item_master.name,' Drg No . ',ms_item_master.drawing_number) as Description
	FROM
		ms_item_master,
		ms_department
	WHERE
		ms_department.department_id = ms_item_master.department_id
		$SearchByDepartmentId
	ORDER BY
		ms_department.name asc,
		ms_item_master.name";//and ms_department.department_id=3
	$result=mysql_query($sql) or die("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	$data_headers=array('<strong>S.No.</strong>','<strong>Description</strong>','<strong>GRN Date</strong>','<strong>Purchase Qty.</strong>');
	if(mysql_num_rows($result)>0){
		$sno = 1; $oldid=""; $flag=0; $flag1=0; $deptId=''; $totalValue=0; $count=0;
		while($row=mysql_fetch_array($result)){
			$sql_G="select
				ms_GRN_master.GRN_date as Date,
				ms_GRN_transaction.rec_qty as PurchaseQty
			from
				ms_GRN_master,
				ms_GRN_transaction,
				ms_item_master
			where
				ms_GRN_transaction.item_id NOT IN
					(select
						ms_IE_transaction.item_id
					from
						ms_IE_master,
						ms_IE_transaction,
						ms_item_master
					where
						ms_IE_master.IE_id = ms_IE_transaction.IE_id
						and ms_IE_transaction.item_id = ms_item_master.item_id)
				and ms_GRN_transaction.item_id = ms_item_master.item_id
				and ms_GRN_master.GRN_id = ms_GRN_transaction.GRN_id
				$SearchInGRNDate
				and ms_item_master.item_id = '".$row['ItemId']."'";			//(DATEDIFF(CAST(now() as DATE),(ms_GRN_master.GRN_date))>=45)
			$res_G=mysql_query($sql_G) or die("Error in : ".$sql_G."<br>".mysql_errno()." : ".mysql_error());
			if(mysql_num_rows($res_G)>0){
				$PurchaseQty = $row["opening_quantity"];
				while($row_G=mysql_fetch_array($res_G)){
					$PurchaseQty += $row_G['PurchaseQty'];
				}
				if($row['DeptId']!=$oldid){
					$checkSql="select
						ms_GRN_master.GRN_date as Date,
						ms_GRN_transaction.rec_qty as PurchaseQty
					from
						ms_GRN_master,
						ms_GRN_transaction,
						ms_item_master,
						ms_department
					where
						ms_GRN_transaction.item_id NOT IN
							(select
								ms_IE_transaction.item_id
							from
								ms_IE_master,
								ms_IE_transaction,
								ms_item_master
							where
								ms_IE_master.IE_id = ms_IE_transaction.IE_id
								and ms_IE_transaction.item_id = ms_item_master.item_id)
						and ms_GRN_transaction.item_id = ms_item_master.item_id
						and ms_GRN_master.GRN_id = ms_GRN_transaction.GRN_id
						and ms_item_master.department_id = '".$row['DeptId']."'
						and ms_department.department_id = ms_item_master.department_id
						$SearchInGRNDate";
					$res_Check=mysql_query($checkSql) or die("Error in : ".$checkSql."<br>".mysql_errno()." : ".mysql_error());
					$remain=mysql_num_rows($res_Check);
					$oldid = $row['DeptId'];
					$flag=1;$sno=1;$totalValue=0;
				}else{
					$flag=0;
				}
				if($flag==1){
					$data_array[]=array($row['Department']);
				}	
				$data_array[]=array($sno,$row['Description'],getDateFormate($remain['Date']),number_format($PurchaseQty,2,'.',''));
				$totalValue+=$PurchaseQty;
				$sno++;$count++;$remain--;
				if($remain==0){
					$data_array[]=array('Total :','','',number_format($totalValue,2,'.',''));
				}
			}
		}
	}else{// End Of Outer If 
		$data_array[]=array('No Data Found');
	} 
	$html_string='<table border="1">';
	$html_string.='<caption>'.$company_Fulladdress.'<br /><strong>Stock Unused Report From'.getDateFormate($fromDate).' To '.getDateFormate($toDate).'</strong></caption>';
	$html_string.='<tr><td>'.implode('</td><td>',$data_headers).'</td></tr>';
		foreach($data_array as $k=>$v){
			$html_string.='<tr><td>'.implode('</td><td>',$v).'</td></tr>';
		}
	$html_string.='</table>';
	//make time dependent xls name that is always unique
	$xlsfile = "Store_Report_Unused_Stock".date("m-d-Y-hiA").".xls";
	//stop the browser displaying the HTML table displaying
	//force the browser to download as xcel document
	//if you make comment below two lines as php comments ,you see a simple HTML table
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition: attachment; filename=$xlsfile");
	print  $html_string;
?>