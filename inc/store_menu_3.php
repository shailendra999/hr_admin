<script language="JavaScript" >
function mmLoadMenus() {
  
   window.mm_Supplier = new Menu("root",150,25,"Verdana,Arial,Helvetica,sans-serif",11,"#cccccc","#ffffff","#555A60","#555A60","center","middle",6,0,1000,-5,7,true,true,true,0,false,true);
   mm_Supplier.addMenuItem("Add Supplier","window.open('store_add_supplier.php', '_parent');");
   mm_Supplier.addMenuItem("Report Supplier","window.open('store_list_supplier.php', '_parent');");
   mm_Supplier.fontWeight="bold";//normal
   mm_Supplier.hideOnMouseOut=true;
   mm_Supplier.menuBorder=1;
   mm_Supplier.menuLiteBgColor='#ffffff';
   mm_Supplier.menuBorderBgColor='#000000';
   mm_Supplier.bgColor='#cccccc';
   
  window.mm_Item = new Menu("root",150,25,"Verdana,Arial,Helvetica,sans-serif",11,"#cccccc","#ffffff","#555A60","#555A60","center","middle",6,0,1000,-5,7,true,true,true,0,false,true);
   mm_Item.addMenuItem("Add Items","window.open('store_add_item.php', '_parent');");
   mm_Item.addMenuItem("Report Items","window.open('store_list_item.php', '_parent');");
	 mm_Item.addMenuItem("Opening Stock","window.open('store_add_item_stock.php', '_parent');");
   mm_Item.fontWeight="bold";
   mm_Item.hideOnMouseOut=true;
   mm_Item.menuBorder=1;
   mm_Item.menuLiteBgColor='#ffffff';
   mm_Item.menuBorderBgColor='#000000';
   mm_Item.bgColor='#cccccc';
   
   window.mm_Indent = new Menu("root",220,25,"Verdana, Arial, Helvetica, sans-serif",11,"#cccccc","#ffffff","#535353","#535353","left","middle",6,0,1000,-5,7,true,true,true,0,false,true);
	 
	 mm_Indent.addMenuItem("Add Purchase Indent","window.open('store_add_purchase_indent.php', '_parent');");
	 mm_Indent.addMenuItem("Report Purchase Indent","window.open('store_list_purchase_indent.php', '_parent');");
	  mm_Indent.addMenuItem("Report Pending Purchase Indent","window.open('store_list_pending_purchase_indent.php', '_parent');");
	 mm_Indent.fontWeight="bold";
   mm_Indent.hideOnMouseOut=true;
   mm_Indent.menuBorder=1;
   mm_Indent.menuLiteBgColor='#ffffff';
   mm_Indent.menuBorderBgColor='#000000';
   mm_Indent.bgColor='#cccccc'; 
	 
	  window.mm_Order = new Menu("root",220,25,"Verdana,Arial,Helvetica,sans-serif",11,"#cccccc","#ffffff","#535353","#535353","left","middle",6,0,1000,-5,7,true,true,true,0,true,true);
	 
	 mm_Order.addMenuItem("Add Purchase Order","window.open('store_add_purchase_order.php', '_parent');");
   mm_Order.addMenuItem("Report Purchase Order","window.open('store_list_purchase_order.php', '_parent');");
	 mm_Order.fontWeight="bold";
   mm_Order.hideOnMouseOut=true;
   mm_Order.menuBorder=1;
   mm_Order.menuLiteBgColor='#ffffff';
   mm_Order.menuBorderBgColor='#000000';
   mm_Order.bgColor='#cccccc'; 
	 
	 window.mm_GRN = new Menu("root",150,25,"Verdana,Arial,Helvetica,sans-serif",11,"#cccccc","#ffffff","#535353","#535353","left","middle",6,0,1000,-5,7,true,true,true,0,true,true);
	 
	 mm_GRN.addMenuItem("Add GRN","window.open('store_add_GRN.php', '_parent');");
   mm_GRN.addMenuItem("Report GRN","window.open('store_list_GRN.php', '_parent');");
	 mm_GRN.fontWeight="bold";
   mm_GRN.hideOnMouseOut=true;
   mm_GRN.menuBorder=1;
   mm_GRN.menuLiteBgColor='#ffffff';
   mm_GRN.menuBorderBgColor='#000000';
   mm_GRN.bgColor='#cccccc'; 
	 
	  window.mm_Form_Entry = new Menu("root",150,25,"Verdana,Arial,Helvetica,sans-serif",11,"#cccccc","#ffffff","#535353","#535353","left","middle",6,0,1000,-5,7,true,true,true,0,true,true);
	 
	 mm_Form_Entry.addMenuItem("Add Form Entry","window.open('store_add_form.php', '_parent');");
   mm_Form_Entry.addMenuItem("Report Form Entry","window.open('store_list_form.php', '_parent');");
	 mm_Form_Entry.fontWeight="bold";
   mm_Form_Entry.hideOnMouseOut=true;
   mm_Form_Entry.menuBorder=1;
   mm_Form_Entry.menuLiteBgColor='#ffffff';
   mm_Form_Entry.menuBorderBgColor='#000000';
   mm_Form_Entry.bgColor='#cccccc';
	 
	 
	 
	 window.mm_Bill_Passing=new Menu("root",150,25,"Verdana,Arial,Helvetica,sans-serif",11,"#cccccc","#ffffff","#535353","#535353","left","middle",6,0,1000,-5,7,true,true,true,0,true,true);
	 
	 mm_Bill_Passing.addMenuItem("Add Bill Passing","window.open('store_add_bill_passing.php', '_parent');");
   mm_Bill_Passing.addMenuItem("Report Bill Passing","window.open('store_list_bill_passing.php', '_parent');");
	 mm_Bill_Passing.addMenuItem("Pending Bill Passing","window.open('store_list_bill_passing_pending.php', '_parent');");
	 mm_Bill_Passing.fontWeight="bold";
   mm_Bill_Passing.hideOnMouseOut=true;
   mm_Bill_Passing.menuBorder=1;
   mm_Bill_Passing.menuLiteBgColor='#ffffff';
   mm_Bill_Passing.menuBorderBgColor='#000000';
   mm_Bill_Passing.bgColor='#cccccc';
	 
	
	 
	  window.mm_Issue_Entry=new Menu("root",150,25,"Verdana,Arial,Helvetica,sans-serif",11,"#cccccc","#ffffff","#535353","#535353","left","middle",6,0,1000,-5,7,true,true,true,0,true,true);
	 
	 mm_Issue_Entry.addMenuItem("Add Issue Entry","window.open('store_add_issue_entry.php', '_parent');");
   mm_Issue_Entry.addMenuItem("Report Issue Entry","window.open('store_list_issue_entry.php', '_parent');");
	 mm_Issue_Entry.fontWeight="bold";
   mm_Issue_Entry.hideOnMouseOut=true;
   mm_Issue_Entry.menuBorder=1;
   mm_Issue_Entry.menuLiteBgColor='#ffffff';
   mm_Issue_Entry.menuBorderBgColor='#000000';
   mm_Issue_Entry.bgColor='#cccccc';
	 
	 window.mm_Issue_Return=new Menu("root",150,25,"Verdana,Arial,Helvetica,sans-serif",11,"#cccccc","#ffffff","#535353","#535353","left","middle",6,0,1000,-5,7,true,true,true,0,true,true);
	 
	 mm_Issue_Return.addMenuItem("Add Issue Return","window.open('store_add_issue_return.php', '_parent');");
   mm_Issue_Return.addMenuItem("Report Issue Return","window.open('store_list_issue_return.php', '_parent');");
	 mm_Issue_Return.fontWeight="bold";
   mm_Issue_Return.hideOnMouseOut=true;
   mm_Issue_Return.menuBorder=1;
   mm_Issue_Return.menuLiteBgColor='#ffffff';
   mm_Issue_Return.menuBorderBgColor='#000000';
   mm_Issue_Return.bgColor='#cccccc';
	 
	 
	 
	 window.mm_RGP=new Menu("root",150,25,"Verdana,Arial,Helvetica,sans-serif",11,"#cccccc","#ffffff","#535353","#535353","left","middle",6,0,1000,-5,7,true,true,true,0,true,true);
	 
	 mm_RGP.addMenuItem("Add RGP","window.open('store_add_RGP.php', '_parent');");
   mm_RGP.addMenuItem("Report RGP","window.open('store_list_RGP.php', '_parent');");
    mm_RGP.addMenuItem("Report RGP Pending","window.open('store_list_RGP_Pending.php', '_parent');");
	 mm_RGP.fontWeight="bold";
   mm_RGP.hideOnMouseOut=true;
   mm_RGP.menuBorder=1;
   mm_RGP.menuLiteBgColor='#ffffff';
   mm_RGP.menuBorderBgColor='#000000';
   mm_RGP.bgColor='#cccccc';
	 
	 window.mm_RGP_GRN=new Menu("root",220,25,"Verdana,Arial,Helvetica,sans-serif",11,"#cccccc","#ffffff","#535353","#535353","left","middle",6,0,1000,-5,7,true,true,true,0,true,true);
	 
	 mm_RGP_GRN.addMenuItem("Add RGP(Goods Received)","window.open('store_add_RGP_GRN.php', '_parent');");
   mm_RGP_GRN.addMenuItem("Report RGP(Goods Received)","window.open('store_list_RGP_GRN.php', '_parent');");
	 mm_RGP_GRN.fontWeight="bold";
   mm_RGP_GRN.hideOnMouseOut=true;
   mm_RGP_GRN.menuBorder=1;
   mm_RGP_GRN.menuLiteBgColor='#ffffff';
   mm_RGP_GRN.menuBorderBgColor='#000000';
   mm_RGP_GRN.bgColor='#cccccc';
	 
	 
	 window.mm_NRGP=new Menu("root",150,25,"Verdana,Arial,Helvetica,sans-serif",11,"#cccccc","#ffffff","#535353","#535353","left","middle",6,0,1000,-5,7,true,true,true,0,true,true);
	 
	 mm_NRGP.addMenuItem("Add NRGP Item","window.open('store_add_NRGP_for_Item.php', '_parent');");
	 mm_NRGP.addMenuItem("Add NRGP GRN","window.open('store_add_NRGP_for_GRN.php', '_parent');");
   mm_NRGP.addMenuItem("Report NRGP Item","window.open('store_list_NRGP_for_Item.php', '_parent');");
	 mm_NRGP.addMenuItem("Report NRGP GRN","window.open('store_list_NRGP_for_GRN.php', '_parent');");
	 mm_NRGP.fontWeight="bold";
   mm_NRGP.hideOnMouseOut=true;
   mm_NRGP.menuBorder=1;
   mm_NRGP.menuLiteBgColor='#ffffff';
   mm_NRGP.menuBorderBgColor='#000000';
   mm_NRGP.bgColor='#cccccc';
	 
	 window.mm_Report=new Menu("root",180,25,"Verdana,Arial,Helvetica,sans-serif",11,"#cccccc","#ffffff","#535353","#535353","left","middle",6,0,1000,-5,7,true,true,true,0,true,true);
	 
	 mm_Report.addMenuItem("Stock Report","window.open('store_report_stock.php','_parent');");
	 mm_Report.addMenuItem("Stock Ledger","window.open('store_report_stock_ledger.php','_parent');");
	 mm_Report.addMenuItem("Stock Ledger Machinary","window.open('store_report_stock_ledger_machine.php','_parent');");
   mm_Report.addMenuItem("Stock Ledger(Qty)","window.open('store_report_stock_ledger_qty.php','_parent');");
	 mm_Report.addMenuItem("Item Stock Report","window.open('store_report_item_stock_ledger.php','_parent');");
	 mm_Report.addMenuItem("Consumption Report","window.open('store_report_consumption.php','_parent');");
	 mm_Report.addMenuItem("Monthly Stock","window.open('store_report_monthly_stock.php','_parent');");
	 mm_Report.addMenuItem("UnUsed Stock","window.open('store_report_unused_stock.php','_parent');");
	 mm_Report.fontWeight="bold";
   mm_Report.hideOnMouseOut=true;
   mm_Report.menuBorder=1;
   mm_Report.menuLiteBgColor='#ffffff';
   mm_Report.menuBorderBgColor='#000000';
   mm_Report.bgColor='#cccccc';
	 
   
  mm_Supplier.writeMenus();
    
} // mmLoadMenus()

</script>