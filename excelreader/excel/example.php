<?php
error_reporting(E_ALL ^ E_NOTICE);
require_once 'excel_reader2.php';
$data = new Spreadsheet_Excel_Reader("../StkCSum.xls");
?>
<html>
<head>
<style>
table.excel {
	border-style:ridge;
	border-width:1;
	border-collapse:collapse;
	font-family:sans-serif;
	font-size:12px;
}
table.excel thead th, table.excel tbody th {
	background:#CCCCCC;
	border-style:ridge;
	border-width:1;
	text-align: center;
	vertical-align:bottom;
}
table.excel tbody th {
	text-align:center;
	width:20px;
}
table.excel tbody td {
	vertical-align:bottom;
}
table.excel tbody td {
    padding: 0 3px;
	border: 1px solid #EEEEEE;
}
</style>
</head>

<body>
<?
for ($row=5;$row<=$data->rowcount();$row++) 
	{ 
		//for ($col=1;$col<=$xls->colcount();$col++) {
		//echo $xls->val($row,$col); echo "-";
		//echo $xls->raw($row,$col); echo "-";	
			//echo $sql_ins = "insert into ms_item_master set
//															name='".$xls->val($row,1)."',
//															opening_quantity = '".$xls->raw($row,2)."',
//															uom_id='',
//															opening_rate = '".$xls->raw($row,3)."'";
		//}
	 } 
?>
<?php echo $data->bold(5,1,$sheet=0) ?>
</body>
</html>
