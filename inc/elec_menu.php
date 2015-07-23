<script language="JavaScript" >
    function mmLoadMenus() {



        window.mm_LT = new Menu("root", 150, 25, "Verdana, Arial, Helvetica, sans-serif", 11, "#cccccc", "#ffffff", "#535353", "#535353", "left", "middle", 6, 0, 1000, -5, 7, true, true, true, 0, false, true);

        mm_LT.addMenuItem("Add Low Tension", "window.open('elec_add_LT.php', '_parent');");
        mm_LT.addMenuItem("List Low Tension", "window.open('elec_list_LT.php', '_parent');");
        mm_LT.fontWeight = "bold";
        mm_LT.hideOnMouseOut = true;
        mm_LT.menuBorder = 1;
        mm_LT.menuLiteBgColor = '#ffffff';
        mm_LT.menuBorderBgColor = '#000000';
        mm_LT.bgColor = '#cccccc';

        window.mm_HT = new Menu("root", 150, 25, "Verdana,Arial,Helvetica,sans-serif", 11, "#cccccc", "#ffffff", "#535353", "#535353", "left", "middle", 6, 0, 1000, -5, 7, true, true, true, 0, true, true);

        mm_HT.addMenuItem("Add High Tension", "window.open('elec_add_HT.php', '_parent');");
        mm_HT.addMenuItem("List High Tension", "window.open('elec_list_HT.php', '_parent');");
        mm_HT.fontWeight = "bold";
        mm_HT.hideOnMouseOut = true;
        mm_HT.menuBorder = 1;
        mm_HT.menuLiteBgColor = '#ffffff';
        mm_HT.menuBorderBgColor = '#000000';
        mm_HT.bgColor = '#cccccc';

        window.mm_HPS = new Menu("root", 150, 25, "Verdana,Arial,Helvetica,sans-serif", 11, "#cccccc", "#ffffff", "#535353", "#535353", "left", "middle", 6, 0, 1000, -5, 7, true, true, true, 0, true, true);

        mm_HPS.addMenuItem("Add HPS", "window.open('elec_add_HPS.php', '_parent');");
        mm_HPS.addMenuItem("List HPS", "window.open('elec_list_HPS.php', '_parent');");
        mm_HPS.fontWeight = "bold";
        mm_HPS.hideOnMouseOut = true;
        mm_HPS.menuBorder = 1;
        mm_HPS.menuLiteBgColor = '#ffffff';
        mm_HPS.menuBorderBgColor = '#000000';
        mm_HPS.bgColor = '#cccccc';

        window.mm_energy_cons = new Menu("root", 190, 25, "Verdana,Arial,Helvetica,sans-serif", 11, "#cccccc", "#ffffff", "#535353", "#535353", "left", "middle", 6, 0, 1000, -5, 7, true, true, true, 0, true, true);

        mm_energy_cons.addMenuItem("Add Energy Consumption", "window.open('elec_add_energy_consumption.php', '_parent');");
        mm_energy_cons.addMenuItem("List Energy Consumption", "window.open('elec_list_energy_consumption.php', '_parent');");
        mm_energy_cons.fontWeight = "bold";
        mm_energy_cons.hideOnMouseOut = true;
        mm_energy_cons.menuBorder = 1;
        mm_energy_cons.menuLiteBgColor = '#ffffff';
        mm_energy_cons.menuBorderBgColor = '#000000';
        mm_energy_cons.bgColor = '#cccccc';

        window.mm_MM = new Menu("root", 150, 25, "Verdana,Arial,Helvetica,sans-serif", 11, "#cccccc", "#ffffff", "#535353", "#535353", "left", "middle", 6, 0, 1000, -5, 7, true, true, true, 0, true, true);

        mm_MM.addMenuItem("Add Motor Maint.", "window.open('elec_add_MM.php', '_parent');");
        mm_MM.addMenuItem("List Motor Maint.", "window.open('elec_list_MM.php', '_parent');");
        mm_MM.fontWeight = "bold";
        mm_MM.hideOnMouseOut = true;
        mm_MM.menuBorder = 1;
        mm_MM.menuLiteBgColor = '#ffffff';
        mm_MM.menuBorderBgColor = '#000000';
        mm_MM.bgColor = '#cccccc';

        window.mm_machine_maint = new Menu("root", 150, 25, "Verdana,Arial,Helvetica,sans-serif", 11, "#cccccc", "#ffffff", "#535353", "#535353", "left", "middle", 6, 0, 1000, -5, 7, true, true, true, 0, true, true);

        mm_machine_maint.addMenuItem("Add Mach. Maint.", "window.open('elec_add_machine_maint.php', '_parent');");
        mm_machine_maint.addMenuItem("List Mach. Maint.", "window.open('elec_list_machine_maint.php', '_parent');");
        mm_machine_maint.fontWeight = "bold";
        mm_machine_maint.hideOnMouseOut = true;
        mm_machine_maint.menuBorder = 1;
        mm_machine_maint.menuLiteBgColor = '#ffffff';
        mm_machine_maint.menuBorderBgColor = '#000000';
        mm_machine_maint.bgColor = '#cccccc';

        window.mm_daily_report = new Menu("root", 150, 25, "Verdana,Arial,Helvetica,sans-serif", 11, "#cccccc", "#ffffff", "#535353", "#535353", "left", "middle", 6, 0, 1000, -5, 7, true, true, true, 0, true, true);

        mm_daily_report.addMenuItem("Add Daily Report", "window.open('elec_add_daily_report_engg.php', '_parent');");
        mm_daily_report.addMenuItem("List Daily Report", "window.open('elec_list_daily_report_engg.php', '_parent');");
        mm_daily_report.fontWeight = "bold";
        mm_daily_report.hideOnMouseOut = true;
        mm_daily_report.menuBorder = 1;
        mm_daily_report.menuLiteBgColor = '#ffffff';
        mm_daily_report.menuBorderBgColor = '#000000';
        mm_daily_report.bgColor = '#cccccc';

        window.mm_Indent = new Menu("root", 150, 25, "Verdana,Arial,Helvetica,sans-serif", 11, "#cccccc", "#ffffff", "#535353", "#535353", "left", "middle", 6, 0, 1000, -5, 7, true, true, true, 0, true, true);

        mm_Indent.addMenuItem("Add Indent", "window.open('elec_add_indent.php', '_parent');");
        mm_Indent.addMenuItem("List Indent", "window.open('elec_list_indent.php', '_parent');");
        mm_Indent.fontWeight = "bold";
        mm_Indent.hideOnMouseOut = true;
        mm_Indent.menuBorder = 1;
        mm_Indent.menuLiteBgColor = '#ffffff';
        mm_Indent.menuBorderBgColor = '#000000';
        mm_Indent.bgColor = '#cccccc';

        window.mm_Item = new Menu("root", 150, 25, "Verdana,Arial,Helvetica,sans-serif", 11, "#cccccc", "#ffffff", "#535353", "#535353", "left", "middle", 6, 0, 1000, -5, 7, true, true, true, 0, true, true);

        mm_Item.addMenuItem("Add Item", "window.open('elec_add_item.php', '_parent');");
        mm_Item.addMenuItem("List Item", "window.open('elec_list_item.php', '_parent');");
        mm_Item.fontWeight = "bold";
        mm_Item.hideOnMouseOut = true;
        mm_Item.menuBorder = 1;
        mm_Item.menuLiteBgColor = '#ffffff';
        mm_Item.menuBorderBgColor = '#000000';
        mm_Item.bgColor = '#cccccc';


        window.mm_diesel_generator = new Menu("root", 250, 25, "Verdana,Arial,Helvetica,sans-serif", 11, "#cccccc", "#ffffff", "#535353", "#535353", "left", "middle", 6, 0, 1000, -5, 7, true, true, true, 0, true, true);

        mm_diesel_generator.addMenuItem("Add Diesel Generator Reading", "window.open('elec_add_dg_reading.php', '_parent');");
        mm_diesel_generator.addMenuItem("List Diesel Generator Reading", "window.open('elec_list_dg_reading.php', '_parent');");
        mm_diesel_generator.addMenuItem("Add Diesel Generator Down Time", "window.open('elec_add_dg_down_time.php', '_parent');");
        mm_diesel_generator.addMenuItem("List Diesel Generator Down Time", "window.open('elec_list_dg_down_time.php', '_parent');");
        mm_diesel_generator.fontWeight = "bold";
        mm_diesel_generator.hideOnMouseOut = true;
        mm_diesel_generator.menuBorder = 1;
        mm_diesel_generator.menuLiteBgColor = '#ffffff';
        mm_diesel_generator.menuBorderBgColor = '#000000';
        mm_diesel_generator.bgColor = '#cccccc';

        mm_LT.writeMenus();

    } // mmLoadMenus()

</script>