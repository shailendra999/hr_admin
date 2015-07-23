<script language="JavaScript" >
function mmLoadMenus() {
  
   window.mm_Company = new Menu("root",150,25,"Verdana,Arial,Helvetica,sans-serif",11,"#cccccc","#ffffff","#555A60","#555A60","center","middle",6,0,1000,-5,7,true,true,true,0,false,true);
   mm_Company.addMenuItem("Add Company","window.open('purchase_add_company.php', '_parent');");
   mm_Company.fontWeight="bold";
   mm_Company.hideOnMouseOut=true;
   mm_Company.menuBorder=1;
   mm_Company.menuLiteBgColor='#ffffff';
   mm_Company.menuBorderBgColor='#000000';
   mm_Company.bgColor='#cccccc';
   
	 window.mm_Purchaser = new Menu("root",150,25,"Verdana,Arial,Helvetica,sans-serif",11,"#cccccc","#ffffff","#555A60","#555A60","center","middle",6,0,1000,-5,7,true,true,true,0,false,true);
   mm_Purchaser.addMenuItem("Add Buyer","window.open('purchase_add_purchaser.php', '_parent');");
   mm_Purchaser.fontWeight="bold";//normal
   mm_Purchaser.hideOnMouseOut=true;
   mm_Purchaser.menuBorder=1;
   mm_Purchaser.menuLiteBgColor='#ffffff';
   mm_Purchaser.menuBorderBgColor='#000000';
   mm_Purchaser.bgColor='#cccccc';
   
   window.mm_Seller = new Menu("root",150,25,"Verdana,Arial,Helvetica,sans-serif",11,"#cccccc","#ffffff","#535353","#535353","left","middle",6,0,1000,-5,7,true,true,true,0,true,true);
	 
	 mm_Seller.addMenuItem("Add Seller","window.open('purchase_add_seller.php', '_parent');");
	 mm_Seller.fontWeight="bold";
   mm_Seller.hideOnMouseOut=true;
   mm_Seller.menuBorder=1;
   mm_Seller.menuLiteBgColor='#ffffff';
   mm_Seller.menuBorderBgColor='#000000';
   mm_Seller.bgColor='#cccccc'; 
	 
   window.mm_Form = new Menu("root",150,25,"Verdana, Arial, Helvetica, sans-serif",11,"#cccccc","#ffffff","#535353","#535353","left","middle",6,0,1000,-5,7,true,true,true,0,false,true);
	 
	 mm_Form.addMenuItem("Add Form","window.open('purchase_add_form.php', '_parent');");
	 mm_Form.fontWeight="bold";
   mm_Form.hideOnMouseOut=true;
   mm_Form.menuBorder=1;
   mm_Form.menuLiteBgColor='#ffffff';
   mm_Form.menuBorderBgColor='#000000';
   mm_Form.bgColor='#cccccc';
	 
	 window.mm_Product = new Menu("root",150,25,"Verdana, Arial, Helvetica, sans-serif",11,"#cccccc","#ffffff","#535353","#535353","left","middle",6,0,1000,-5,7,true,true,true,0,false,true);
	 
	 mm_Product.addMenuItem("Add Product","window.open('purchase_add_product.php', '_parent');");
	 mm_Product.fontWeight="bold";
   mm_Product.hideOnMouseOut=true;
   mm_Product.menuBorder=1;
   mm_Product.menuLiteBgColor='#ffffff';
   mm_Product.menuBorderBgColor='#000000';
   mm_Product.bgColor='#cccccc';
	 
	 window.mm_Buy_Sell = new Menu("root",150,25,"Verdana, Arial, Helvetica, sans-serif",11,"#cccccc","#ffffff","#535353","#535353","left","middle",6,0,1000,-5,7,true,true,true,0,false,true);
	 
	 mm_Buy_Sell.addMenuItem("Add Buy/Sell","window.open('purchase_add_buysell.php', '_parent');");
	 mm_Buy_Sell.addMenuItem("Edit Buy/Sell","window.open('purchase_edit_buysell.php', '_parent');");
	 mm_Buy_Sell.fontWeight="bold";
   mm_Buy_Sell.hideOnMouseOut=true;
   mm_Buy_Sell.menuBorder=1;
   mm_Buy_Sell.menuLiteBgColor='#ffffff';
   mm_Buy_Sell.menuBorderBgColor='#000000';
   mm_Buy_Sell.bgColor='#cccccc'; 
	 
	  window.mm_Reports = new Menu("root",150,25,"Verdana, Arial, Helvetica, sans-serif",11,"#cccccc","#ffffff","#535353","#535353","left","middle",6,0,1000,-5,7,true,true,true,0,false,true);
	 
	 mm_Reports.addMenuItem("Reports ","window.open('purchase_reports.php', '_parent');");
	  mm_Reports.addMenuItem("Stock Statement ","window.open('purchase_stock_statement.php', '_parent');");
	 mm_Reports.fontWeight="bold";
   mm_Reports.hideOnMouseOut=true;
   mm_Reports.menuBorder=1;
   mm_Reports.menuLiteBgColor='#ffffff';
   mm_Reports.menuBorderBgColor='#000000';
   mm_Reports.bgColor='#cccccc'; 
	 
	 
	
   
  mm_Company.writeMenus();
    
} // mmLoadMenus()

</script>