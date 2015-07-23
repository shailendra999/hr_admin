<?
include("inc/store_header.php");
?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
    <tr>
    	<td align="left" valign="top" width="230px" style="padding-top:5px;">
			<? include ("inc/production_snb.php"); ?>
        </td>
        <td style="padding-left:5px; padding-top:5px;"  valign="top">
        	<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
            	<tr>
                	<td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; Location Master</td>
                </tr>
                <tr>
                	<td valign="top" style="border-top:5px solid #FFFFFF;">
                    	<table align="center" width="95%" cellpadding="0" cellspacing="0" border="0">
                        	<tr>
                            	<td align="left" valign="top"><img src="images/white1.gif" /></td>
                               	<td class="white2"></td>
                                <td align="right" valign="top"><img src="images/white3.gif" /></td>
                            </tr>
                            <tr>
                            	<td class="white4"></td>
                                <td>
                                	<table align="center" width="100%" cellpadding="3" cellspacing="1" border="0">
                                        <tr>
                                            <td valign="top">
                                                <table width="100%" cellpadding="2" cellspacing="2" align="center" border="0">
                                                    <tr>
                                                        <td class="form_txt border">Location</td>
                                                        <td align="left" class="border"><select name='supplier_id' id='supplier_id' style='width:170px; height:20px;'>
                                                                  <option value='0'></option>
                                                                  <option value="" selected="selected"></option>
                                                              </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td align="left">
                                                            <input type="submit" id="btn_submit" name="btn_submit" value="Submit" class="btn_bg" />
                                                        </td>
                                                    </tr>                                             
                                               </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td class="white5"></td>
                            </tr>
                            <tr>
                            	<td align="left" valign="top"><img src="images/white6.gif" /></td>
                               	<td class="white7"></td>
                                <td align="right" valign="top"><img src="images/white8.gif" /></td>
                            </tr>
                        </table>
                  </td>
              </tr>
          </table>
      </td>
  </tr>
</table>
<? 
include("inc/hr_footer.php");
?>
