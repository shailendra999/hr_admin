<?php
ini_set("display_errors",1);
ini_set("memory_limit","123M");
error_reporting(E_ALL);
require_once 'excel_reader2.php';

$xls = new Spreadsheet_Excel_Reader("JOBMASTER.xls");

?>
<html>
<head>

<style>
div { display:none; color:#aaa; }
</style>
</head>
<body style="width:1250px">

<? 
include("../inc/store_function.php");
include("../inc/dbconnection.php");
//$resCpunt=mysql_query("select * from maint_job");
//echo mysql_num_rows($resCpunt);
/*for($col=1;$col<=$xls->colcount();$col++)
{
	echo $xls->val(1,$col).'<br />';
}
$xls->rowcount();*/
for ($row=2;$row<=$xls->rowcount();$row++) 
{
	$arr=array();
	$job_code=(int)($xls->val($row,1));
	$service_id=(int)$xls->val($row,4);
	$machine_id=(int)$xls->val($row,3);
	$status=trim($xls->val($row,9));
	$remark=addslashes($xls->val($row,7)).' '.addslashes($xls->val($row,8));
	$maint_date='';
	if($xls->val($row,6)!="")
	{
		$maint_date=explode('-',$xls->val($row,6));
		if(sizeof($maint_date)>0)
			$maint_date=date("Y-m-d", mktime(0, 0, 0, (int)$maint_date[1], ((int)$maint_date[0]-1), (int)$maint_date[2]));
		else
			$maint_date='';
	}
	$schedule_date='';
	if($xls->val($row,2)!="")
	{
		$schedule_date=explode('-',$xls->val($row,2));
		if(sizeof($schedule_date)>0)
			$schedule_date=date("Y-m-d", mktime(0, 0, 0, (int)$schedule_date[1], ((int)$schedule_date[0]-1), (int)$schedule_date[2]));
		else
			$schedule_date='';
	}
	$attend_date='';
	if($xls->val($row,5)!="")
	{
		$attend_date=explode('-',$xls->val($row,5));
		if(sizeof($attend_date)>0)
			$attend_date=date("Y-m-d", mktime(0, 0, 0, (int)$attend_date[1], ((int)$attend_date[0]-1), (int)$attend_date[2]));
		else
			$attend_date='';
	}
	echo $sql="insert into maint_job (job_id,job_code,service_id,machine_id,status,schedule_date,maint_date,attend_date,remark,insert_date) values('','$job_code','$service_id','$machine_id','$status','$schedule_date','$maint_date','$attend_date','$remark',now())";
	$res=mysql_query($sql);	
	//$mac_code=$xls->val($row,1);$mac_name=$xls->val($row,2);$dept_code=$xls->val($row,3);
	//$m_code=$xls->val($row,1);$name=$xls->val($row,2);
	//$mac_code=$xls->val($row,1);$mac_name=$xls->val($row,2);$dept_code=$xls->val($row,3);
	/*$m_code=$xls->val($row,1);$name=$xls->val($row,2);
	$department_code=$xls->val($row,3);$model=$xls->val($row,11);
	$errected_by=$xls->val($row,13);$machine_serial_no=$xls->val($row,7);
	$make_machine=$xls->val($row,4);$machine_price=$xls->val($row,9);
	$manufacture_year=$xls->val($row,12);
	//$install_date=$xls->val($row,6);
	//$commissioning_date=$xls->val($row,8);
	$install_date=explode('/',$xls->val($row,6));$install_date=$install_date[2].'-'.$install_date[0].'-'.($install_date[1]-1);
	$commissioning_date=explode('/',$xls->val($row,8));$commissioning_date=$commissioning_date[2].'-'.$commissioning_date[0].'-'.($commissioning_date[1]-1);
	echo $sql="insert into maint_machine_master (machine_transaction_id,machine_id,service_id,department_code,model,errected_by,machine_serial_no,make_machine,machine_price,manufacture_year,install_date,commissioning_date,insert_date) values('','$m_code','$name','$department_code','$model','$errected_by','$machine_serial_no','$make_machine','$machine_price','$manufacture_year','$install_date','$commissioning_date',now())";	//$mac_code=$xls->val($row,1);$mac_name=$xls->val($row,2);$dept_code=$xls->val($row,3);
	$m_code=$xls->val($row,1);$name=$xls->val($row,2);
	$department_code=$xls->val($row,3);$model=$xls->val($row,11);
	$errected_by=$xls->val($row,13);$machine_serial_no=$xls->val($row,7);
	$make_machine=$xls->val($row,4);$machine_price=$xls->val($row,9);
	$manufacture_year=$xls->val($row,12);
	//$install_date=$xls->val($row,6);
	//$commissioning_date=$xls->val($row,8);
	$install_date=explode('/',$xls->val($row,6));$install_date=$install_date[2].'-'.$install_date[0].'-'.($install_date[1]-1);
	$commissioning_date=explode('/',$xls->val($row,8));$commissioning_date=$commissioning_date[2].'-'.$commissioning_date[0].'-'.($commissioning_date[1]-1);
	echo $sql="insert into maint_machine_master (machine_transaction_id,machine_id,service_id,department_code,model,errected_by,machine_serial_no,make_machine,machine_price,manufacture_year,install_date,commissioning_date,insert_date) values('','$m_code','$name','$department_code','$model','$errected_by','$machine_serial_no','$make_machine','$machine_price','$manufacture_year','$install_date','$commissioning_date',now())";
	$m_code=$xls->val($row,1);$s_code=$xls->val($row,2);
	//$department_code=$xls->val($row,3);$model=$xls->val($row,11);
	//$errected_by=$xls->val($row,13);$machine_serial_no=$xls->val($row,7);
	//$make_machine=$xls->val($row,4);$machine_price=$xls->val($row,9);
	//$manufacture_year=$xls->val($row,12);
	//$install_date=$xls->val($row,6);
	//$commissioning_date=$xls->val($row,8);
	//$maint_date='.'.$xls->val($row,5).'.';
	$maint_date=explode('-',$xls->val($row,5));
	//echo '   days='.$maint_date[0].'month='.$maint_date[1].'year='.$maint_date[2].'<br />';
	$maint_date=date("Y-m-d", mktime(0, 0, 0, (int)$maint_date[1], ((int)$maint_date[0]-1), (int)$maint_date[2]));
	//$maint_date[0].'-'.$maint_date[1].'-'.$maint_date[2];
	//echo date('Y-m-d',strtotime($maint_date)).'<br />';
	//
	//$maint_date=$maint_date[2].'-'.$maint_date[0].'-'.($maint_date[1]-1);
	//$commissioning_date=explode('/',$xls->val($row,8));$commissioning_date=$commissioning_date[2].'-'.$commissioning_date[0].'-'.($commissioning_date[1]-1);
	echo $sql="insert into maint_machine_transaction (machine_transaction_id,machine_id,service_id,maint_date,schedule_date,insert_date) values('','$m_code','$s_code','$maint_date','',now())";
	$res=mysql_query($sql);*/
	//$res=mysql_query($sql);
	//for ($col=1;$col<=$xls->colcount();$col++) 
	{	
		//if($col==2||$col==3||$col==4||$col==5 ||$col==6||$col==10||$col==11||$col==13||$col==14||$col==15||$col==16||$col==17||$col==18||$col==19||$col==20)
		{
			//addDataIntoTable($tableName,$tableData);
	 		//array_push($arr,$xls->val($row,$col));
		}
	//	echo $xls->val($row,$col)." || ";
		 /*$code=$xls->val($row,1);$name=$xls->val($row,2);
		 		 $odebit=$xls->val($row,3);
		 $ocredit=$xls->val($row,4);		 $debit=$xls->val($row,5);
		 $credit=$xls->val($row,6);		 $tax_description=$xls->val($row,10);
		 $tax_perc=$xls->val($row,11);		 $pan_number=$xls->val($row,13);
		 $tds_required=$xls->val($row,14);		 $tds_name=$xls->val($row,15);
		 $tds_amount=$xls->val($row,16);		 $tds_perc=$xls->val($row,17);
		 $cheque_from=$xls->val($row,18);		 $cheque_to=$xls->val($row,19);
		 $cheque_now=$xls->val($row,20);*/
		 /*echo $sql="insert into ms_supplier (supplier_id,code,name,odebit,ocredit,debit,credit,tax_description,tax_perc,pan_number,tds_required,tds_name,tds_amount,tds_perc,cheque_from,cheque_to,cheque_now,bank_detail,insert_date) values ('','$code','$name','$odebit','$ocredit','$debit','$credit','$tax_description','$tax_perc','$pan_number','$tds_required','$tds_name','$tds_amount','$tds_perc','$cheque_from','$cheque_to','$cheque_now','',now())";*/
		 
		 
		 /*$code=$xls->val($row,1);
		 $address=$xls->val($row,2);		 $phone=$xls->val($row,3);
		 $fax=$xls->val($row,4);		 $email=$xls->val($row,5);
		 
		  echo $sql="update ms_supplier set address='$address',contact_number='$phone',fax='$fax',email_id='$email' where code='$code'";*/
			/*$name=addslashes($xls->val($row,2));$deptcode=addslashes($xls->val($row,3));$machno=addslashes($xls->val($row,4));
			echo $sql="insert into ms_machinary (machinary_id,number,name,department_id,insert_date) values ('','$name','$deptcode','$machno',now())";*/
			/*$supp_id=$xls->val($row,21);
			
			$item_code=$xls->val($row,1);$name=addslashes($xls->val($row,2));$code=$xls->val($row,3);
			$item_head_id=$xls->val($row,5);$sub_item_head_id=$xls->val($row,6);
			$department_id=$xls->val($row,7);$machinary_id=$xls->val($row,8);
			
			
			
			$uom_id=$xls->val($row,11);$location=$xls->val($row,13);
			$opening_quantity=$xls->val($row,14);
			$opening_rate=$xls->val($row,15);$opening_value=$xls->val($row,16);
			$reorder_level=$xls->val($row,17);
			
			$minimum_quantity=$xls->val($row,19);$maximum_quantity=$xls->val($row,20);
			
			$cancel_quantity=$xls->val($row,22);$item_code2=$xls->val($row,23);
			$drawing_number=$xls->val($row,27);$catelog_number=$xls->val($row,28);
			//$sub_title=$xls->val($row,27);
			//$specification=$xls->val($row,28);
			$rec_qty=$xls->val($row,29);$GRN_qty=$xls->val($row,31);$reorder_application=$xls->val($row,32);
			$issue_qty=$xls->val($row,48);$unit_rate=$xls->val($row,54);
			
			$store_packing='';*/
			
			
			
		/*	$code=$xls->val($row,1);$name=addslashes($xls->val($row,2));
			$itcode=$xls->val($row,3);*/
			
			 /*$sql="insert into ms_item_master(item_id,item_code,code,name,item_head_id,sub_item_head_id,department_id,machinary_id,drawing_number,catelog_number,uom_id,store_packing,	reorder_application,reorder_level,location,maximum_quantity,minimum_quantity,unit_rate,opening_quantity,opening_rate,opening_value,cancel_quantity,item_code2,rec_qty,GRN_qty,issue_qty,insert_date) values ('','$item_code','$code','$name','$item_head_id','$sub_item_head_id','$department_id','$machinary_id','$drawing_number','$catelog_number','$uom_id','$store_packing','$reorder_application','$reorder_level','$location','$maximum_quantity','$minimum_quantity','$unit_rate','$opening_quantity','$opening_rate','$opening_value','$cancel_quantity','$item_code2','$rec_qty','$GRN_qty','$issue_qty',now())";
			//echo "<br />";
			  $sql_trans="insert into ms_item_transaction (item_transaction_id,item_id,supplier_id,rate,quotation_number,quotation_date,insert_date) values('','$item_code','$supp_id','','','',now())";
			$res=mysql_query($sql);
			$res1=mysql_query($sql_trans);*/
		  ////echo "<br />";
		
  }
	//print_r($arr);
	//echo "<br />";
 } ?>

<?php /*?><table border="1">
<? 
include("../inc/store_function.php");
for ($row=1;$row<=$xls->rowcount();$row++) { ?>
	<tr>
	<? for ($col=1;$col<=$xls->colcount();$col++) {	
		if($col==2||$col==3||$col==4||$col==5 ||$col==6||$col==10||$col==11||$col==13||$col==14||$col==15||$col==16||$col==17||$col==18||$col==19||$col==20)
		{
			
			//addDataIntoTable($tableName,$tableData);
	
	?>
		<td><?= $xls->val($row,$col) ?>&nbsp;
		</td>
	<?
	} } ?>
	</tr>
<? } ?>
</table><?php */?>
</body>
</html>
