<?php
ini_set("memory_limit","10000M");
$conn = mysql_connect("localhost","mahimagroup", "Mahima123")or die ("Couldn't connect to server.");
$db = mysql_select_db("mahimagroup", $conn)or die ("Couldn't select database.");
ini_set("display_errors",1);
error_reporting(E_ALL);
require_once 'excel/excel_reader2.php';
$data = new Spreadsheet_Excel_Reader("itemMaster.xls");
for ($row=2;$row<=$data->rowcount();$row++) 
	{ 
		$sql = "SELECT uom_id FROM ms_uom where name = '".$data->value($row,6)."'";
		$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
		
		if(mysql_num_rows($result)>0)
		{
			
			$row_1 = mysql_fetch_array($result);
			$unit_id = $row_1['uom_id'];				
		}
		
		$sql = "SELECT department_id  FROM ms_department where name = '".$data->value($row,2)."'";
		$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
		
		if(mysql_num_rows($result)>0)
		{
			
			$row_1 = mysql_fetch_array($result);
			$department_id = $row_1['department_id'];				
		}
		
		$sql = "SELECT machinary_id FROM ms_machinary where name = '".$data->value($row,3)."'";
		$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
		
		if(mysql_num_rows($result)>0)
		{
			
			$row_1 = mysql_fetch_array($result);
			$machinary_id = $row_1['machinary_id'];				
		}


				echo $sql_item = "insert into ms_item_master set
																name = '".addslashes($data->value($row,1))."',
																department_id = '".$department_id."',
																uom_id = '".$unit_id."',
																machinary_id = '".$machinary_id."',
																drawing_number ='".$data->value($row,4)."',
																catelog_number = '".$data->value($row,5)."',
																type_of_item = '".$data->value($row,8)."'";
																	
				//$result_ins = mysql_query($sql_item) or die("Error in query:".$sql_item."<br>".mysql_error().":".mysql_errno());																	

	}
	?>
<body>
</body>
</html>
