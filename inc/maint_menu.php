<script language="JavaScript" >
function mmLoadMenus() {
  
   
   
   window.mm_Services = new Menu("root",150,25,"Verdana, Arial, Helvetica, sans-serif",11,"#cccccc","#ffffff","#535353","#535353","left","middle",6,0,1000,-5,7,true,true,true,0,false,true);
	 
	 mm_Services.addMenuItem("Add Services","window.open('maint_add_services.php', '_parent');");
	 mm_Services.addMenuItem("List Services","window.open('maint_list_services.php', '_parent');");
	 mm_Services.fontWeight="bold";
   mm_Services.hideOnMouseOut=true;
   mm_Services.menuBorder=1;
   mm_Services.menuLiteBgColor='#ffffff';
   mm_Services.menuBorderBgColor='#000000';
   mm_Services.bgColor='#cccccc'; 
	 
	  window.mm_Machine = new Menu("root",150,25,"Verdana,Arial,Helvetica,sans-serif",11,"#cccccc","#ffffff","#535353","#535353","left","middle",6,0,1000,-5,7,true,true,true,0,true,true);
	 
	 mm_Machine.addMenuItem("Add Machine","window.open('maint_add_machines.php', '_parent');");
   mm_Machine.addMenuItem("List Machine","window.open('maint_list_machines.php', '_parent');");
	 mm_Machine.fontWeight="bold";
   mm_Machine.hideOnMouseOut=true;
   mm_Machine.menuBorder=1;
   mm_Machine.menuLiteBgColor='#ffffff';
   mm_Machine.menuBorderBgColor='#000000';
   mm_Machine.bgColor='#cccccc'; 
	 
	 window.mm_Job = new Menu("root",150,25,"Verdana,Arial,Helvetica,sans-serif",11,"#cccccc","#ffffff","#535353","#535353","left","middle",6,0,1000,-5,7,true,true,true,0,true,true);
	 
	 mm_Job.addMenuItem("Add Job","window.open('maint_add_job.php', '_parent');");
   mm_Job.addMenuItem("List Job","window.open('maint_list_job.php', '_parent');");
	 mm_Job.fontWeight="bold";
   mm_Job.hideOnMouseOut=true;
   mm_Job.menuBorder=1;
   mm_Job.menuLiteBgColor='#ffffff';
   mm_Job.menuBorderBgColor='#000000';
   mm_Job.bgColor='#cccccc'; 
	 
	 window.mm_Report = new Menu("root",150,25,"Verdana,Arial,Helvetica,sans-serif",11,"#cccccc","#ffffff","#535353","#535353","left","middle",6,0,1000,-5,7,true,true,true,0,true,true);
	 
	 mm_Report.addMenuItem("Job Report","window.open('maint_job_report.php', '_parent');");
	 mm_Report.addMenuItem("Pending Job Report","window.open('maint_pendeing_job_report.php', '_parent');");
	 mm_Report.fontWeight="bold";
   mm_Report.hideOnMouseOut=true;
   mm_Report.menuBorder=1;
   mm_Report.menuLiteBgColor='#ffffff';
   mm_Report.menuBorderBgColor='#000000';
   mm_Report.bgColor='#cccccc'; 
	 
	 window.mm_ItemReceived = new Menu("root",150,25,"Verdana,Arial,Helvetica,sans-serif",11,"#cccccc","#ffffff","#535353","#535353","left","middle",6,0,1000,-5,7,true,true,true,0,true,true);
	 mm_ItemReceived.addMenuItem("Add Item Received","window.open('maint_add_item_received.php', '_parent');");
	 mm_ItemReceived.addMenuItem("List Item Received","window.open('maint_list_item_received.php', '_parent');");
	 mm_ItemReceived.fontWeight="bold";
   mm_ItemReceived.hideOnMouseOut=true;
   mm_ItemReceived.menuBorder=1;
   mm_ItemReceived.menuLiteBgColor='#ffffff';
   mm_ItemReceived.menuBorderBgColor='#000000';
   mm_ItemReceived.bgColor='#cccccc';
	  
	 window.mm_ItemConsumption = new Menu("root",170,25,"Verdana,Arial,Helvetica,sans-serif",11,"#cccccc","#ffffff","#535353","#535353","left","middle",6,0,1000,-5,7,true,true,true,0,true,true);
	 mm_ItemConsumption.addMenuItem("Add Item Consumption","window.open('maint_add_item_consumption.php', '_parent');");
	 mm_ItemConsumption.addMenuItem("List Item Consumption","window.open('maint_list_item_consumption.php', '_parent');");
	 mm_ItemConsumption.fontWeight="bold";
   mm_ItemConsumption.hideOnMouseOut=true;
   mm_ItemConsumption.menuBorder=1;
   mm_ItemConsumption.menuLiteBgColor='#ffffff';
   mm_ItemConsumption.menuBorderBgColor='#000000';
   mm_ItemConsumption.bgColor='#cccccc'; 
	 
	window.mm_Indent = new Menu("root",150,25,"Verdana,Arial,Helvetica,sans-serif",11,"#cccccc","#ffffff","#535353","#535353","left","middle",6,0,1000,-5,7,true,true,true,0,true,true);
	 
	 mm_Indent.addMenuItem("Add Purchase Indent","window.open('maint_add_indent.php', '_parent');");
	 mm_Indent.addMenuItem("List Purchase Indent","window.open('maint_list_indent.php', '_parent');");
	 mm_Indent.fontWeight="bold";
   mm_Indent.hideOnMouseOut=true;
   mm_Indent.menuBorder=1;
   mm_Indent.menuLiteBgColor='#ffffff';
   mm_Indent.menuBorderBgColor='#000000';
   mm_Indent.bgColor='#cccccc'; 
	 
	 window.mm_Item = new Menu("root",150,25,"Verdana,Arial,Helvetica,sans-serif",11,"#cccccc","#ffffff","#535353","#535353","left","middle",6,0,1000,-5,7,true,true,true,0,true,true);
	 
	 mm_Item.addMenuItem("Add Item","window.open('maint_add_item.php', '_parent');");
   mm_Item.addMenuItem("List Item","window.open('maint_list_item.php', '_parent');");
	 mm_Item.fontWeight="bold";
   mm_Item.hideOnMouseOut=true;
   mm_Item.menuBorder=1;
   mm_Item.menuLiteBgColor='#ffffff';
   mm_Item.menuBorderBgColor='#000000';
   mm_Item.bgColor='#cccccc';
	 
  mm_Services.writeMenus();
    
} // mmLoadMenus()

</script>