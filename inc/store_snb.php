<link rel="stylesheet" href="css/ss.css">
   <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
   <script src="js/ss.js"></script>
<table width="230" cellpadding="0" cellspacing="0" align="center" border="0">
    <tr>
    	<td align="center"><img src="images/snb_top_img.jpg" width="230" height="10"></td>
    </tr>
    <tr>
    	<td class="snb_bg">
<!-- ************************************ my code started here. ******************************************* -->
        <div id='cssmenu'>
<ul>
   <li><a href="hr_homepage.php"><span>Home</span></a></li>
   <li class='has-sub'><a href="#"><span>Supplier Master</span></a> 
      <ul>
         <li><a href='store_add_supplier.php'><span>Add Supplier</span></a></li>
         <li><a href='store_list_supplier.php'><span>List Supplier</span></a></li>
         <!--<li><a href='list_releaved_employee.php'><span>Releaved Employee</span></a></li>
         <li><a href='list_salary_employee.php'><span>List Salary</span></a></li>
         <li><a href='list_department_employee.php'><span>List Department</span></a></li>
         <li><a href='list_designation_employee.php'><span>List Designation</span></a></li>
         <li><a href='list_weeklyoff_employee.php'><span>List Weekly Off</span></a></li>-->
      </ul>
   </li>
   <li class='has-sub'><a href='#'><span>Item Master</span></a>
      <ul>
         <li><a href='store_add_item.php'><span>Add Items</span></a></li>
         <li><a href='store_list_item.php'><span>Report Items</span></a></li>
         <li><a href='store_add_item_stock.php'><span>Opening Items</span></a></li>
      </ul>
   </li>
   <li class='has-sub'><a href='#'><span>Purchase Indent</span></a>	
   		<ul>
         <li><a href='store_add_purchase_indent.php'><span>Add purchase induction</span></a></li>
         <li><a href='store_list_purchase_indent.php'><span>Report Purchase Induction</span></a></li>
         <li><a href='store_list_pending_purchase_indent.php'><span>Report Pending Purchase Induction</span></a			></li>
         </ul>
   </li>
   
   <li class='has-sub'><a href='#'><span>Purchase Order</span></a>	
   		<ul>
         <li><a href='store_add_purchase_order.php'><span>Add Purchase Order</span></a></li>
         <li><a href='store_list_purchase_indent.php'><span>Report Purchase order</span></a></li>
      </ul>
   </li>
   
   <li class='has-sub'><a href='#'><span>Good Recived Note</span></a>	
   		<ul>
         <li><a href='store_add_GRN.php'><span>Add GRN</span></a></li>
         <li><a href='store_list_GRN.php'><span>Report GRN</span></a></li>
      </ul>
   </li>
   <li class='has-sub'><a href='#'><span>Form Entry</span></a>	
   		<ul>
         <li><a href='store_add_form.php'><span>Add Form Entry</span></a></li>
         <li><a href='store_list_form.php'><span>Report Form Entry</span></a></li>
      </ul>
   </li>
   <li class='has-sub'><a href='#'><span>Bill Passing Entry</span></a>	
   		<ul>
         <li><a href='store_add_bill_passing.php'><span>Add Bill Passing</span></a></li>
         <li><a href='store_list_bill_passing.php'><span>Report Bill Passing</span></a></li>
         <li><a href='store_list_bill_passing_pending.php'><span>Pending Bill Passing</span></a></li>
         </ul>
   </li>
   <li class='has-sub'><a href='#'><span>Issue Entry</span></a>	
   		<ul>
         <li><a href='store_add_issue_entry.php'><span>Add issue Entry</span></a></li>
         <li><a href='store_list_issue_return.php'><span>Report Issue Entry</span></a></li>
         </ul>
   </li>
   <li class='has-sub'><a href='#'><span>Issue Return</span></a>	
   		<ul>
         <li><a href='store_add_issue_return.php'><span>Add issue Return</span></a></li>
         <li><a href='store_list_issue_return.php'><span>Report Issue Return</span></a></li>
         </ul>
   </li>
   <li class='has-sub'><a href='#'><span> Returable Gate Pass</span></a>	
   		<ul>
        <li><a href='store_add_RGP.php'><span>Add RGP</span></a></li>
        <li><a href='store_list_RGP.php'><span>Report RGP</span></a></li>
        <li><a href='store_list_RGP_Pending.php'><span>Report RGP Pending</span></a></li>
        </ul>
   </li>
   <li class='has-sub'><a href='#'><span>RGP-Good Received Note</span></a>	
   		<ul>
        <li><a href='store_add_RGP.php'><span>Add RGP(Goods Recived)</span></a></li>
        <li><a href='store_list_RGP.php'><span>Report RGP(Goods Recived)</span></a></li>
        </ul>
   </li>
     <li class='has-sub'><a href='#'><span>Non Returable Gate Pass</span></a>	
   		<ul>
        <li><a href='store_add_NRGP_for_Item.php'><span>Add NRGP Items</span></a></li>
        <li><a href='store_add_NRGP_for_GRN.php'><span>Add NRGP RRN</span></a></li>
        <li><a href='store_list_NRGP_for_Item.php'><span>Report NRGP Items</span></a></li>
        <li><a href='store_list_NRGP_for_GRN.php'><span>Report NRGP RRN</span></a></li>
        </ul>
   </li>
   <li class='has-sub'><a href='#'><span>Reports</span></a>	
   		<ul>
        <li><a href='store_add_NRGP_for_Item.php'><span>Stock Report</span></a></li>
        <li><a href='store_add_NRGP_for_GRN.php'><span>Stock Ledger</span></a></li>
        <li><a href='store_list_NRGP_for_Item.php'><span>Stock Ledger Machinary</span></a></li>
        <li><a href='store_list_NRGP_for_GRN.php'><span>Stock Ledger(Qty)</span></a></li>
        <li><a href='store_list_NRGP_for_GRN.php'><span>Item Stock Report</span></a></li>
        <li><a href='store_list_NRGP_for_GRN.php'><span>Consumption Report</span></a></li>
        <li><a href='store_list_NRGP_for_GRN.php'><span>Monthly Report</span></a></li>
        <li><a href='store_list_NRGP_for_GRN.php'><span>UnUsed Stock</span></a></li>
        </ul>
   </li>
  <li><a href="logoff.php"><span>Logoff</span></a></li>
</ul>
</div>
        
        
<!-- *****************************************  and ended here   *****************************************  -->
				
			</td>
		</tr>
    <tr>
    	<td align="center"><img src="images/snb_btm_img.jpg" width="230" height="10"/></td>
    </tr>
</table>
