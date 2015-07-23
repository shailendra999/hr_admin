<?php
ini_set("memory_limit","10000M");
$conn = mysql_connect("localhost","jsmdevcons", "Jsmd1234")or die ("Couldn't connect to server.");
$db = mysql_select_db("test", $conn)or die ("Couldn't select database.");
ini_set("display_errors",1);
error_reporting(E_ALL);
require_once 'excel/excel_reader2.php';
$data = new Spreadsheet_Excel_Reader("StkCSum.xls");

$unit_master=array();
	for ($row=5;$row<=$data->rowcount();$row++) 
	{ 	
		
		if($data->format($row,3)!="")
		{
			$arr_test = explode(" ",$data->format($row,3));
			$uom = str_replace('"',"", $arr_test[1]);	
			if(!in_array($uom,$unit_master))
			{
				$unit_master[] =$uom;
			}			
		}
	 } 
	 foreach($unit_master as $unit_name)
	 {
	 	$sql_unit_master = "insert into ms_uom set
															name = '".$unit_name."'";
		$result_ins = mysql_query($sql_unit_master) or die("Error in query:".$sql_unit_master."<br>".mysql_error().":".mysql_errno());												
	 }
	 
	$dep_id=0;
	for ($row=5;$row<=$data->rowcount();$row++) 
	{ 
		
	
		if($data->bold($row,1,0))
		{
			$sql_department = "insert into ms_department set
														name = '".$data->value($row,1,0)."'";
			$result_ins = mysql_query($sql_department) or die("Error in query:".$sql_department."<br>".mysql_error().":".mysql_errno());
			$dep_id = mysql_insert_id();											
		}
		else
		{
			$unit_id=0;
			if($data->format($row,3)!="")
			{
				$arr_test = explode(" ",$data->format($row,3));
			
				$uom = str_replace('"',"", $arr_test[1]);	
			}
			$sql = "SELECT uom_id FROM ms_uom where name = '".$uom."'";
			$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
			
			if(mysql_num_rows($result)>0)
			{
				
				$row_1 = mysql_fetch_array($result);
				$unit_id = $row_1['uom_id'];				
			}

			$sql_item = "insert into ms_item_master set
																name = '".addslashes($data->value($row,1))."',
																department_id = '".$dep_id."',
																uom_id = '".$unit_id."',
																opening_rate ='".$data->raw($row,4)."',
																opening_quantity = '".$data->raw($row,3)."'";
																	
			$result_ins = mysql_query($sql_item) or die("Error in query:".$sql_item."<br>".mysql_error().":".mysql_errno());																	

		}
	 } 
	?>
<body>
</body>
</html>
